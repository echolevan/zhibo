<?php

namespace App\Http\Controllers\Home;
use App\Models\Award;
use Illuminate\Http\Request;
use App\Http\Requests;
//推广
class PromotionController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
           '_promotion' => 'on'
        ]);
    }

    public function index()
    {
        $awards = Award::with('user')->where('user_id',$this->user->id)->orderBy('id','desc')->get();
        return view('home.user.promotion.index')->with('awards',$awards);
    }
}
