<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;
use App\Elan;
use App\User;
use Auth;
use DateTime;
use Session;
use Mail;
use App\Qarsiliq;
use App\Photo;
use App\Chat;

class PagesController extends Controller
{
    public function index(Request $request)
    {
      $datas_destek=Elan::raw(1)->orderBy('created_at','desc')->whereRaw('`status` = 1 AND `type_id` = 1')->take(4)->get();
      $datas_istek=Elan::raw(1)->orderBy('created_at','desc')->whereRaw('`status` = 1 AND `type_id` = 2')->take(4)->get();

     // dd($datas_destek);
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
      // $ElanLocation ve $ElanType mapda select optionlar ile secilen value-lardi yeni seher ve elanin tipi(istek ve ya destek) adlaridir.
      $ElanLocation = $request->ElanLocation;
      $ElanType = $request->ElanType;
        if ($ElanLocation =="all" && $ElanType =="all") {// eger default olaraq hecne secilmeyibse value-dan all gelecek ve butun datalar secilecek.
          $datalar=Elan::all();
          foreach ($datalar as $key => $value) {
            $datalar[$key]['image'] = $value->shekiller[0]->imageName;//photo table-i ayri olduqu ucun els table-da olan image columuna photo table-dan 0-ci colum-u elave olunur.
          }
        }else if($ElanLocation !=="all" && $ElanType !=="all"){
          $datalar=Elan::where([
            ['location','LIKE','%'.$ElanLocation.'%'],
            ['type_id','LIKE','%'.$ElanType.'%'],
            ['status','=','1']
        ])->get();
        foreach ($datalar as $key => $value) {
          $datalar[$key]['image'] = $value->shekiller[0]->imageName;
        }
      }else if ($ElanLocation !=="all") {
        $datalar=Elan::where([
          ['location','LIKE','%'.$ElanLocation.'%'],
          ['status','=','1']
      ])->get();
        foreach ($datalar as $key => $value) {
          $datalar[$key]['image'] = $value->shekiller[0]->imageName;
        }
      }else if ($ElanLocation =="all" && $ElanType !=="all") {
        $datalar=Elan::where([
          ['type_id','LIKE','%'.$ElanType.'%'],
          ['status','=','1']
      ])->get();
        foreach ($datalar as $key => $value) {
          $datalar[$key]['image'] = $value->shekiller[0]->imageName;
        }
      }else if (!empty($datalar)) {
        $datalar = 'ok';
      }
      return $datalar;
    };
      return view('pages.index',compact('datas_destek', 'datas_istek'));
    }

    //<================= METHHOD FOR REGİSTER ===========>

    public function register()
    {
      //qeydiyyat sehifesinde login ederse ana sehifeye yonelecek ve yalniz cixis edenden sonra qeydiyyat sehifesini gore bilecek.
      if (Auth::user()) {
        return redirect('/');
      }else {
        return view('pages.register');
      }
    }
      //<================= METHHOD FOR REGİSTER END===========>
      //<===================METHOD FOR USER LOGIN =============>
      public function user_login(Request $request)
      {
        $email = $request->email;
        $password = $request->password;
        $this->validate($request, [
          'email' => 'required',
          'password' => 'required',
        ]);
        // Auth ozu user table-dan axtarir eger inputdan gelen email ve sifre dogru deyilse eyni zamanda activated 1 deyilse /resources/lang/en/passwords.php -de
        //olan  arraylarin icindeki user key-ne uygun valueni cixardir yeni We can't find a user with that e-mail address. :)
            if (Auth::attempt(['email' => $email, 'password' => $password, 'activated' => 1])) {

            }else {
              return Lang::get('passwords.user');
            }
      }
      //<===================METHOD FOR USER LOGIN END=============>
    //<================= METHHOD FOR SİNGLE PAGE  ================>

    public function single($slug)
    {
      $single = Elan::where('slug', $slug)->first();
      $qarsiliqs = Qarsiliq::all();
      $check = false;
      foreach ($qarsiliqs as $qarsiliq) {
        if (Auth::user()) {
          if (Auth::user()->id == $qarsiliq->user_id && $single->id == $qarsiliq->elan_id) {
            $check = true;
            break;
          }else {
            $check = false;
            continue;
          }
        }else {
          break;
        }
      }
      if ($single) {
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

        return view('pages.single',compact('single','diff','check'));
      }else {
        return view('errors.503');
      }

    }

    //<================= METHHOD FOR NOTIFICATION COUNT ================>

    public function notification_count(Request $request,Qarsiliq $qarsiliq,$id)
    {

      $qarsiliq_table = Qarsiliq::find($id);
        $this->validate($request, [
            'description' => 'required',
        ]);

        if ($qarsiliq->description='') {
            Session::flash('description_error' , "Boş mesaj gonderməyin !");
        }else{
            Session::flash('description_destek' , "Dəstəyiniz uğurla  göndərildi. Qəbul olunduğu zaman sizə bildiriş göndəriləcək ");
            Session::flash('description_istek' , "İstəyiniz uğurla  göndərildi. Qəbul olunduğu zaman sizə bildiriş göndəriləcək ");
        }

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
      $istek=Elan::whereRaw('`type_id` = 2 AND user_id = '. Auth::user()->id)->count();
      $destek=Elan::whereRaw('`type_id` = 1 AND user_id = '. Auth::user()->id)->count();

      $noti_message = Qarsiliq::join('users', 'users.id', '=', 'qarsiliqs.user_id')
                                ->join('els', 'els.id', '=', 'qarsiliqs.elan_id')
                                ->select('users.name','users.avatar','qarsiliqs.data','els.user_id as elan_userid',
                                'qarsiliqs.created_at','els.title','els.type_id','qarsiliqs.description',
                                'qarsiliqs.notification','qarsiliqs.user_id','qarsiliqs.id')
                                ->where('els.user_id', '=', Auth::user()->id)
                                ->orderBy('created_at', 'desc')
                                ->get();

      $data_join=Qarsiliq::join('els', 'els.id', '=', 'qarsiliqs.elan_id')
                          ->join('users', 'users.id', '=', 'els.user_id')
                          ->select('users.name','els.type_id','users.email',
                          'qarsiliqs.user_id as qars_userid','users.city',
                          'qarsiliqs.id','qarsiliqs.data','users.avatar','users.phone','els.location')
                          ->where('qarsiliqs.user_id', '=', Auth::user()->id)
                          ->get();

      // data for my helps
      $help = Qarsiliq::join('els', 'els.id', '=', 'qarsiliqs.elan_id')
                            ->join('users', 'users.id', '=', 'qarsiliqs.user_id')
                            ->join('photos','els.id', '=', 'photos.els_id')
                            ->select('qarsiliqs.id as qars_id','qarsiliqs.user_id','qarsiliqs.description',
                            'els.title','photos.imageName','els.id as elan_id','els.about','els.type_id','qarsiliqs.data','qarsiliqs.data_status')
                            ->where('qarsiliqs.user_id', '=' , Auth::user()->id)
                            ->groupBy('qarsiliqs.elan_id')
                            ->get();
      // dd($help);
      return view('pages.profil', compact('Elan_all','noti_message','data_join','istek','destek','help'));
    }


    //<================= METHHOD FOR NOFICATION_SINGLE ================>
    public function notication_single($id, Chat $chat, Qarsiliq $qarsiliq_table)
    {
      $notication_single = Qarsiliq::join('users', 'users.id', '=', 'qarsiliqs.user_id')
            ->join('els', 'els.id', '=', 'qarsiliqs.elan_id')
            ->select('users.name', 'users.avatar', 'els.type_id','qarsiliqs.elan_id', 'qarsiliqs.user_id',
            'qarsiliqs.description', 'qarsiliqs.id', 'qarsiliqs.status', 'qarsiliqs.notification', 'qarsiliqs.data')
            ->where([
                ['qarsiliqs.id', '=', $id],
                ['els.user_id', '=', Auth::user()->id]
            ])->get();

        if ($notication_single)
        {
            foreach ($notication_single as $notication_single)
            {
                $notication_single->status = 0;
                $notication_single->update();
            }
          return view('pages.notification_single', compact('notication_single', 'data_join', 'userId'));
        }
        else
        {
            return view('errors.503');
        }
    }


    //<================= METHHOD FOR PROFİL UPDATE ================>


    public function imageType($name)
      {
        $file_type = strtolower($name->getClientOriginalExtension());
        if($file_type =='jpg' || $file_type =='jpeg' || $file_type =='png')
        {
          if($name->getRealPath() && !@is_array(getimagesize($name->getRealPath())))
          {
            return false;
          }
          else
          {
            return true;
          }
        }
        else
        {
          return false;
        }
      }


    public function settings(Request $request)
    {

      $this->validate($request, [
         'name' => 'required',
         'phone' => 'required',
         'city' => 'required'
      ]);
      if ($request->avatar == '')
      {
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
      }
      else
      {
        // $filetype=$request->file('avatar')->getClientOriginalExtension();
            $img_name = $request->file('avatar')->getCLientOriginalName();
        // $lowered = strtolower($filetype);

        //   if($lowered=='jpg' || $lowered=='jpeg' || $lowered=='png'){

              $check = $this->imageType($request->file('avatar'));

            if($check==true){

              $avatar_del = Auth::user()->avatar;
              if($avatar_del=="prof.png")
              {
                  echo "hello";
              }
              else if(file_exists('image/'.$avatar_del))
              {
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
          }
          else
          {
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
        $message->to('farid.b@code.edu.az')->subject('nese');
      });
      Session::flash('send', 'İsmarıcınız müvəffəqiyyətlə göndərildi.');
      return back();
    }


    //<================= METHHOD FOR ISTEK_LIST ================>

    public function istek_list()
    {
      $datas=Elan::raw(1)->orderBy('created_at','desc')->whereRaw('`status` = 1 AND `type_id` = 2')->paginate(8);

      return view('pages.istek_list', compact('datas'));
    }


    //<================= METHHOD FOR DESTEK_LIST ================>
    public function destek_list()
    {
      $datas=Elan::raw(1)->orderBy('created_at','desc')->whereRaw('`status` = 1 AND `type_id` = 1')->paginate(8);

      return view('pages.destek_list', compact('datas'));
    }


    //<================= METHHOD FOR DELETE ISTEK OR DESTEK MESSSAGE ================>
    public function refusal($id)
    {
      $qarsiliq_table = Qarsiliq::find($id);
      $delete_chat = Chat::where('sender_id', '=', $qarsiliq_table->user_id)->where('receiver_id', '=', Auth::user()->id  )->get();
      $delete_message = Chat::where('sender_id', '=', Auth::user()->id )->where('receiver_id', '=', $qarsiliq_table->user_id  )->get();

      if ($delete_message)
      {
          foreach ($delete_message as $delete_messages) {
              $delete_messages->delete();
          }
      }
      if ($delete_chat)
      {
          foreach ($delete_chat as $delete_chats) {

              $delete_chats->delete();
          }
      }
        $qars=Qarsiliq::find($id);
        if ($qars)
        {
          $qars->notification=0;
          $qars->update();
          return back();
        }
        else
        {
          return view('errors.503');
        }
    }



    //<================= METHHOD FOR ACCEPT ISTEK OR DESTEK MESSSAGE ================>
    public function accept($id)
    {
      Session::flash('accept', 'İsmarıcınız müvəffəqiyyətlə göndərildi.');

      $qars=Qarsiliq::find($id);
      if ($qars) {
        $qars->data=1;
        $qars->data_status=1;
        $qars->update();
        return back();
      }
      else {
        return view('errors.503');
      }
    }


    //<================= METHHOD FOR MESSSAGE ================>

    public function message($id)
    {
      $data_join=Qarsiliq::join('els', 'els.id', '=', 'qarsiliqs.elan_id')
                ->join('users', 'users.id', '=', 'els.user_id')
                ->select('users.name','els.type_id','users.email','qarsiliqs.user_id','users.city','qarsiliqs.id','users.avatar','users.phone','els.location')
                ->where([
                      ['qarsiliqs.id', '=', $id],
                      ['qarsiliqs.user_id', '=', Auth::user()->id]
                  ])->get();
      if ($data_join) {
        foreach ($data_join as $data_join) {
          $data_join->data_status=0;
          $data_join->update();
        }
        return view('pages.message', compact('data_join'));
      }else {
        return view('errors.503');
      }
    }

    public function chat($id)
    {
        $one_message = Chat::join('users','users.id','=','chats.sender_id')
                            ->select('chats.sender_id','chats.receiver_id','chats.elan_id','users.name')
                            ->where('chats.id','=',$id)
                            ->get();
        if (!isset($one_message[0]))
        {
            return redirect('/');
        }
        elseif ($one_message[0]->receiver_id == Auth::user()->id)   //Eger user id chat table-den gelen receiver_id-ye beraberdirse
        {
            $gonderilen = $one_message[0]->receiver_id;             // chat table-dan gelen receiver_id $gonderilen deyiseninde saxlanilir ki asaqida menimsedilende itmesin.
            $one_message[0]->receiver_id = $one_message[0]->sender_id;        // burada user deyisikliyi edirik cunki chat.blade.php-de auth user GONDERILEN yox mesaj gonderen olmalidir.
            $one_message[0]->sender_id = $gonderilen;
        }
        $chats = Chat::join('users','users.id','=','chats.sender_id')
                    ->select('chats.message','chats.sender_id','chats.receiver_id','users.name','users.avatar','users.username')
                    ->where([
                                ['sender_id', '=', Auth::user()->id],
                                ['receiver_id', '=',$one_message[0]->receiver_id],
                                ['elan_id', '=',$one_message[0]->elan_id]
                            ])
                    ->orWhere([
                                ['receiver_id', '=', Auth::user()->id],
                                ['sender_id', '=',$one_message[0]->receiver_id],
                                ['elan_id', '=',$one_message[0]->elan_id]
                            ])->get();


                    // chatin vaxti bitibse session yaradilir ki vaxti bitib
                    $elsId = $one_message[0]->elan_id;
                    $elan = Elan::where('id',$elsId)->get();
                    if($elan[0]->status == 0)
                      {
                        if ($elan[0]->user_id == Auth::user()->id) {
                        Session::flash('chatdead', 'Bu elana qoyulan vaxt bitdiyindən elan üzərindən əlaqə sona çatmışdır. Elanın vaxtın uzada bilərsiz');

                        }else{
                        Session::flash('chatdead', 'Bu elana qoyulan vaxt bitdiyindən elan üzərindən əlaqə sona çatmışdır.');

                        }
                        return view('pages.chat');
                      }
                    // chatin vaxti bitibse session yaradilir ki vaxti bitib


        return view('pages.chat',compact('chats','one_message'));
    }

    public function chatToNoti($sender,$elan_id)
    {
      $user = User::find($sender);
       $chats = Chat::join('users','users.id','=','chats.sender_id')
                    ->select('chats.message','chats.sender_id','chats.receiver_id','chats.elan_id','users.name','users.avatar','users.username')
                    ->where([
                                ['sender_id', '=', Auth::user()->id],
                                ['receiver_id', '=',$sender],
                                ['elan_id', '=',$elan_id]
                            ])
                    ->orWhere([
                                ['receiver_id', '=', Auth::user()->id],
                                ['sender_id', '=',$sender],
                                ['elan_id', '=',$elan_id]
                            ])->get();

                    // chatin vaxti bitibse session yaradilir ki vaxti bitib
              if (isset($chats[0])) {

                    $elsId = $chats[0]->elan_id;
                    $elan = Elan::where('id',$elsId)->get();
                    if($elan[0]->status == 0)
                      {
                        if ($elan[0]->user_id == Auth::user()->id) {
                        Session::flash('chatdead', 'Bu elana qoyulan vaxt bitdiyindən elan üzərindən əlaqə sona çatmışdır. Elanın vaxtın uzada bilərsiz');

                        }else{
                        Session::flash('chatdead', 'Bu elana qoyulan vaxt bitdiyindən elan üzərindən əlaqə sona çatmışdır.');

                        }
                        return view('pages.chat');
                      }
                }
                    // chatin vaxti bitibse session yaradilir ki vaxti bitib



        if(!isset($user))
        {
          return view('errors.503');
        }
        return view('pages.chat',compact('chats','sender','elan_id','user'));
    }
}
