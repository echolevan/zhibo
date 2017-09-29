@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <style>
        .am-ucheck-icons{height: 0px;top: inherit;}
    </style>
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">权限</strong> /
                <small>当前修改的角色:{{$role->display_name}}</small>
            </div>
        </div>

        <hr/>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
            </div>

            <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                <form class="am-form am-form-horizontal" method="post" action="{{route('editRole_permission')}}">
                    {{csrf_field()}}
                    <div class="am-form-group">
                        <label class="am-u-sm-3 am-form-label"></label>
                        @if(!empty($permissions))

                            <div class="am-u-sm-9">
                                @foreach($permissions as $pzero)
                                    @if($pzero->pid==0)
                                        <label class="am-checkbox-inline" style="color: darkolivegreen"
                                               onclick="check_all({{$pzero->id}})">
                                                <input type="checkbox" data-am-ucheck
                                                       @foreach($role->cachedPermissions() as $c)
                                                       @if($c->id==$pzero->id)
                                                       checked="checked"
                                                       @endif
                                                       @endforeach
                                                       id="{{$pzero->id}}"
                                                       name="permission"
                                                       class="zero_tree"
                                                       value="{{$pzero->id}}"
                                                >{{$pzero->display_name}}</label>
                                        <div style="margin-left: 50px;">
                                            @foreach($permissions as $k)
                                                @if($k->pid==$pzero->id)
                                                    <div>
                                                        <label class="am-checkbox-inline"
                                                               onclick="check_all({{$k->id}})">
                                                            <p style="color: #3a79c9">
                                                                <input type="checkbox" data-am-ucheck
                                                                       class="{{$pzero->id}} "
                                                                       id="{{$k->id}}"
                                                                       @foreach($role->cachedPermissions() as $aa)
                                                                       @if($aa->id==$k->id)
                                                                       checked="checked"
                                                                       @endif
                                                                       @endforeach
                                                                       tel="{{$k->pid}}"
                                                                       name="permission"
                                                                       value="{{$k->id}}">{{$k->display_name}}
                                                            </p>
                                                        </label>
                                                        <div style="margin-left: 50px;width: 70%">
                                                            @foreach($permissions as $z)
                                                                @if($z->pid==$k->id)

                                                                    <label class="am-checkbox-inline">
                                                                        <p><input type="checkbox" data-am-ucheck
                                                                                  class="{{$pzero->id}} {{$k->id}}"
                                                                                  @foreach($role->cachedPermissions() as $q)
                                                                                  @if($q->id==$z->id)
                                                                                  checked="checked"
                                                                                  @endif
                                                                                  @endforeach
                                                                                  tel="{{$z->pid}}"
                                                                                  name="permission"
                                                                                  value="{{$z->id}}">
                                                                            {{$z->display_name}}
                                                                        </p>
                                                                    </label>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <button type="button" id="tt" class="am-btn am-btn-primary">修改</button>
                        </div>
                    </div>
                    @else
                        空
                    @endif
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        function check_all(pid) {
            if ($('#' + pid).is(':checked')) {//取消
                $('.' + pid).uCheck('check');
            } else {
                $('.' + pid).uCheck('uncheck');
            }
        }

        $(function () {
            $(document).on('click', '#tt', function () {
                var chk_role = [];
                $('input[name="permission"]:checked').each(function () {
                    chk_role.push($(this).val());
                });
                console.log(chk_role)
//                return;
                var data = {
                    permission: chk_role,
                    role_id: "{{$role->id}}"
                };
                var url = "{{route('editRole_permission')}}"
                $.post(url, data, function (res) {
                    if (res['status'] == false) {
                        layer.alert(res['msg'])
                        console.log(res)

                    }
                    if (res['status'] == true) {
                        layer.alert(res['msg'])
                        setTimeout(function () {
                            window.location.reload()
                        }, 2000);
                    }
                })
            })
        })
    </script>
    @stop