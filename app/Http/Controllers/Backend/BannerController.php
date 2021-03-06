<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Banner;

use Validator;
use DB;
use Image;
use File;

class BannerController extends Controller
{
    public function index(){
      $Banner = Banner::get();

        return view('backend.banner.index', compact('Banner'));
    }

    public function store(request $request){
      $message = [
        // 'title.required' => 'This Field Required',
        // 'title.max' => 'Max Character 35',
        // 'descript.required' => 'This Field Required',
        // 'descript.max' => 'Max Character 35',
        'picture.required' => 'This Field Required',
        'picture.dimensions' => 'Maximum Resolution 1366px x 1366px',
        'picture.image' => 'Invalid Format, Image file only',
        'picture.max' => 'File too large',
      ];

      $validator = Validator::make($request->all(), [
        // 'title' => 'required|max:35',
        // 'descript' => 'required|max:135',
        'picture' => 'required|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.banner')->withErrors($validator)->withInput()->with('info-form-add', true);
      }

      DB::transaction(function () use($request) {
        $salt = str_random(4);
        $image = $request->file('picture');
        $img_url = str_slug($request->title,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
        $upload1 = Image::make($image);
        $upload1->save('amadeo/images/'.$img_url);

        $save = new Banner;
        if ($request->title == null) {
          $save->title = '     ';
        }
        else{
          $save->title = $request->title;
        }
        if ($request->descript == null) {
          $save->descript = '     ';
        }
        else{
          $save->descript = $request->descript;
        }
        $save->picture = $img_url;
        $save->save();
      });


      return redirect()->route('backend.banner')->with('berhasil', 'Data Has Been Added '.$request->title);
    }

    public function change(request $request){
      $message = [
        // 'title.required' => 'This Field Required',
        // 'title.max' => 'Terlalu Panjang, Maks 25 Karakter',
        // 'title.unique' => 'Produk ini sudah ada',
        // 'descript.required' => 'This Field Required',
        // 'descript.max' => 'Max Character 35',
        'picture.dimensions' => 'Maximum Resolution 1366px x 1366px',
        'picture.image' => 'Invalid Format, Image file only',
        'picture.max' => 'File too large',
      ];

      $validator = Validator::make($request->all(), [
        // 'title' => 'required|max:35',
        // 'descript' => 'required|max:135',
        'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.banner')->withErrors($validator)->withInput()->with('info-form-change', true);
      }

      DB::transaction(function () use($request) {
        $save = Banner::find($request->id);

        if($request->has('picture')){
          File::delete('amadeo/images/'.$save->picture);
              $salt = str_random(4);
              $image = $request->file('picture');
              $img_url = str_slug($request->title,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
              $upload1 = Image::make($image);
              $upload1->save('amadeo/images/'.$img_url);
              $save->picture = $img_url;
        }

        if ($request->title == null) {
          $save->title = '     ';
        }
        else{
          $save->title = $request->title;
        }
        if ($request->descript == null) {
          $save->descript = '     ';
        }
        else{
          $save->descript = $request->descript;
        }
        $save->save();
      });


      return redirect()->route('backend.banner')->with('berhasil', 'Data Has Been Updated '.$request->title);
    }

    public function flagPublish($id){
      $Banner = Banner::find($id);
      if ($Banner->flug_publish == 'N') {
        $Banner->flug_publish = 'Y';
      }
      else if ($Banner->flug_publish == 'Y') {
        $Banner->flug_publish = 'N';
      }
      $Banner->save();
      return redirect()->route('backend.banner')->with('berhasil', 'Data Has Been Updated '.$Banner->title);
    }

    public function delete($id){
      $Banner = Banner::find($id);

    DB::transaction(function() use($Banner){
      File::delete('amadeo/images/'.$Banner->picture);
      $Banner->delete();
    });

      return redirect()->route('backend.banner')->with('berhasil', 'Data Has Been Deleted '.$Banner->title);
    }
}
