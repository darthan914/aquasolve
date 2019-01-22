<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Validator;

class UserController extends Controller
{
    // ALTER TABLE `amd_users` ADD `permission` TEXT NULL AFTER `remember_token`;
    // ALTER TABLE `amd_users` ADD `level` INT NOT NULL DEFAULT '0' AFTER `permission`;
    public function index()
    {
        $me       = Users::find(Auth::user()->id);
        $getUsers = Users::get();
        return view('backend.account.index', compact(
            'me',
            'getUsers'
        ));
    }

    public function add(request $request)
    {
        $message = [
            'new_name.required'  => 'This Field Required',
            'new_email.required' => 'This Field Required',
            'new_email.email'    => 'Format email',
            'new_email.unique'   => 'Email sudah dipakai',
        ];

        $validator = Validator::make($request->all(), [
            'new_name'  => 'required',
            'new_email' => 'required|email|unique:users,email',
        ], $message);

        if ($validator->fails()) {
            return redirect()->route('backend.user')->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request) {
            $new_password = str_random(40);

            $confirmation_code       = str_random(30) . time();
            $user                    = new Users;
            $user->name              = $request->new_name;
            $user->email             = $request->new_email;
            $user->login_count       = 0;
            $user->password          = Hash::make($new_password);
            $user->confirmed         = 1;
            $user->confirmation_code = $confirmation_code;
            $user->permission        = 'list-user, create-user, edit-user, list-page, create-page, edit-page, delete-page, list-inbox, list-jobApply, list-news, create-news, edit-news, delete-news';
            $user->level             = $request->level ?? 0;
            $user->save();

            $data = array([
                'name'     => $user->name,
                'email'    => $user->email,
                'password' => $new_password,
            ]);

            Mail::send('backend.email.confirm', ['data' => $data], function ($message) use ($data) {
                $message->to($data[0]['email'], $data[0]['name'])->subject('Admin CMS Aquasolve');
            });

            // $data = array([
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'confirmation_code' => $confirmation_code
            // ]);

            // Mail::send('backend.email.confirm', ['data' => $data], function($message) use ($data) {
            // $message->to($data[0]['email'], $data[0]['name'])->subject('Aktifasi Akun CMS Gofress');
            // });
        });

        return redirect()->route('backend.user')->with('berhasil', $request->name . ' success to add');
    }

    public function update(request $request)
    {

        $message = [
            'name.required'         => 'This Field Required',
            'email.required'        => 'This Field Required',
            'email.email'           => 'Format email',
            'old_password.required' => "This field is required",
            'new_password.required' => "This field is required",
            'new_password.min'      => "Too Short",
        ];

        $validator = Validator::make($request->all(), [
            'name'         => 'required',
            'email'        => 'required|email',
            'old_password' => 'required',
            'new_password' => 'required|min:8',
        ], $message);

        if ($validator->fails()) {
            return redirect()->route('backend.user')->withErrors($validator)->withInput();
        }

        $me = Users::find(Auth::user()->id);
        if (Hash::check($request->old_password, $me->password)) {
            $me->password = Hash::make($request->new_password);
            $me->save();

            return redirect()->route('backend.user')->with('berhasil', 'Your password has been changed');
        } else {
            return redirect()->route('backend.user')->withInput()->with('errors_oldpass', 'Wrong Password!	');
        }
    }

    public function status($id)
    {
        if (!$this->levelgrant($id)) {
            return redirect()->route('backend.user')->with('berhasil', 'Error! Access Denied');
        }

        if (Auth::user()->id == $id) {
            return redirect()->route('backend.user')->with('berhasil', 'Error! Cant change self status');
        }

        $find = Users::find($id);
        if ($find->status == 'N') {
            $find->status = 'Y';
        } else if ($find->status == 'Y') {
            $find->status = 'N';
        }
        $find->save();
        return redirect()->route('backend.user')->with('berhasil', $find->name . ' success to change status');
    }

    public function resetPassword($id)
    {

        if (!$this->levelgrant($id)) {
            return redirect()->route('backend.user')->with('berhasil', 'Error! Access Denied');
        }

        if (Auth::user()->id == $id) {
            return redirect()->route('backend.user')->with('berhasil', 'Error! Cant reset self password');
        }

        $find           = Users::find($id);
        $find->password = Hash::make(12345678);
        $find->save();
        return redirect()->route('backend.user')->with('berhasil', $find->name . ' success to reset password');
    }

    

    public function delete($id)
    {

        if (!$this->levelgrant($id)) {
            return redirect()->route('backend.user')->with('berhasil', 'Error! Access Denied');
        }

        if (Auth::user()->id == $id) {
            return redirect()->route('backend.user')->with('berhasil', 'Error! Cant reset self password');
        }

        $find = Users::find($id);

        DB::transaction(function () use ($find) {
            $find->delete();
        });

        return redirect()->route('backend.user')->with('berhasil', 'Data Has Been Deleted ' . $find->name);
    }

    public function permission($id)
    {
        if (!$this->levelgrant($id)) {
            return redirect()->route('backend.user')->with('berhasil', 'Error! Access Denied');
        }

        $index = Users::find($id);
        $key   = Users::keypermission();

        return view('backend.account.permission')->with(compact('index', 'key'));
    }

    public function permissionUpdate($id, Request $request)
    {
        if (!$this->levelgrant($id)) {
            return redirect()->route('backend.user')->with('berhasil', 'Error! Access Denied');
        }

        $index = Users::find($id);

        $message = [
            'password.required' => 'This field required.',
        ];

        $validator = Validator::make($request->all(), [
            'password' => 'required',
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

        $permission = $request->permission ? implode($request->permission, ', ') : '';

        $index->permission = $permission;
        $index->level      = $request->level ?? 0;

        $index->save();

        return redirect()->route('backend.user')->with('berhasil', 'Data Has Been Updated');
    }

    public function sql()
    {
        // $sql = "ALTER TABLE `amd_news` ADD `meta_title` VARCHAR(191) NULL DEFAULT NULL AFTER `flug_publish`, ADD `meta_url` TEXT NULL DEFAULT NULL AFTER `meta_title`, ADD `meta_keywords` TEXT NULL DEFAULT NULL AFTER `meta_url`, ADD `meta_description` TEXT NULL DEFAULT NULL AFTER `meta_keywords`, ADD `meta_image` TEXT NULL DEFAULT NULL AFTER `meta_description`;";

        // DB::statement($sql);
        return 'database Updated';
    }

}
