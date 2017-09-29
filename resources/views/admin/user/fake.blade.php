@extends('admin.layouts.application')

@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">添加送礼员</strong></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-9 am-u-sm-offset-1">
                <form method="post" action="{{route('admin.create.fake',$user->id)}}" class="am-form am-form-horizontal">
                    {!! csrf_field() !!}
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            昵称
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="name" type="text"value="{{old('name')}}"  minlength="2" placeholder="输入用户名（登陆用）" required/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            密码
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="password" type="password"  minlength="6" placeholder="输入密码" autocomplete="new-password" required/>
                        </div>
                    </div>
                    <hr>
                    <div class="am-form-group">
                        <label class="am-u-sm-3 am-form-label"></label>
                        <button class="am-btn am-btn-secondary" type="submit">提交</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@stop
