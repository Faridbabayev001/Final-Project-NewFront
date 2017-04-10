<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Session;

use App\User;
use App\Elan;
use App\Admin;
use Auth;
use Carbon\Carbon;
use App\Qarsiliq;

class AdminController extends Controller
{
  //========================For Admin Login===========================
  public function login()
  {
     return view('admin.admin_login');
  }

  public function postLogin(Request $request)
  {
    $email = $request->email;
    $password = md5($request->password);
    $validator= validator($request->all(), [
      'email' => 'required|min:3|max:100',
      'password' => 'required|min:3|max:100',
  ]);

    if ($validator->fails() ) {
        return redirect('/alfagen/login')
                ->withErrors($validator)
                ->withInput();
    }
    if (isset($_SESSION))
    {
      $admins = Admin::all();
      foreach ($admins as $admin) {
        if ($admin->email == $email && $admin->password == $password) {
          $_SESSION['admin'] = 'admin';


        //cheking non activated users and deleting after 30days///////////////////////////////////////

          $users = User::all()->where('activated', '=', '0');

          $now = Carbon::now();

            foreach ($users as $dat) {

              $createdUser = new Carbon($dat['created_at']);
              $diffbtwUserNow = $createdUser->diff($now)->days;

                if ($diffbtwUserNow >= 30) {

                  User::find($dat['id'])->delete();

                }
            }

        //end////////////////////////////////////////////////////////


          return redirect('/alfagen');
        }else {
          return redirect('/alfagen/login')
                  ->withErrors(['errors' => 'Duzgun deyl!'])
                  ->withInput();
        }
      }
    }
    else
    {
      session_start();
      // return redirect('/alfagen/login')
      //         ->withErrors(['errors' => 'Duzgun deyl!'])
      //         ->withInput();
    }
  }
  public function logout()
    {
      unset($_SESSION['admin']);
      auth()->guard('admin')->logout();
      return redirect('/alfagen/login');
    }
  //========================For Admin Login End=======================
    public function index()
    {
      $user = User::orderBy('created_at','desc');
      $users = $user->paginate(8);
      $user_count = $user->get()->count();
      $istek_count = Elan::where('type_id', 2)->get()->count();
      $destek_count = Elan::where('type_id', 1)->get()->count();

      return view('admin.index',compact('users','istek_count','destek_count', 'user_count'));
    }

    public function istek_list()
    {
      $istekler=Elan::orderBy('created_at','desc')->paginate(8);
      return view('admin.istek_list',compact('istekler'));
    }

    public function destek_list()
    {
      $destekler=Elan::orderBy('created_at','desc')->paginate(8);
      return view('admin.destek_list',compact('destekler'));
    }

    public function activate($id)
    {

      $status=Elan::find($id);
      $status->status='1';
      $status->save();
      return back();
    }

    public function deactivate($id)
    {
      $status=Elan::find($id);
      $status->status='0';
      $status->save();
      return back();
    }

    public function elan_edit(Elan $elan)
    {
      return view('admin.elan_edit', compact('elan'));
    }

    public function elan_edit_update(Elan $elan, Request $request)
    {
      $elan->title = $request->title;
      $elan->about = $request->about;

      $elan->update();

      Session::flash('success', 'Elan uğurla yeniləndi.');

      return back();
    }
    public function qarsiliq()
    {
      $qarsiliqs = Qarsiliq::paginate(10);
      $zeroCount = Qarsiliq::where('data', 1)->count();
      $oneCount = Qarsiliq::where('data', 0)->count();


      return view('admin.qarsiliq-list', compact('qarsiliqs', 'zeroCount', 'oneCount'));
    }
}
