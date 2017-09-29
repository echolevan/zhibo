@extends('admin.layouts.application')

@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">添加讲师</strong> / <small>Create Lecturer</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-9 am-u-sm-offset-1">
                <form method="post" action="{{route('lecturer.store')}}" class="am-form am-form-horizontal">
                    {!! csrf_field() !!}
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

                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                    电话
                                </div>
                                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                    <input value="{{old('phone')}}" name="phone" type="text"  placeholder="输入电话" />
                                </div>
                            </div>


                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                    性别
                                </div>
                                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" checked  value="1" name="sex"> 男
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" value="2"  name="sex"> 女
                                    </label>
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
                                        <input type="hidden"  name="thumb">
                                    </div>

                                    <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />

                                    <div>
                                        <div class="am-gallery-item">
                                            <a href="javascript:void (0);">
                                                <img id="img_show" src=""/>
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
                                    <textarea name="sign" id="doc-vld-ta-2" minlength="4" maxlength="100">{{old('sign')}}</textarea>
                                </div>

                            </div>
                        </div>
                        <div class="am-tab-panel am-fade" id="tab2">
                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                    姓名
                                </div>
                                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                    <input value="{{old('username')}}" name="username" type="text"  placeholder="输入姓名（实名认证）" />
                                </div>
                            </div>

                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                    姓名
                                </div>
                                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                    <input value="{{old('auth_id_number')}}" name="auth_id_number" type="text" placeholder="输入身份证号码（实名认证）" />
                                </div>
                            </div>

                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                    讲师资产
                                </div>
                                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                    <input value="{{old('award')}}" name="award" type="text" />
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