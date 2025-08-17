<?php

namespace App\Livewire\TendersApplicants;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use App\Models\ApplicantTender;
use App\Models\ApplicantAnswer;
use App\Models\TenderQuestion;
use App\Models\Question;
use App\Models\Tender;
use App\Models\User;
use App\Models\TenderItemAward;
use App\Models\TenderItem;
use App\Models\ApplicantTenderItem;

class TendersApplicantsTable extends Component
{
    use LivewireAlert;

    public $id;
    public $selectedItemId;
    public $selectedApplicantItemId;
    public $awardNotes = '';
    public $showItemAwardModal = false;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function index($id)
    {
        $this->id = $id;
        return view('livewire.tenders-applicants.index', compact('id'));
    }

    public function render()
    {
        $tenderId = $this->id;

        $applicants_ids = ApplicantTender::where('tender_id', $tenderId)->pluck('user_id')->toArray();

        $applicants = User::whereIn('id', $applicants_ids)
            ->with('CompanyInfo')
            ->with([
                'applicantAnswers' => function ($query) use ($tenderId) {
                    $query->where('tender_id', $tenderId)
                        ->with('question.Answer');
                }
            ])
            ->with([
                'applicantTenderItems' => function ($query) use ($tenderId) {
                    $query->whereHas('applicantTender', function ($q) use ($tenderId) {
                        $q->where('tender_id', $tenderId);
                    })->with('tenderItem.item');
                }
            ])
            ->paginate(20);

        $tender = Tender::with([
            'tenderItems.item',
            'tenderItems.award.winner.companyInfo',
            'tenderItems.applicantItems.applicantTender.user.companyInfo'
        ])->find($tenderId);

        return view('livewire.tenders-applicants.tenders-applicants-table', compact('applicants', 'tender'));
    }

    public function SetWinner($winner_id)
    {
        Tender::where('id', $this->id)->update(['winner_id' => $winner_id]);
        $this->alert('success', "تم ارساء العطاء بنجاح");
    }

    public function awardItem($tenderItemId, $applicantTenderItemId)
    {
        $tenderItem = TenderItem::find($tenderItemId);
        $applicantItem = ApplicantTenderItem::find($applicantTenderItemId);

        if (!$tenderItem || !$applicantItem) {
            $this->alert('error', 'العنصر غير موجود');
            return;
        }

        if ($tenderItem->award) {
            $this->alert('warning', 'العنصر مُرسى مسبقاً');
            return;
        }

        try {
            TenderItemAward::create([
                'tender_id' => $this->id,
                'tender_item_id' => $tenderItemId,
                'winner_user_id' => $applicantItem->applicantTender->user_id,
                'applicant_tender_item_id' => $applicantTenderItemId,
                'awarded_price' => $applicantItem->price,
                'awarded_quantity' => $tenderItem->quantity,
                'notes' => $this->awardNotes,
                'awarded_at' => now(),
                'awarded_by' => auth()->id()
            ]);

            $tenderItem->update(['award_status' => 'awarded']);

            $tender = Tender::find($this->id);
            $tender->updateAwardStatus();

            $this->alert('success', 'تم إرساء العنصر بنجاح');
            $this->reset(['awardNotes', 'showItemAwardModal']);
        } catch (\Exception $e) {
            $this->alert('error', 'حدث خطأ أثناء الإرساء');
        }
    }

    public function cancelItemAward($tenderItemId)
    {
        $tenderItem = TenderItem::find($tenderItemId);

        if (!$tenderItem || !$tenderItem->award) {
            $this->alert('error', 'العنصر غير مُرسى');
            return;
        }

        try {
            $tenderItem->award->delete();
            $tenderItem->update(['award_status' => 'pending']);

            $tender = Tender::find($this->id);
            $tender->updateAwardStatus();

            $this->alert('success', 'تم إلغاء إرساء العنصر');
        } catch (\Exception $e) {
            $this->alert('error', 'حدث خطأ أثناء إلغاء الإرساء');
        }
    }
}
