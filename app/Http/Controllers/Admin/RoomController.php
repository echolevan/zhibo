<?php

namespace App\Http\Controllers\Admin;
use App\Models\Lecturer;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
/**
 * 房间管理
 */
class RoomController extends CommonController
{

    public function __construct()
    {
        parent::__construct();
        view()->share([
           '_room' => 'am-in'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = function ($query) use($request) {
            if($request->has('status') and $request->status != '-1'){
                $query->where('status',$request->status);
            }
            if($request->has('room_name') and $request->room_name != ''){
                $search = "%" . $request->room_name . "%";
                $query->where('room_name', 'like', $search);
            }
        };
        $room = Room::with('lecturer.user')->where($where)->orderBy('id','desc')->paginate(15);
        return view('admin.room.index')->with('room',$room);
    }

    //相册模式
    public function videoList()
    {
        $room = Room::with('lecturer.user')->orderBy('id','desc')->paginate(15);
        return view('admin.room.video_model_index')->with('room',$room);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lecturer = Lecturer::with('user','room')->where('status',2)->get();
        return view('admin.room.create')->with('lecturer',$lecturer);
    }

    /**
     * Store a newly created resource in storage.
     *添加房间 云端创建一个流
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!empty($request->number)){
            if(preg_match("/^[1-9][0-9]*$/",$request->number)){
                $number = $request->number;
            }else{
                return ['status' => false,'msg' => '房间人数请填写正整数！'];
            }
        }else{
            $number = '1';
        }
        if(empty($request->room_name)){
            return ['status' => false,'msg' => '该房间名称不能为空！'];
        }else{
            $res = Room::where('room_name',$request->room_name)->first();
            if($res){
                return ['status' => false,'msg' => '该房间名称已存在！'];
            }
            $room_name = $request->room_name;
        }
        if($request->lecturer_id == '-1'){
           $lecturer = '';
        }else{
            $check_lecturer = Lecturer::with('room')->find($request->lecturer_id);
            if(!empty($check_lecturer->room)){
                return ['status' => false,'msg' => '该房间已经分配！'];
            }
            $lecturer = $request->lecturer_id;
        }
        $barrage = $request->barrage;
        $speak = $request->speak;
        $luck = $request->luck;
        //生成流
        $streamKey = date('d').time();
        $stream = createStream($streamKey);
        disableStream($streamKey);
        if($stream['status'] == false){
            return $stream;
        }
        Room::create([
            'streams_name' => $streamKey,
            'lecturer_id' => $lecturer,
            'room_name' => $room_name,
            'desc' => $request->desc,
            'notice' => $request->notice,
            'number' => $number,
            'barrage' => $barrage,
            'speak' => $speak,
           // 'luck' => $luck,
            'created_time' => Carbon::now()
        ]);
        return ['status' => true,'msg' => '添加成功！'];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = Room::with('lecturer.user')->find($id);
        if(empty($room)){
            return redirect(route('room'));
        }
        $lecturer = Lecturer::with('user','room')->where('status','!=',3)->get();
        return view('admin.room.edit')->with('room',$room)
            ->with('lecturer',$lecturer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $info = Room::find($request->id);
        if(empty($info)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        if(!empty($request->number)){
            if(!preg_match("/^[1-9][0-9]*$/",$request->number)){
                return ['status' => false,'msg' => '房间人数请填写正整数！'];
            }
        }
        if(empty($request->room_name)){
            return ['status' => false,'msg' => '该房间名称不能为空！'];
        }else{
            $res = Room::where('room_name','!=',$info->room_name)->where('room_name',$request->room_name)->first();
            if($res){
                return ['status' => false,'msg' => '该房间名称已存在！'];
            }
        }
        $check_lecturer = Lecturer::with('room')->where('id','!=',$info->lecturer_id)->find($request->lecturer_id);
        if(!empty($check_lecturer->room)){
            return ['status' => false,'msg' => '该房间已经分配！'];
        }
        $info->update($request->all());
        return ['status' => true,'msg' => '修改成功！'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id  关闭房间
     * @return \Illuminate\Http\Response
     */
    public function close(Request $request)
    {
        if(empty($request->room_id)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $res = Room::find($request->room_id);
        if($res->status == 2){
            $res->update(['status' => 1]);
            return ['status' => true,'msg' => '开启成功！'];
        }else{
            $res->update(['status' => 2]);
            return ['status' => true,'msg' => '关闭成功！'];
        }
    }

    public function changeStreamStatus(Request $request)
    {
        if(empty($request->name)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        //判断是否禁用
        $res = getStream($request->name);
        if($res['disabledTill'] == 0){
            disableStream($request->name);
            return ['status' => true,'msg' => '禁用成功！'];
        }
        if($res['disabledTill'] == -1){
            enableStream($request->name);
            return ['status' => true,'msg' => '启用成功！'];
        }
        return ['status' => false,'msg' => '操作失败！'];
    }
}
