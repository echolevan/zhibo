<?php

namespace App\Http\Controllers\Home;

use App\Models\Lecturer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function __construct()
    {
        $info = config('siteinfo');
        if (\Auth::check()) {
            $auth = \Auth::user();
            $this->user = $auth;
            $userinfo = User::with('oauth')->find($auth->id);
            $lec = Lecturer::where('user_id',$auth->id)->first();
//            liveSave($lec->streams_name);
            view()->share([
                'siteinfo' => $info,
                'userinfo' => $userinfo,
                'lec'=>$lec
            ]);
        }else{
			if(session()->has('live_promotion')){
				view()->share([
					'siteinfo' => $info,
					'per_propid' => session()->get('live_promotion'),
				]);				
			} else {
				view()->share([
					'siteinfo' => $info
				]);				
			}
        }

    }
}
