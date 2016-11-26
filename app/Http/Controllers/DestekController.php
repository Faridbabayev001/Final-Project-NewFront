<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use App\Elan;
use Session;
class DestekController extends Controller
{
  public function show()
  {
    return view('pages.destek_add');
  }
  public function destek_add(Request $req)
  {
    $this->validate($req, [
  'title' => 'required',
      'about' => 'required',
      'location' => 'required',
      'lat' => 'required',
      'lng' => 'required',
      'name' => 'required',
      'phone' => 'required',
      'email' => 'required',
      'image' => 'required',
      'nov' => 'required',
]);

  Session::flash('destek_add' , "Dəstəyiniz uğurla əlavə olundu və yoxlamadan keçəndən sonra dərc olunacaq.");
  $direction='images';
  $filetype=$req->file('image')->getClientOriginalExtension();
  $filename=time().'.'.$filetype;
  $req->file('image')->move(public_path('image'),$filename);

  $data = [
        'type_id'=>'1',
        'title'=>$req->title,
        'view' => '0',
        'about'=>$req->about,
        'location'=>$req->location,
        'lat'=>$req->lat,
        'lng'=>$req->lng,
        'name'=>$req->name,
        'phone'=>$req->phone,
        'email'=>$req->email,
        'image'=>$filename,
        'org'=>$req->org,
        'nov'=>$req->nov
      ];

    Auth::user()->elanlar()->create($data);
    return redirect('/destek-add');
  }
}
