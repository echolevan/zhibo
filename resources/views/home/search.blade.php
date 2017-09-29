@extends('home.layout.app')
@section('content')
    <div class="container">
        <div class="row">

            <div class="clear"></div>
            <div class="tab-content">
                <div class="biglive tab-pane active" id="home">
                    <ul>
                        @foreach($search as $c)
                        <li>
                            <a href="{{route('live',[$c->user_id,$c->streams_name])}}">
                                <div class="liveimg">
                                    <img src="{{$c->thumb}}" width="224" height="121">
                                    <span class="live-right-tag"></span>
                                </div>
                                <div class="livetxt">
                                    <p  class="livetit">{{$c->room_name}}</p>
                                    <p  class="livetec">
                                        <span class="pull-left">讲师：{{$c->name}}</span>
                                        <span class="pull-right text-right" style="color:#de4c44;">
                                            <i class="glyphicon  glyphicon-heart"></i>
                                            {{App\Models\Follow::where('user_id',$c->user_id)->count()}}</span>
                                    </p>
                                </div>
                            </a>
                        </li>
                            @endforeach
                    </ul>

                </div>
                <div class="clear"></div>
                <div aria-label="Page navigation">
                    {!! $search->appends(Request::all())->links() !!}
                </div>
            </div>
        </div>

    </div>
    @stop