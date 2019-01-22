<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Partner;

use Auth;
use DB;
use Image;
use Validator;
use File;

class PartnerController extends Controller
{
	public function index()
	{
		$getPartner = Partner::orderBy('flag_publish', 'desc')->get();

		return view('backend.partner.index', compact('getPartner'));
	}

	public function tambah()
	{
		return view('backend.partner.tambah');
	}

	public function store(Request $request){
		$message = [
			'name.required' => 'This Field Required',
			'name.unique' => 'Partner Sudah Ada',
			'img_url.required' => 'This Field Required',
			'img_url.image' => 'Invalid Format, Image file only',
			'img_url.max' => 'File too large',
			'img_url.dimensions' => 'Ukuran Tinggi Maksimal 60px',
			'img_alt.required' => 'This Field Required',
			'link_url.url' => 'Format url tidak sesuai'
		];

		$validator = Validator::make($request->all(), [
			'name' => 'required|unique:amd_partner',
			'img_url' => 'required|image|mimes:jpeg,bmp,png|max:1000|dimensions:max_height=60',
			'img_alt' => 'required',
			'link_url' => 'nullable|url'
		], $message);


		if($validator->fails())
		{
			return redirect()->route('backend.partner.tambah')->withErrors($validator)->withInput();
		}


		$salt = str_random(4);

		$image = $request->file('img_url');
		$img_url = str_slug($request->nama_Partner,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
		Image::make($image)->save('amadeo/images/partner/'. $img_url);

		if($request->flag_publish == 'on'){
		$flag_publish = 1;
		}else{
		$flag_publish = 0;
		}

		// if($request->flag_buynow == 'on'){
		// $flag_buynow = 1;
		// }else{
		// $flag_buynow = 0;
		// }

		$save = new Partner;
		$save->name = $request->name;
		$save->img_url = $img_url;
		$save->img_alt = $request->img_alt;
		$save->link_url = $request->link_url;
		// $save->flag_buynow = $flag_buynow;
		$save->flag_publish = $flag_publish;
		$save->actor = Auth::user()->id;
		$save->save();

		// $log = new LogAkses;
		// $log->actor = Auth::user()->id;
		// $log->aksi = 'Menambahkan Partner '.$request->nama_Partner;
		// $log->save();

		return redirect()->route('backend.partner')->with('berhasil', 'Data Has Been Addedkan Partner '.$request->name);
	}

	public function ubah($id){
		$getPartner = Partner::find($id);

		if(!$getPartner){
		return view('backend.errors.404');
		}

		return view('backend.partner.ubah', compact('getPartner'));
	}

	public function edit(Request $request){
		$message = [
			'name.required' => 'This Field Required',
			'name.unique' => 'Social Media ini sudah ada',
			'img_url.image' => 'Invalid Format, Image file only',
			'img_url.max' => 'File too large',
			'img_url.dimensions' => 'Ukuran Tinggi Maksimal 60px',
			'img_alt.required' => 'This Field Required',
			'link_url.url' => 'Format url tidak sesuai',
		];

		$validator = Validator::make($request->all(), [
			'name' => 'required|unique:amd_partner,name,'.$request->id,
			'img_url' => 'image|mimes:jpeg,bmp,png|max:1000|dimensions:max_height=60',
			'img_alt' => 'required',
			'link_url' => 'nullable|url',
		], $message);

		if($validator->fails())
		{
		return redirect()->route('backend.partner.update', ['id' => $request->id])->withErrors($validator)->withInput();
		}


		DB::transaction(function() use($request){
		$salt = str_random(4);
		$image = $request->file('img_url');

		if($request->flag_publish == null){
		$flag_publish = 0;
		}else{
		$flag_publish = 1;
		}

		// if($request->flag_buynow == null){
		// $flag_buynow = 0;
		// }else{
		// $flag_buynow = 1;
		// }

		$update = Partner::find($request->id);
		$update->name = $request->name;
		$update->img_alt  = $request->img_alt;
		$update->link_url  = $request->link_url;
		// $update->flag_buynow = $flag_buynow;
		$update->flag_publish = $flag_publish;
		$update->actor = Auth::user()->id;

		if (!$image) {
		$update->update();
		}else{
		$img_url = str_slug($request->nama_Partner,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
		Image::make($image)->save('amadeo/images/partner/'. $img_url);

		$update->img_url  = $img_url;
		$update->update();
		}

		// $log = new LogAkses;
		// $log->actor = Auth::user()->id;
		// $log->aksi = 'Mengubah Partner '.$request->nama_Partner;
		// $log->save();

		});

		return redirect()->route('backend.partner')->with('berhasil', 'Data Has Been Updated Partner '.$request->name);
	}

	public function flagPublish($id){
		$getPartner = Partner::find($id);

		if(!$getPartner){
			return view('backend.errors.404');
		}

		if ($getPartner->flag_publish == 1) {
			$getPartner->flag_publish = 0;
			$getPartner->update();

			return redirect()->route('backend.partner')->with('berhasil', 'Berhasil Unpublish Partner '.$getPartner->nama_Partner);
		}else{
			$getPartner->flag_publish = 1;
			$getPartner->update();

			return redirect()->route('backend.partner')->with('berhasil', 'Berhasil Publish Partner '.$getPartner->nama_Partner);
		}
	}

	public function delete($id){
		$getPartner = Partner::find($id);

		if(!$getPartner){
			return view('backend.errors.404');
		}

		DB::transaction(function() use($getPartner){
			File::delete('amadeo/images/partner' .$getPartner->img_url);
			$getPartner->delete();

			// $log = new LogAkses;
			// $log->actor = Auth::user()->id;
			// $log->aksi = 'Menghapus Partner '.$getPartner->img_url;
			// $log->save();
		});

		return redirect()->route('backend.partner')->with('berhasil', 'Berhasil menghapus Partner');
	}
}
