<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\JobApply;

class JobApplyController extends Controller
{
    function index(){
    	$inbox = JobApply::orderBy('id', 'DESC')->get();

    	return view('backend.job-apply.index', compact('inbox'));
    }
}
