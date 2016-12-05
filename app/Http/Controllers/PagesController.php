<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Elan;
use App\User;
use Auth;
use DateTime;
use Session;
use Mail;
use App\Qarsiliq;
use App\Photo;
class PagesController extends Controller
{
    public function index(Request $request)
    {
      $datas=Elan::orderBy('created_at','desc')->take(4)->get();
      $datamaps=Elan::all();
      foreach ($datamaps as $check_date) {
      $dbdate=new DateTime($check_date->deadline);
      $newdate=new DateTime('now');
      $diff = date_diff($newdate,$dbdate);
      if ($diff->d == 0 && $diff->m==0) {
        $check_date->status = 0;
        $check_date->update();
      }
    }
    //Ajax search
    if ($request->ajax()) {
      $ElanLocation = $request->ElanLocation;
      $ElanType = $request->ElanType;
        if ($ElanLocation =="all" && $ElanType =="all") {
          $datalar=Elan::all();
          foreach ($datalar as $key => $value) {
            $datalar[$key]['image'] = $value->shekiller[0]->imageName;
          }
        }else if($ElanLocation !=="all" && $ElanType !=="all"){
          $datalar=Elan::where([
            ['location','LIKE','%'.$ElanLocation.'%'],
            ['type_id','LIKE','%'.$ElanType.'%']
        ])->get();
        foreach ($datalar as $key => $value) {
          $datalar[$key]['image'] = $value->shekiller[0]->imageName;
        }
      }else if ($ElanLocation !=="all") {
        $datalar = Elan::where('location','LIKE','%'.$ElanLocation.'%')->get();
        foreach ($datalar as $key => $value) {
          $datalar[$key]['image'] = $value->shekiller[0]->imageName;
        }
      }else if ($ElanLocation =="all" && $ElanType !=="all") {
        $datalar = Elan::where('type_id','=',$ElanType)->get();
        foreach ($datalar as $key => $value) {
          $datalar[$key]['image'] = $value->shekiller[0]->imageName;
        }
      }else if (!empty($datalar)) {
        $datalar = 'ok';
      }
      return $datalar;
    };
      return view('pages.index',compact('datas'));
    }


    //<================= METHHOD FOR REGİSTER ===========>

    public function register()
    {
      return view('pages.register');
    }

    //<================= METHHOD FOR SİNGLE PAGE  ================>

    public function single($id)
    {
      $single = Elan::find($id);
        if ($single->status == 0) {
          return redirect('/');
        }
        $date = $single->deadline;
        $dbdate=new DateTime($date);
        $newdate=new DateTime('now');
        $diff = date_diff($newdate,$dbdate);
        if (!$diff->d== 0) {
          $single->update();
        }
        elseif ($diff->d == 0 && $diff->m) {
        $single->status = 0;
        $single->save();
        return redirect('/');
      }

      return view('pages.single',compact('single','diff'));
    }


    //<================= METHHOD FOR NOTIFICATION COUNT ================>

      public function notification_count(Request $request,Qarsiliq $qarsiliq,$id)
      {   Session::flash('description_destek' , "Dəstəyiniz uğurla  gönderildi. ");
          Session::flash('description_istek' , "istəyiniz uğurla  gönderildi. ");

          $qarsiliq->elan_id = $id;
          $qarsiliq->user_id = Auth::user()->id;
          $qarsiliq->description = $request->description;
          $qarsiliq->notification =1;
          $qarsiliq->status =1;
          $qarsiliq->save();
          return back();
      }


    //<================= METHHOD FOR PROFIL ================>
    public function profil()
    {
      $Elan_all=Elan::all();
      $noti_message = Qarsiliq::join('users', 'users.id', '=', 'qarsiliqs.user_id')
                ->join('els', 'els.id', '=', 'qarsiliqs.elan_id')
                ->select('users.name','users.avatar','qarsiliqs.created_at','els.type_id','qarsiliqs.description','qarsiliqs.notification','qarsiliqs.id')
                ->where([
                      ['els.user_id', '=', Auth::user()->id]
                  ])
                ->orderBy('created_at', 'desc')
                ->get();
      return view('pages.profil',compact('Elan_all','noti_message'));
    }


    //<================= METHHOD FOR NOFICATION_SINGLE ================>
    public function notication_single($id)
    {

        $notication_single=Qarsiliq::join('users', 'users.id', '=', 'qarsiliqs.user_id')
              ->join('els', 'els.id', '=', 'qarsiliqs.elan_id')
              ->select('users.name','users.avatar','els.type_id','qarsiliqs.description','qarsiliqs.id','qarsiliqs.status','qarsiliqs.notification')
              ->where([
                    ['qarsiliqs.id', '=', $id],
                    ['els.user_id', '=', Auth::user()->id]
                ])->get();
          foreach ($notication_single as $notication_single) {
              $notication_single->status=0;
              $notication_single->update();
          }
          // dd($notication_single);
       return view('pages.notification_single',compact('notication_single'));
    }


    //<================= METHHOD FOR PROFİL UPDATE ================>

    public function settings(Request $request)
    {
      // dd('sss');
      // dd($request['avatar']);
      $this->validate($request, [
         'name' => 'required',
         'phone' => 'required',
         // 'avatar' => 'required',
         'city' => 'required'
      ]);
      if ($request->avatar == '') {
        // return true;
        $profil_image = Auth::user()->avatar;
        $data = [
          'username' => Auth::user()->username,
          'name' => $request['name'],
          'phone' => '+994'.$request['operator'].$request['phone'],
          'avatar' => $profil_image,
          'city' => $request['city']
        ];
        Auth::user()->update($data);
      }else {
        $filetype=$request->file('avatar')->getClientOriginalExtension();
        $img_name = $request->file('avatar')->getCLientOriginalName();
        $lowered = strtolower($filetype);

          if($lowered=='jpg' || $lowered=='jpeg' || $lowered=='png'){

            $avatar_del = Auth::user()->avatar;
            if($avatar_del=="prof.png"){
              echo "hello";
            }
            else if(file_exists('image/'.$avatar_del)){
                echo "no";
              unlink('image/'.$avatar_del);
            }

            $filename=date('ygmis').'.'.$img_name;
            $request->file('avatar')->move(public_path('image/'),$filename);
            $data = [
              'username' => Auth::user()->username,
              'name' => $request['name'],
              'phone' => '+994'.$request['operator'].$request['phone'],
              'avatar' => $filename,
              'city' => $request['city']
            ];

             Auth::user()->update($data);
          }else{
                Session::flash('imageerror' , "Xahiş olunur şəkili düzgun yükləyəsiniz.");
            return redirect('/Tənzimləmələr');
          }

      }
       Session::flash('added' , "Məlumatlarınız yeniləndi.");
        return redirect('/Tənzimləmələr');
    }

    //<================= METHHOD FOR ABOUT US  ================>

    public function about()
    {
      return view('pages.about_us');
    }


    //<================= METHHOD FOR CONTACT PAGE ================>

    public function contact()
    {
      return view('pages.contact_us');
    }


    //<================= METHHOD FOR CONTACT_SEND MESSAGE ================>

    public function contact_send(Request $request)
    {
      $this->validate($request, [
         'name' => 'required',
         'email' => 'required',
         'message' => 'required',
      ]);
      $data=[
        'name' => $request->name,
        'email' => $request->email,
        'contactMessage' => $request->message,
      ];
      Mail::send('pages.contact_us_mail',$data, function($message) use ($data){
        $message->from($data['email']);
        $message->to('farid.b@code.edu.az');
      });
      Session::flash('send', 'İsmarıcınız müvəffəqiyyətlə göndərildi.');
      return back();
    }

    //<================= METHHOD FOR ISTEK_LIST ================>

    public function istek_list()
    {
      $datas=Elan::orderBy('created_at','desc')->get();

      return view('pages.istek_list', compact('datas'));
    }

    //<================= METHHOD FOR DESTEK_LIST ================>
    public function destek_list()
    {
      $datas=Elan::orderBy('created_at','desc')->get();
      return view('pages.destek_list', compact('datas'));
    }

    //<================= METHHOD FOR DELETE ISTEK OR DESTEK MESSSAGE ================>
    public function refusal($id)
    {
        $qars=Qarsiliq::find($id);
        $qars->notification=0;
        $qars->update();
       return back();
    }

    //<================= METHHOD FOR ACCEPT ISTEK OR DESTEK MESSSAGE ================>
    public function accept($id)
    {
      
    }
}
