<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Overseas;
use App\Models\GeneralConfig;

use Validator;
use DB;
use Image;
use File;

class OverseasController extends Controller
{
    public function index(){
    	$Overseas = Overseas::get();
      $distribution  = GeneralConfig::find(13);

      return view('backend.overseas.index', compact('Overseas', 'distribution'));
    }

    public function flagPublish($id){
      $Overseas = Overseas::find($id);
      if ($Overseas->flug_publish == 'N') {
        $Overseas->flug_publish = 'Y';
      }
      else if ($Overseas->flug_publish == 'Y') {
        $Overseas->flug_publish = 'N';
      }
      $Overseas->save();
      return redirect()->route('backend.overseas')->with('berhasil', 'Data Has Been Updated '.$Overseas->name);
    }

    public function delete($id){
		$Overseas = Overseas::find($id);

		DB::transaction(function() use($Overseas){
			File::delete('amadeo/images/overseas/'.$Overseas->img_url);
			$Overseas->delete();
		});

		return redirect()->route('backend.overseas')->with('berhasil', 'Data Has Been Deleted '.$Overseas->name);
    }

    public function store(request $request){
      $message = [
        'name.required' => 'This Field Required',
        'name.max' => 'Max Character 35',
        'css_left.required' => 'This Field Required',
        'css_bottom.required' => 'This Field Required',
      ];

      $validator = Validator::make($request->all(), [
        'name' => 'required|max:35',
        'css_left' => 'required',
        'css_bottom' => 'required',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.overseas')->withErrors($validator)->withInput()->with('info-form-add', true);
      }

      DB::transaction(function () use($request) {
        $salt = str_random(4);
        // $image = $request->file('picture');
        // $img_url = str_slug($request->name,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
        // $upload1 = Image::make($image);
        // $upload1->save('amadeo/images/overseas/'.$img_url);

        $save = new Overseas;

        $save->name = $request->name;
        $save->css_left = number_format($request->css_left, 2);
		    $save->css_bottom = number_format($request->css_bottom, 2);
        // $save->img_url = $img_url;
        $save->save();
      });


      return redirect()->route('backend.overseas')->with('berhasil', 'Data Has Been Added '.$request->title);
    }

    public function change(request $request){
      $message = [
        'name.required' => 'This Field Required',
        'name.max' => 'Max Character 35',
        'css_left.required' => 'This Field Required',
        'css_bottom.required' => 'This Field Required',
      ];

      $validator = Validator::make($request->all(), [
        'name' => 'required|max:35',
        'css_left' => 'required',
        'css_bottom' => 'required',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.overseas')->withErrors($validator)->withInput()->with('info-form-change', true);
      }

      DB::transaction(function () use($request) {
        $save = Overseas::find($request->id);

        // if($request->has('picture')){
        //   File::delete('amadeo/images/overseas/'.$save->picture);
        //       $salt = str_random(4);
        //       $image = $request->file('picture');
        //       $img_url = str_slug($request->title,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
        //       $upload1 = Image::make($image);
        //       $upload1->save('amadeo/images/overseas/'.$img_url);
        //       $save->picture = $img_url;
        // }

        $save->name = $request->name;
        $save->css_left = number_format($request->css_left, 2);
        $save->css_bottom = number_format($request->css_bottom, 2);
        $save->save();
      });


      return redirect()->route('backend.overseas')->with('berhasil', 'Data Has Been Updated '.$request->name);
    }
}
