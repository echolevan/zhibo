@extends('mobile.layout.app')
@section('content')
        <!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border-bottom:#ddd solid 1px;">
    <div style="height:40px;">
        <ul style="line-height:50px;">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left">
                <a href="{{route('mobile.customer')}}"><i style="width:12px;display:block; float:left; margin-top:15px; margin-left:5px;"><img src="/homestyle/m_img/back.png" class=" img-responsive"></i></a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="font-size:1.2em;"><a href="">设置</a></li>
        </ul>
    </div>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div class="mylist" style="margin-top:50px;">
    <div class=" container">
        <div class="row">
            <ul>
                <li>
                    <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                        <div class="list-img"> <img src="/homestyle/m_img/s-qc.png" class="img-responsive"> </div>
                        <div class="list-txt">
                            <p>清除缓存</p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right right-img"><img src="/homestyle/m_img/R1.png" class="img-responsive"></div>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="{{url('mobile/logout')}}">
                        <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                            <div class="list-img">
                                <img src="/homestyle/m_img/s-about.png" class="img-responsive"> </div>
                            <div class="list-txt">
                                <p>退出</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 pull-right">
                        <span class="right-img">
                            <img src="/homestyle/m_img/R1.png" class="img-responsive"></span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--主界面内容end-->
<!--底部固定导航-->
<div style="height:50px;"></div>

<!--底部固定导航end-->
    @stop
