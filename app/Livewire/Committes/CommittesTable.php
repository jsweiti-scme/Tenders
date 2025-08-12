<?php

namespace App\Livewire\Committes;

use Livewire\Component;
use App\Models\User;
use App\Models\TenderCommitte;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CommittesTable extends Component
{
    use LivewireAlert;

    public $type = 'internal';

    public $newCommitte = [
        'name' => '',
        'email' => '',
        'job_number' => '',
    ];
    public function index()
    {
        return view('livewire.committes.index');
    }
    public function mount($type = 'internal')
    {
        $this->type = $type;
    }

    public function render()
    {
        $committes = User::where('type', 3)
            ->orWhere('type', 4)
            ->paginate(20);
        return view('livewire.committes.committes-table', compact('committes'));
    }


    public function create()
    {



        if (User::where('job_number', $this->newCommitte['job_number'])->exists() || User::where('email', $this->newCommitte['email'])->exists()) {
            $this->alert('warning', "يرجى التأكد من ان الرقم الوظيفي و البريد الإلكتروني غير مضافين مسبقاً");
            return;
        }

        $emailDomain = explode('@', $this->newCommitte['email'])[1] ?? '';

        if ($emailDomain !== 'scme.edu.ps') {
            $this->alert('warning', "يجب ان يكون البريد الإلكتروني ضمن نطاق الكلية @scme.edu.ps");
            return;
        }

        $pass = Hash::make("@!!Tenders@0599!!");

        $newCommitte = new User;
        $newCommitte->name = $this->newCommitte['name'];
        $newCommitte->email = $this->newCommitte['email'];
        $newCommitte->job_number = $this->newCommitte['job_number'];
        $newCommitte->password = $pass;
        $newCommitte->type = $this->type === 'internal' ? 3 : 4;
        $newCommitte->status = 1;
        $newCommitte->email_verified_at = Carbon::now();
        $newCommitte->save();


        $this->newCommitte = [
            'name' => '',
            'email' => '',
            'job_number' => '',
        ];

        $this->alert('success', trans('translation.add_success'));
    }

    public function delete($id)
    {
        try {
            $committe = User::find($id);

            $activeTenders = TenderCommitte::where('user_id', $id)->count();

            if ($activeTenders > 0) {
                $this->alert('warning', 'لا يمكن حذف عضو اللجنة لوجود عطاءات نشطة مرتبطة به');
                return;
            }

            $committe->delete();

            $this->alert('success', 'تم حذف عضو اللجنة بنجاح');
        } catch (\Exception $e) {
            $this->alert('error', 'حدث خطأ أثناء حذف عضو اللجنة');
        }
    }
}