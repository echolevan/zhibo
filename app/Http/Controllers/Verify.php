<?php

namespace App\Http\Controllers;
use App\Models\Verify_mobile;
use Carbon\Carbon;
use DB;
use Validator;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
class Verify
{
    //发送短信
    public function sendMobileCode($mobile)
    {
        //检查手机号码合法性 以及使用场景  两种场景，pass为通过
        $verifyMobile = $this->verifyMobile($mobile);
        if($verifyMobile['status'] == true){
            //检查是否发送过于频繁
            $intervalTime = $this->intervalTime($mobile);
            if($intervalTime['status'] == true){
                // 配置信息
                $config = [
                    'app_key'    => config('mobile.app_key'),
                    'app_secret' => config('mobile.app_secret'),
                ];

                $client = new Client(new App($config));
                $req    = new AlibabaAliqinFcSmsNumSend;
                $code = rand(10000, 99999);
                $req->setRecNum($mobile)
                    ->setSmsParam([
                        'number' => $code,
                        'minutes' => config('mobile.minutes'),
                    ])
                    ->setSmsFreeSignName(config('mobile.templateName'))
                    ->setSmsTemplateCode(config('mobile.templateId'));

                $resp = $client->execute($req);
                if(!empty($resp->sub_code)){
                    return ['status' => false, 'msg' => '短信发送失败！'];
                }
                if(!empty($resp->result->model)){
                    Verify_mobile::create([
                        'phone' => $mobile,
                        'verification_code' => $code,
                        'post_time' => Carbon::now()
                    ]);
                    return ['status' => true, 'msg' => '短信发送成功！'];
                }
            }else{
                return $intervalTime;
            }

        }else{
            return $verifyMobile;
        }

    }

    //发送短信
    public function take_config($mobile)
    {
        $config = [
            'app_key'    => config('mobile.app_key'),
            'app_secret' => config('mobile.app_secret'),
        ];

        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;
        $req->setRecNum($mobile)
            ->setSmsFreeSignName(config('mobile.templateName'))
            ->setSmsTemplateCode(config('mobile.templateTakeId'));

        $resp = $client->execute($req);
        if(!empty($resp->sub_code)){
            return ['status' => false, 'msg' => '订阅失败！'];
        }
        if(!empty($resp->result->model)){
            return ['status' => true, 'msg' => '订阅成功！'];
        }
    }

    //验证手机号码和验证码是否合法
    public function verifyMobileCode($mobile,$code)
    {
        //检查验证是否与发送的手机号相匹配
        $verifyCodeAndPhone = $this->checkMobileChange($mobile,$code);
        if($verifyCodeAndPhone['status'] == true){
            //检查验证码是否超时
            $timeOut = $this->checkCodeOutTime($mobile,$code);
            if($timeOut['status'] == true){
                //判断 是否超过错误次数
                $errorNum = $this->checkErrorsNum($mobile,$code);
                if($errorNum['status'] == true){
                    $v = Verify_mobile::where('phone',$mobile)->where('verification_code',$code)->first();
                    $v->update(['status' => 1]);
                    return ['status' => true, 'msg' => '验证通过！'];
                }else{
                    return $errorNum;
                }
            }else{
                return $timeOut;
            }
        }else{
            return $verifyCodeAndPhone;
        }
    }


    //手机号码验证规则
    public function verifyMobile($mobile)
    {
        //检查是否是标准大陆手机号码
        if(empty($mobile)){
            return ['status' => false,'msg' => '手机号码不能为空，请重新输入！'];
        }
        $format = preg_match('/^(\+?0?86\-?)?((13\d|14[57]|15[^4,\D]|17[678]|18\d)\d{8}|170[059]\d{7})$/', $mobile);
        if($format == 0) {
            return ['status' => false, 'msg' => '手机号码格式不对，请重新输入！'];
        }
        return ['status' => true, 'msg' => '验证通过！'];
    }

    //提交时验证是否是上次请求的手机号码
    public function checkMobileChange($mobile,$code)
    {
        //首先检查是否有此条记录
        $res = Verify_mobile::where('phone',$mobile)->where('verification_code',$code)->orderBy('id','desc')->where('status',10)->first();
        if(empty($res)){
            $r = collect(Verify_mobile::where('phone',$mobile)
                ->where('status',10)
                ->where('number','<',config('mobile.errorsNum'))
                ->lists('id'))->last();
            //如果没有记录直接返回错误
            if(!empty($r)){
                $info = Verify_mobile::find($r);
                $info ->update(['number' => ($info->number)+1]);
                return ['status' => false,'msg' => '手机验证码错误，请重新输入！'];
            }else{
                return ['status' => false,'msg' => '您还没有发送短信！'];//没有发送短信的记录
            }
        }
        return ['status' => true,'msg' => '验证通过,继续下一步！'];

    }

    //检查手机验证码是否超时
    public function checkCodeOutTime($mobile,$code)
    {
        $res = Verify_mobile::where('phone',$mobile)->where('verification_code',$code)->orderBy('id','desc')->where('status',10)->first();
        $postTime = date('Y-m-d H:i:s',strtotime($res->post_time));
        $time = config('mobile.minutes');//配置设置的超时时间
        $now = date('Y-m-d H:i:s',strtotime(Carbon::now()));//当前时间
        $endTime =  date("Y-m-d H:i:s", strtotime("$postTime +$time min"));//超时时间
        if($now > $endTime)
        {
            return ['status' => false,'msg' => '验证码已超时，请重新发送！'];//验证超时
        }
        return ['status' => true,'msg' => '验证通过,继续下一步！'];
    }

    //检查是否超过错误次数
    public function checkErrorsNum($mobile,$code)
    {
        $res = Verify_mobile::where('phone',$mobile)->where('verification_code',$code)->orderBy('id','desc')->where('status',10)->first();
        if($res->number > config('mobile.errorsNum'))
        {
            return ['status' => false,'msg' => '验证码错误次数过多，请重新发送！'];
        }
        return ['status' => true,'msg' => '验证通过,继续下一步！'];
    }

    //检测短信发送频率  1分钟一次
    public function intervalTime($mobile)
    {
        $res = Verify_mobile::where('phone',$mobile)->orderBy('id','desc')->first();
        if(empty($res)){
            return ['status' => true,'msg' => '继续下一步！'];
        }
        if(date("Y-m-d",strtotime($res->post_time)) != date('Y-m-d H:i:s',strtotime(Carbon::now()))){
            return ['status' => true,'msg' => '继续下一步！'];
        }
        $time = date("Y-m-d H:i:s",strtotime($res->post_time));
        $intervalTime =  date("Y-m-d H:i:s", strtotime("$time +60 second"));
        $now = date('Y-m-d H:i:s',strtotime(Carbon::now()));
        if($intervalTime > $now){
            return ['status' => false,'msg' => '短信发送频率过高，请稍后再试！'];
        }

    }

}
