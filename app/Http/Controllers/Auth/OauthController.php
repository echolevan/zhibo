<?php

namespace App\Http\Controllers\Auth;

use App\Models\Oauth;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Overtrue\Socialite\SocialiteManager;

class OauthController extends Controller
{
    protected $qq_config = [
        'qq' => [
            'client_id'     => '101408707',
            'client_secret' => 'd212ff9908ff2559d659646cc479304b',
            'redirect'      => 'http://www.goniu8.com/qq/login',
        ],
    ];
    protected $wb_config = [
        'weibo' => [
            'client_id'     => '830558505',
            'client_secret' => 'c27c465ccd8987660c9c48f83d41f439',
            'redirect'      => 'http://zhibo.app/weibo/login',
        ],
    ];
    private function createOauth($idstr,$nickname,$avatar_url,$email,$type,$ip)
    {
        $res = Oauth::where('idstr',$idstr)->where('type',$type)->first();
        if(empty($res)){
            $oauth = Oauth::create([
               'idstr' => $idstr,
                'nickname' => $nickname,
                'avatar_url' => $avatar_url,
                'email' => $email,
                'type' => $type,
                'created_time' => Carbon::now()
            ]);
            $user = User::create([
                'oauth_id' => $oauth->id,
                'password' => bcrypt(str_random(16)),
                'created_at' => Carbon::now(),
                'thumb' => $avatar_url,
                'login_time' => Carbon::now(),
                'ip' => $ip,
                'login_number' => 1,
            ]);
            \Auth::login($user);
            return redirect(route('home'));
        }
        $user = User::where('oauth_id',$res->id)->first();
        $user->update(['login_time' => Carbon::now()]);
        \Auth::login($user);
        return redirect(route('home'));
    }
    //微博授权登陆
    public function weibo()
    {
        $socialite = new SocialiteManager($this->wb_config);
        return $response = $socialite->driver('weibo')->redirect();
    }

    public function weiboLogin(Request $request)
    {
        $socialite = new SocialiteManager($this->wb_config);
        $user = $socialite->driver('weibo')->user();
        return $this->createOauth($user->getId(),$user->getNickname(),$user->getAvatar(),$user->getEmail(),2,$request->ip());
    }

    //qq授权登陆
    public function qq()
    {
        $socialite = new SocialiteManager($this->qq_config);
        return $response = $socialite->driver('qq')->redirect();
    }

    public function qqLogin(Request $request)
    {
        $socialite = new SocialiteManager($this->qq_config);
        $user = $socialite->driver('qq')->user();
        return $this->createOauth($user->getId(),$user->getNickname(),$user->getAvatar(),$user->getEmail(),1,$request->ip());
    }
}
