@extends('home.layout.app')
@section('content')
    <div class="change">
        <div class="step">
            <div class="steptit">申请成为主播</div>
            <div class="bind2">
                <div class="stepimg3"></div>
                <div class="steptxt">
                    <span class="s1">身份验证</span>
                    <span class="s3" style="left:125px;">官方审核</span>
                </div>
            </div>
        </div>
        <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 20px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" onclick="$(this).parent().parent().hide()">&times;</span>
            </button>
            <p>审核未通过，请查看我的消息，按要求重新提交！</p>
        </div>
        <div class="Realname">
            <p>您在平台所传身份证只用于主播认证手续，不做其他用途，其他任何人均无法查看。</p>
            <div>
                <form action="{{route('apply_lecturer_update')}}" method="post">
                    {{csrf_field()}}
                    {{ method_field('PUT') }}
                    <p>
                        <label>真实姓名：</label>
                        <input type="text" name="username" value="{{$lecturer->username}}" class="oldtext form-control" placeholder="请填写姓名">
                    </p>
                    <div class="clear"></div>
                    <p>
                        <label>身份证号：</label>
                        <input type="text" name="auth_id_number" value="{{$lecturer->auth_id_number}}" class="oldtext form-control"
                               placeholder="请填写姓名所对应的身份证号">
                    </p>
                    <div class="clear"></div>
                    <p>
                        <label>主讲领域：</label>
                        <label>
                            <input type="checkbox" name="lecturer_type[]" value="1"> 股票
                        </label>
                        <label>
                            <input type="checkbox"  name="lecturer_type[]" value="2"> 期货
                        </label>
                        <label>
                            <input type="checkbox"  name="lecturer_type[]" value="3"> 黄金
                        </label>
                        <label>
                            <input type="checkbox"  name="lecturer_type[]" value="4"> 外汇
                        </label>
                    </p>
                    <p class="upfile" style="width:450px; float:left; margin-left:100px;">

                        <a href="##" class="upload1">
                            <img id="img1" src="{{$lecturer->front_picture}}" style="width: 150px;height: 95px;">
                        </a>
                        <input type="hidden" value="{{$lecturer->front_picture}}" name="front_picture" />
                        <input id="thumb_upload1" class="am-form-group am-form-file" type="file"  style="display:none;">

                        <a href="##" class="upload2" style="margin-left:15px;">
                            <img id="img2" src="{{$lecturer->back_picture}}" style="width: 150px;height: 95px;">
                        </a>
                        <input type="hidden" value="{{$lecturer->back_picture}}" name="back_picture" />
                        <input id="thumb_upload2" class="am-form-group am-form-file" type="file"  style="display:none;">

                        <a href="##" class="upload3" style="margin-left:15px;">
                            <img id="img3" src="{{$lecturer->hand_picture}}" style="width: 150px;height: 95px;">
                        </a>
                        <input type="hidden" value="{{$lecturer->hand_picture}}" name="hand_picture" />
                        <input id="thumb_upload3" class="am-form-group am-form-file" type="file"  style="display:none;">
                    </p>
                    
                    <p class="upfile" style="width:600px; float:left; margin-left:100px;">
                        <span style="width: 150px;margin-left: 5px; float: left">身份证正面照片</span>
                        <span style="width: 150px;margin-left: 5px; float: left">身份证反面照片</span>
                        <span style="width: 150px;margin-left: 5px; float: left">手持身份证照片</span>
                    </p>
                    <br/>
                    
                    <div class="upfload" style="margin-top: 30px;">
                        <div class="left">
                            <img src="{{asset('homestyle/images/id_card.jpg')}}" class="img-responsive">
                            <span style="text-align: center;width: 110px; padding: 10px 0px;display: inline-block;">示例图片</span>
                        </div>
                        <div class="right">
                            <span>
         无居民身份证的内地居民可提交《临时居民身份证》，香港、澳门特别行政区、台湾居民提供当地有效身份证件。<br>
         照片或扫描件必须本人手持身份证，保证头像清晰可辨认，保证身份证信息清晰可见。<br>
         格式要求：支持.jpg .jpeg .png格式照片，大小不超过2M。
                            </span>
                        </div>
                    </div>
                    <div class="logcheckbox fl protocol">
                        <input type="checkbox" name="ok" class="" checked="true"/>
                        我已阅读并接受<a href="">讲师协议</a>和<a href="">隐私保护</a>条款
                    </div>
                    <p class="stepbtn1">
                        <button type="submit" id="apply" class="btn steppink">认证</button>
                    </p>

                </form>
            </div>
            <div class="clear"></div>
            <p style="height:60px;"></p>
        </div>
    </div>
    <div style="height:60px;"></div>
@stop
@section('js')
    <script src="{{asset('assets/upload/jquery.html5-fileupload.js')}}"></script>
    <script src="{{asset('assets/upload/apply_lecturer.js')}}"></script>
@stop