<div class="web_qr_login" id="web_qr_login" style="display: block;">

    <!--登录-->
    <div class="web_login" id="web_login" style="">
        <div class="login-box loginwrap">
            <div class="login_form">
                <form>
                    <div class="logininput">
                        <input type="text" name="username" class="loginusername form-control" placeholder="手机/用户名" id="username"/>
                        <input type="password"  class="loginuserpasswordt form-control" autocomplete="new-password" placeholder="密码" id="password"/>
                    </div>
                    <div class="loginbtn">
                        <div class="loginsubmit fl do_login">
                            <button type="button">登陆</button>
                            <div class="loginsubmiting">
                                <div class="loginsubmiting_inner"> </div>
                            </div>
                        </div>
                        <div class="logcheckbox fl">
                            <input id="bcdl" type="checkbox" name="remember"/>
                            保持登录 </div>
                        <div class="fr"> <a href="{{route('forget.password')}}">忘记密码?</a> </div>
                        <div class="clear"> </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
	@if (empty($per_propid))	
		@include('home.auth.oauth_login')
	@endif
    <!--登录end-->
</div>