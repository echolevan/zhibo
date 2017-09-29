@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">管理员</strong> /
                <small>新增</small>
            </div>
        </div>

        <hr/>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
            </div>

            <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                <form class="am-form am-form-horizontal">
                    @if($roles->count()>=1)
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">角色 / Role</label>
                            <div class="am-u-sm-9">
                                @foreach($roles as $r)
                                    <label class="am-checkbox-inline">
                                        <input type="checkbox"
                                               @foreach($admin->cachedRoles() as $v)
                                               @if($v->id==$r->id)
                                               checked="checked"
                                               @endif
                                               @endforeach
                                               name="role"
                                               value="{{$r->id}}">
                                        {{$r->display_name}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">名称 / Name</label>
                        <div class="am-u-sm-9">
                            <input type="text" name="name" id="user-name" value="{{$admin->name}}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-email" class="am-u-sm-3 am-form-label">登录账号 / Email</label>
                        <div class="am-u-sm-9">
                            <input type="email" name="email" id="user-email" value="{{$admin->email}}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">密码 / Password</label>
                        <div class="am-u-sm-9">
                            <input type="text" name="password" id="user-phone" placeholder="修改密码则填写此栏目 / Password">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <button type="button" id="tt" class="am-btn am-btn-primary">修改</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $('#tt').click(function () {
            var name = $('input[name=name]').val();
            var email = $('input[name=email]').val();
            var password = $('input[name=password]').val();
            var chk_role = [];
            $('input[name="role"]:checked').each(function () {
                chk_role.push($(this).val());
            });
            var data = {
                name: name,
                email: email,
                password: password,
                roles: chk_role,
                admin_id: "{{$admin->id}}"
            };
            var url = "{{route('createAdminrole')}}"
            $.post(url, data, function (res) {
                if (res['status'] == false) {
                    layer.alert(res['msg'])
                    setTimeout(function () {
                        window.location.reload()
                    }, 2000);
                }
                if (res['status'] == true) {
                    layer.alert(res['msg'])
                    setTimeout(function () {
                        window.location.reload()
                    }, 2000);
                }
            })
        })
    </script>
@stop