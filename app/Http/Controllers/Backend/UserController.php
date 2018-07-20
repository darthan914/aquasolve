<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Users;

use Auth;
use Hash;
use DB;
use Mail;
use Validator;

class UserController extends Controller
{
    // ALTER TABLE `amd_users` ADD `permission` TEXT NULL AFTER `remember_token`;
    public function index(){
    	$me = Users::find(Auth::user()->id);
    	$getUsers = Users::get();
        return view('backend.account.index', compact(
        	'me',
        	'getUsers'
        ));
    }

    public function add(request $request){
    	$message = [
          'new_name.required' => 'Wajib di isi',
          'new_email.required' => 'Wajib di isi',
          'new_email.email' => 'Format email',
          'new_email.unique' => 'Email sudah dipakai',
        ];

        $validator = Validator::make($request->all(), [
          'new_name' => 'required',
          'new_email' => 'required|email|unique:users,email'
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('backend.user')->withErrors($validator)->withInput();
        }

		DB::transaction(function() use($request){
			$confirmation_code = str_random(30).time();
			$user = new Users;
			$user->name = $request->new_name;
			$user->email = $request->new_email;
			$user->login_count = 0;
			$user->password = Hash::make(12345678);
      $user->confirmed = 1;
      $user->confirmation_code = $confirmation_code;
			$user->permission = 'list-user, create-user, edit-user, list-page, create-page, edit-page, delete-page, list-inbox, list-jobApply, list-news, create-news, edit-news, delete-news';
			$user->save();

			// $data = array([
			// 	'name' => $request->name,
			// 	'email' => $request->email,
			// 	'confirmation_code' => $confirmation_code
			// ]);

			// Mail::send('backend.email.confirm', ['data' => $data], function($message) use ($data) {
			// $message->to($data[0]['email'], $data[0]['name'])->subject('Aktifasi Akun CMS Gofress');
			// });
		});

		return redirect()->route('backend.user')->with('berhasil', $request->name.' success to add');
    }

    public function update(request $request){
    	$message = [
          'name.required' => 'Wajib di isi',
          'email.required' => 'Wajib di isi',
          'email.email' => 'Format email',
          'old_password.required' => "This field is required",
          'new_password.required' => "This field is required",
          'new_password.min' => "Too Short",
        ];

        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'email' => 'required|email',
          'old_password' => 'required',
          'new_password' => 'required|min:8',
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('backend.user')->withErrors($validator)->withInput();
        }

    	$me = Users::find(Auth::user()->id);
		if(Hash::check($request->old_password, $me->password)){
			$me->password = Hash::make($request->new_password);
			$me->save();

			return redirect()->route('backend.user')->with('berhasil', 'Your password has been changed');
		}
		else{
			return redirect()->route('backend.user')->withInput()->with('errors_oldpass', 'Wrong Password!	');
		}
    }

    public function status($id){
    	if (Auth::user()->id == $id) {
    		return redirect()->route('backend.user')->with('berhasil', 'Error! Cant change self status');
    	}
    	$find = Users::find($id);
    	if ($find->status == 'N') {
  			$find->status = 'Y';
  		}
  		else if ($find->status == 'Y') {
  			$find->status = 'N';
  		}
  		$find->save();
		return redirect()->route('backend.user')->with('berhasil', $find->name.' success to change status');
    }

    public function resetPassword($id){
    	if (Auth::user()->id == $id) {
    		return redirect()->route('backend.user')->with('berhasil', 'Error! Cant reset self password');
    	}
    	$find = Users::find($id);
		$find->password = Hash::make(12345678);
		$find->save();
		return redirect()->route('backend.user')->with('berhasil', $find->name.' success to reset password');

    }

    public function delete($id){
    	if (Auth::user()->id == $id) {
    		return redirect()->route('backend.user')->with('berhasil', 'Error! Cant reset self password');
    	}
    	$find = Users::find($id);

		DB::transaction(function() use($find){
			$find->delete();
		});

	    return redirect()->route('backend.user')->with('berhasil', 'Berhasil Menghapus '.$find->name);
    }

    public function permission($id)
    {
        $index = Users::find($id);
        $key = Users::keypermission();

        return view('backend.account.permission')->with(compact('index', 'key'));
    }

    public function permissionUpdate($id, Request $request)
    {
        $index = Users::find($id);

        $message = [
            'password.required' => 'This field required.',
        ];

        $validator = Validator::make($request->all(), [
            'password'        => 'required',
        ], $message);

        $validator->after(function ($validator) use ($request) {
            if (!Hash::check($request->password, Auth::user()->password)) {
                $validator->errors()->add('password', 'Your password user invalid');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $permission  = $request->permission ? implode($request->permission, ', ') : '';
        
        $index->permission  = $permission;
        
        $index->save();
        
        return redirect()->route('backend.user')->with('berhasil', 'Data Has Been Updated');
    }
    
}
