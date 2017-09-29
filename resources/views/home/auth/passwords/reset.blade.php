@extends('home.layout.app')
@section('css')
    <link href="{{asset('homestyle/css/Password.css')}}" rel="stylesheet" type="text/css">
@stop
@section('content')
<div class=" container">
    <div class="row">
        <div class="change">
            <div class="step">
                <div class="steptit">重置登录密码</div>
                <div class="step2">
                    <div class="stepimg2"></div>
                    <div class="steptxt">
                        <span class="s1">忘记密码</span>
                        <span class="s2">重置密码</span>
                        <span class="s3">完成</span>
                    </div>
                </div>
            </div>
            <div class="setnew">
                <div>
                    <form method="post" action="{{route('update.password')}}">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <p><label>密码：</label>
                            <input  name="reset_password" type="password" class="oldtext form-control" />
                        </p>
                        <div class="clear"></div>
                        <p><label>确认密码：</label>
                            <input name="reset_password_confirmation" type="password" class="oldtext form-control" />
                            @if(session()->has('different'))
                            <span style="font-size:14px;*color:#ff9802;"><i class="glyphicon glyphicon-exclamation-sign"></i> 密码不一致</span>
                                @endif
                        </p>
                        <input type="submit" class="reset_password" style="display:none;" />
                    </form>
                </div>
                <p class="stepbtn1"><a href="javascript:void (0);" class="reset">确定</a></p>
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
            $('.reset').click(function(){
                var password = $('input[name=reset_password]').val();
                var password_confirmation = $('input[name=reset_password_confirmation]').val();
                if(password == ''){
                    layer.msg('请输入密码不能为空！');
                    return false;
                }
                if(password_confirmation == ''){
                    layer.msg('请再次输入密码不能为空！');
                    return false;
                }
                $('.reset_password').click();
            })
        })
    </script>
    @stop