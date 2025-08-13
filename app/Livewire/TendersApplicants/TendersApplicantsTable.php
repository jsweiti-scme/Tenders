<?php

namespace App\Livewire\TendersApplicants;

use App\Models\ApplicantTender;
use App\Models\ApplicantAnswer;
use App\Models\TenderQuestion;
use App\Models\Question;
use App\Models\Tender;
use Livewire\Component;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TendersApplicantsTable extends Component
{
    use LivewireAlert;

    public $id;
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
        $tenderId = $this->id; // خزن قيمة id في متغير محلي

        $applicants_ids = ApplicantTender::where('tender_id', $tenderId)->pluck('user_id')->toArray();

        $applicants = User::whereIn('id', $applicants_ids)
            ->with('CompanyInfo')
            ->with(['applicantAnswers.question.Answer'])
            ->with(['applicantTenderItems' => function ($query) use ($tenderId) {
                $query->whereHas('applicantTender', function ($q) use ($tenderId) {
                    $q->where('tender_id', $tenderId);
                })->with('tenderItem.item');
            }])
            ->paginate(20);

        $tender = Tender::find($tenderId);
        return view('livewire.tenders-applicants.tenders-applicants-table', compact('applicants', 'tender'));
    }




    public function SetWinner($winner_id)
    {
        Tender::where('id', $this->id)->update(['winner_id' => $winner_id]);
        $this->alert('success', "تم ارساء العطاء بنجاح");
    }
}
