@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">账号管理</strong> /
                <small>修改密码</small>
            </div>
        </div>

        <hr/>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
            </div>

            <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                <form class="am-form am-form-horizontal" method="post" action="{{route('postreset')}}">
                    {{csrf_field()}}
                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">新密码 / Password</label>
                        <div class="am-u-sm-9">
                            <input type="text" name="password" id="user-phone" placeholder="修改密码则填写此栏目 / Password">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <button type="submit" class="am-btn am-btn-primary">修改</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop