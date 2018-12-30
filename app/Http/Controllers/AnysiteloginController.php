<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class AnysiteloginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    //   /* login with twitter*/
    public function redirectToProvider($service)
    {
        return Socialite::driver($service)->redirect();
    }

    public function handleProviderCallback($service)
    {
        $userSocial = Socialite::driver($service)->user();

        $findUser=User::where('email',$userSocial->email)->first();
        if ($findUser)
        {
            Auth::login($findUser);
            return 'done with old';
        }
        else{
            $user=new User;
            $user->name=$userSocial->name;
            $user->email=$userSocial->email;
            $user->password=bcrypt(123456);
            $user->save();
            Auth::login($user);
            return 'done with new';
        }

    }
}
