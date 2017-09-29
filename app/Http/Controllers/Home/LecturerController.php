<?php

namespace App\Http\Controllers\Home;

use App\Models\Lecturer;
use App\Models\Room;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;
class LecturerController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
           '_lecturer' => 'on'
        ]);

    }

    public function index()//讲师中心页面
    {
        return view('home.lecturer.index', compact('room'));
    }

    public function info()
    {
        $lecturer = Lecturer::where('user_id',$this->user->id)->first();
        $room = Room::where('lecturer_id',$lecturer->id)->first();
        if($room->status == 2){
            return redirect(route('lecturer_index'));
        }
        return view('home.lecturer.room.info')->with('room',$room);
    }

    public function updateRoomInfo(Request $request)
    {
        $lecturer = Lecturer::where('user_id',$this->user->id)->first();
        $room = Room::where('lecturer_id',$lecturer->id)->first();
        if($request->roo_name){
            return back()->with('error','房间名称不能为空');
        }
        if(empty($request->number)){
            return back()->with('error','房间人数限制不能为空');
        }
        $room->update($request->all());
        return back()->with('msg','修改成功！');
    }

    public function img_upload(Request $request, $name = 'Filedata', $depath = '/finder/room/')
    {
        if ($request->hasFile($name) and $request->file($name)->isValid()) {
            $result = array();

            //文件类型
            $allow = array('image/jpeg', 'image/png', 'image/gif');
            $mine = $request->file($name)->getMimeType();
            if (!in_array($mine, $allow)) {
                $result['status'] = 0;
                $result['info'] = '文件类型错误，只能上传图片';
                return $result;
            }

            //文件大小判断
            $max_size = 1024 * 1024;
            $size = $request->file($name)->getClientSize();
            if ($size > $max_size) {
                $result['status'] = 0;
                $result['info'] = '文件大小不能超过1M';
                return $result;
            }

            //上传文件夹，如果不存在，建立文件夹
            $date = date("Y_m");
            $path = getcwd() . $depath . $date;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            //生成新文件名
            $extension = $request->file($name)->getClientOriginalExtension();      //取得之前文件的扩展名

            $file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $extension;
            $request->file($name)->move($path, $file_name);
            $file_path = $path.'/'.$file_name;
            $thumb_name = $path.'/'. basename($file_path);
            $thumb = Image::make($file_path);
            $thumb->resize(222, 121);
            $thumb->save($thumb_name);
            //返回新文件名
            $result['status'] = 1;
            $result['info'] = $depath . $date . '/' . $file_name;
            return $result;
        }
    }
}
