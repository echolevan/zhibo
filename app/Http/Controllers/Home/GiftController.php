<?php

namespace App\Http\Controllers\Home;

use App\Models\Gift_history;
use App\Models\Gifts;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GiftController extends Controller
{
    //
    public function __construct()
    {
        $this->user = 'test';
    }

    public function send_gift(Request $request)//送礼物
    {
        $gift = Gifts::where('is_delete', 1)->find($request->gift_id);
        if (empty($gift) || $request->num < 1) {
            return false;
        }
        $num = intval($request->num);//礼物数量
        $all_price = $gift->price * $num;//礼物总价值
        $have_gold = self::have_gold($all_price);
        if (!$have_gold) {
            return false;
        }
        $receiver = User::find($request->receiver);
        if (empty($receiver)) {
            return false;
        }
        $this->user->gold = $this->user->gold - $all_price;
        $this->user->save();
        $receiver->gold = $receiver->gold + $all_price;
        $receiver->save();
        self::store_gift_history($gift, $request, $receiver);
        return true;
    }

    public function store_gift_history($gift, $all_price, $receiver)//写入送礼物明细表
    {
        $info = array(
            'gift_id' => $gift->id,
            'gift_name' => $gift->name,
            'gift_price' => $gift->price,
            'send_name' => $this->user->name,
            'send_id' => $this->user->id,
            'num' => ($all_price / $gift->price),
            'all_price' => $all_price,
            'receiver_name' => $receiver->name,
            'receiver_id' => $receiver->id,
            'create_time' => date('Y-m-d H:i:s'),
        );
        Gift_history::create($info);
    }

    public function have_gold($price)//判断余额够不够,传进来一个礼物价格
    {
        if ($price < 0 || $this->user->gold < $price) {
            return false;
        }
        return true;
    }
}
