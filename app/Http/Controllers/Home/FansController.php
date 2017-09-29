<?php

namespace App\Http\Controllers\Home;

use App\Models\Follow;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FansController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_fans' => 'on'
        ]);
    }

    public function index()
    {
        $fans = Follow::with('fans')->where('user_id',$this->user->id)->paginate(12);
        return view('home.user.follow.fans')->with('fans',$fans);
    }
}
