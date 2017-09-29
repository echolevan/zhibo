@extends('mobile.layout.app')
@section('content')
        <!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border-bottom:#ddd solid 1px;">
    <div style="height:50px;">
        <div class=" text-center" style="line-height:50px; font-size:1.2em;">搜索结果</div>
    </div>
</div>

<!--顶部固定条end-->
<!--主界面内容-->
<div class="hot" style="margin-top:50px;">
    <div class="container">
        <div class="row">
            <div class="title">
                <ul class="tec">
                    @foreach($search as $c)
                            <li>
                                <a href="{{route('mobile.live',[$c->user_id,$c->streams_name])}}">
                                    <div class="r-img">
                                        <img src="{{$c->thumb}}" class="img-responsive">
                                        <div class="tec-name">
                                            <span class="pull-left">{{$c->name}}</span>
                                            <span class="pull-right"><i class="name-fire">
                                                    <img src="/homestyle/m_img/fire.png" class="img-responsive"></i>
                                                {{App\Models\Follow::where('user_id',$c->user_id)->count()}}</span>
                                        </div>
                                    </div>
                                    <p >{{$c->room_name}}</p>
                                </a>
                            </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
</div>
<!--主界面内容end-->
@include('mobile.layout.footer')
@stop