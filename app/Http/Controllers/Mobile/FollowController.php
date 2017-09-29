<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Follow;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FollowController extends Controller
{
    public function __construct()
    {
        $auth = \Auth::user();
        $userinfo = User::with('oauth')->find($auth->id);
        $this->user = $userinfo;
        view()->share([
            '_mobile_follow' => 'curr'
        ]);
    }

    public function index()
    {
        $follows = Follow::with('user.lecturer.room')->where('my_id',$this->user->id)->get();
        return view('mobile.follow.index')->with('follows',$follows);
    }
}
