<?php

namespace App\Livewire\Tenders;

use App\Models\ApplicantAnswer;
use App\Models\ApplicantTender;
use App\Models\Question;
use App\Models\Item;
use App\Models\TenderItem;
use Livewire\Component;
use App\Models\Tender;
use App\Models\TenderCommitte;
use App\Models\TenderQuestion;
use App\Models\User;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\ApplicantTenderItem;

class TendersTable extends Component
{
    use LivewireAlert;

    public $newTender = [
        'title' => '',
        'description' => '',
        'status' => '',
        'start_date' => null,
        'end_date' => null,
    ];

    public $tenderId;
    public $canApplicant;
    public $selectedCommittes = [];
    public $selectedQuestions = [];
    public $questionAnswers = [];
    public $questionid = [];
    public $committeeTypeFilter = [];

    public $selectedItems = [];
    public $availableItems = [];
    public $searchItems = '';
    public $tempSelectedItems = [];

    public $currentTender;
    public $tenderItems = [];
    public $selectedTenderItems = [];
    public $totalBidAmount = 0;

    public $currentTenderQuestions = [];

    public function mount()
    {
        $this->loadSelectedCommittes();
        $this->loadSelectedQuestions();
        $this->loadAvailableItems();
    }

    public function loadAvailableItems()
    {
        $query = Item::query();

        if (!empty($this->searchItems)) {
            $query->where('name', 'like', '%' . $this->searchItems . '%')
                ->orWhere('description', 'like', '%' . $this->searchItems . '%');
        }

        $this->availableItems = $query->get()->toArray();
    }

    public function updatedSearchItems()
    {
        $this->loadAvailableItems();
    }

    public function addNewItem()
    {
        $this->selectedItems[] = [
            'id' => null,
            'name' => '',
            'description' => '',
            'unit' => '',
            'quantity' => 1,
            'is_new' => true
        ];
    }

    public function addSelectedItems()
    {
        if (!empty($this->tempSelectedItems)) {
            foreach ($this->tempSelectedItems as $itemId) {
                $item = Item::find($itemId);
                if ($item) {
                    $exists = collect($this->selectedItems)->contains('id', $item->id);
                    if (!$exists) {
                        $this->selectedItems[] = [
                            'id' => $item->id,
                            'name' => $item->name,
                            'description' => $item->description,
                            'unit' => $item->unit,
                            'quantity' => 1,
                            'is_new' => false
                        ];
                    }
                }
            }

            $this->tempSelectedItems = [];
            $this->alert('success', 'تم إضافة البنود المحددة بنجاح');
        }
    }

    public function removeItem($index)
    {
        unset($this->selectedItems[$index]);
        $this->selectedItems = array_values($this->selectedItems);
    }

    public function loadSelectedQuestions()
    {
        $tenders = Tender::all();
        foreach ($tenders as $tender) {
            $this->selectedQuestions[$tender->id] = $tender->questions->pluck('id')->toArray();
        }
    }

    public function updateQuestions($tenderId)
    {
        $tender = Tender::find($tenderId);
        $tender->questions()->sync($this->selectedQuestions[$tenderId]);

        $this->alert('success', trans('translation.update_success'));
    }

    public function loadSelectedCommittes()
    {
        $tenders = Tender::all();
        foreach ($tenders as $tender) {
            $this->selectedCommittes[$tender->id] = $tender->committes->pluck('id')->toArray();
        }
    }

    public function updateCommittes($tenderId)
    {
        $tender = Tender::find($tenderId);

        $syncData = [];

        foreach ($this->selectedCommittes[$tenderId] as $committeeId) {
            $user = User::find($committeeId);
            $committeeType = $user->type == 3 ? 'internal' : 'external';

            $syncData[$committeeId] = ['committee_type' => $committeeType];
        }

        $tender->committes()->sync($syncData);

        $this->alert('success', trans('translation.update_success'));
    }

    public function index()
    {
        return view('livewire.tenders.index');
    }

    public function render()
    {
        if (auth()->user()->type == 1) {
            $tenders = Tender::paginate(20);
            $committes = User::whereIn('type', [3, 4])->get();
            $questions = Question::all();

            foreach ($tenders as $tender) {
                $approvalCount = TenderCommitte::where('tender_id', $tender->id)
                    ->where('approval', 1)
                    ->count();
                $totalCount = TenderCommitte::where('tender_id', $tender->id)->count();
                $tender->is_can_open = ($tender->end_date <= Carbon::now() || $tender->status == 4 && $approvalCount === $totalCount);
            }

            return view('livewire.tenders.tenders-table', compact('questions', 'tenders', 'committes'));
        } else if (auth()->user()->type == 2) {
            $tenders = Tender::where('status', 1)->paginate(20);

            $tenderIds = $tenders->pluck('id')->toArray();
            $tenderQuestions = \DB::table('tender_questions')
                ->whereIn('tender_id', $tenderIds)
                ->get()
                ->groupBy('tender_id');

            $allQuestionIds = \DB::table('tender_questions')
                ->whereIn('tender_id', $tenderIds)
                ->pluck('question_id')
                ->unique()
                ->toArray();

            $questions = Question::whereIn('id', $allQuestionIds)
                ->with('Answer')
                ->get()
                ->keyBy('id');

            $tenders->getCollection()->transform(function ($tender) use ($tenderQuestions, $questions) {
                $tender->can_apply = !ApplicantTender::where('user_id', auth()->user()->id)
                    ->where('tender_id', $tender->id)
                    ->exists();

                $tender->questions = collect();
                if (isset($tenderQuestions[$tender->id])) {
                    foreach ($tenderQuestions[$tender->id] as $tq) {
                        if (isset($questions[$tq->question_id])) {
                            $tender->questions->push($questions[$tq->question_id]);
                        }
                    }
                }

                return $tender;
            });

            return view('livewire.tenders.company-tender-table', compact('tenders'));
        } else if (auth()->user()->type == 3) {

            $tenders_id = TenderCommitte::where('user_id', auth()->user()->id)->pluck('tender_id')->toArray();

            $tenders = Tender::wherein('id', $tenders_id)->with('committes')->paginate(20);

            foreach ($tenders as $tender) {
                $approvalCount = TenderCommitte::where('tender_id', $tender->id)
                    ->where('approval', 1)
                    ->count();
                $totalCount = TenderCommitte::where('tender_id', $tender->id)->count();
                $tender->is_can_open = ($tender->end_date <= Carbon::now() || $tender->status == 4 && $approvalCount === $totalCount);
            }

            return view('livewire.tenders.committes-tender-table', compact('tenders'));
        }
    }

    public function create()
    {
        $startDate = Carbon::parse($this->newTender['start_date'])->startOfDay();
        $endDate = Carbon::parse($this->newTender['end_date'])->startOfDay();
        $currentDate = Carbon::now()->startOfDay();

        if ($startDate < $currentDate || $endDate < $currentDate) {
            $this->alert('warning', "لا يمكن ان يكون وقت بداية او نهاية العطاء قبل الوقت الحالي");
            return;
        } else if (Carbon::parse($this->newTender['end_date'])->isBefore(Carbon::parse($this->newTender['start_date']))) {
            $this->alert('warning', "لا يمكن ان يكون تاريخ بداية العطاء بعد تاريخ نهاية العطاء");
            return;
        }

        if (empty($this->selectedItems)) {
            $this->alert('warning', 'يجب إضافة بند واحد على الأقل للعطاء');
            return;
        }

        foreach ($this->selectedItems as $item) {
            if ($item['is_new']) {
                if (empty($item['name']) || empty($item['unit']) || !isset($item['quantity']) || $item['quantity'] <= 0) {
                    $this->alert('warning', 'يرجى التأكد من إكمال جميع بيانات البنود الجديدة');
                    return;
                }
            } else {
                if (!isset($item['quantity']) || $item['quantity'] <= 0) {
                    $this->alert('warning', 'يرجى التأكد من إدخال كمية صحيحة لجميع البنود');
                    return;
                }
            }
        }

        $newTender = new Tender;
        $newTender->title = $this->newTender['title'];
        $newTender->description = $this->newTender['description'];
        $newTender->start_date = Carbon::parse($this->newTender['start_date']);
        $newTender->end_date = Carbon::parse($this->newTender['end_date']);
        $newTender->winner_id = null;
        $newTender->status = 0;
        $newTender->created_by = auth()->user()->id;
        $newTender->save();

        foreach ($this->selectedItems as $itemData) {
            if ($itemData['is_new']) {
                $newItem = new Item();
                $newItem->name = $itemData['name'];
                $newItem->description = $itemData['description'];
                $newItem->unit = $itemData['unit'];
                $newItem->save();

                $itemId = $newItem->id;
            } else {
                $itemId = $itemData['id'];
            }

            $tenderItem = new TenderItem();
            $tenderItem->tender_id = $newTender->id;
            $tenderItem->item_id = $itemId;
            $tenderItem->quantity = $itemData['quantity'];
            $tenderItem->save();
        }

        $this->newTender = [
            'title' => '',
            'description' => '',
            'status' => '',
            'start_date' => null,
            'end_date' => null,
        ];
        $this->selectedItems = [];
        $this->tempSelectedItems = [];

        $this->alert('success', 'تم إضافة العطاء بنجاح');
    }

    public function update($id, $field, $value)
    {
        $Tender = Tender::findOrFail($id);
        $Tender->$field = $value;
        $Tender->save();

        $this->alert('success', trans('translation.update_success'));
    }

    public function delete(Tender $Tender)
    {
        TenderCommitte::where('tender_id', $Tender->id)->delete();
        TenderQuestion::where('tender_id', $Tender->id)->delete();
        TenderItem::where('tender_id', $Tender->id)->delete();

        ApplicantAnswer::where('tender_id', $Tender->id)->delete();
        ApplicantTender::where('tender_id', $Tender->id)->delete();
        $Tender->delete();

        $this->alert('success', trans('translation.delete_success'));
    }

    public function CommittesApprove($tender_id)
    {
        TenderCommitte::where('tender_id', $tender_id)
            ->where('user_id', auth()->user()->id)
            ->update(['approval' => 1]);
        $this->alert('success', "تم الموافقة على فتح العطاء");
    }

    public function setTenderId($id)
    {
        $this->tenderId = $id;
        $this->loadTenderDetails($id);
    }

    public function loadTenderDetails($tenderId)
    {
        $this->currentTender = Tender::with(['questions', 'questions.Answer'])->find($tenderId);

        $this->tenderItems = TenderItem::where('tender_id', $tenderId)
            ->with('item')
            ->get()
            ->map(function ($tenderItem) {
                return [
                    'id' => $tenderItem->id,
                    'name' => $tenderItem->item->name,
                    'description' => $tenderItem->item->description,
                    'unit' => $tenderItem->item->unit,
                    'quantity' => $tenderItem->quantity,
                ];
            })->toArray();

        $this->currentTenderQuestions = $this->currentTender->questions->toArray();

        $this->selectedTenderItems = [];
        $this->totalBidAmount = 0;
    }

    public function toggleTenderItem($tenderItemId)
    {
        if (
            !isset($this->selectedTenderItems[$tenderItemId]['selected']) ||
            !$this->selectedTenderItems[$tenderItemId]['selected']
        ) {
            unset($this->selectedTenderItems[$tenderItemId]);
        } else {
            if (!isset($this->selectedTenderItems[$tenderItemId]['price'])) {
                $this->selectedTenderItems[$tenderItemId]['price'] = '';
            }
        }
        $this->calculateTotalBidAmount();
    }

    public function calculateTotal($tenderItemId)
    {
        $this->calculateTotalBidAmount();
    }

    public function calculateTotalBidAmount()
    {
        $total = 0;
        foreach ($this->selectedTenderItems as $itemId => $itemData) {
            if (isset($itemData['selected']) && $itemData['selected'] && isset($itemData['price'])) {
                $tenderItem = collect($this->tenderItems)->firstWhere('id', $itemId);
                if ($tenderItem) {
                    $total += (is_numeric($itemData['price']) ? (float)$itemData['price'] : 0)
                        * (is_numeric($tenderItem['quantity']) ? (float)$tenderItem['quantity'] : 0);
                }
            }
        }
        $this->totalBidAmount = $total;
    }

    public function ApplyTenderWithItems()
    {
        $hasSelectedItems = false;
        foreach ($this->selectedTenderItems as $itemData) {
            if (isset($itemData['selected']) && $itemData['selected']) {
                $hasSelectedItems = true;
                break;
            }
        }

        if (!$hasSelectedItems) {
            $this->alert('error', 'يجب اختيار بند واحد على الأقل للتقدم للعطاء');
            return;
        }

        foreach ($this->selectedTenderItems as $itemId => $itemData) {
            if (isset($itemData['selected']) && $itemData['selected']) {
                if (empty($itemData['price']) || $itemData['price'] <= 0) {
                    $this->alert('error', 'يرجى إدخال سعر صحيح لجميع البنود المختارة');
                    return;
                }
            }
        }

        $numOfQuestion = count($this->currentTenderQuestions);
        if ($numOfQuestion > 0 && (empty($this->questionAnswers) || count($this->questionAnswers) != $numOfQuestion)) {
            $this->alert('error', "يرجى التأكد من الإجابة على جميع الأسئلة");
            return;
        }

        if (ApplicantTender::where('user_id', auth()->user()->id)->where('tender_id', $this->tenderId)->exists()) {
            $this->alert('error', "تم التقديم مسبقاً لهذا العطاء");
            return;
        }

        $allowedFileTypes = ['pdf', 'jpg', 'jpeg', 'png'];
        $maxFileSize = 1 * 1024 * 1024;

        foreach ($this->questionAnswers as $key => $value) {
            $question_type = Question::where('id', $key)->first();

            $ApplicationAnswer = new ApplicantAnswer();
            $ApplicationAnswer->tender_id = $this->tenderId;
            $ApplicationAnswer->question_id = $key;
            $ApplicationAnswer->user_id = auth()->user()->id;

            if ($question_type->Answer->answer_type == "file") {
                $fileExtension = $value->extension();

                if (!in_array($fileExtension, $allowedFileTypes) || $value->getSize() > $maxFileSize) {
                    continue;
                }

                $file_extension = time() . '_' . uniqid() . '.' . $value->extension();
                $value->storeAs('public/AnswersFile', $file_extension);
                $ApplicationAnswer->answer = 'AnswersFile/' . $file_extension;
            } else {
                $ApplicationAnswer->answer = $value;
            }
            $ApplicationAnswer->save();
        }

        $ApplicantTender = new ApplicantTender();
        $ApplicantTender->user_id = auth()->user()->id;
        $ApplicantTender->tender_id = $this->tenderId;
        $ApplicantTender->save();

        foreach ($this->selectedTenderItems as $itemId => $itemData) {
            if (isset($itemData['selected']) && $itemData['selected'] && !empty($itemData['price'])) {
                $applicantTenderItem = new ApplicantTenderItem();
                $applicantTenderItem->applicant_tender_id = $ApplicantTender->id;
                $applicantTenderItem->tender_item_id = $itemId;
                $applicantTenderItem->price = $itemData['price'];
                $applicantTenderItem->save();
            }
        }

        $this->selectedTenderItems = [];
        $this->questionAnswers = [];
        $this->totalBidAmount = 0;

        $this->alert('success', "تم تقديم العرض بنجاح");
        $this->dispatch('CloseModel');
    }

    public function ApplyTender()
    {
        $this->ApplyTenderWithItems();
    }

    public function PublishTender($tender_id)
    {
        Tender::where('id', $tender_id)
            ->update(['status' => 1]);

        $this->alert('success', "تم نشر العطاء");
    }

    public function filterCommittes($type)
    {
        $this->committeeTypeFilter = $type;
    }
}
