<?php

namespace App\Http\Controllers\Home;

use DB;
use Illuminate\Http\Request;
use App\Http\Requests;

class SearchController extends CommonController
{
    public function index(Request $request)
    {
        if(empty($request->name)){
            return redirect(route('home'));
        }
        $where = function($query) use ($request){
            if($request->has('name') and $request->name != ''){
                $search = "%" . $request->name . "%";
                $query->where('a.name', 'like', $search)->orwhere('b.room_name' ,'like', $search);
            }
        };
        $search = DB::table('lecturers')
            ->leftjoin('users as a','lecturers.user_id','=','a.id')
            ->leftjoin('rooms as b','lecturers.id','=','b.lecturer_id')
            ->select('lecturers.*','a.name','b.room_name','b.thumb','b.streams_name')
            ->where($where)
            ->paginate(20);
        if(\Route::currentRouteName() == 'mobile.search'){
            $view = view('mobile.search');
        }else{
            $view = view('home.search');
        }
        return $view->with('search',$search);
    }
}
