<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Sensitive;
use Illuminate\Http\Request;
use App\User;
use DB;
class IndexController extends Controller
{
    public function testcall(){
//        self::sendGift(1, "senderName", 12, "receiverName", "giftName", 3, 100, 300);
        self::updateUserStatus(2,2);
    }

    // get online user list
    public static function sendGift($senderID, $senderName, $receiverID, $receiverName, $giftID, $giftName, $giftNum, $giftPrice, $giftTotalAmount)
    {
        $url = self::url("uSendGift");
        $parameter = ['senderID' => $senderID, 'senderName' => $senderName, 'receiverID' => $receiverID, 'receiverName' => $receiverName,  'giftID' => $giftID, 'giftName' => $giftName, 'giftNum' => $giftNum, 'giftPrice' => $giftPrice, 'giftTotalAmount' => $giftTotalAmount, ];
        $url = appendUrlParameter($url, $parameter);
        $data = curlAPI($url);
        return $data;
    }
    
    // send question
    public static function sendQuestion($userID, $userName, $questionID, $questionTitle, $questionCost, $questionStatus)
    {
        $url = self::url("uNewQuestion");
        $parameter = ['userID' => $userID, 'userName' => $userName, 'questionID' => $questionID, 'questionTitle' => $questionTitle, 'questionCost' => $questionCost, 'questionStatus'=>$questionStatus ];
        $url = appendUrlParameter($url, $parameter);
//        var_dump($url);
        $data = curlAPI($url);
        return $data;
    }
    
    //  question had solved
    public static function solvedQuestion($questionID, $answer, $questionStatus)
    {
        $url = self::url("uSolveQuestion");
        $parameter = ['questionID' => $questionID, 'answer' => $answer, 'questionStatus' => $questionStatus];
        $url = appendUrlParameter($url, $parameter);
//        var_dump($url);
        $data = curlAPI($url);
        return $data;
    }
    
    // 用户状态修改：// 1:正常，2：禁言
    public function updateUserStatus($cid, $status)
    {
        $url = self::url("uUpdateUserStatus");
        var_dump($url);
        $parameter = ['cid' => $cid, 'status' => $status];
        $url = appendUrlParameter($url, $parameter);
        $data = curlAPI($url);
        var_dump($data);
        return $data;
    }

   

    // -----------------------------------------------------

    public function getConfig()
    {
        $config = config('api_info');
        echo json_encode($config);
    }
    
    // 全量同步机器人（聊天室启动时）
    public function synchronizeRobot(){
        $result = User::where('type',2)->get();
        $rebots = [];
        foreach ( $result as $bot){
            $b = [];
            $b['uid'] = $bot->id;
            $b['name'] = $bot->name;
            $b['level'] = intval($bot->level);
            $b['status'] = intval($bot->status);
            $rebots[] = $b;
        }
        echo json_encode($rebots);
    }
    
    // 全量同步脏词库（聊天室启动时）
    public function synchronizeBadWord(){
        $result = Sensitive::select('word')->get();
        $words = [];
        foreach ( $result as $r){
            $words[] = $r->word;
        }
        echo json_encode($words);
    }

  

    private static function url($url)
    {
        return "http://" . config('api.chat_server_host') . ":" . config('api.chat_server_port') . config("api.{$url}");
    }
}
