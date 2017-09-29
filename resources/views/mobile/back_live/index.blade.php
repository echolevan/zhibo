@extends('mobile.layout.app')
@section('content')
        <!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border-bottom:#ddd solid 1px;">
    <div style="height:50px;">
        <div class=" text-center" style="line-height:50px; font-size:1.2em;">直播回看</div>
    </div>
</div>

<!--顶部固定条end-->
<!--主界面内容-->
<div class="hot" style="margin-top:50px;">
    <div class="container">
        <div class="row">
            <div class="title">
                <ul class="tec">
                    @foreach($back as $b)
                        @if(!empty($b->user))
                    <li>
                        <a href="{{route('mobile.back_live.details',$b->id)}}">
                            <div class="r-img">
                                <img src="http://{{$b->thumb}}" class="img-responsive">
                                <div class="living"><span style="color:#3bb5ff;">●</span><span style="color:#fff;"> 录像</span></div>
                                <div class="tec-name">
                                    <span class="pull-left">{{$b->user->name}}</span>
                                    <span class="pull-right"><i class="name-fire">
                                            <img src="/homestyle/m_img/fire.png" class="img-responsive"></i>{{$b->count}}</span>
                                </div>
                            </div>
                            <p >{{$b->title}}</p>
                        </a>
                    </li>
                        @endif
                        @endforeach
                </ul>

            </div>
        </div>
    </div>
</div>
<!--主界面内容end-->
@include('mobile.layout.footer')
@stop