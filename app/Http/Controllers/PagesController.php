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
      // $datalar=Elan::all();
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
      }
      return $datalar;
    };
      return view('pages.index',compact('datas'));
    }

    public function register()
    {
      return view('pages.register');
    }
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


    //<================= METHHOD FOR NOTIFICATION ================>
      public function notification_count(Request $request,Qarsiliq $qarsiliq,$id)
      {
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
                      // ['qarsiliqs.id', '=', $id],
                      ['els.user_id', '=', Auth::user()->id]
                  ])
                ->orderBy('created_at', 'desc')
                ->get();
                // foreach ($noti_image as $key => $notification_image) {
                //        $id=$notification_image['elan_id'];
                //         $qarsiliqs=Qarsiliq::find($var);
                //     }
                //     $qarsiliqs->notification = 0;
                //     $qarsiliqs->update();
      // dd($noti_image);
      return view('pages.profil',compact('Elan_all','noti_message'));
    }


    //<================= METHHOD FOR NOFICATION_SINGLE ================>
    public function notication_single($id)
    {
        $notication_single=Qarsiliq::join('users', 'users.id', '=', 'qarsiliqs.user_id')
              ->join('els', 'els.id', '=', 'qarsiliqs.elan_id')
              ->select('users.name','users.avatar','els.type_id','qarsiliqs.description','qarsiliqs.id','qarsiliqs.status')
              ->where([
                    ['qarsiliqs.id', '=', $id],
                    ['els.user_id', '=', Auth::user()->id]
                ])->get();
          foreach ($notication_single as $notication_single) {
              $notication_single->status=0;
              $notication_single->update();
          }

       return view('pages.notification_single',compact('notication_single'));
    }
    public function settings(Request $request)
    {
      $this->validate($request, [
         'username' => 'required',
         'name' => 'required',
         'email' => 'required',
         'phone' => 'required',
         'city' => 'required',
      ]);
      $data = [
            'username' => Auth::user()->username,
            'name' => $request['name'],
            'phone' => '+994'.$request['operator'].$request['phone'],
            'email' => $request['email'],
            'city' => $request['city']
        ];
        Auth::user()->update($data);
      return back();
    }
    public function about()
    {
      return view('pages.about_us');
    }

    public function contact()
    {
      return view('pages.contact_us');
    }

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
}
