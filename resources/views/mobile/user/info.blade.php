@extends('mobile.layout.app')
        @section('css')
            <script type="text/javascript" src="{{asset('homestyle/m_js/vue.js')}}"></script>
        @stop
@section('content')
<!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border-bottom:#ddd solid 1px;">
    <div style="height:40px;">
        <ul style="line-height:50px;">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left">
                <a href="{{route('mobile.customer')}}">
                    <i style="width:12px;display:block; float:left; margin-top:15px; margin-left:5px;">
                        <img src="/homestyle/m_img/back.png" class=" img-responsive"></i></a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="font-size:1.2em;">
                <a href="">我的资料</a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <a href="article.html">
                    <span style=" height:24px; display:block; float:right; margin-top:0px; margin-right:10px; color:#ff4436;"></span></a></li>
        </ul>
    </div>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div class="myinfor" style="margin-top:50px;">
    <div class="container">
        <div class="row">
            <ul>
                <li>
                        <div class="col-md-9 col-sm-9 col-xs-9 pull-left">
                            <div class="list-txt">
                                <p> 头像</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 pull-right">
                            <span class="list-img1 upload_img"> <img id="img_show" src="{{$userinfo->thumb}}" class="img-circle img-responsive"></span>
                            <span class="right-img"><img src="/homestyle/m_img/R1.png" class="img-responsive"></span>
                            <input id="thumb_upload"  type="file" style="display:none;">
                        </div>
                </li>
                <li>
                        <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                            <div class="list-txt">
                                <p>昵称</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 pull-right name">
                                <span class="right-txt"> @{{ name }}</span>
                            <span class="right-img"><img src="/homestyle/m_img/R1.png" class="img-responsive"></span>
                            <input class="username" name="username" v-model="name" style="display: none;">
                        </div>
                </li>
                <li class="sign">
                        <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">

                            <div class="list-txt ">
                                <p style="line-height:30px;">个人简介</p>
                                <p style="line-height:30px; font-size:1.1em; color:#999;">@{{ sign }}</p>
                                <input id="sign" name="sign" v-model="sign" style="display: none;">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 pull-right">
                            <span class="right-txt"></span>
                            <span class="right-img"><img src="/homestyle/m_img/R1.png" class="img-responsive"></span>
                        </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@stop
@section('js')
    <script src="{{asset('assets/upload/jquery.html5-fileupload.js')}}"></script>
    <script>
        //文件上传
        $('.upload_img').click(function(){
            $('#thumb_upload').click();
        })
        var opts = {
            url: "/mobile/upload/imgs",
            type: "POST",
            success: function (result, status, xhr) {
                if (result.status == "0") {
                    layer.open({
                        content: result.msg
                        ,skin: 'msg'
                        ,time: 2
                    });
                    return false;
                }
                layer.open({
                    type: 2
                    ,content: '上传成功'
                    ,time: 2
                });
                $("#img_show").attr('src', result.medium);
            },
            error: function (result, status, errorThrown) {
                layer.open({
                    content: '文件上传失败'
                    ,skin: 'msg'
                    ,time: 2
                });
            }
        }
        $('#thumb_upload').fileUpload(opts);
    </script>
    <script type="text/javascript">
        new Vue({
            el: '.name',
            data: {
                name: '{{$name}}'
            }
        });
        new Vue({
            el: '.sign',
            data: {
                sign: '{{subtext($userinfo->sign,20)}}'
            }
        });
        $(function(){
            $('.name').click(function(){
                $('.username').fadeIn(600);
            });
            $('.sign').click(function(){
                $('#sign').fadeIn(600);
            })
            $('input[name=username]').blur(function(){
                var name= $(this).val();
                var _this = $(this);
                if(name == ''){
                    layer.open({
                        content: '昵称不能为空！'
                        ,skin: 'msg'
                        ,time: 2
                    });
                    return false;
                }
                var data = {name: name};
                var url = '{{route('mobile.change.username')}}';
                changeinfo(url,data,_this);
            });

            $('input[name=sign]').blur(function(){
                var sign= $(this).val();
                var _this = $(this);
                var data = {sign: sign};
                var url = '{{route('mobile.change.sign')}}';
                changeinfo(url,data,_this);
            });

            function changeinfo(url,data,_this){
                $.ajax({
                    type: 'put',
                    url: url,
                    data: data,
                    success: function(data){
                        if(data.status == false){
                            layer.open({
                                content: data.msg
                                ,skin: 'msg'
                                ,time: 2
                            });
                            return false;
                        }
                        _this.hide();
                    },error: function(){
                        layer.open({
                            content: '操作失败！'
                            ,skin: 'msg'
                            ,time: 2
                        });
                        return false;
                    }
                })
            }

        })
    </script>
    @stop