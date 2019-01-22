<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\SolutionsImg;
use App\Models\SolutionsCategory;

use Validator;
use DB;
use Image;
use File;

class SolutionsController extends Controller
{
    public function index(){
      $SolutionsImg = SolutionsImg::get();
    	$SolutionsCategory = SolutionsCategory::get();

        return view('backend.solutions.index', compact('SolutionsImg','SolutionsCategory'));
    }

    public function store(request $request){
      $message = [
        'category.required' => 'This Field Required',
        'picture.required' => 'This Field Required',
        'picture.dimensions' => 'Maximum Resolution 1366px x 1366px',
        'picture.image' => 'Invalid Format, Image file only',
        'picture.max' => 'File too large',
      ];

      $validator = Validator::make($request->all(), [
        'category' => 'required',
        'picture' => 'required|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.solutions')->withErrors($validator)->withInput()->with('info-form-add', true);
      }

      DB::transaction(function () use($request) {
        $salt = str_random(4);
        $saltName = str_random(6);
        $image = $request->file('picture');
        $img_url = $saltName.'-'.$salt. '.' . $image->getClientOriginalExtension();
        $upload1 = Image::make($image);
        $upload1->save('amadeo/images/'.$img_url);

        $save = new SolutionsImg;
        $save->picture = $img_url;
        $save->category = $request->category;
        $save->save();
      });


      return redirect()->route('backend.solutions')->with('berhasil', 'Data Has Been Added ');
    }

    public function change(request $request){
      $message = [
        'category.required' => 'This Field Required',
        'picture.dimensions' => 'Maximum Resolution 1366px x 1366px',
        'picture.image' => 'Invalid Format, Image file only',
        'picture.max' => 'File too large',
      ];

      $validator = Validator::make($request->all(), [
        'category' => 'required',
        'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.solutions')->withErrors($validator)->withInput()->with('info-form-change', true);
      }

      DB::transaction(function () use($request) {
        $save = SolutionsImg::find($request->id);
        $salt = str_random(4);
        $saltName = str_random(6);
        if($request->has('picture')){
          File::delete('amadeo/images/'.$save->picture);
          $image = $request->file('picture');
          $img_url = $saltName.'-'.$salt. '.' . $image->getClientOriginalExtension();
          $upload1 = Image::make($image);
          $upload1->save('amadeo/images/'.$img_url);

          $save->picture = $img_url;
        }
        $save->category = $request->category;
        $save->save();
      });


      return redirect()->route('backend.solutions')->with('berhasil', 'Data Has Been Updated ');
    }

    public function flagPublish($id){
    	$SolutionsImg = SolutionsImg::find($id);
    	if ($SolutionsImg->flug_publish == 'N') {
  			$SolutionsImg->flug_publish = 'Y';
  		}
  		else if ($SolutionsImg->flug_publish == 'Y') {
  			$SolutionsImg->flug_publish = 'N';
  		}
  		$SolutionsImg->save();
	    return redirect()->route('backend.solutions')->with('berhasil', 'Data Has Been Updated ');
    }

    public function delete($id){
    	$SolutionsImg = SolutionsImg::find($id);

  		DB::transaction(function() use($SolutionsImg){
  			File::delete('amadeo/images/'.$SolutionsImg->picture);
  			$SolutionsImg->delete();
  		});

	    return redirect()->route('backend.solutions')->with('berhasil', 'Data Has Been Deleted ');
    }
}
