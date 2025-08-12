<?php

namespace App\Livewire\Tenders;

use App\Models\ApplicantAnswer;
use App\Models\ApplicantTender;
use App\Models\Question;
use Livewire\Component;
use App\Models\Tender;
use App\Models\TenderCommitte;
use App\Models\TenderQuestion;
use App\Models\User;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;

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


    public function mount()
    {
        $this->loadSelectedCommittes();
        $this->loadSelectedQuestions();
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

            return view('livewire.tenders.tenders-table', compact('tenders', 'committes', 'questions'));
        } else if (auth()->user()->type == 2) {
            $tenders = Tender::where('status', 1)->paginate(20);
            $tenders->getCollection()->transform(function ($tender) {
                $tender->can_apply = !ApplicantTender::where('user_id', auth()->user()->id)
                    ->where('tender_id', $tender->id)
                    ->exists();
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
        } else if (Carbon::parse($this->newTender['end_date'])->isBefore(Carbon::parse($this->newTender['start_date']))) {
            $this->alert('warning', trans("لا يمكن ان يكون تاريخ بداية العطاء بعد تاريخ نهاية العطاء"));
        } else {
            $newTender = new Tender;

            $newTender->title = $this->newTender['title'];
            $newTender->description = $this->newTender['description'];
            $newTender->start_date = Carbon::parse($this->newTender['start_date']);
            $newTender->end_date = Carbon::parse($this->newTender['end_date']);


            $newTender->winner_id = null;
            $newTender->status = 0;
            $newTender->created_by = auth()->user()->id;
            $newTender->save();

            $this->newTender = [
                'title' => '',
                'description' => '',
                'status' => '',
                'start_date' => null,
                'end_date' => null,
            ];

            $this->alert('success', trans('translation.add_success'));
        }
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


        // Now delete the tender
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
    }

    public function ApplyTender()
    {
        $numOfQuestion = TenderQuestion::where('tender_id', $this->tenderId)->count();

        if ($this->questionAnswers == null || count($this->questionAnswers) != $numOfQuestion) {
            $this->alert('error', "يرجى التأكد من الاجابة على جميع الاسئلة - صيغة وحجم المرفقات");
        } else if (ApplicantTender::where('user_id', auth()->user()->id)->where('tender_id', $this->tenderId)->count() > 0) {
            $this->alert('error', "تم التقديم مسبقاً");
        } else {
            $allowedFileTypes = ['pdf', 'jpg', 'jpeg', 'png'];
            $maxFileSize = 1 * 1024 * 1024; // 1 MB
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
            $ApplicantTender->user_id =  auth()->user()->id;
            $ApplicantTender->tender_id = $this->tenderId;
            $ApplicantTender->save();

            $this->alert('success', "تم التقديم للعطاء بنجاح");

            $this->dispatch('CloseModel');
        }
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