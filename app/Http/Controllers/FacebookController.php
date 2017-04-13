<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Session;
use App\Http\Requests;

class FacebookController extends Controller
{
   /**
    * Redirect the user to the GitHub authentication page.
    *
    * @return Response
    */
   public function redirectToProvider()
   {
       // dd(Socialite::driver('facebook'));
       return Socialite::driver('facebook')->redirect();
   }

   /**
    * Obtain the user information from GitHub.
    *
    * @return Response
    */
   public function handleProviderCallback()
   {
       $users = Socialite::driver('facebook')->user();
       $user = $users->getName();
       $myEmail = $users->getEmail();

       Session::flash('user',$user);
       Session::flash('email',$myEmail);
       return redirect('/qeydiyyat');


       // $user->token;
   }
}
