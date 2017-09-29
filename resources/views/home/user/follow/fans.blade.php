@extends('home.layout.app')
@section('content')
    <div class="container user">
        <div class="row">
            @include('home.user.menu')
                    <!--右侧-->
            <div class="pull-right userright">
                <div class="record">
                    <div class="recording">
                        <div style=" width:100%; height:50px;border-bottom:#ddd 1px solid;">
                            <div class="recordtit"><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>我的粉丝</div>
                        </div>
                        <div class="clear"></div>
                        <div class="message">
                            <ul id="itemContainer">
                                @foreach($fans as $f)
                                    @if(!empty($f->fans))
                                    <li>
                                        <a href="{{route('message.show',$f->id)}}">
                                            <div class="pull-left">
                                                <div class="mymessage">
                                                    <img class="img-circle" src="{{$f->fans->thumb}}" width="50" height="50">
                                                </div>
                                                <div class="mytxt">
                                                    <p class="mydetail">{{$f->fans->name}}</p>
                                                </div>

                                            </div>
                                            <div class="pull-right"> <span >{{$f->created_time}}</span> </div>
                                        </a>
                                    </li>
                                    <div class="clear"></div>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div style="height:5px;"></div>

            </div>

            <!--右侧结束-->
        </div>
    </div>
    <div style="height:60px;"></div>
@stop

