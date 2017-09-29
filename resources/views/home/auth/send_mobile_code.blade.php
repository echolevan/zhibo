<script>
    function sendMobileCode(data,url,_this)
    {
        $.ajax({
            type: 'post',
            url: url,
            data: data,
            success: function (data,status){
                if(data.status == true){
                    layer.msg(data.msg);
                    var countdown = 60;

                    //设置button效果，开始计时
                    _this.attr("disabled", "true");
                    _this.text(countdown + "秒后重新获取");
                    //启动计时器，1秒执行一次
                    var timer = setInterval(function(){
                        if (countdown == 0) {
                            clearInterval(timer);//停止计时器
                            _this.removeAttr("disabled");//启用按钮
                            _this.text("重新发送验证码");
                        }
                        else {
                            countdown--;
                            _this.text(countdown + "秒后重新获取");
                        }
                    }, 1000);
                    return false;
                }else if(data.status == false){
                    layer.msg(data.msg);
                    return false;
                }
            },
            error: function (){
                layer.msg('发送失败，请重新发送！');
            }
        })
    }


</script>