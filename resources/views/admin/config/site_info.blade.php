@extends('admin.layouts.application')

@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">站点信息</strong> / <small>Site Info</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-9 am-u-sm-offset-1">
                <form method="post" action="{{route('config.update.site_info')}}" class="am-form am-form-horizontal">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            站点名称
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="title" type="text" value="{{$siteInfo['title']}}" required/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            平台简介
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <textarea name="content" type="text">{{$siteInfo['content']}}</textarea>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            关键词
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="keyword" type="text" value="{{$siteInfo['keyword']}}"/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            网站图标
                        </div>

                        <div class="am-u-sm-4 am-u-md-3">

                            <div class="am-form-group am-form-file">
                                <button type="button" class="am-btn am-btn-success am-btn-sm">
                                    <i class="am-icon-cloud-upload" id="ico_loading"></i> 选择要上传的图标
                                </button>
                                <input type="file" id="ico_upload">
                                <input type="hidden" name="ico" value="{{$siteInfo['ico']}}"/>
                            </div>
                        </div>

                        <div class="am-u-sm-4 am-u-md-6">
                            <img src="{{$siteInfo['ico']}}" id="ico_show" style="max-height: 200px;">
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            备案号
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="icp" type="text" value="{{$siteInfo['icp']}}"/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            地址
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="address" type="text" value="{{$siteInfo['address']}}"/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            公司名称
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="copyright" type="text" value="{{$siteInfo['copyright']}}"/>
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            电话
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="tel" type="text" value="{{$siteInfo['tel']}}"/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            邮箱
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="email" type="text" value="{{$siteInfo['email']}}"/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            QQ
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="qq" type="text" value="{{$siteInfo['qq']}}"/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            logo
                        </div>


                        <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                            <div class="am-form-group am-form-file new_thumb">
                                <button type="button" class="am-btn am-btn-success am-btn-sm">
                                    <i class="am-icon-cloud-upload" id="loading"></i> 上传新的logo
                                </button>
                                <input type="file" id="image_upload">
                                <input type="hidden" name="logo" value="{{$siteInfo['logo']}}">
                            </div>
                            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

                            <div>
                                <img src="{{$siteInfo['logo']}}" id="img_show" style="max-height: 200px;">
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
    <script src="{{asset('assets/upload/upload_logo.js')}}"></script>
    <script>
        //文件上传
        var opts = {
            url: "/image/upload_icon",
            type: "POST",
            beforeSend: function () {
                $("#ico_loading").attr("class", "am-icon-spinner am-icon-pulse");
            },
            success: function (result, status, xhr) {
                if (result.status == "0") {
                    alert(result.msg);
                    $("#loading").attr("class", "am-icon-cloud-upload");
                    return false;
                }
                $("input[name='ico']").val(result.ico);
                $("#ico_loading").attr("class", "am-icon-cloud-upload");
                $("#ico_show").attr('src', result.ico);
            },
            error: function (result, status, errorThrown) {
                alert('文件上传失败');
            }
        }
        $('#ico_upload').fileUpload(opts);
    </script>
@endsection
