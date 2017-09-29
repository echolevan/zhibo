<?php

namespace App\Http\Controllers\Admin;

use App\Models\Focus;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Cache;
use Validator;
class ConfigController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_config' => 'am-in'
        ]);
    }

    //站点信息
    public function siteInfo()
    {
        $siteInfo = config('siteinfo');
        return view('admin.config.site_info')->with('siteInfo',$siteInfo);
    }

    //更新站点信息
    public function updateSiteInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('error','请按要求填写字段！')->withInput();
        }
        $all = $request->all();
        $array = collect($all)->except(['_token','_method'])->toArray();
        $this->config_set('siteinfo',$array);
        return back()->with('msg','更新成功！');
    }

    public function clearCache()
    {
        Cache::flush();
        return back()->with('msg', '缓存清理成功！');
    }

    public function focus()
    {
        $focus = Focus::with('lecturer.user')->get();
        return view('admin.config.focus')->with('focus',$focus);
    }

    public function editFocus($id)
    {
        $focus = Focus::find($id);
        if(empty($focus)){
            return redirect(route('config.focus'));
        }
        $lecturer = Lecturer::with('user','room')->groupBy('user_id')->get();
        return view('admin.config.update_focus')->with('focus',$focus)->with('lecturer',$lecturer);
    }

    public function updateFocus(Request $request,$id)
    {
        $res = Focus::find($id);
        if(empty($res)){
            return redirect(route('config.focus'));
        }
        if($request->thumb != $res->thumb){
            if($res->thumb){
                if(file_exists(public_path($res->thumb))){
                    unlink(public_path($res->thumb));
                }
            }
            if($res->small){
                if(file_exists(public_path($res->small))){
                    unlink(public_path($res->small));
                }
            }
        }
        $res->update([
            'thumb' => $request->thumb,
            'small' => $request->small,
            'desc' => $request->desc,
            'sort' => $request->sort,
            'lecturer_id' => $request->lecturer_id
        ]);
        return redirect(route('config.focus'))->with('msg','修改成功');
    }
}
