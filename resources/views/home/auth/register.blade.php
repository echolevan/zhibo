<!--注册-->
<div class="qlogin" id="qlogin" style="display: none;">
    <div class="web_login loginwrap">
        <div class="login_form">
            <form>
                <div class="logininput">
                    <input type="text" name="name" class="loginusername form-control" placeholder="用户名" id="username1"/>
                    <input type="text" name="phone" class="loginusername form-control" placeholder="手机" />
                    <div class="form-control messagge">
                        <input type="text" name="code" class=" form-control" placeholder="短信验证码" id="message"/>
                        <button class="btn btn-large btn-primary send_code" type="button">发送短信验证码</button>
                    </div>
                    <input type="password" class="form-control password" placeholder="密码"/>
                    <input type="password"  class="form-control confirmation" placeholder="确认密码" />
                </div>
                <div class="loginbtn">
                    <div class="loginsubmit fl register">
                        <button type="button">注册</button>
                        <div class="loginsubmiting">
                            <div class="loginsubmiting_inner"> </div>
                        </div>
                    </div>
                    <div class="logcheckbox fl">
                        <input class="check" id="bcdl" type="checkbox" checked/>
                        <a href="{{route('state')}}" target="_blank">已同意并接受用户服务条款</a></div>

                    <div class="clear"> </div>
                </div>
            </form>
        </div>
    </div>
	
	@if (empty($per_propid))		
		@include('home.auth.oauth_login')
	@endif
</div>

<!--注册end-->