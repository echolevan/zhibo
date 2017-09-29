@extends('mobile.layout.app')
@section('content')
        <!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border-bottom:#ddd solid 1px;">
    <div style="height:40px;">
        <ul style="line-height:50px;">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left"><a href="{{route('mobile.customer')}}"><i style="width:12px;display:block; float:left; margin-top:15px; margin-left:5px;">
                        <img src="/homestyle/m_img/back.png" class=" img-responsive"></i></a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="font-size:1.2em;"><a href="">我的粉丝</a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right"><a href=""><span style=" height:24px; display:block; float:right; margin-top:0px; margin-right:10px; color:#ff4436;"></span></a></li>
        </ul>
    </div>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div class="hot" style="margin-top:40px;">
    <div class="container">
        @if($fans->isEmpty())
            <p class="text-center" style="color:#DFDEDE;margin-top: 200px;">暂无粉丝！</p>
        @endif
        <ul class="list-group list-unstyled table-condensed attention">
            @foreach($fans as $f)
                @if(!empty($f->fans) or !empty($f->fans->room) or !empty($f->fans->lecturer->room))
                    <li>
                        <div class="col-lg-5 col-md-5 col-sm-8 col-xs-8 pull-left">
                            <div class="img"><a href="{{route('mobile.live',[$f->user_id,$f->fans->lecturer->room->streams_name])}}">
                                    <img src="{{$f->fans->thumb}}" class="img-responsive img-circle" alt="60x60"></a></div>
                            <div style="display:inline-block; margin-left:10px;">
                                <p style="font-size:1.2em; line-height:30px;">{{$f->fans->name}}</p>
                                <p style="color:#999; line-height:30px;">粉丝数：{{App\Models\Follow::where('user_id',$f->user_id)->count()}}</p>
                            </div>
                        </div>
                    </li>
                    <div class="clear"></div>
                @endif
            @endforeach
        </ul>
    </div>
</div>
<!--主界面内容end-->
@stop
