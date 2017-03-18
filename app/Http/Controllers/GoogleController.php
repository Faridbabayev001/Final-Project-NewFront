<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Socialite;
use Session;

class GoogleController extends Controller
{
   /**
    * Redirect the user to the GitHub authentication page.
    *
    * @return Response
    */
   public function redirectToProvider()
   {
       return Socialite::driver('google')->redirect();
   }

   /**
    * Obtain the user information from GitHub.
    *
    * @return Response
    */
   public function handleProviderCallback()
   {
       $users = Socialite::driver('google')->user();
       $user = $users->getName();
       $myEmail = $users->getEmail();
       Session::flash('user',$user);
       Session::flash('email',$myEmail);
       return redirect('/Qeydiyyat');

       // $user->token;
   }
}
