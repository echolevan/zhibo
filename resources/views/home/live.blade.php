<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <script src="{{asset('homestyle/js/jquery.min.js')}}"></script>
    <link href="{{asset('video/video-js.css')}}" rel="stylesheet">
    <link href="{{asset('homestyle/css/index.css')}}" rel="stylesheet" type="text/css">
    <!-- If you'd like to support IE8 -->
    <script src="{{asset('video/videojs-ie8.min.js')}}"></script>
    <style>
        .vjs-default-skin.vjs-big-play-centered .vjs-big-play-button {
            /* Center it horizontally */
            left: 50%;
            margin-left: -2.1em;
            /* Center it vertically */
            top: 50%;
            margin-top: -1.4000000000000001em;
        }
    </style>
</head>
<body >
<div style=" width:100%; height:100%; display:block;position:absolute; left:0%; top:0%;">
@if(empty($focus->lecturer))
   <img width="1800" height="956" src="{{$focus->thumb}}" />
@else
@if(empty(liveStatus($focus->lecturer->room->streams_name)['status']))
    <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" style="width:100%; height:100%; display:block;"
           poster="{{photoUrl($focus->lecturer->room->streams_name)}}"
           data-setup="{}">
        <source src="{{playUrl($focus->lecturer->room->streams_name)}}" type="rtmp/flv">
    </video>
@else
    <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" style="width:100%; height:590px;; display:block;"
           poster="http://{{$focus->lecturer->user->history->thumb}}"
           data-setup="{}">
        <source src="http://{{$focus->lecturer->user->history->url}}" type="video/mp4">
    </video>
@endif
@endif
    </div>
<script src="{{asset('video/video.js')}}"></script>
<script>
    var myPlayer = videojs('my-video');
    videojs("my-video").ready(function(){
        myPlayer.play();
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>
</body>
</html>
