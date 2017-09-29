<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PayController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        return view('mobile.pay.index')->with('user',$user);
    }
}
