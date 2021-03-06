@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">角色</strong> /
                <small>修改</small>
            </div>
        </div>

        <hr/>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
            </div>

            <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                <form class="am-form am-form-horizontal" method="post" action="{{route('editRole')}}">
                    {{csrf_field()}}
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">唯一标示 / 英文</label>
                        <div class="am-u-sm-9">
                            <input type="text" name="name" id="user-name" value="{{$role->name}}">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">角色名称 / Name</label>
                        <div class="am-u-sm-9">
                            <input type="text" name="display_name" value="{{$role->display_name}}" >
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-email" class="am-u-sm-3 am-form-label">角色介绍</label>
                        <div class="am-u-sm-9">
                            <input type="text" name="description" value="{{$role->description}}" >
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <input type="text" style="display: none" name="role_id" value="{{$role->id}}">
                            <button type="submit" class="am-btn am-btn-primary">修改</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop