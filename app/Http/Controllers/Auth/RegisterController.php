<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CompanyInfo;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
class RegisterController extends Controller
{
    use WithFileUploads;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $cities = City::all();
        return view('auth.register',compact('cities'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return  Validator::make($data, [
            'email' => 'required|email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
            ],
            'company_name' => [
                'required',
                'string',
                'max:255',
            ],
            'phone_number' => [
                'required',
            ],
            'mobile_number' => [
                'required',
            ],
            'license_worker_number' => [
                'required',
            ],
            'address' => [
                'required',
                'string',
            ],
        ]);      
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        
        $user = new User();
        $user->email = $data['email'];
        $user->name = $data['company_name'];
        $user->type = 2;
        $user->password = Hash::make($data['password']);
        $user->status = 0;
        $user->save();

        $company_info = new CompanyInfo();
        $company_info->company_name = $data['company_name'];
        $company_info->mobile_number = $data['mobile_number'];
        $company_info->phone_number = $data['phone_number'];
        $company_info->address = $data['address'];
        $company_info->license_worker_number = $data['license_worker_number'];
        $company_info->user_id = $user->id;
        $company_info->city_id = $data['city_id'];
        $company_info->discount_certification_issuer_expired_date = $data['discount_certification_issuer_expired_date'];


        $license_worker_certificationimageName = time() . '.' . $data['license_worker_certification']->extension();
        $data['license_worker_certification']->storeAs('public/Certifications', $license_worker_certificationimageName);
        $company_info->license_worker_certification = 'Certifications/' . $license_worker_certificationimageName;

        $discount_certification_issuerimageName = time() . '.' . $data['discount_certification_issuer']->extension();
        $data['discount_certification_issuer']->storeAs('public/Certifications', $discount_certification_issuerimageName);
        $company_info->discount_certification_issuer = 'Certifications/' . $discount_certification_issuerimageName;

        $company_info->save();


        return $user;
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->create($request->all());

        auth()->login($user);

        return redirect($this->redirectPath());
    }
}
