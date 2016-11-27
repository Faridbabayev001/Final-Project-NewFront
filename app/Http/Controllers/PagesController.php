<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\City;
use App\Elan;
use App\User;
use App\Contact;
use Auth;
use DateTime;
use Session;
use Mail;

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
      $ElanNov = $request->ElanNov;
      $datalar=Elan::all();
        if ($ElanLocation =="all" && $ElanType =="all" && $ElanNov =="all") {
          $datalar=Elan::all();
        }else if($ElanLocation !=="all" || $ElanType !=="all" || $ElanNov !=="all"){
          $datalar=Elan::where('location',$ElanLocation)
          ->orWhere('type_id',$ElanType)
          ->orWhere('nov',$ElanNov)
          ->get();
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

    //<================= METHHOD FOR PROFIL ================>
    public function profil()
    {  $Elan_all=Elan::all();
      return view('pages.profil',compact('Elan_all'));
    }

    // Haqqimizda ve elaqe sehifesi hazir olmadqindan muveqqeti olaraq 503 sehifesine gedir
    public function about()
    {
      return view('pages.about_us');
    }

    public function contact()
    {
      return view('errors.503');
    }
}
