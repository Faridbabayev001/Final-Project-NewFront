<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use App\Elan;
use App\Photo;
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
      // 'image' => 'required',
      'nov' => 'required',
]);

  // $direction='image';
  // $filetype=$req->file('image')->getClientOriginalExtension();
  // if ($filetype=='jpg' || $filetype=='jpeg' || $filetype=='png') {
  //   $filename=time().'.'.$filetype;
  //   $req->file('image')->move(public_path('image'),$filename);
  //   Session::flash('destekadded' , "İstəyiniz uğurla əlavə olundu və yoxlamadan keçəndən sonra dərc olunacaq.");

     $files = $req->file('image');
     $pic_name = array();
     foreach ($files as $file) {
       $filetype=$file->getClientOriginalExtension();
       // echo "$filetype";
       if($filetype=='jpg' || $filetype=='jpeg' || $filetype=='png'){
          array_push($pic_name, $filetype);
       }
       else{
         Session::flash('imageerror' , "Xahiş olunur şəkili düzgun yükləyəsiniz.");
          return redirect('/istek-add');
       }
     }

    $data = [
          'type_id'=>'1',
          'title'=>$req->title,
          'about'=>$req->about,
          'location'=>$req->location,
          'lat'=>$req->lat,
          'lng'=>$req->lng,
          'name'=>$req->name,
          'phone'=>'+994'.$req->operator.$req->phone,
          'email'=>$req->email,
          // 'image'=>$filename,
          'org'=>$req->org,
          'nov'=>$req->nov,
          'deadline'=>$req->date
        ];
     // Auth::user()->elanlar()->create($data);

        $insert_pic_id = Auth::user()->elanlar()->create($data)->shekiller();
          $files = $req->file('image');

          foreach ($files as $file) {
            $file_name =  time().$file->getClientOriginalName();
            $file->move(public_path('image'),$file_name);
            $data = new Photo;
            $data->imageName = $file_name;
            $insert_pic_id->save($data);
          }
       return redirect('/destek-add');
  // }
  //  else
  //   {
  //     Session::flash('imageerror' , "Xahiş olunur şəkli düzgün seçəsiniz.");
   // }
  }
}
