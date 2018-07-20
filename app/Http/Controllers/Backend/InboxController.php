<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Inbox;

class InboxController extends Controller
{
    function index(){
    	$inbox = Inbox::get();

    	return view('backend.inbox.index', compact('inbox'));
    }
}
