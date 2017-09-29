@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">用户</strong> /
                <small>修改</small>
            </div>
        </div>

        <hr/>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
            </div>
            <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                <form class="am-form am-form-horizontal" method="post" action="{{route('admin.user_edit')}}">
                    <div class="am-form-group">
                        {{csrf_field()}}
                        <label for="user-phone" class="am-u-sm-3 am-form-label">登录账号</label>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input type="text" name="name" value="{{$user->name}}" required/>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">登录密码(修改则填写)</label>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input type="text" name="password" required/>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-email" class="am-u-sm-3 am-form-label">手机号码</label>
                        <div class="am-u-sm-9">
                            <input type="text" name="phone" value="{{$user->phone}}">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">性别</label>
                        <div class="am-u-sm-9">
                            @if($user->sex==1)
                                <label class="am-radio-inline">
                                    <input type="radio" checked value="1" name="sex"> 男
                                </label>
                                <label class="am-radio-inline">
                                    <input type="radio" value="2" name="sex"> 女
                                </label>
                            @else
                                <label class="am-radio-inline">
                                    <input type="radio" value="1" name="sex"> 男
                                </label>
                                <label class="am-radio-inline">
                                    <input type="radio" checked value="2" name="sex"> 女
                                </label>
                            @endif

                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">会员等级</label>
                        <div class="am-u-sm-9">
                            <input type="text" name="Level" value="{{$user->Level}}">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">初始金币</label>
                        <div class="am-u-sm-9">
                            <input type="text" name="gold" value="{{$user->gold}}">
                        </div>
                    </div>


                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <button type="submit" id="tt" class="am-btn am-btn-primary">修改</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
