<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\ProdukCategory;

use Validator;
use DB;
use Image;
use File;

class ProductController extends Controller
{
    public function index(){
    	$Product = Product::get();

        return view('backend.product.index', compact('Product'));
    }

    public function add(){
		$ProdukCategory = ProdukCategory::get();
		return view('backend.product.add', compact('ProdukCategory'));
    }

    public function addStore(request $request){
		$message = [
	        'name.required' => 'Wajib di isi',
	        'name.max' => 'Terlalu Panjang, Maks 35 Karakter',
	        'descript.required' => 'Wajib di isi',
	        'descript.max' => 'Terlalu Panjang, Maks 250 Karakter',
	        'category.required' => 'Wajib di isi',
	        'website.max' => 'Terlalu Panjang, Maks 190 Karakter',
			'title_picture.dimensions' => 'Ukuran yg di terima 1366px x 1366px',
			'title_picture.image' => 'Format Gambar Tidak Sesuai',
			'title_picture.max' => 'File Size Terlalu Besar',
	        'picture.required' => 'Wajib di isi',
			'picture.dimensions' => 'Ukuran yg di terima 1366px x 1366px',
			'picture.image' => 'Format Gambar Tidak Sesuai',
			'picture.max' => 'File Size Terlalu Besar',
	        'background_picture.required' => 'Wajib di isi',
			'background_picture.dimensions' => 'Ukuran yg di terima 1366px x 1366px',
			'background_picture.image' => 'Format Gambar Tidak Sesuai',
			'background_picture.max' => 'File Size Terlalu Besar',
		];

		$validator = Validator::make($request->all(), [
			'name' => 'required|max:35',
			'descript' => 'required|max:190',
			'category' => 'required',
			'website' => 'nullable|max:190',
	        'title_picture' => 'nullable|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
	        'picture' => 'required|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
	        'background_picture' => 'required|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
		], $message);


		if($validator->fails())
		{
		return redirect()->route('backend.product.add')->withErrors($validator)->withInput();
		}

		DB::transaction(function () use($request) {
			$salt = str_random(4);

			$image = $request->file('picture');
			$img_url = str_slug($request->name,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
			$upload1 = Image::make($image);
			$upload1->save('amadeo/images/'.$img_url);

			$bg_image = $request->file('background_picture');
			$bg_img_url = str_slug($request->name,'-').'-bg'.$salt. '.' . $bg_image->getClientOriginalExtension();
			$upload2 = Image::make($bg_image);
			$upload2->save('amadeo/images/'.$bg_img_url);

			if($request->has('title_picture'))
			{
				$title_image = $request->file('title_picture');
				$title_img_url = str_slug($request->name,'-').'-'.$salt. '.' . $title_image->getClientOriginalExtension();
				$upload3 = Image::make($title_image);
				$upload3->save('amadeo/images/'.$title_img_url);
			}

			$save = new Product;
			$save->name = $request->name;
			$save->slug = str_slug($request->name,'-');
			$save->descript = $request->descript;
			$save->category = $request->category;
			$save->website = $request->website;
			$save->title_picture = $title_img_url;
			$save->picture = $img_url;
			$save->background_picture = $bg_img_url;
			$save->save();
		});


		return redirect()->route('backend.product')->with('berhasil', 'Berhasil Menambah '.$request->name);
    }

    public function flagPublish($id){
    	$Product = Product::find($id);
    	if ($Product->flug_publish == 'N') {
  			$Product->flug_publish = 'Y';
  		}
  		else if ($Product->flug_publish == 'Y') {
  			$Product->flug_publish = 'N';
  		}
  		$Product->save();
	    return redirect()->route('backend.product')->with('berhasil', 'Berhasil Mengubah '.$Product->name);
    }

    public function flagHome($id){
    	$Product = Product::find($id);
    	if ($Product->flug_home == 'N') {
  			$Product->flug_home = 'Y';
  		}
  		else if ($Product->flug_home == 'Y') {
  			$Product->flug_home = 'N';
  		}
  		$Product->save();
	    return redirect()->route('backend.product')->with('berhasil', 'Berhasil Mengubah '.$Product->name);
    }

    public function change($id){
		$Product = Product::find($id);
		$ProdukCategory = ProdukCategory::get();
		return view('backend.product.change', compact('Product','ProdukCategory'));
    }
    public function changeStore(request $request,$id){
		$message = [
	        'name.required' => 'Wajib di isi',
	        'name.max' => 'Terlalu Panjang, Maks 35 Karakter',
	        'descript.required' => 'Wajib di isi',
	        'descript.max' => 'Terlalu Panjang, Maks 250 Karakter',
	        'category.required' => 'Wajib di isi',
	        'website.max' => 'Terlalu Panjang, Maks 190 Karakter',
	        'title_picture.dimensions' => 'Ukuran yg di terima 1366px x 1366px',
			'title_picture.image' => 'Format Gambar Tidak Sesuai',
			'title_picture.max' => 'File Size Terlalu Besar',
			'picture.dimensions' => 'Ukuran yg di terima 1366px x 1366px',
			'picture.image' => 'Format Gambar Tidak Sesuai',
			'picture.max' => 'File Size Terlalu Besar',
			'background_picture.dimensions' => 'Ukuran yg di terima 1366px x 1366px',
			'background_picture.image' => 'Format Gambar Tidak Sesuai',
			'background_picture.max' => 'File Size Terlalu Besar',
		];

		$validator = Validator::make($request->all(), [
			'name' => 'required|max:35',
			'descript' => 'required|max:190',
			'category' => 'required',
			'website' => 'nullable|max:190',
	        'title_picture' => 'nullable|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
	        'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
	        'background_picture' => 'nullable|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
		], $message);


		if($validator->fails())
		{
			return redirect()->route('backend.product.change', ['id'=>$id])->withErrors($validator)->withInput();
		}

		DB::transaction(function () use($request,$id) {
			$save = Product::find($id);

			$salt = str_random(4);
			if($request->has('picture')){
				File::delete('amadeo/images/'.$save->picture);
				$image = $request->file('picture');
				$img_url = str_slug($request->name,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
				$upload1 = Image::make($image);
				$upload1->save('amadeo/images/'.$img_url);

				$save->picture = $img_url;
			}
			if($request->has('background_picture')){
				File::delete('amadeo/images/'.$save->background_picture);
				$bg_image = $request->file('background_picture');
				$bg_img_url = str_slug($request->name,'-').'-bg'.$salt. '.' . $bg_image->getClientOriginalExtension();
				$upload2 = Image::make($bg_image);
				$upload2->save('amadeo/images/'.$bg_img_url);
				$save->background_picture = $bg_img_url;
			}

			if($request->has('title_picture'))
			{
				File::delete('amadeo/images/'.$save->title_picture);
				$title_image = $request->file('title_picture');
				$title_img_url = str_slug($request->name,'-').'-'.$salt. '.' . $title_image->getClientOriginalExtension();
				$upload3 = Image::make($title_image);
				$upload3->save('amadeo/images/'.$title_img_url);
				$save->title_picture = $title_img_url;
			}else if(isset($request->remove_title_picture)){
				File::delete('amadeo/images/'.$save->title_picture);
				$save->title_picture = '';
			}

			$save->name = $request->name;
			$save->slug = str_slug($request->name,'-');
			$save->descript = $request->descript;
			$save->category = $request->category;
			$save->website = $request->website;
			$save->save();
		});


		return redirect()->route('backend.product')->with('berhasil', 'Berhasil Mengubah '.$request->name);
    }

    public function delete($id){
    	$Product = Product::find($id);

		DB::transaction(function() use($Product){
			File::delete('amadeo/images/'.$Product->picture);
			File::delete('amadeo/images/'.$Product->background_picture);
			File::delete('amadeo/images/'.$Product->title_img_url);
			$Product->delete();
		});

	    return redirect()->route('backend.product')->with('berhasil', 'Berhasil Menghapus '.$Product->name);
    }
}
