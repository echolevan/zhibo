<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>直播平台登陆</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="alternate icon" type="image/png" href="{{asset('assets/i/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('assets/css/amazeui.min.css')}}"/>
    <style>
        .header {
            text-align: center;
        }
        .header h1 {
            font-size: 200%;
            color: #333;
            margin-top: 30px;
        }
        .header p {
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="am-g">
        <h1>后台登陆</h1>
        <p>直播平台管理</p>
    </div>
    <hr />
</div>
<div class="am-g">
    <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
        <h3>登录</h3>
        <hr>
        <br>
        @include('admin.layouts.msg')
        <form method="POST" action="{{ url('/admin/login') }}" class="am-form">
            {{ csrf_field() }}
            <label for="email">邮箱:</label>
            <input type="email" name="email" id="email" value="{{old('email')}}" required>
            <br>
            <label for="password">密码:</label>
            <input type="password" name="password" id="password" autocomplete="new-password" value="" required>
            <br>
            <label for="remember-me">
                <input id="remember-me" type="checkbox" name="remember">
                记住密码
            </label>
            <br />
            <div class="am-cf">
                <input type="submit"  value="登 录" class="am-btn am-btn-primary am-btn-sm am-fl">
                {{--<input type="submit" name="" value="忘记密码 ^_^? " class="am-btn am-btn-default am-btn-sm am-fr">--}}
            </div>
        </form>
        <hr>
        <p>© {{date('Y')}}.</p>
    </div>
</div>
</body>
</html>
