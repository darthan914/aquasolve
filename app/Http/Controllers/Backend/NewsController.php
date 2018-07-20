<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\News;

use Validator;
use DB;
use Image;
use File;

class NewsController extends Controller
{
    public function index(){
    	$News = News::get();

        return view('backend.news.index', compact('News'));
    }

    public function add(){
        return view('backend.news.add');
    }

    public function store(request $request){
      $message = [
        'name.unique' => 'Sudah pernah digunakan',
        'name.required' => 'Wajib di isi',
        'name.max' => 'Terlalu Panjang, Maks 35 Karakter',
        'descript.required' => 'Wajib di isi',
        'picture.required' => 'Wajib di isi',
        'picture.dimensions' => 'Ukuran yg di terima 1366px x 1366px',
        'picture.image' => 'Format Gambar Tidak Sesuai',
        'picture.max' => 'File Size Terlalu Besar',
      ];

      $validator = Validator::make($request->all(), [
        'name' => 'required|max:35|unique:amd_news',
        'descript' => 'required',
        'picture' => 'required|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.news.add')->withErrors($validator)->withInput()->with('info-form-add', true);
      }

      DB::transaction(function () use($request) {
        $salt = str_random(4);
        $image = $request->file('picture');
        $img_url = str_slug($request->name,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
        $upload1 = Image::make($image);
        $upload1->save('amadeo/images/'.$img_url);

        $save = new News;
        $save->name = $request->name;
        $save->slug = str_slug($request->name,'-');
        $save->descript = $request->descript;
        $save->picture = $img_url;
        $save->save();
      });


      return redirect()->route('backend.news')->with('berhasil', 'Berhasil Menambah '.$request->name);
    }

    public function change($id){
		$News = News::find($id);

        return view('backend.news.change', compact('News'));
    }

    public function changeStore(request $request,$id){
      $message = [
        'name.required' => 'Wajib di isi',
        'name.max' => 'Terlalu Panjang, Maks 25 Karakter',
        'name.unique' => 'Produk ini sudah ada',
        'descript.required' => 'Wajib di isi',
        'picture.dimensions' => 'Ukuran yg di terima 1366px x 1366px',
        'picture.image' => 'Format Gambar Tidak Sesuai',
        'picture.max' => 'File Size Terlalu Besar',
      ];

      $validator = Validator::make($request->all(), [
        'name' => 'required|max:35',
        'descript' => 'required',
        'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.news.store.change', ['id'=>$id])->withErrors($validator)->withInput()->with('info-form-change', true);
      }

      DB::transaction(function () use($request) {
    		$save = News::find($request->id);

    		if($request->has('picture')){
    			File::delete('amadeo/images/'.$save->picture);
    	        $salt = str_random(4);
    	        $image = $request->file('picture');
    	        $img_url = str_slug($request->name,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
    	        $upload1 = Image::make($image);
    	        $upload1->save('amadeo/images/'.$img_url);
    	        $save->picture = $img_url;
    		}

        $save->name = $request->name;
        $save->slug = str_slug($request->name,'-');
        $save->descript = $request->descript;
        $save->save();
      });


      return redirect()->route('backend.news')->with('berhasil', 'Berhasil Mengubah '.$request->name);
    }

    public function flagPublish($id){
    	$News = News::find($id);
    	if ($News->flug_publish == 'N') {
  			$News->flug_publish = 'Y';
  		}
  		else if ($News->flug_publish == 'Y') {
  			$News->flug_publish = 'N';
  		}
  		$News->save();
	    return redirect()->route('backend.news')->with('berhasil', 'Berhasil Mengubah '.$News->name);
    }

    public function delete($id){
    	$News = News::find($id);

		DB::transaction(function() use($News){
			File::delete('amadeo/images/'.$News->picture);
			$News->delete();
		});

	    return redirect()->route('backend.news')->with('berhasil', 'Berhasil Menghapus '.$News->name);
    }
}
