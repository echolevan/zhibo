<?php

namespace App\Http\Middleware;

use Closure;


class AuthenticateAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $timeUnix = intval($request->get("time"));
        $token = $request->get("token");
        
        $result = [
            'data'=>[],
            'result'=>false,
            'msg'=>'',
        ];
        
        // check time out
//        if (time()<$timeUnix || time() - $timeUnix >config('api.timeout')){
        if (abs(time() - $timeUnix) > config('api.timeout')){
            $result['msg']= 'time out, please retry';
            echo json_encode($result);
            exit;
        }
        
        // check sign
        $url = $request->getQueryString();
        parse_str($url, $queryArr);
        unset($queryArr['token']);
        $encryptStr = http_build_query($queryArr);
        if(sign($encryptStr) != $token){
            $result['msg']= 'token error';
            echo json_encode($result);
            exit;
        }
        
        return $next($request);
    }
}