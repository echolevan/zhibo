@extends('home.layout.app')
@section('content')
<div class=" container">
    <div class="row">
        <div class="change">
            <div class="step">
                <div class="steptit">修改登录密码</div>
                <div class="bind1">
                    <div class="stepimg1"></div>
                    <div class="steptxt">
                        <span class="s1">设置密码</span>
                        <span class="s3" style="left:125px;">完成</span>
                    </div>
                </div>
            </div>
            <div class="setnew">
                <div>
                    <form method="post" action="{{route('user.update.password')}}">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <p><label>原密码：</label>
                            <input name="old_password" type="password" class="oldtext form-control old_password" />
                            @if(session()->has('different'))
                            <span style="font-size:14px;*color:#ff9802;"><i class="glyphicon glyphicon-exclamation-sign"></i>{{session()->get('different')}}</span>
                                @endif
                        </p>
                        <div class="clear"></div>
                        <p><label>密码：</label>
                            <input name="password" type="password" class="oldtext form-control new_password" />
                        </p>
                        <div class="clear"></div>
                        <p><label>确认密码：</label>
                            <input name="confirmation_password" type="password" class="oldtext form-control new_c_password" />
                            @if(session()->has('confirm'))
                            <span style="font-size:14px;*color:#ff9802;"><i class="glyphicon glyphicon-exclamation-sign"></i> 密码不一致</span>
                            @endif
                        </p>
                        <p class="stepbtn1" id="change_password"><a href="javascript:void (0);">确定</a></p>
                        <input type="submit" class="changepassword" style="display:none;" />
                        <div class="clear"></div>
                        <p style="height:60px;"></p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<div style="height:60px;"></div>
    @stop
@section('js')
    <script>
        $(function(){
            $('#change_password').click(function(){
                var old_password = $('.old_password').val();
                var new_password = $('.new_password').val();
                var new_c_password = $('.new_c_password').val();
                if (old_password == '') {
                    layer.msg('原始密码不能为空！');
                    return false;
                }
                if (new_password == '') {
                    layer.msg('新密码不能为空！');
                    return false;
                }
                if (new_c_password == '') {
                    layer.msg('请再次输入新密码不能为空！');
                    return false;
                }
                $('.changepassword').click();
            })
        })
    </script>
    @stop