<?php
//是否...
function is_something($attr, $module)
{
    return $module->$attr ? '<span style="margin-left:15px;" class="am-icon-check is_something" data-attr="' . $attr . '"></span>' : '<span style="margin-left:15px;" class="am-icon-close is_something" data-attr="' . $attr . '"></span>';
}

//显示栏目对应文章
function show_articles($category)
{
    if ($category->type == 2) {
        return '<a class="am-badge am-badge-secondary" href="' . route('xCms.article.index', ['category_id' => $category->id]) . '">查看栏目文章</a>';
    }
}

function time_format($attr, $datetime)
{
    if ($datetime == "") {
        return "";
    }
    return date($attr, strtotime($datetime));
}

function subtext($text, $length)
{
    if (mb_strlen($text, 'utf8') > $length)
        return mb_substr($text, 0, $length, 'utf8') . '...';
    return $text;
}
function ATarrry()
{
    $res=array('1'=>'讲师观点','2'=>'讲师文章','3'=>'系统发布');
    return $res;
}
function isThere($users,$userid)
{
    $bool=false;
    foreach($users as $k=> $v)
    {
        if($v['user_id']==$userid)
        {
            $bool=true;
        }
    }
    return $bool;
}

function convertTime($sec){
    $sec = round($sec/60);
    if ($sec >= 60){
        $hour = floor($sec/60);
        $min = $sec%60;
        $res = $hour.' 小时 ';
        $min != 0  &&  $res .= $min.' 分';
    }else{
        $res = $sec.' 分钟';
    }
    return $res;
}

function evaluate_count($userid){
    if(\App\Models\Delivery_comment::where('delivery_user_id',$userid)->sum('evaluate') == 0){
        return 0;
    }else{
        return round(\App\Models\Delivery_comment::where('delivery_user_id',$userid)->sum('evaluate')/\App\Models\Delivery_comment::where('delivery_user_id',$userid)->count());
    }
}

function evaluate_year($userid){
    if(\App\Models\Delivery_comment::whereBetween('created_time',[date('Y-1-1')." 00:00:00",date('Y-12-30')." 23:59:59"])->where('delivery_user_id',$userid)->sum('evaluate') == 0){
        return 0;
    }else{
        return round(\App\Models\Delivery_comment::whereBetween('created_time',[date('Y-1-1')." 00:00:00",date('Y-12-30')." 23:59:59"])->where('delivery_user_id',$userid)->sum('evaluate')/\App\Models\Delivery_comment::whereBetween('created_time',[date('Y-1-1')." 00:00:00",date('Y-12-30')." 23:59:59"])->where('delivery_user_id',$userid)->count());
    }
}

function oauth_name($id){
    return \App\Models\Oauth::find($id)->nickname;
}

function evaluate_day($userid){
    if(empty(\App\Models\Delivery_comment::where('delivery_user_id',$userid)->first())){
        return 0;
    }else{
        $res = \App\Models\Delivery_comment::where('delivery_user_id',$userid)->first();
        return $res->evaluate;
    }
}


//相对日收益
function day_average($stock_data_id)
{
    $id = explode(',',str_replace(']','',str_replace('[','',$stock_data_id)));
    $end = array_reverse($id);
    $start_time = \App\Models\Stock_data::find($id[0])->time;
    $end_time = \App\Models\Stock_data::find($end[0])->time;
    $time = strtotime($end_time)-strtotime($start_time);
    return floor($time / 86400);
}


//    private function generateValidateJson($uid, $name, $level, $key) {
function generateValidateJson($user, $encryptKey)
{
    $userChatInfos = array(
        "uid" => $user->id,
        "name" => $user->name,
        "level" => intval($user->level),
        "status" => intval($user->status),
        "thumb"=>$user->thumb,
        "time" => intval(time()),
    );
    $token = sign(http_build_query_sorted($userChatInfos));
    $userChatInfos['token'] = $token;
    return "1000|" . json_encode($userChatInfos);
}

function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();

    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}

function finance($gid)
{
    $url = "http://web.juhe.cn:8080/finance/stock/hs";
    $params = array(
        "gid" => $gid,//股票编号，上海股市以sh开头，深圳股市以sz开头如：sh601009
        "key" => 'd3694634555534906f771e0e57ad3fac',//APP Key
    );
    $paramstring = http_build_query($params);
    $content = juhecurl($url,$paramstring);
    $result = json_decode($content,true);
    if($result){
        if($result['error_code']=='0'){
            $res =  $result['result']['0']['dapandata'];
            $data = [];
            if(empty($res)){
                $data = [
                    'dot' => '0',
                    'name'=> '0',
                    'nowPic' => '0',
                    'rate' => '0'
                ];
            }else{
                $data = [
                    'dot' => substr($res['dot'],0,-2),
                    'name'=> $res['name'],
                    'nowPic' => $res['nowPic'],
                    'rate' => $res['rate']
                ];
            }
            return $data;
        }else{
            return $result['error_code'].":".$result['reason'];
        }
    }else{
        return "请求失败";
    }
}


function randStrCode($i) {//生成随机邀请码
    $str = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($str), 0, $i);
}

// token encrypt method
function sign($str) {
    $md5Str01 = md5($str . config('api.api_secret_key'));
    return md5($md5Str01 . substr($md5Str01, 0, 16));
}

// for url curl
function curlAPI($url) {
    $url = tokenAddon($url);
//    echo $url;exit;
    return curlRequest($url);
}

function tokenAddon($url){
    $url = appendUrlParameter($url, array('time'=>time()));
    $urlInfo = parse_url($url);
    parse_str($urlInfo['query'], $queryArr);
    $queryStr = http_build_query_sorted($queryArr);
    $token = sign($queryStr);
    return appendUrlParameter($url, array('token'=>$token));
}

// anppend parameter to url
function appendUrlParameter($url, $parameter) {
    $appendUrl = http_build_query($parameter);
    $symbol = stristr($url, "?") ? "&" : "?";
    return $url . $symbol . $appendUrl;
}

// sort the keys, than use http_build_query to generate url query 
function http_build_query_sorted($parameter){
    if (!is_array($parameter) || empty($parameter)){
        return ;
    }
    ksort($parameter);
    return http_build_query($parameter);
}

/**
 * $url：request url，
 * $post: is empty, request method is GET, or is POST
 * $cookie: client cookie
 * $returnCookie: return the server cookie
 */
function curlRequest($url, $post = '', $cookie = '', $returnCookie = 0) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
    curl_setopt($curl, CURLOPT_REFERER, "");
    if ($post) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    if ($cookie) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    }
    curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    if (curl_errno($curl)) {
        return curl_error($curl);
    }
    curl_close($curl);
    if ($returnCookie) {
        list($header, $body) = explode("\r\n\r\n", $data, 2);
        preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
        $info['cookie'] = substr($matches[1][0], 1);
        $info['content'] = $body;
        return $info;
    } else {
        return $data;
    }
}

//站点信息
function configInfo()
{
    $arr = [];
    $arr = config('siteinfo');
    return $arr;
}
