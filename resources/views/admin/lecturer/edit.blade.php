@extends('admin.layouts.application')

@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">讲师详情</strong> / <small>Lecturer Info</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-9 am-u-sm-offset-1">
                <form method="post" action="{{route('lecturer.update',$lecturer->id)}}" class="am-form am-form-horizontal">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <div class="am-tabs" data-am-tabs="{noSwipe: 1}">
                        <ul class="am-tabs-nav am-nav am-nav-tabs">
                            <li class="am-active"><a href="#tab1">会员信息</a></li>
                            <li><a href="#tab2">讲师信息</a></li>
                        </ul>

                        <div class="am-tabs-bd">
                            <div class="am-tab-panel am-fade am-in am-active" id="tab1">
                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        昵称
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input name="name" type="text"value="{{old('name')}}{{$lecturer->user->name}}" minlength="2"  required/>
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        密码
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input name="password" type="password"  minlength="6" placeholder="不修改请置空" autocomplete="new-password" />
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        电话
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input value="{{old('phone')}}{{$lecturer->user->phone}}" name="phone" type="text"  placeholder="输入电话" />
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        排序
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input name="sort" type="number" value="{{$lecturer->sort}}" placeholder=">0" required/>
                                    </div>

                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        用户头像
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                                        <div class="am-form-group am-form-file new_thumb">
                                            <button type="button" class="am-btn am-btn-success am-btn-sm">
                                                <i class="am-icon-cloud-upload" id="loading"></i> 上传新的缩略图
                                            </button>
                                            <input type="file" id="image_upload">
                                            <input type="hidden" value="{{$lecturer->user->thumb}}" name="thumb">
                                        </div>

                                        <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />

                                        <div>
                                            <div class="am-gallery-item">
                                                <a href="javascript:void (0);">
                                                    <img id="img_show" src="{{$lecturer->user->thumb}}"/>
                                                </a>
                                                <div class="file-panel">
                                                    <span class="cancel">删除</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        签名
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <textarea name="sign" id="doc-vld-ta-2" minlength="4" maxlength="100">{{$lecturer->user->sign}}{{old('sign')}}</textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="am-tab-panel am-fade" id="tab2">
                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        姓名
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input value="{{$lecturer->username}}{{old('username')}}" name="username" type="text"  placeholder="输入姓名（实名认证）" />
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        姓名
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input value="{{$lecturer->auth_id_number}}{{old('auth_id_number')}}" name="auth_id_number" type="text" placeholder="输入身份证号码（实名认证）" />
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        讲师资产
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input value="{{$lecturer->user->award}}{{old('award')}}" name="award" type="text" />
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        主讲类型
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <select multiple data-am-selected="{dropUp: 1}" name="lecturer_type[]">
                                            <option @if(strpos($lecturer->lecturer_type,'1') !== false) selected @endif value="1">股票</option>
                                            <option @if(strpos($lecturer->lecturer_type,'2') !== false) selected @endif value="2">期货</option>
                                            <option @if(strpos($lecturer->lecturer_type,'3') !== false) selected @endif value="3">黄金</option>
                                            <option @if(strpos($lecturer->lecturer_type,'4') !== false) selected @endif value="4">股外汇</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
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

@section('js')
    <script src="{{asset('assets/upload/jquery.html5-fileupload.js')}}"></script>
    <script src="{{asset('assets/upload/upload.js')}}"></script>
    <script>
        $(function(){
            $(".am-gallery-item").hover(function () {
                $('.file-panel').fadeIn(300);
            }, function () {
                $('.file-panel').fadeOut(300);
            });

            $(".cancel").click(function () {
                var _this = $(this);
                $.ajax({
                    type: "delete",
                    url: "/image/delete",
                    data: {url: _this.data('id'),thumb: _this.data('img')},
                    success: function (data) {
                        if (data.status == 0) {
                            alert(data.msg);
                            return false;
                        }
                        _this.parent().parent().fadeOut(600);
                    }
                });
            });
        })
    </script>
@stop