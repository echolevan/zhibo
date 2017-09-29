<?php
use Qiniu\Pili\Client;
use Qiniu\Pili\Mac;
//配置信息
function config_set()
{
    $ak = config('qiniu.accessKey');
    $sk = config('qiniu.secretKey');
    $hubName = config('qiniu.hubName');
    $mac = new Mac($ak, $sk);
    $client = new Client($mac);
    $hub = $client->hub($hubName);
    return  $hub;
}

/**
 * 获取推流地址
 * @param $streamKey 流名 $hubName 空间名
 * @return mixed
 */
 function publishUrl($streamKey){
     $ak = config('qiniu.accessKey');
     $sk = config('qiniu.secretKey');
     return Qiniu\Pili\RTMPPublishURL(config('qiniu.rtmp_pili_publish'),config('qiniu.hubName'),$streamKey,3600,$ak,$sk);
}



/**
 * 获取拉流地址（RTMP直播地址）
 * @param $streamKey $hubName 空间名
 * @return mixed
 */
function playUrl($streamKey){
    return Qiniu\Pili\RTMPPlayURL(config('qiniu.pili_live_rtmp'),config('qiniu.hubName'), $streamKey);
}

//获取直播封面地址
function photoUrl($streamKey){
    return  Qiniu\Pili\SnapshotPlayURL(config('qiniu.pili_live_snapshot'),config('qiniu.hubName'), $streamKey);
}


//HLS play URL
function hlsUrl($streamKey){
    return Qiniu\Pili\HLSPlayURL(config('qiniu.pili_live_hls'), config('qiniu.hubName'), $streamKey);
}

//HDL play URL
function hdlUrl($streamKey){
    return Qiniu\Pili\HDLPlayURL(config('qiniu.pili_live_hdl'), config('qiniu.hubName'), $streamKey);
}


//新建流 $name 流名
function createStream($name)
{
    try{
        $streamKey = $name;
        config_set()->create($streamKey);
        return ['status' => true,'msg' => '新建流成功！'];
    }catch(\Exception $e) {
        return ['status' => false,'msg' => '新建流失败，请检查云端及配置！'];
    }
}

//获得流 查看流信息
function getStream($name)
{
    try{
        $resp = config_set()->stream($name);
        return $resp->info();
    }catch(\Exception $e) {
        return ['status' => false,'msg' => '无法查看！'];
    }
}

//启用流
function enableStream($name)
{
    try{
        $resp = config_set()->stream($name);
        $resp->enable();
    }catch(\Exception $e) {
        return ['status' => false,'msg' => '启用失败！'];
    }
}

function disableStream($name)
{
    try{
        $resp = config_set()->stream($name);
        $resp->disable();
    }catch(\Exception $e) {
        return ['status' => false,'msg' => '禁用失败！'];
    }
}

/**
 * 查询直播空间中的流列表。
 * @param $prefix  字符串，可选，限定只返回带以 prefix 为前缀的流名，不指定表示不限定前缀。
 * @param $limit  整数，可选，限定返回的流个数，不指定表示遵从系统限定的最大个数。
 * @param $marker  字符串，可选，上一次查询返回的标记，用于提示服务端从上一次查到的位置继续查询，不指定表示从头查询。
 */
     function streamList($prefix,$limit,$marker)
    {
        try{
            $resp =  config_set()->listStreams($prefix, $limit, $marker);
            return $resp;
        }catch(\Exception $e) {
            return ['status' => false,'msg' => '无法查看！'];
        }
    }

//流状态
 function liveStatus($name){
    $stream = config_set()->stream($name);
     try{
         $status= $stream->liveStatus();
         return $status;
     }catch(\Exception $e) {
         return ['status' => 'error','info' => 'no live'];
     }
}

/**
 * 保存直播回放
 * 将指定时间段的直播保存到存储空间里面。
 */
function liveSave($name,$start){
    $stream = config_set()->stream($name);
    try {
        $resp = $stream->saveas(array("format"=>"mp4","start" => $start));
        return $resp;
    } catch (\Exception $e) {
        //echo "Error:", $e, "\n";
        return ['status' => 'error','info' => '保存失败'];
    }
}

//保存直播截图
function liveThumb($name)
{
    $stream = config_set()->stream($name);
    try {
        $resp = $stream->snapshot(array("format"=>"jpg"));
        return $resp;
    } catch (\Exception $e) {
        return ['status' => 'error','info' => '保存失败'];
    }
}

function playback($name){
    $stream = config_set()->stream($name);
    $records= $stream->historyActivity(0,0);
    print_r($records["items"]);
}

