<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lecturer;
use App\Models\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use DB;
/**
 * 讲师管理
 */
class LecturerController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $admins = \Auth::guard('admin')->user();
        $this->admin = $admins;
        view()->share([
            '_lecturer' => 'am-in'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = function ($query) use ($request){
            if($request->has('status') and $request->status != '-1'){
                $query->where('a.status',$request->status);
            }
            if($request->has('name') and $request->name != ''){
                $search = "%" . $request->name . "%";
                $query->where('a.name', 'like', $search);
            }
        };
        $lecturer = DB::table('lecturers')
            ->leftjoin('users as a','a.id','=','lecturers.user_id')
            ->leftjoin('rooms as b','b.lecturer_id','=','lecturers.id')
            ->select('lecturers.*','a.name','a.status as user_status','a.award','b.lecturer_id','b.id as room_id','a.oauth_id')
            ->where($where)
            ->where('lecturers.status',2)
            ->orderBy('lecturers.sort','asc')
            ->paginate(15);
        return view('admin.lecturer.index')->with('lecturer',$lecturer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.lecturer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //验证

    public function store(Request $request)
    {
        //验证字段
        if(empty($request->name)){
            return back()->with('error','昵称用于登录，不能为空！')->withInput();
        }
        if(empty($request->password)){
            return back()->with('error','密码不能为空！')->withInput();
        }
        $v_name = User::where('name',$request->name)->first();
        if($v_name){
            return back()->with('error','该昵称已经存在，请换一个！')->withInput();
        }
        $v_phone = User::where('phone',$request->phone)->where('phone','!=','')->first();
        if($v_phone){
            return back()->with('error','手机号已经存在！')->withInput();
        }
        $user = User::create([
           'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'thumb' => $request->thumb,
            'type' => 2,
            'award' => $request->award,
            'created_at' => Carbon::now(),
            'sign' => $request->sign
        ]);
        Lecturer::create([
            'user_id' => $user->id,
            'username' => $request->username,
            'auth_id_number' => $request->auth_id_number,
            'created_time' => Carbon::now()
        ]);
        return redirect(route('lecturer.check.list'))->with('msg','添加成功！');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lecturer = Lecturer::with('user')->find($id);
        if(empty($lecturer)){
            if(empty($lecturer->user)){
                return redirect(route('room'));
            }
        }
        return view('admin.lecturer.edit')->with('lecturer',$lecturer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $res = Lecturer::find($id);
        if(empty($res)){
            return redirect(route('lecturer'));
        }
        $user = User::find($res->user_id);
        if(empty($user)){
            return redirect(route('lecturer'));
        }
        //验证字段
        if(empty($request->name)){
            return back()->with('error','昵称用于登录，不能为空！')->withInput();
        }
        $v_name = User::where('name','!=',$user->name)->where('name',$request->name)->first();
        if($v_name){
            return back()->with('error','该昵称已经存在，请换一个！')->withInput();
        }
        $v_phone = User::where('phone','!=',$user->phone)->where('phone',$request->phone)->where('phone','!=','')->first();
        if($v_phone){
            return back()->with('error','手机号已经存在！')->withInput();
        }
        $data = [];
        if($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['thumb'] = $request->thumb;
        $data['sign'] = $request->sign;
        $data['award'] = $request->award;
        $user->fill($data)->save();
        $res->update([
            'username' => $request->username,
            'sort' => $request->sort,
            'lecturer_type' => implode(',',$request->lecturer_type),
            'auth_id_number' => $request->auth_id_number,
        ]);
        return redirect(route('lecturer'))->with('msg','修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        if(empty($request->user_id)){
            return ['status' => false,'msg' => '非法操作！'];
        }
        $res = User::find($request->user_id);
        if($res->status == 2){
            $res->update(['status' => 1]);
            return ['status' => true,'msg' => '恢复成功！'];
        }else{
            $res->update(['status' => 2]);
            return ['status' => true,'msg' => '冻结成功！'];
        }
    }

    //讲师审核列表
    public function checkList()
    {
        $lecturer = Lecturer::with('user')->where('status',1)->orderBy('id','desc')->paginate(15);
        return view('admin.lecturer.check_list')->with('lecturer',$lecturer);
    }

    //讲师驳回列表
    public function rejectList()
    {
        $lecturer = Lecturer::with('user')->where('status',3)->orderBy('id','desc')->paginate(15);
        return view('admin.lecturer.reject_list')->with('lecturer',$lecturer);
    }

    //讲师申请详情
    public function checkInfo($id)
    {
        $lecturer = Lecturer::with('user')->find($id);
        if(empty($lecturer)){
            return redirect(route('lecturer'));
        }
        return view('admin.lecturer.check_info')->with('lecturer',$lecturer);
    }

    //申请通过
    public function checkOpen(Request $request)
    {
        $res = Lecturer::find($request->id);
        $res->update(['status' => 2 ,'desc' => '审核通过' , 'admin_id' => $this->admin->id , 'open_time' => Carbon::now()]);
        $user = User::find($res->user_id);
        $user->update(['type' => 2]);
        Message::create([
            'user_id' => $res->user_id,
            'title' => '讲师申请通知',
            'reply' => '恭喜，您申请的讲师资格已通过审核！',
            'type' => 2,
            'created_time' => Carbon::now()
        ]);
        return ['status' => true,'msg' => '审核通过'];
    }

    //驳回申请
    public function checkReject(Request $request)
    {
        $res = Lecturer::find($request->id);
        $res->update(['status' => 3 ,'desc' => $request->desc , 'admin_id' => $this->admin->id ]);
        Message::create([
           'user_id' => $res->user_id,
            'title' => '讲师申请通知',
            'reply' => '您申请的讲师资格未通过审核，请重新修改提交您的资料继续审核，未通过原因：'.$request->desc,
            'type' => 2,
            'created_time' => Carbon::now()
        ]);
        return ['status' => true,'msg' => '成功驳回！'];
    }
}
