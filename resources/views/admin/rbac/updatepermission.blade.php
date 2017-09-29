@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">功能</strong> /
                <small>修改</small>
            </div>
        </div>

        <hr/>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
            </div>

            <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                <form class="am-form am-form-horizontal" method="post" action="{{route('editPermission')}}">
                    {{csrf_field()}}
                    <div class="am-form-group">
                        <label for="doc-select-1" class="am-u-sm-3 am-form-label">所属组</label>
                        <div class="am-u-sm-9">
                            <select id="doc-select-1" name="pid">
                                <option value="0">顶级组</option>
                                @if(!empty($per_zero))
                                    @foreach($per_zero as $p)
                                        <option value="{{$p->id}}"
                                                @if($p->id==$per->pid)
                                                selected="selected"
                                                @endif
                                        >
                                            {{$p->display_name}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="am-form-caret"></span>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">权限唯一标示：</label>
                        <div class="am-u-sm-9">
                            <input type="text" name="name" value="{{$per->name}}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-email" class="am-u-sm-3 am-form-label">权限名称：</label>
                        <div class="am-u-sm-9">
                            <input type="text" name="display_name" value="{{$per->display_name}}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">权限介绍：</label>
                        <div class="am-u-sm-9">
                            <input type="text" name="description" value="{{$per->description}}">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <input type="hidden" value="{{$per->id}}" name="permission_id">
                            <button type="submit" class="am-btn am-btn-primary">修改</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop