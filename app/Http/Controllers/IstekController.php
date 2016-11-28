<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use Auth;

class IstekController extends Controller
{
    public function show()
    {
      return view('pages.istek_add');
    }

    public function istek_add(Request $req)
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
     Session::flash('istekadded' , "İstəyiniz uğurla  əlavə olundu və yoxlamadan keçəndən sonra dərc olunacaq.");
     $data = [
           'type_id'=>'2',
           'title'=>$req->title,
           'view' => '0',
           'about'=>$req->about,
           'location'=>$req->location,
           'lat'=>$req->lat,
           'lng'=>$req->lng,
           'name'=>$req->name,
           'phone'=>'+994'.$req->operator.$req->phone,
           'email'=>$req->email,
           'image'=>$filename,
           'org'=>$req->org,
           'nov'=>$req->nov,
           'deadline'=>$req->date
         ];
      Auth::user()->elanlar()->create($data);
        return redirect('/istek-add');
   }
    else
     {
       Session::flash('imageerror' , "Xahiş olunur şəkili düzgun yükləyəsiniz.");
      return redirect('/istek-add');
    }
  }
}
