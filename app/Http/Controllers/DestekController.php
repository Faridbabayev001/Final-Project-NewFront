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

  $direction='image';
  $filetype=$req->file('image')->getClientOriginalExtension();
  if ($filetype=='jpg' || $filetype=='jpeg' || $filetype=='png') {
    $filename=time().'.'.$filetype;
    $req->file('image')->move(public_path('image'),$filename);
    Session::flash('destekadded' , "İstəyiniz uğurla əlavə olundu və yoxlamadan keçəndən sonra dərc olunacaq.");
    $data = [
          'type_id'=>'2',
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
          'nov'=>$req->nov,
          'deadline'=>$req->date
        ];
     Auth::user()->elanlar()->create($data);
       return redirect('/destek-add');
  }
   else
    {
      Session::flash('imageerror' , "Xahiş olunur şəkli düzgün seçəsiniz.");
     return redirect('/destek-add');
   }
  }
}
