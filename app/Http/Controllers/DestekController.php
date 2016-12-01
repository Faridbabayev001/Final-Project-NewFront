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

  public function destek_edit($id)
  {
    $destek_edit = Elan::find($id);
    return view('pages.destek_edit',compact('destek_edit'));
  }

  public function destek_update(Request $req,$id)
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
        'nov' => 'required',
]);
   if ($req->image == '') {
      $image = Elan::find($id);
      $photoname = $image->image;
    }
    else{
    // image upload
    $phototype=$req->file('image')->getClientOriginalExtension();
    $photoname=time().'.'.$phototype;
    $req->file('image')->move(public_path('image'),$photoname);

    }
   Session::flash('destek_edited' , "İstəyiniz uğurla dəyişdirildi və yoxlamadan keçəndən sonra dərc olunacaq.");
   $destek_update = Elan::find($id);
   $destek_update->title = $req->title;
   $destek_update->location = $req->location;
   $destek_update->lat = $req->lat;
   $destek_update->lng = $req->lng;
   $destek_update->about = $req->about;
   $destek_update->image = $photoname;
   $destek_update->name = $req->name;
   $destek_update->email = $req->email;
   $destek_update->org = $req->org;
   $destek_update->nov = $req->nov;
   $destek_update->deadline = $req->date;
   $destek_update->phone = $req->phone;
   $destek_update->status = 0;
   $destek_update->update();
   return redirect("/destek-edit/$destek_update->id");
  }
}
