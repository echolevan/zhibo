<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
/**
 * 七牛配置
 */
class SystemController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
           '_system' => 'am-in'
        ]);
    }

    //图片储存配置
    public function qiniuConfig()
    {
        $site = config('qiniu');
        return view('admin.system.qiniu_config')->with('site',$site);
    }

    //更新图片储存配置
        public function updateQiniuConfig(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required',
            'medium' => 'required',
            'accessKey' => 'required',
            'secretKey' => 'required',
            'bucket' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('error','请按要求填写字段！')->withInput();
        }
        $all = $request->all();
        $array = collect($all)->except(['_token','_method'])->toArray();
        $this->config_set('qiniu',$array);
        return back()->with('msg','更新成功！');
    }

    //第三方key 配置
    public function oauthConfig()
    {
        $oauth = config('oauth');
        return view('admin.system.oauth')->with('oauth',$oauth);
    }

    public function updateOauthConfig(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qq_client_id' => 'required',
            'qq_client_secret' => 'required',
            'qq_redirect' => 'required',
            'weibo_id' => 'required',
            'weibo_secret' => 'required',
            'weibo_redirect' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('error','请按要求填写字段！')->withInput();
        }
        $all = $request->all();
        $array = collect($all)->except(['_token','_method'])->toArray();
        $this->config_set('oauth',$array);
        return back()->with('msg','更新成功！');
    }
}
