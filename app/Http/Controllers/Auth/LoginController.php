<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

//    /*login wi=ith facebook*/
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback()
    {
        $userSocial = Socialite::driver('facebook')->stateless()->user();

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



    /*-----------------------------------------------------*/


}
