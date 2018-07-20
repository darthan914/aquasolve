<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\GeneralConfig;

use Validator;
use Mail;
use DB;
use Image;
use File;

class GeneralConfigController extends Controller
{
    public function index(){
    	$GeneralConfig = GeneralConfig::get();

        return view('backend.general-config.index', compact('GeneralConfig'));
    }
    public function update($id){
    	$GeneralConfig = GeneralConfig::find($id);

        return view('backend.general-config.update', compact('GeneralConfig'));
    }
    public function store(request $request, $id){
    	
		$message = [
			'picture.dimensions' => 'Ukuran yg di terima 1024px x 1024px',
			'picture.image' => 'Format Gambar Tidak Sesuai',
			'picture.max' => 'File Size Terlalu Besar',
		];

		$validator = Validator::make($request->all(), [
	        'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:2000',
		], $message);


		if($validator->fails())
		{
			return redirect()->route('backend.general-config.update', ['id'=> $id])->withErrors($validator)->withInput();
		}

		DB::transaction(function () use($request, $id) {
			$save = GeneralConfig::find($id);

			if($request->has('picture')){
				File::delete('amadeo/images/'.$save->picture);
				$salt = str_random(12);
				$image = $request->file('picture');
				$img_url = $salt. '.' . $image->getClientOriginalExtension();
				$upload1 = Image::make($image);
				$upload1->save('amadeo/images/'.$img_url);
				$save->picture = $img_url;
			}

			$save->title = $request->title;
			$save->content = $request->content;
			$save->save();
		});


		return redirect()->route('backend.general-config')->with('berhasil', 'Success updated...');
    }
}
