<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class GoogleLoginController extends Controller
{
    use LivewireAlert;
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $existingUser = User::where('email', $user->email)->first();
            
            if ($existingUser) 
            {
                $BanUser = User::where('id',$existingUser->id)->first();
                if($BanUser->blocked)
                {
                    return redirect()->to('/login')->with('error-message', 'لقد تم حظر حسابك من الدخول مؤقتاً يرجى التواصل مع دائرة المشتريات');
                }
                else
                {
                    Auth::login($existingUser);
                }
            } 
            else 
            {
                return redirect()->to('/login')->with('error-message', 'ليس لديك حساب على النظام يرجى التواصل مع دائرة المشتريات');
            }

            return redirect()->to('/dashboard'); // Redirect to the user's dashboard
        } catch (Exception $e) {
            return redirect()->to('/login')->with('error-message', 'Google login failed.');
        }
    }


    public function LoginCommitts()
    {
        if (Auth::check()) 
        {
            return redirect()->to('dashboard');
        }
        return view('auth.login-committs');
    }
}
