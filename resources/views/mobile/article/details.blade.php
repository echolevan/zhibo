@extends('mobile.layout.app')

@section('content')
        <!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border-bottom:#ddd solid 1px;">
    <div style="height:40px;">
        <ul style="line-height:50px;">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left"><a href="{{route('mobile.view')}}"><i style="width:12px;display:block; float:left; margin-top:15px; margin-left:5px;">
                        <img src="/homestyle/m_img/back.png" class=" img-responsive"></i></a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="font-size:1.2em;"><a href="">{{$details->title}}</a></li>
        </ul>
    </div>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div class="dynamic" style="margin-top:50px;">
    <ul class="list-group list-unstyled table-condensed">
        <li>
            <div class="container">
                <div>
                    <div class="img">
                        <img src="{{$details->user->thumb}}" class="img-responsive img-circle" alt="60x60">
                    </div>
                    <div style="display:inline-block; margin-left:10px;">
                        <p style="font-size:1.1em; line-height:20px;">{{$details->user->name}}</p>
                        <p style="color:#999; line-height:20px;">{{$details->ctime}}</p>
                    </div>
                </div>
                <p class="dy-title">{{$details->title}}</p>
                <p class="dy-text1">{!! $details->contents  !!}</p>
                <p class="text-center" style="font-size:0.8em; color:#999;">（内容仅代表个人观点，不构成投资建议）</p>
            </div>
        </li>
    </ul>
</div>
<div class="no-comment">
    <p style="border-bottom:#ddd solid 1px; text-indent:10px;"><span>全部评论</span> <span>{{$comments->count()}}</span></p>
    <ul class="comment append">
        @foreach($comments as $comment)
            @if(!empty($comment->user))
        <li>
            <div>
                <div class="img">
                    <img src="{{$comment->user->thumb}}" class="img-responsive img-circle" alt="60x60">
                </div>
                <div style=" width:82%;display:inline-block; margin-left:10px;  border-bottom:#ddd 1px solid;">
                    <div class="co-name">
                        <div class="pull-left">
                            @if(empty($comment->user->name))
                                <p style="font-size:1.1em; line-height:20px;">{{$comment->user->oauth->nickname}}</p>
                                @else
                                <p style="font-size:1.1em; line-height:20px;">{{$comment->user->name}}</p>
                                @endif
                            <p style="color:#999; line-height:20px;">{{$comment->created_time}}</p>
                        </div>
                        <div style="display:inline-block; margin-top:5px;" class="pull-right">
                            <a  href="{{route('mobile.reply',[$details->id,$comment->id])}}" class="reply"><img src="/homestyle/m_img/pl.png" class="img-responsive"></a>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="co-name">
                        <p>{{$comment->contents}}</p>
                        @if(!$comment->children->isEmpty())
                        <div class="reply">
                                @foreach($comment->children as $children)
                                    @if(!empty($children->user))
                            <div class="reply-txt">
                                @if(empty($children->user->name))
                                    <span style="color:#4975b0;">{{$children->user->oauth->nickname}}</span>
                                    @else
                                    <span style="color:#4975b0;">{{$children->user->name}}</span>
                                    @endif

                                <span>：{{$children->contents}}</span>
                            </div>
                                    @endif
                                @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </li>
            @endif
        @endforeach
    </ul>
</div>
<!--主界面内容end-->
<!--底部固定导航-->
<div class="navbar navbar-default navbar-fixed-bottom" style="background:#e6e6e6;">
    <form class="form-group p-dynamic">
        <input type="text" name="comment" class="form-control t-input no-input" placeholder="评论回复"  style="width:80%;">
        <button type="button" class="btn btn-info addcomment" style="float:right;margin-top: -33px;">提交</button>
    </form>
</div>
<!--底部固定导航end-->
@stop
@section('js')
    <script>
        $(function(){
           $('.addcomment').click(function(){
                       @if(\Auth::check())
                  var article_id = '{{$details->id}}';
               var contents = $('input[name=comment]').val();
               if(contents == ''){
                   layer.open({
                       content: '评论不能为空！'
                       ,skin: 'msg'
                       ,time: 2 //2秒后自动关闭
                   });
                   return false;
               }
               if(contents.length > 50){
                   layer.open({
                       content: '请限制 在50个字以内！'
                       ,skin: 'msg'
                       ,time: 2 //2秒后自动关闭
                   });
                   return false;
               }
               var data = {
                   article_id: article_id,
                   contents: contents
               };
               $.ajax({
                   type: 'post',
                   url: '{{route('add.comment')}}',
                   data: data,
                   success: function(data){
                       if(data.status == false){
                           layer.open({
                               content: data.msg
                               ,skin: 'msg'
                               ,time: 2 //2秒后自动关闭
                           });
                           return false;
                       }
                       var comment = '<li>'+
                               '<div>'+
                               '<div class="img"><img src="'+ data.info.thumb +'" class="img-responsive img-circle" alt="60x60"></div>'+
                               '<div style=" width:82%;display:inline-block; margin-left:10px;  border-bottom:#ddd 1px solid;">'+
                               '<div class="co-name">'+
                               '<div class="pull-left">'+
                               '<p style="font-size:1.1em; line-height:20px;">'+ data.info.name +'</p>'+
                               '<p style="color:#999; line-height:20px;">'+ data.info.time +'</p>'+
                               '</div>'+
                               '<div style="display:inline-block; margin-top:5px;" class="pull-right">'+
                               '<a href="##"><img src="/homestyle/m_img/pl.png" class="img-responsive"></a>'+
                               '</div>'+
                               '</div>'+
                               '<div class="clear"></div>'+
                               '<div class="co-name">'+
                               '<p>'+ data.info.contents +'</p>'+
                               '</div>'+
                               '</div>'+
                               '</div>'+
                               '</li>';
                       $(comment).appendTo('.append');
                       layer.open({
                           content: data.msg
                           ,skin: 'msg'
                           ,time: 2 //2秒后自动关闭
                       });
                       $('input[name=comment]').val('');
                   },error: function(){
                       layer.open({
                           content: '操作失败！'
                           ,skin: 'msg'
                           ,time: 2 //2秒后自动关闭
                       });
                       return false;
                   }
               });
               @else
              layer.open({
                   content: '请先登陆！'
                   ,btn: ['确定']
                   ,skin: 'footer'
                   ,yes: function(index){
                       location.href = "{{url('mobile/login')}}";
                   }
               });
               @endif
           });
        })
    </script>
    @stop