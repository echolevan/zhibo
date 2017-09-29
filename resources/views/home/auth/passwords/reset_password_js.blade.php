<script>
    $(function(){
        $('.forget_send').click(function(){
            var phone = $('.mobile').val();
            if (phone == '') {
                layer.msg('电话号码不能为空！');
                return false;
            }
            var url = '{{route('forget.send')}}';
            var _this = $(this);
            var data = {
                phone: phone
            };
            sendMobileCode(data, url, _this);
        });
        $('.reset').click(function(){
            var phone = $('.mobile').val();
            var img_code = $('.imgcode').val();
            var mobile_code = $('.mobilecode').val();
            var style_mobile = /^1[3|4|5|7|8]\d{9}$/;
            if (phone == '') {
                layer.msg('电话号码不能为空！');
                return false;
            }
            if (!style_mobile.test(phone)) {
                layer.msg('电话号码格式不对！');
                return false;
            }
            if (img_code == '') {
                layer.msg('图形验证码不能为空！');
                return false;
            }
            if (mobile_code == '') {
                layer.msg('短信验证码不能为空！');
                return false;
            }
            var data = {
                phone: phone,
                img_code: img_code,
                mobile_code: mobile_code
            }
            $.ajax({
                type: 'post',
                url: '{{route('forget.check')}}',
                data: data,
                success: function(data){
                    if(data.status == false){
                        layer.msg(data.msg);
                        $(".code").click();
                        return false;
                    }
                    //layer.msg(data.msg, {icon: 1});
                    setTimeout(function () {
                        location.href = data.info;
                    }, 600);
                },error: function(){
                    layer.msg('操作失败', {icon: 5});
                    return false;
                }
            })
        })
    })
</script>