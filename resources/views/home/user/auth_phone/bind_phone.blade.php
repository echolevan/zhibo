@extends('home.layout.app')
@section('content')
    <div class=" container">
        <div class="row">
            <div class="change">
                <div class="step">
                    <div class="steptit">绑定手机号</div>
                    <div class="bind1">
                        <div class="stepimg1"></div>
                        <div class="steptxt">
                            <span class="s1">手机验证</span>
                            <span class="s3" style="left:125px;">完成</span>
                        </div>
                    </div>
                </div>
                <div class="forgot">
                    <p></p>
                    <div>
                        <form>
                            <p>
                                <label>手机号：</label>
                                <input type="text" class="oldtext form-control auth_phone" />
                            </p>
                            <div class="clear"></div>
                            <p>
                                <label>短信码：</label>
                                <input type="text" class="oldtext1 form-control auth_code">
                                <button class="btn btn-large btn-primary bind_send" type="button">发送短信验证码</button>
                            </p>
                        </form>
                    </div>
                    <div class="clear"></div>
                    <p class="stepbtn1 bind_phone"><a href="javascript:void (0);">下一步</a></p>
                    <div class="clear"></div>
                    <p style="height:60px;"></p>
                </div>
            </div>
        </div>
    </div>
    <div style="height:60px;"></div>
    @stop
@section('js')
    <script>
        $(function(){
            $('.bind_send').click(function(){
                var phone = $('.auth_phone').val();
                if (phone == '') {
                    layer.msg('电话号码不能为空！');
                    return false;
                }
                var url = '{{route('send.mobileCode')}}';
                var _this = $(this);
                var data = {
                    phone: phone
                };
                sendMobileCode(data, url, _this);
            });
            $('.bind_phone').click(function(){
                var phone = $('.auth_phone').val();
                var code = $('.auth_code').val();
                if (phone == '') {
                    layer.msg('电话号码不能为空！');
                    return false;
                }
                if (code == '') {
                    layer.msg('验证码不能为空！');
                    return false;
                }
                var data = {
                    phone: phone,
                    code: code
                };
                $.ajax({
                    type: 'post',
                    url: '{{route('user.auth.phone')}}',
                    data: data,
                    success: function(data){
                        if(data.status == false){
                            layer.msg(data.msg);
                            return false;
                        }
                       // layer.msg(data.msg, {icon: 1});
                        setTimeout(function () {
                            location.href = "{{route('user.bind.success')}}";
                        }, 600);
                    },error: function(){
                        layer.msg('绑定失败！', {icon: 5});
                        return false;
                    }
                });

            })
        })
    </script>
    @stop