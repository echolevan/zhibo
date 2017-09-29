<?php

namespace App\Http\Controllers\Home\Customer;

use App\Http\Controllers\Home\CommonController;
use App\Models\Article;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;


class IndexController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_customer' => 'on'
        ]);
    }

    public function index($id)
    {
        $customer = User::with('lecturer.room','oauth')->where('type',2)->find($id);
        //判断该用户是否存在
        if(empty($customer)){
            return redirect(route('home'));
        }
        //判断该主播是否有房间
        if(empty($customer->lecturer->room)){
            return redirect(route('home'));
        }
        $articles = Article::with('user','comments')->where('user_id',$id)->where('type',2)->orderBy('id','desc')->paginate(10);
        return view('home.customer.index')->with('customer',$customer)->with('articles',$articles);
    }
}
