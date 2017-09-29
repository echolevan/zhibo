<?php

namespace App\Http\Controllers\Home;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
class LivingController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_living' => 'on'
        ]);
    }

    public function index(Request $request)
    {
        $where = function($query) use ($request){
            if($request->has('type') and $request->type != ''){
                $search = "%" . $request->type . "%";
                $query->where('lecturer_type', 'like', $search);
            }
        };
        $living = DB::table('lecturers')
            ->join('rooms as a','lecturers.id','=','a.lecturer_id')
            ->leftjoin('users as b','lecturers.user_id','=','b.id')
            ->select('lecturers.*','a.streams_name','a.room_name','b.name')
            ->where($where)
            ->paginate(20);
       // $living = Room::with('lecturer.user')->where('lecturer_id','!=',0)->take(20)->get();
        return view('home.living.index')->with('living',$living);
    }
}
