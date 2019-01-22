<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\ProdukCategory;
use DB;
use Image;
use File;
use Validator;

class ProductCategoryController extends Controller
{
    public function index(){
      $ProdukCategory = ProdukCategory::get();

        return view('backend.product-category.index', compact('ProdukCategory'));
    }

    public function store(request $request){
      $message = [
        'name.required' => 'This Field Required',
    		'name.unique' => 'Category Sudah Ada',
        'name.max' => 'Max Character 35',
      ];

      $validator = Validator::make($request->all(), [
        'name' => 'required|unique:produkcategory|max:35',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.category-product')->withErrors($validator)->withInput()->with('info-form-add', true);
      }

      DB::transaction(function () use($request) {

        $save = new ProdukCategory;
        $save->name = $request->name;
		$save->slug = str_slug($request->name,'-');
        $save->save();
      });


      return redirect()->route('backend.category-product')->with('berhasil', 'Data Has Been Added '.$request->name);
    }

    public function change(request $request){
      $message = [
        'name.required' => 'This Field Required',
        'name.unique' => 'Category Sudah Ada',
        'name.max' => 'Max Character 35',
      ];

      $validator = Validator::make($request->all(), [
        'name' => 'required|max:35|unique:produkcategory,'.$request->id,
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.category-product')->withErrors($validator)->withInput()->with('info-form-change', true);
      }

      DB::transaction(function () use($request) {
        $save = ProdukCategory::find($request->id);

        $save->name = $request->name;
		$save->slug = str_slug($request->name,'-');
        $save->save();
      });


      return redirect()->route('backend.category-product')->with('berhasil', 'Data Has Been Updated '.$request->name);
    }

    public function flagPublish($id){
      $ProdukCategory = ProdukCategory::find($id);
      if ($ProdukCategory->flug_publish == 'N') {
        $ProdukCategory->flug_publish = 'Y';
      }
      else if ($ProdukCategory->flug_publish == 'Y') {
        $ProdukCategory->flug_publish = 'N';
      }
      $ProdukCategory->save();
      return redirect()->route('backend.category-product')->with('berhasil', 'Data Has Been Updated '.$ProdukCategory->title);
    }

    public function delete($id){
		$ProdukCategory = ProdukCategory::find($id);

		DB::transaction(function() use($ProdukCategory){

			$Product = Product::where('category',$ProdukCategory->id)->get();
			
			foreach ($Product as $key) {
				$del = Product::find($key->id);
				File::delete('amadeo/images/'.$key->picture);
				File::delete('amadeo/images/'.$key->background_picture);
				$del->delete();
			}

			$ProdukCategory->delete();
		});

		return redirect()->route('backend.category-product')->with('berhasil', 'Data Has Been Deleted '.$ProdukCategory->title);
    }
}
