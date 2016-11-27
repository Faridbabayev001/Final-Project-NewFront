<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Elan;

class AdminController extends Controller
{
    public function index()
    {
      $users = User::all();
      $istek_count = Elan::where('type_id', 2);
      $destek_count = Elan::where('type_id', 1);
      return view('admin.index',compact('users','istek_count','destek_count'));
    }

    public function istek_list()
    {
      $istekler=Elan::all();
      return view('admin.istek_list',compact('istekler'));
    }

    public function destek_list()
    {
      $destekler=Elan::all();
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
}
