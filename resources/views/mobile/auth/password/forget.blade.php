@extends('mobile.layout.app')
@section('content')
        <!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border:none;">
    <div style="height:40px;">
        <ul style="line-height:50px;">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left"><a href="{{url('mobile/login')}}"><i style="width:12px;display:block; float:left; margin-top:15px; margin-left:5px;"><img src="/homestyle/m_img/back.png" class=" img-responsive"></i></a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="font-size:1.2em;"><a href="">忘记密码</a></li>
        </ul>
    </div>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div class="bindphone" style="margin-top:50px;">
    <form>
        <div class="input-name" style="margin-top:20px;">
            <input type="text" name="phone" placeholder="请输入手机号">
        </div>
        <div class="input-group input-name" style="margin-top:20px;">
            <input type="text" name="code" placeholder="请输入验证码">
      <span class="input-group-btn">
        <button class="btn btn-default yzm send_code" type="button">获取验证码</button>
      </span>
        </div>
        <div class="input-group input-name" style="margin-top:20px;">
            <input type="password" name="password" placeholder="请输入新密码">
        </div>
        <p><a  href="javascript:void (0);" class="btn bind-btn changePassword">修改</a></p>

    </form>
</div>
<!--主界面内容end-->
@stop
@section('js')
    @include('mobile.layout.send_mobile_code_m')
    <script>
        $(function() {
            $('.send_code').click(function () {
                var phone = $('input[name=phone]').val();
                if (phone == '') {
                    layer.open({
                        content: '电话号码不能为空！'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    return false;
                }
                var url = '{{route('forget.send')}}';
                var _this = $(this);
                var data = {
                    phone: phone
                };
                sendMobileCode_m(data, url, _this);
            });

            $('.changePassword').click(function(){
                var phone = $('input[name=phone]').val();
                var code = $('input[name=code]').val();
                var password = $('input[name=password]').val();
                if (phone == '') {
                    layer.open({
                        content: '电话号码不能为空！'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    return false;
                }
                if (code == '') {
                    layer.open({
                        content: '验证码不能为空！'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    return false;
                }
                if (password == '') {
                    layer.open({
                        content: '密码不能为空！'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    return false;
                }
                $.ajax({
                   type: 'post',
                    url: '{{route('mobile.reset.password')}}',
                    data: {phone:phone,code:code,password:password},
                    success: function(data){
                        if(data.status == false){
                            layer.open({
                                content: data.msg
                                ,skin: 'msg'
                                ,time: 2 //2秒后自动关闭
                            });
                            return false;
                        }
                        layer.open({
                            type: 2
                            ,content: data.msg
                        });
                        setTimeout(function () {
                            location.href = "{{url('mobile/login')}}";
                        }, 1000);
                    },error: function(){
                        layer.open({
                            content: '找回失败！'
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
                        return false;
                    }
                });
            });
        });
    </script>
    @stop