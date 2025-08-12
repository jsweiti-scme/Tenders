<?php

namespace App\Livewire\Companies;

use App\Models\City;
use App\Models\CompanyInfo;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class CompaniesTable extends Component
{
    use LivewireAlert, WithFileUploads;

    public $newCompany =
    [
        "email" => "",
        "password" => "",
        "password_confirmation" => "",
        "company_name" => "",
        "phone_number" => "",
        "mobile_number" => "",
        "city_id" => "",
        "address" => "",
        "license_worker_number" => "",
        "license_worker_certification" => "",
        "discount_certification_issuer" => "",
        "discount_certification_issuer_expired_date" => null,
    ];
    public function index()
    {
        return view('livewire.companies.index');
    }
    public function render()
    {
        $companies = User::where('type', 2)->with('CompanyInfo', 'CompanyInfo.City')->paginate(20);

        $cities = City::all();

        return view('livewire.companies.companies-table', compact('companies', 'cities'));
    }

    public function active(User $User)
    {
        if ($User->status == 0) {
            $User->status = 1;
            $this->alert('success', "تم تفعيل الحساب بنجاح");
        } else {
            $User->status = 0;
            $this->alert('warning', "تم حظر الحساب بنجاح");
        }

        $User->save();
    }

    public function create()
    {
        $this->validate([
            'newCompany.email' => 'required|string|max:255|email',
            'newCompany.password' => 'required|string|min:6|confirmed',
            'newCompany.password_confirmation' => 'required|string',
            'newCompany.city_id' => 'required|integer',
        ]);


        $newUser = new User();
        $newUser->email = $this->newCompany['email'];
        $newUser->name = $this->newCompany['company_name'];
        $newUser->type = 2;
        $newUser->password = Hash::make($this->newCompany['password']);
        $newUser->status = 1;
        $newUser->email_verified_at = Carbon::now();
        $newUser->save();

        $newCompany = new CompanyInfo();
        $newCompany->company_name = $this->newCompany['company_name'];
        $newCompany->mobile_number = $this->newCompany['mobile_number'];
        $newCompany->phone_number = $this->newCompany['phone_number'];
        $newCompany->address = $this->newCompany['address'];
        $newCompany->license_worker_number = $this->newCompany['license_worker_number'];
        $newCompany->user_id = $newUser->id;
        $newCompany->city_id = $this->newCompany['city_id'];


        if (isset($this->newCompany['discount_certification_issuer_expired_date'])) {
            $newCompany->discount_certification_issuer_expired_date = $this->newCompany['discount_certification_issuer_expired_date'];
        } else {
            $newCompany->discount_certification_issuer_expired_date = null;
        }



        if (isset($this->newCompany['license_worker_certification']) && $this->newCompany['license_worker_certification'] instanceof \Illuminate\Http\UploadedFile) {
            $license_worker_certificationimageName = time() . '.' . $this->newCompany['license_worker_certification']->extension();
            $this->newCompany['license_worker_certification']->storeAs('public/Certifications', $license_worker_certificationimageName);
            $newCompany->license_worker_certification = 'Certifications/' . $license_worker_certificationimageName;
        } else {
            $newCompany->license_worker_certification = 'Certifications/noImage.jpg';
        }

        // Check if discount_certification_issuer has a file before storing
        if (isset($this->newCompany['discount_certification_issuer']) && $this->newCompany['discount_certification_issuer'] instanceof \Illuminate\Http\UploadedFile) {
            $discount_certification_issuerimageName = time() . '.' . $this->newCompany['discount_certification_issuer']->extension();
            $this->newCompany['discount_certification_issuer']->storeAs('public/Certifications', $discount_certification_issuerimageName);
            $newCompany->discount_certification_issuer = 'Certifications/' . $discount_certification_issuerimageName;
        } else {
            $newCompany->discount_certification_issuer = 'Certifications/noImage.jpg';
        }


        $newCompany->save();

        $this->reset(['newCompany']);

        $this->alert('success', trans('translation.add_success'));
    }
}