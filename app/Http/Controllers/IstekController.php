<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use Auth;
use App\Elan;
class IstekController extends Controller
{
  //<================= METHHOD FOR SHOW PAGE ================>
    public function show()
    {
      return view('pages.istek_add');
    }

  //<================= METHHOD FOR ISTEK_ADD PAGE ================>
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


  //<================= METHHOD FOR ISTEK_EDIT ================>
  public function istek_edit($id)
  {
    $istek_edit = Elan::find($id);
    return view('pages.istek_edit',compact('istek_edit'));
  }


  //<================= METHHOD FOR ISTEK_EDIT ================>
  public function istek_update(Request $req,$id)
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
       Session::flash('istek_edited' , "İstəyiniz uğurla dəyişdirildi və yoxlamadan keçəndən sonra dərc olunacaq.");
       $istek_update = Elan::find($id);
       $istek_update->title = $req->title;
       $istek_update->location = $req->location;
       $istek_update->lat = $req->lat;
       $istek_update->lng = $req->lng;
       $istek_update->about = $req->about;
       $istek_update->image = $photoname;
       $istek_update->name = $req->name;
       $istek_update->email = $req->email;
       $istek_update->org = $req->org;
       $istek_update->nov = $req->nov;
       $istek_update->deadline = $req->date;
       $istek_update->phone = $req->phone;
       $istek_update->status = 0;
       $istek_update->update();
       return redirect("/istek-edit/$istek_update->id");
  }


  //<================= METHHOD FOR ISTEK_EDIT ================>
   public function istek_delete($id)
   {
     $istek_delete=Elan::find($id);
     unlink('image/'.$istek_delete->image);
     $istek_delete->delete();
     return back();
   }
}
