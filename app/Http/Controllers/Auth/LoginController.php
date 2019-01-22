<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;


use App\Models\Users;

use Validator;
use Auth;
use Hash;
use Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    public function login(Request $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');

        $message = [
          'email.required' => 'This field is required.',
          'email.email' => 'Email format not valid',
          'password.required' => 'This field is required.',
        ];

        $validator = Validator::make($request->all(), [
          'email' => 'required|email',
          'password' => 'required',
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('loginForm')->withErrors($validator)->withInput();
        }

        if (Auth::attempt(['email' => $email, 'password' => $password, 'confirmed'=>1 ]))
        {
            $set = Users::find(Auth::user()->id);
            $getCounter = $set->login_count;
            $set->login_count = $getCounter+1;
            $set->update();

            return redirect()->route('backend.dashboard');
        }
        else
        {
            return redirect()->route('loginForm')->with('status', 'Your account is not active or wrong password')->withInput();
        }
    }

    public function showResetForm()
    {
      return view('backend.auth.reset');
    }

    public function reset(Request $request)
    {
        $user = Users::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('resetForm')->with('status', 'Email Not Exist');
        }

        $new_password = str_random(40);

        $user->password = Hash::make($new_password);
        $user->save();

        $data = array([
            'name'     => $user->name,
            'email'    => $user->email,
            'password' => $new_password,
        ]);

        Mail::send('backend.email.reset', ['data' => $data], function ($message) use ($data) {
            $message->to($data[0]['email'], $data[0]['name'])->subject('Reset Password CMS Aquasolve');
        });

        return redirect()->route('loginForm')->with('status', 'Your new password has been sent to ' . $user->email);
    }

}
