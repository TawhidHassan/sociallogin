<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class TwitterController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    //   /* login with twitter*/
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleProviderCallback()
    {
        $userSocial = Socialite::driver('twitter')->user();

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
