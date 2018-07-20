<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Careers;

use Validator;
use DB;

class CareersController extends Controller
{
    public function index(){
    	$Careers = Careers::get();

        return view('backend.careers.index', compact('Careers'));
    }

    public function add(){
        return view('backend.careers.add');
    }

    public function addStore(request $request){
    	$message = [
        'name.required' => 'Wajib di isi',
        'name.max' => 'Terlalu Panjang, Maks 35 Karakter',
        'job_type.required' => 'Wajib di isi',
        'job_type.max' => 'Terlalu Panjang, Maks 35 Karakter',
        'location.required' => 'Wajib di isi',
        'location.max' => 'Terlalu Panjang, Maks 35 Karakter',
        'contract.required' => 'Wajib di isi',
        'contract.max' => 'Terlalu Panjang, Maks 35 Karakter',
        'vacancy.required' => 'Wajib di isi',
        'vacancy.max' => 'Terlalu Panjang, Maks 35 Karakter',
        'job_description.required' => 'Wajib di isi',
        'job_description.max' => 'Terlalu Panjang, Maks 1500 Karakter',
        'responsibilities.required' => 'Wajib di isi',
        'responsibilities.max' => 'Terlalu Panjang, Maks 1500 Karakter',
        'qualifications.required' => 'Wajib di isi',
        'qualifications.max' => 'Terlalu Panjang, Maks 1500 Karakter',

      ];

      $validator = Validator::make($request->all(), [
        'name' => 'required|max:35',
        'job_type' => 'required|max:35',
        'location' => 'required|max:35',
        'contract' => 'required|max:35',
        'vacancy' => 'required|max:35',
        'job_description' => 'required|max:1500',
        'responsibilities' => 'required|max:1500',
        'qualifications' => 'required|max:1500',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.careers.add')->withErrors($validator)->withInput();
      }

      DB::transaction(function () use($request) {
        $save = new Careers;
        $save->name = $request->name;
        $save->job_type = $request->job_type;
        $save->location = $request->location;
        $save->contract = $request->contract;
        $save->vacancy = $request->vacancy;
        $save->job_description = $request->job_description;
        $save->responsibilities = $request->responsibilities;
        $save->qualifications = $request->qualifications;
        $save->save();
      });


      return redirect()->route('backend.careers')->with('berhasil', 'Berhasil Menambah '.$request->name);
    }

    public function flagPublish($id){
    	$Careers = Careers::find($id);
    	if ($Careers->flug_publish == 'N') {
  			$Careers->flug_publish = 'Y';
  		}
  		else if ($Careers->flug_publish == 'Y') {
  			$Careers->flug_publish = 'N';
  		}
  		$Careers->save();
	    return redirect()->route('backend.careers')->with('berhasil', 'Berhasil Mengubah '.$Careers->name);
    }

    public function change($id){
    	$Careers = Careers::find($id);
        return view('backend.careers.change', compact('Careers'));
    }
    public function changeStore(request $request,$id){
    	$message = [
        'name.required' => 'Wajib di isi',
        'name.max' => 'Terlalu Panjang, Maks 35 Karakter',
        'job_type.required' => 'Wajib di isi',
        'job_type.max' => 'Terlalu Panjang, Maks 35 Karakter',
        'location.required' => 'Wajib di isi',
        'location.max' => 'Terlalu Panjang, Maks 35 Karakter',
        'contract.required' => 'Wajib di isi',
        'contract.max' => 'Terlalu Panjang, Maks 35 Karakter',
        'vacancy.required' => 'Wajib di isi',
        'vacancy.max' => 'Terlalu Panjang, Maks 35 Karakter',
        'job_description.required' => 'Wajib di isi',
        'job_description.max' => 'Terlalu Panjang, Maks 1500 Karakter',
        'responsibilities.required' => 'Wajib di isi',
        'responsibilities.max' => 'Terlalu Panjang, Maks 1500 Karakter',
        'qualifications.required' => 'Wajib di isi',
        'qualifications.max' => 'Terlalu Panjang, Maks 1500 Karakter',

      ];

      $validator = Validator::make($request->all(), [
        'name' => 'required|max:35',
        'job_type' => 'required|max:35',
        'location' => 'required|max:35',
        'contract' => 'required|max:35',
        'vacancy' => 'required|max:35',
        'job_description' => 'required|max:1500',
        'responsibilities' => 'required|max:1500',
        'qualifications' => 'required|max:1500',
      ], $message);


      if($validator->fails())
      {
          return redirect()->route('backend.careers.change', ['id'=>$id])->withErrors($validator)->withInput();
      }

      DB::transaction(function () use($request,$id) {
    	$save = Careers::find($id);

        $save->name = $request->name;
        $save->job_type = $request->job_type;
        $save->location = $request->location;
        $save->contract = $request->contract;
        $save->vacancy = $request->vacancy;
        $save->job_description = $request->job_description;
        $save->responsibilities = $request->responsibilities;
        $save->qualifications = $request->qualifications;
        $save->save();
      });


      return redirect()->route('backend.careers')->with('berhasil', 'Berhasil Mengubah '.$request->name);
    }

    public function delete($id){
    	$Careers = Careers::find($id);

		DB::transaction(function() use($Careers){
			$Careers->delete();
		});

	    return redirect()->route('backend.careers')->with('berhasil', 'Berhasil Menghapus '.$Careers->name);
    }
}
