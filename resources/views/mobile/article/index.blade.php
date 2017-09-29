@extends('mobile.layout.app')
@section('content')
        <!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border-bottom:#ddd solid 1px;">
    <div style="height:40px;">
        <ul style="line-height:50px;">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left"><a href=""><i class=""></i></a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="font-size:1.2em;"><a href="">动态</a></li>
        </ul>
    </div>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div class="dynamic" style="margin-top:50px;">
    <ul class="list-group list-unstyled table-condensed">
        @foreach($views as $v)
            @if(!empty($v->user))
        <li>
            <div class="container">
                <div>
                    <a href="{{route('mobile.view.details',$v->id)}}">
                        <div class="img"><img src="{{$v->user->thumb}}" class="img-responsive img-circle" alt="60x60"></div>
                        <div style="display:inline-block; margin-left:10px;">
                            <p style="font-size:1.1em; line-height:20px;">{{$v->user->name}}</p>
                            <p style="color:#999; line-height:20px;">{{$v->ctime}}</p>
                        </div>
                    </a>
                </div>
                <a href="{{route('mobile.view.details',$v->id)}}">
                    <p class="dy-title">{{$v->title}}</p>
                    <p class="dy-text" id="clamp-this-module">
                        {!! subtext($v->contents,30)  !!}
                    </p>
                </a>
                <div class="dy-num">
                    <span><i><img src="/homestyle/m_img/yd.png" class="img-responsive"></i> {{$v->count}}</span>
                    <span style="border:none;"><i><img src="/homestyle/m_img/pl.png" class="img-responsive"></i> {{$v->comments->count()}}</span>
                </div>
            </div>
        </li>
            @endif
            @endforeach
    </ul>
</div>
<!--主界面内容end-->
@include('mobile.layout.footer')
    @stop