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

class SolutionsCategoryController extends Controller
{
    public function index(){
    	$SolutionsCategory = SolutionsCategory::get();

        return view('backend.solutions-category.index', compact('SolutionsCategory'));
    }

    public function store(request $request){
      $message = [
        'name.required' => 'This Field Required',
		'name.unique' => 'Category Sudah Ada',
        'name.max' => 'Max Character 35',
      ];

      $validator = Validator::make($request->all(), [
        'name' => 'required|unique:amd_solutioncategory|max:35',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.solutions-category')->withErrors($validator)->withInput()->with('info-form-add', true);
      }

      DB::transaction(function () use($request) {
        $save = new SolutionsCategory;
        $save->name = $request->name;
        $save->save();
      });


      return redirect()->route('backend.solutions-category')->with('berhasil', 'Data Has Been Added ');
    }

    public function change(request $request){
      $message = [
        'name.required' => 'This Field Required',
        'name.max' => 'Max Character 35',
      ];

      $validator = Validator::make($request->all(), [
        'name' => 'required|max:35',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.solutions-category')->withErrors($validator)->withInput()->with('info-form-change', true);
      }

      DB::transaction(function () use($request) {
        $save = SolutionsCategory::find($request->id);

        $save->name = $request->name;
        $save->save();
      });


      return redirect()->route('backend.solutions-category')->with('berhasil', 'Data Has Been Updated '.$request->name);
    }

    public function flagPublish($id){
    	$SolutionsCategory = SolutionsCategory::find($id);
    	if ($SolutionsCategory->flug_publish == 'N') {
  			$SolutionsCategory->flug_publish = 'Y';
  		}
  		else if ($SolutionsCategory->flug_publish == 'Y') {
  			$SolutionsCategory->flug_publish = 'N';
  		}
  		$SolutionsCategory->save();
	    return redirect()->route('backend.solutions-category')->with('berhasil', 'Data Has Been Updated ');
    }

    public function delete($id){
    	$SolutionsCategory = SolutionsCategory::find($id);

		DB::transaction(function() use($SolutionsCategory){
			$SolutionsImg = SolutionsImg::where('category',$SolutionsCategory->id)->get();
			
			foreach ($SolutionsImg as $key) {
				$del = SolutionsImg::find($key->id);
				File::delete('amadeo/images/'.$del->picture);
				$del->delete();
			}
			$SolutionsCategory->delete();
		});

	    return redirect()->route('backend.solutions-category')->with('berhasil', 'Data Has Been Deleted ');
    }
}
