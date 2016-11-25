<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request; //verification
use App\ActivationService; //verification

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $activationService;//verification


    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
     public function __construct(ActivationService $activationService)
       {
           $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
           $this->activationService = $activationService;
       }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
          'username' => 'required|unique:users',
          'city' => 'required',
          'name' => 'required|max:255',
          'phone' => 'required',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6|confirmed',
          // 'password_confirmation' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
          'username' => $data['username'],
          'name' => $data['name'],
          'phone' => '+994'.$data['operator'].$data['phone'],
          'city' => $data['city'],
          'email' => $data['email'],
          'password' => bcrypt($data['password'])
        ]);
    }

    public function register(Request $request)
    {

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        $this->activationService->sendActivationMail($user);

        return redirect('/')->with('status', 'Biz sizə aktivasiya linki yolladıq. Zəhmət olmasa Email adresinizi yoxlayın');
    }

    public function authenticated(Request $request, $user)
    {
        if (!$user->activated) {
            $this->activationService->sendActivationMail($user);
            auth()->logout();
            return back()->with('warning',"Hesabınızı təsdiqləməlisiniz. Biz sizə aktivasiya kodu yollamışıq, zəhmət olmasa email adresinizi yoxlayın.");
        }
        return redirect()->intended($this->redirectPath());
    }


    public function activateUser($token)
    {
        if ($user = $this->activationService->activateUser($token)) {
            auth()->login($user);
            return redirect($this->redirectPath());
        }
        abort(404);
    }
}
