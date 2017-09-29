@include('home.auth.send_mobile_code')
<script>
$(function(){
    $('.send_code').click(function(){
        var phone = $('input[name=phone]').val();
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
    })

    $('.register').click(function(){
        var name = $('input[name=name]').val();
        var phone = $('input[name=phone]').val();
        var code = $('input[name=code]').val();
        var password = $('.password').val();
        var password_confirmation = $('.confirmation').val();
        var check = $('.check').is(':checked');
        var mobile = /^1[3|4|5|7|8]\d{9}$/;
        if(name == ''){
            layer.msg('昵称不能为空！');
            return false;
        }
        if(phone == ''){
            layer.msg('电话号码不能为空！');
            return false;
        }
        if (!mobile.test(phone)) {
            layer.msg('电话号码格式不对！');
            return false;
        }
        if(code == ''){
            layer.msg('短信验证码不能为空！');
            return false;
        }
        if(password == ''){
            layer.msg('密码不能为空！');
            return false;
        }
        if(password_confirmation == ''){
            layer.msg('请再次输入密码！');
            return false;
        }
        if(check == false){
            layer.msg('请阅读服务条款！');
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
                    layer.msg(data.msg);
                    return false;
                }
                layer.msg(data.msg, {icon: 1});
                setTimeout(function () {
                    window.location.reload()
                }, 1000);
            },error: function(){
                layer.msg(error, {icon: 5});
                return false;
            }
        })
    }

    $('.do_login').click(function(){
        var name = $('input[name=username]').val();
        var password = $('#password').val();
        var remember = $('input[name=remember]').is(':checked');
        if(name == ''){
            layer.msg('昵称不能为空！');
            return false;
        }
        if(password == ''){
            layer.msg('密码不能为空！');
            return false;
        }
        var data = {
            name: name,
            password: password,
            remember: remember
        };
        var url = '{{url('login')}}';
        var error = '登陆失败！';
        ajax(url,data,error);
    })
})
</script>