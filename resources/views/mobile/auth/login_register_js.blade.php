@include('mobile.layout.send_mobile_code_m')
<script>
    $(function(){
        $('.send_code').click(function(){
            var phone = $('input[name=phone]').val();
            if (phone == '') {
                layer.open({
                    content: '电话号码不能为空！'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                return false;
            }
            var url = '{{route('send.mobileCode')}}';
            var _this = $(this);
            var data = {
                phone: phone
            };
            sendMobileCode_m(data, url, _this);
        });

        $('.m_do_register').click(function(){
            var name = $('input[name=name]').val();
            var phone = $('input[name=phone]').val();
            var code = $('input[name=code]').val();
            var password = $('.password').val();
            var password_confirmation = $('.confirmation').val();
            var mobile = /^1[3|4|5|7|8]\d{9}$/;
            if(name == ''){
                layer.open({
                    content: '昵称不能为空！'
                    ,skin: 'msg'
                    ,time: 2
                });
                return false;
            }
            if(phone == ''){
                layer.open({
                    content: '电话号码不能为空！'
                    ,skin: 'msg'
                    ,time: 2
                });
                return false;
            }
            if (!mobile.test(phone)) {
                layer.open({
                    content: '短信验证码不能为空！'
                    ,skin: 'msg'
                    ,time: 2
                });
                return false;
            }
            if(code == ''){
                layer.open({
                    content: '短信验证码不能为空！'
                    ,skin: 'msg'
                    ,time: 2
                });
                return false;
            }
            if(password == ''){
                layer.open({
                    content: '密码不能为空！'
                    ,skin: 'msg'
                    ,time: 2
                });
                return false;
            }
            if(password_confirmation == ''){
                layer.open({
                    content: '请再次输入密码！'
                    ,skin: 'msg'
                    ,time: 2
                });
                return false;
            }
            var data = {
                name: name,
                phone: phone,
                code: code,
                password: password,
                password_confirmation: password_confirmation
            };
            var url = '{{url('register')}}';
            var error = '注册失败！';
            ajax(url,data,error);
        })

        function ajax(url,data,error){
            $.ajax({
                type: 'post',
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
                    layer.open({
                        type: 2
                        ,skin: 'msg'
                        ,content: data.msg
                    });
                    setTimeout(function () {
                        location.href = "{{route('mobile.customer')}}";
                    }, 1000);
                },error: function(){
                    layer.open({
                        content: error
                        ,skin: 'msg'
                        ,time: 2
                    });
                    return false;
                }
            })
        }

        $('.m_do_login').click(function(){
            var name = $('input[name=username]').val();
            var password = $('#password').val();
            if(name == ''){
                layer.open({
                    content: '昵称不能为空！'
                    ,skin: 'msg'
                    ,time: 2
                });
                return false;
            }
            if(password == ''){
                layer.open({
                    content: '密码不能为空！'
                    ,skin: 'msg'
                    ,time: 2
                });
                return false;
            }
            var data = {
                name: name,
                password: password,
            };
            var url = '{{url('login')}}';
            var error = '登陆失败！';
            ajax(url,data,error);
        })


    })
</script>