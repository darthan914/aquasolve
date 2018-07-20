<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Certification;

use Validator;
use DB;
use Image;
use File;

class CertificationController extends Controller
{
    public function index(){
    	$Certification = Certification::get();

        return view('backend.certification.index', compact('Certification'));
    }

    public function store(request $request){
      $message = [
        'title.required' => 'Wajib di isi',
        'title.max' => 'Terlalu Panjang, Maks 35 Karakter',
        'picture.required' => 'Wajib di isi',
        'picture.dimensions' => 'Ukuran yg di terima 1024px x 1024px',
        'picture.image' => 'Format Gambar Tidak Sesuai',
        'picture.max' => 'File Size Terlalu Besar',
      ];

      $validator = Validator::make($request->all(), [
        'title' => 'required|max:35',
        'picture' => 'required|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1024,max_height=1024',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.certification')->withErrors($validator)->withInput()->with('info-form-add', true);
      }

      DB::transaction(function () use($request) {
        $salt = str_random(4);
        $image = $request->file('picture');
        $img_url = str_slug($request->title,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
        $upload1 = Image::make($image);
        $upload1->save('amadeo/images/'.$img_url);

        $save = new Certification;
        $save->title = $request->title;
        $save->picture = $img_url;
        $save->save();
      });


      return redirect()->route('backend.certification')->with('berhasil', 'Berhasil Menambah '.$request->title);
    }

    public function change(request $request){
      $message = [
        'title.required' => 'Wajib di isi',
        'title.max' => 'Terlalu Panjang, Maks 25 Karakter',
        'title.unique' => 'Produk ini sudah ada',
        'picture.dimensions' => 'Ukuran yg di terima 1024px x 1024px',
        'picture.image' => 'Format Gambar Tidak Sesuai',
        'picture.max' => 'File Size Terlalu Besar',
      ];

      $validator = Validator::make($request->all(), [
        'title' => 'required|max:35',
        'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1024,max_height=1024',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.certification')->withErrors($validator)->withInput()->with('info-form-change', true);
      }

      DB::transaction(function () use($request) {
		$save = Certification::find($request->id);

		if($request->has('picture')){
			File::delete('amadeo/images/'.$save->picture);
	        $salt = str_random(4);
	        $image = $request->file('picture');
	        $img_url = str_slug($request->title,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
	        $upload1 = Image::make($image);
	        $upload1->save('amadeo/images/'.$img_url);
	        $save->picture = $img_url;
		}

        $save->title = $request->title;
        $save->save();
      });


      return redirect()->route('backend.certification')->with('berhasil', 'Berhasil Mengubah '.$request->title);
    }

    public function flagPublish($id){
    	$Certification = Certification::find($id);
    	if ($Certification->flug_publish == 'N') {
  			$Certification->flug_publish = 'Y';
  		}
  		else if ($Certification->flug_publish == 'Y') {
  			$Certification->flug_publish = 'N';
  		}
  		$Certification->save();
	    return redirect()->route('backend.certification')->with('berhasil', 'Berhasil Mengubah '.$Certification->title);
    }

    public function delete($id){
    	$Certification = Certification::find($id);

		DB::transaction(function() use($Certification){
			File::delete('amadeo/images/'.$Certification->picture);
			$Certification->delete();
		});

	    return redirect()->route('backend.certification')->with('berhasil', 'Berhasil Menghapus '.$Certification->title);
    }
}
