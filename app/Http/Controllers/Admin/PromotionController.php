<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
class PromotionController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
           '_promotion' => 'am-in'
        ]);
    }

    public function index(Request $request)
    {
        $where = function($query) use ($request){
            if($request->has('name') and $request->name != ''){
                $search = "%" . $request->name . "%";
                $query->where('name', 'like', $search);
            }
        };
        $promotions = User::with('children')->where($where)->orderBy('id','desc')->paginate(15);
        return view('admin.promotion.index')->with('promotions',$promotions);
    }

    public function promotionConfig()
    {
        $promotion = config('promotion');
        return view('admin.promotion.config')->with('promotion',$promotion);
    }

    public function updatePromotionConfig(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'register_award' => 'required',
            'pay_award' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('error','请按要求填写字段！')->withInput();
        }
        if(!preg_match("/^[0-9][0-9]*$/",$request->register_award)){
            return ['status' => false,'msg' => '奖励请填写正整数！'];
        }
        if(!preg_match("/^[0-9][0-9]*$/",$request->pay_award)){
            return ['status' => false,'msg' => '提成请填写正整数！'];
        }
        $all = $request->all();
        $array = collect($all)->except(['_token','_method'])->toArray();
        $this->config_set('promotion',$array);
        return back()->with('msg','更新成功！');
    }
}
