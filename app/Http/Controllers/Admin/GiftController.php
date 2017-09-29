<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gift_history;
use App\Models\Gifts;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;

class GiftController extends CommonController
{
    //

    public function index()//礼物列表
    {
        $gifts = Gifts::where('is_delete', 1)->orderBy('create_time', 'desc')->paginate(15);//1为显示
        return view('admin.gift.index')->with('gifts', $gifts);
    }

    public function create()//添加礼物页面
    {
        return view('admin.gift.create');
    }

    public function store(Request $request)//提交添加礼物
    {
        $validators = Validator::make($request->all(), $this->gift_role, $this->gift_msg);
        if ($validators->fails()) {
            return back()->with('error', $validators->errors()->first())->withInput();
        }
        $info = $request->all();
        $vali_price = self::vali_price($info);
        if (!$vali_price) {
            return back()->with('error', '礼物价格需为数字且不能为负数')->withInput();
        }
        $vali_promotion = self::vali_promotion($info);
        if (!$vali_promotion) {
            return back()->with('error', '请将表单中的三条促销信息补齐')->withInput();
        }
        $info = self::replace_time($info);
        Gifts::create($info);
        return back()->with('msg', '添加成功');
    }

    public function update(Request $request)//修改礼物页面
    {
        $gift = Gifts::find($request->id);
        if (empty($gift)) {
            return back()->with('error', '商品不存在');
        }
        return view('admin.gift.update')->with('gift', $gift);
    }

    public function edit(Request $request)//提交修改礼物
    {
        $gift = Gifts::find($request->id);
        if (empty($gift)) {
            return back()->with('error', '商品不存在');
        }
        $validators = Validator::make($request->all(), $this->gift_role, $this->gift_msg);
        if ($validators->fails()) {
            return back()->with('error', $validators->errors()->first())->withInput();
        }
        $info = $request->all();
        $vali_price = self::vali_price($info);
        if (!$vali_price) {
            return back()->with('error', '礼物价格需为数字且不能为负数')->withInput();
        }
        $vali_promotion = self::vali_promotion($info);
        if (!$vali_promotion) {
            return back()->with('error', '请将表单中的三条促销信息补齐')->withInput();
        }
        $info = self::replace_time($info);
        $gift->update($info);
        return back()->with('msg', '修改成功');
    }

    public function delete(Request $request)//删除礼物
    {
        $gift = Gifts::find($request->id);
        if (empty($gift)) {
            return back()->with('error', '商品不存在');
        }
        $gift->update(['is_delete' => 10]);
        return back()->with('msg', '删除成功');
    }

    public function history()//送礼记录
    {
        $history = Gift_history::all();
        return view('admin.gift.history')->with('history', $history);
    }

    public function vali_price($info)//检查价格
    {
        if ($info['price'] < 0 || (!empty($info['promotion_price']) && $info['promotion_price'] < 0)) {
            return false;
        }
        return true;
    }

    public function vali_promotion($info)//检查促销信息
    {
        if (!empty($info['promotion_begin_time']) || !empty($info['promotion_end_time']) || !empty($info['promotion_price'])) {
            if (empty($info['promotion_begin_time']) || empty($info['promotion_end_time']) || empty($info['promotion_price']) || ($info['promotion_begin_time'] > $info['promotion_end_time'])) {
                return false;
            }
        }
        return true;
    }

    public function replace_time($info)//时间格式化
    {
        $info['promotion_begin_time'] = str_replace('T', ' ', $info['promotion_begin_time']);
        $info['promotion_end_time'] = str_replace('T', ' ', $info['promotion_end_time']);
        $info['create_time'] = date('Y-m-d H:i:s');
        return $info;
    }

    public $gift_role = array(
        'name' => 'required',
        'price' => 'required|numeric',
    );

    public $gift_msg = array(
        'name.required' => '请填写礼物名称',
        'price.required' => '请填写礼物价格',
        'price.numeric' => '礼物价格需为数字且不能为负数',
    );

}
