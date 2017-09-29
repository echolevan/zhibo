@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">文章管理</strong> /
                <small>编辑文章</small>
            </div>
        </div>

        <hr/>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
            </div>

            <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                @foreach($comments as $c)
                <article class="am-comment" >
                    <a href="#link-to-user-home">
                        <img src="" alt="" class="am-comment-avatar" width="48" height="48"/>
                    </a>

                    <div class="am-comment-main">
                        <header class="am-comment-hd">
                            <!--<h3 class="am-comment-title">评论标题</h3>-->
                            <div class="am-comment-meta">
                                <a href="#link-to-user" class="am-comment-author">{{$c->user->name}}</a>
                                评论于 <time>{{$c->created_time}}</time><a href="{{route('delComment',$c->id)}}">删除</a>
                            </div>
                        </header>

                        <div class="am-comment-bd">
                            <P>{{$c->contents}}</P>
                            @if(!$c->children->isEmpty())
                                @foreach($c->children as $children)
                                    <blockquote>
                                        @if(empty($children->user->name))
                                           {{$children->user->oauth->nickname}}
                                        @else
                                            {{$children->user->name}}
                                        @endif
                                            ： {{$children->contents}} {{$children->created_time}}<a href="{{route('delComment',$children->id)}}">删除</a></blockquote>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </article>
                 <br>



                    
                @endforeach
            </div>
        </div>
    </div>
@stop
@section('js')
    <script type="text/javascript" src="/assets/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/assets/ueditor/ueditor.all.js"></script>
    <script type="text/javascript" src="/assets/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script src="{{asset('assets/upload/jquery.html5-fileupload.js')}}"></script>
    <script type="text/javascript">

    </script>
    <script type="text/javascript">

    </script>
@stop