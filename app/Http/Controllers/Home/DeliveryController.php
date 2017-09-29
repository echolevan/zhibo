<?php

namespace App\Http\Controllers\Home;

use App\Models\Article;
use App\Models\Delivery_comment;
use App\Models\Profit;
use App\Models\Stock_data;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use Excel;
use DB;
use Validator;
//交割单
class DeliveryController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_delivery' => 'on'
        ]);
    }
    public function index()
    {
        //总收益
        $countUserId = Profit::select('user_id')->distinct()->get();
        $counts = Profit::with('user')->select('user_id',DB::raw('sum(earnings) as sum_earnings'),DB::raw('sum(gain) as sum_gain'))
            ->whereIn('user_id',$countUserId)
            ->groupBy('user_id')
            ->orderBy(DB::raw('sum(gain)'), 'desc')
            ->take(10)
            ->get();
        //年收益
//        $yearUserId = Profit::whereBetween('created_time',[date('Y-1-1')." 00:00:00",date('Y-12-30')." 23:59:59"])->select('user_id')->distinct()->get();
//        $years = Profit::with('user')->select('user_id',DB::raw('sum(earnings) as sum_earnings'),DB::raw('sum(gain) as sum_gain'))
//            ->whereBetween('created_time',[date('Y-1-1')." 00:00:00",date('Y-12-30')." 23:59:59"])
//            ->whereIn('user_id',$yearUserId)
//            ->groupBy('user_id')
//            ->orderBy(DB::raw('sum(gain)'), 'desc')
//            ->take(10)
//            ->get();
        //日收益
        $day = Profit::select('user_id')->orderBy('id','desc')->take(10)->distinct()->get();
        $today = Profit::with('user')
            ->whereIn('user_id',$day)
            ->orderBy('gain','desc')
            ->take(10)
            ->get();
        //牛人观点
        $best = Article::with('user','comments')->where('type',1)->where('is_delete','!=',2)->orderBy('id','asc')->take(6)->get();
        return view('home.delivery.index')->with('counts',$counts)->with('today',$today)->with('best',$best);
    }
//    public function export(){
//        $cellData = [
//            ['日期','证券代码','证券名称','操作','成交数量','成交均价','发生金额','后资金额','交易市场','股东帐户','货币单位'],
//        ];
//        Excel::create('delivery',function($excel) use ($cellData){
//            $excel->sheet('score', function($sheet) use ($cellData){
//                $sheet->rows($cellData);
//            });
//        })->export('xls');
//    }

    public function deliveryList(Request $request,$user_id)
    {
        $check_user = User::find($user_id);
        if(empty($check_user) and $check_user->type != 2){
            return redirect(route('delivery'));
        }
        //DB::enableQueryLog();
        $where = function($query) use($request){
            if ($request->has(['start_time','end_time']) and $request->start_time != '' and $request->end_time != '') {
                $query->whereBetween('time',[$request->start_time,$request->end_time]);
            }
        };
        $delivery = Profit::with('user','comments')->where($where)->orderBy('id','desc')->where('user_id',$user_id)->paginate(10);
        $sum = Profit::where('user_id',$user_id)->sum('gain');
        //return DB::getQueryLog();
        return view('home.delivery.list')->with('delivery',$delivery)->with('check_user',$check_user)->with('sum',$sum);
    }

    public function details($user_id,$profit_id)
    {
        $check_user = User::find($user_id);
        if(empty($check_user) and $check_user->type != 2){
            return redirect(route('delivery'));
        }
        $check_profit = Profit::find($profit_id);
        if(empty($check_profit)){
            return redirect(route('delivery'));
        }
        $sum = Profit::where('user_id',$user_id)->sum('gain');
        $count = Profit::where('user_id',$user_id)->count();
        $data_id = explode(',',str_replace(']','',str_replace('[','',$check_profit->stock_data_id)));
        //DB::enableQueryLog();
        $details = Stock_data::whereIn('id',$data_id)->get();
        //return DB::getQueryLog();
        $comments = Delivery_comment::with('user','children.user.oauth')
            ->where('delivery_id',$profit_id)
            ->where('parent_id',0)
            ->orderBy('id','desc')
            ->get();
        if(Delivery_comment::where('delivery_id',$profit_id)->sum('evaluate') == 0){
            $evaluate = 1;
        }else{
            $evaluate = round(Delivery_comment::where('delivery_id',$profit_id)->sum('evaluate')/$comments->count());
        }
        return view('home.delivery.details')
            ->with('check_user',$check_user)
            ->with('sum',$sum)->with('count',$count)
            ->with('details',$details)
            ->with('profit_id',$profit_id)
            ->with('comments',$comments)
            ->with('evaluate',$evaluate);
    }

    //添加评论
    public function addComment(Request $request)
    {
        if(empty($request->profit_id)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $profit = Profit::find($request->profit_id);
        if(empty($profit)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if($profit->user_id == $this->user->id){
            return ['status' => false,'msg' => '请不要评论自己！'];
        }
        $validator = Validator::make(['contents' => $request->contents], [
            'contents' => 'required|max:50',
        ]);
        if ($validator->fails()) {
            return ['status' => false,'msg' => '内容不能为空,切字数最多为50！'];
        }
        //查看评论是否过于频繁
        //查找当前登陆用户最新发布的评论
        $comment = Delivery_comment::where('delivery_id',$request->profit_id)->where('user_id',$this->user->id)->orderBy('id','desc')->first();
        if(!empty($comment)){
            $time = date("Y-m-d H:i:s",strtotime($comment->created_time));
            $intervalTime =  date("Y-m-d H:i:s", strtotime("$time +300 second"));
            $now = date('Y-m-d H:i:s',strtotime(Carbon::now()));
            if($intervalTime > $now){
                return ['status' => false,'msg' => '您已经评论过了，请稍后发布！'];
            }
        }
        if(empty($this->user->thumb)){
            $thumb = $this->user->oauth->avatar_url;
        }else{
            $thumb = $this->user->thumb;
        }
        if(empty($this->user->name)){
            $name = $this->user->oauth->nickname;
        }else{
            $name = $this->user->name;
        }
        $comment = Delivery_comment::create([
            'delivery_id' => $request->profit_id,
            'delivery_user_id' => $profit->user_id,
            'user_id' => $this->user->id,
            'contents' => $request->contents,
            'evaluate' => $request->evaluate,
            'created_time' => Carbon::now()
        ]);
        $info = [
            'thumb' => $thumb,
            'name' => $name,
            'contents' => $comment->contents,
            'time' => date('Y-m-d H:i:s')
        ];
        return ['status' => true,'msg' => '添加成功！','info' => $info];
    }

    //回复评论
    public function replyComment(Request $request)
    {
        if(empty($request->profit_id)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if(empty($request->id)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $profit = Delivery_comment::find($request->id);
        if(empty($profit)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $comment = Delivery_comment::find($request->id);
        if(empty($comment)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if($comment->parent_id != 0){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $validator = Validator::make(['contents' => $request->contents], [
            'contents' => 'required|max:50',
        ]);
        if ($validator->fails()) {
            return ['status' => false,'msg' => '内容不能为空,切字数最多为50！'];
        }
        if($comment->user_id == $this->user->id){
            return ['status' => false,'msg' => '请不要回复自己的评论！'];
        }
        //查看评论是否过于频繁
        //查找当前登陆用户最新发布的评论
        $check_comment = Delivery_comment::where('delivery_id',$request->profit_id)->where('parent_id',$request->id)->first();
        if(!empty($check_comment)){
            $time = date("Y-m-d H:i:s",strtotime($check_comment->created_time));
            $intervalTime =  date("Y-m-d H:i:s", strtotime("$time +300 second"));
            $now = date('Y-m-d H:i:s',strtotime(Carbon::now()));
            if($intervalTime > $now){
                return ['status' => false,'msg' => '您已经回复过了，请稍后发布！'];
            }
        }
        Delivery_comment::create([
            'delivery_id' => $request->profit_id,
            'user_id' => $this->user->id,
            'parent_id' => $request->id,
            'contents' => $request->contents,
            'created_time' => Carbon::now()
        ]);
        return ['status' => true,'msg' => '添加成功！'];
    }

    //讲师上传交割单页面
    public function addStock()
    {
        return view('home.lecturer.delivery.add')->with('_delivery','on');
    }

    public function import(Request $request){
        if(!$request->hasFile('delivery')){
            return back()->with('error','上传内容不能为空！');
        }
        $file = $request->file('delivery');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            var_dump($file->getErrorMessage());
            exit;
        }
        //文件类型
        $allow = array('application/vnd.ms-office');
        $mine = $request->file('delivery')->getMimeType();
//        if (!in_array($mine, $allow)) {
//            return "<script>alert('文件格式不对，请下载Microsoft Excel2013！'),location.href= '/';</script>";
//        }


        $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
        $savePath = 'test/';
        if (!is_dir($savePath)) {
            mkdir($savePath, 0777, true);
        }
        $request->file('delivery')->move($savePath, $newFileName);
        $filePath = 'public/test/'.$newFileName;
        $res = [];
        Excel::load($filePath, function ($reader) use (&$res){
           $reader = $reader->getSheet(0);
            //获取表中的数据
            $data = $reader->toArray();
            for($i=0;$i<count($data);$i++){
                foreach($data[$i] as $k=>$v){
                    $res[$i+1][$k]= $v;
                }
            }
        });

        //检查格式是否正确
        $style = ['日期','证券代码','证券名称','操作','成交数量','成交均价','发生金额','后资金额','交易市场','股东帐户','货币单位'];
        if($style != array_filter($res[1])){
            unlink(public_path('test/'.$newFileName));
            return back()->with('error','请按照规范填写上传内容！');
        }
        unset($res[1]);
        //验证提交的Excel是否有空的字段
        foreach($res as $k=>$v){
            if($v[3] != '利息归本'){
                if(empty($v)){
                    unlink(public_path('test/'.$newFileName));
                    return back()->with('error','数据不能为空,请检查提交的数据！');
                }
            }
        }
        //检查是否平仓
        $arr = [];
        foreach($res as $k=>$v){
            $arr[] = $v[4];
        }
        $count_number =  array_sum($arr);
        if($count_number != 0){
            unlink(public_path('test/'.$newFileName));
            return back()->with('error','尚未平仓！');
        }
        //如果已经平仓，将交割单数据写入 方便查看详情 下一步进行盈利率计算
        //进行数据校验 检查是否重复
        $data_id = [];
        foreach(array_reverse($res) as $v){
            $check_repetition = Stock_data::where('user_id',$this->user->id)->where('time',date('Y-m-d',strtotime($v[0])))->where('code',$v[1])->first();
            if(!empty($check_repetition)){
                unlink(public_path('test/'.$newFileName));
                return back()->with('error','与上次提交的数据有重复，请检查 重新上传！');
            }
            if(!empty($v[1])){
                $stock_data = Stock_data::create([
                    'user_id' => $this->user->id,
                    'operate' => $v[3],
                    'code' => $v[1],
                    'name' => $v[2],
                    'number' => $v[4],
                    't_price' => $v[5],
                    'h_price' => $v[6],
                    'price' => $v[7],
                    'market' => $v[8],
                    'account'=> $v[9],
                    'time' => date('Y-m-d',strtotime($v[0])),
                    'created_time' => Carbon::now()
                ]);
            }
            $data_id[] = $stock_data->id;
        }
        $profit = Profit::create([
            'user_id' => $this->user->id,
            'stock_data_id' => collect($data_id)->toJson(),
            'gain' => ($res[2][7]-array_reverse($res)[0][7])/array_reverse($res)[0][7],
            'earnings' => ($res[2][7]-array_reverse($res)[0][7]),
            'time' => date('Y-m-d',strtotime($res[2][0])),
            'created_time' => Carbon::now()
        ]);
        unlink(public_path('test/'.$newFileName));
        if(empty($profit)){
            return back()->with('error','上传失败！');
        }
        return back()->with('msg','上传成功！');
    }

}
