@extends('admin.layouts.application')
@section('css')
    <style>
        .am-gallery-item{padding-top: 10px;}
    </style>
    @stop
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">讲师申请详情</strong> / <small>Lecturer Info</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-9 am-u-sm-offset-1">
                <h3>申请资料审核</h3>
                @if($lecturer->status == 1)
                    状态： <span class="am-badge am-badge-secondary">待审核</span>
                    @elseif($lecturer->status == 2)
                    状态： <span class="am-badge am-badge-success">审核通过</span> &nbsp; &nbsp;<span>审核者: {{App\Admin_user::find($lecturer->admin_id)->name}}</span>
                    @else
                    状态： <span class="am-badge am-badge-warning">未通过</span> &nbsp; &nbsp;<span>审核者: {{App\Admin_user::find($lecturer->admin_id)->name}}</span>
                    @endif

                <p>用户信息</p>
                <ol>
                    <li>用户名： <a href="">{{$lecturer->user->name}}</a></li>
                    <li>手机号： <a href="javascript:void (0);">{{$lecturer->user->phone}}</a></li>
                </ol>
                <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />
                <p>身份信息</p>
                <ol>
                    <li>姓名： <a href="javascript:void (0);">{{$lecturer->username}}</a></li>
                    <li>身份证号码： <a href="javascript:void (0);">{{$lecturer->auth_id_number}}</a></li>
                    <li>主讲领域： <a href="javascript:void (0);">{{$lecturer->type}}</a></li>
                </ol>
                <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />
                <p>证件照</p>
                <ol>
                    <div class="am-gallery-item" data-am-scrollspy="{animation: 'fade'}">
                        <a href="javascript:void (0);">
                            <img class="small" width="350px" height="200px" src="{{$lecturer->front_picture}}"/>
                            <img class="hide" style="display: none;" width="700px" height="400px" src="{{$lecturer->front_picture}}"/>
                        </a>
                    </div>
                    <div class="am-gallery-item" data-am-scrollspy="{animation: 'fade', delay: 300}">
                        <a href="javascript:void (0);">
                            <img class="small" width="350px" height="200px" src="{{$lecturer->back_picture}}"/>
                            <img class="hide" style="display: none;" width="700px" height="400px" src="{{$lecturer->back_picture}}"/>
                        </a>
                    </div>
                    <div class="am-gallery-item">
                        <a href="javascript:void (0);">
                            <img class="small"  width="350px" height="200px" src="{{$lecturer->hand_picture}}"/>
                            <img class="hide" style="display: none;" width="700px" height="400px" src="{{$lecturer->hand_picture}}"/>
                        </a>
                    </div>
                </ol>

            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />
            <div class="am-form-group am-u-sm-offset-2">
                @if($lecturer->status == 1 || $lecturer->status == 3)
                    <button type="button" class="am-btn am-btn-primary am-btn-xs open">通过</button>
                @endif
                @if($lecturer->status == 1)
                    <button type="button" class="am-btn am-btn-warning am-btn-xs reject">驳回</button>
                    @endif
            </div>

        </div>
    </div>
@stop
@section('js')
    <script>
        $(function(){
            $('.small').click(function(){
                layer.open({
                    type: 1,
                    title: false,
                    area: ['800px', '600px'],
                    skin: 'layui-layer-nobg', //没有背景色
                    shadeClose: true,
                    content: $(this).next('.hide')
                });
            });

            @if($lecturer->status == 1 || $lecturer->status == 3)
          $('.open').click(function(){
                layer.confirm('是否审核通过？', {
                    btn: ['确定','取消'], //按钮
                    title: false
                }, function(){
                    var id = '{{$lecturer->id}}';
                    $.ajax({
                        type: 'post',
                        url: '{{route('lecturer.check.open')}}',
                        data: {id: id},
                        success: function(data){
                            layer.msg(data.msg, {icon: 1});
                            setTimeout(function () {
                                location.href = "{{route('lecturer.check.list')}}";
                            }, 2000);
                        },error: function(){
                            layer.msg('审核失败！', {icon: 5});
                            return false;
                        }
                    })
                });
            })
            @endif
               @if($lecturer->status == 1)
            $('.reject').click(function(){
                layer.prompt({
                    title: '驳回原因', //不显示标题
                },function(val, index){
                    if(val == ''){
                        layer.msg('请填写原因！');
                        return false;
                    }
                    var id = '{{$lecturer->id}}';
                    $.ajax({
                        type: 'post',
                        url: '{{route('lecturer.check.reject')}}',
                        data: {id: id, desc: val},
                        success: function(data){
                            layer.msg(data.msg, {icon: 2});
                            setTimeout(function () {
                                location.href = "{{route('lecturer.check.list')}}";
                            }, 2000);
                        },error: function(){
                            layer.msg('驳回失败！', {icon: 5});
                            return false;
                        }
                    })
                    layer.close(index);
                });
            })
            @endif
       })
    </script>
    @stop
