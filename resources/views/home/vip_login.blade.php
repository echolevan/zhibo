<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<title></title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ asset('homestyle/vip_login/room_main.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('homestyle/vip_login/js/skin/default/layer.css') }}" rel="stylesheet" type="text/css">
	<script src="{{ asset('homestyle/vip_login/js/jquery-1.11.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('homestyle/vip_login/js/layer.js') }}"></script>
<script type="text/javascript">
function viewWH(){
	var wh = {'width':'','height':''};
	wh.width = $(window).width();
	wh.height =$(window).height();
	return wh;
}
var srcPx = $(document).scrollTop();
//弹框插件
$(function(){
	//对象+命名空间
	$.fn.windowOpen = function(options){
		//默认值
		var defaults = {
			"clickEle":"loginReward",
			"popEle":"loginRewardPop"
		}
		//合并默认值与参数
		var options = $.extend(defaults,options);
		//操作代码
		this.each(function(){
			//生命动画变量
			var This = $(this);
			var clickEle = "#" + options.clickEle;
			var popEle = "#" + options.popEle;
			var popClose = $(popEle).find("h2 a");
			var popEleH = $(popEle).innerHeight();	
			var popEleW = $(popEle).innerWidth();	
			var $windowBg = $('.windowBg');		
			$(clickEle).click(function(){	
				var posTop = (viewWH().height - popEleH)/2 + srcPx;
				var posLeft = -(popEleW/2)
				$(".windowOpen").css({"display":"none"});
				//$(".masterEle").show();
				$(popEle).css({"display":"block","top":posTop,"marginLeft":posLeft});	
				$windowBg.show();
				});
			$(popClose).click(function(){
				$(popEle).css({"display":"none"});	
				$windowBg.hide();	
			});
			$(window).scroll(function () {
				resizeEle();
			});
			$(window).resize(function () {
				resizeEle();
			});
			function resizeEle(){
				srcPx = $(document).scrollTop();
				$(popEle).css({"top":srcPx + (viewWH().height - popEleH)/2});	
			}
		});
	}
});
$(function(){
	//用户设置
	$("#dialogSetting").windowOpen({
		"clickEle":"dialogSetting",
		"popEle":"dialogSettingPop"
	});
	$("#dialogSetting").click();
})
</script>
</head>

<body>
<div class="warp">
	<div style="padding:300px 100px 700px;font-size:15px;">
        <span id="dialogSetting" style="display: none;">用户设置</span>
    </div>
		<div id="token"><?php echo csrf_field(); ?>	</div>
		<div class="windowOpen" id="dialogSettingPop" style="display: block; top: 301.5px; margin-left: -250px;">
			<!--
		 	<div class="contactVip">
					<a href="">获取密码</a>
			</div>
			-->
	        <h2><span>用户设置</span></h2>
	        <div class="cont">
	        	<ul>
	                <li>
	                	<label><span class="passwordSpan">房间密码</span></label>
	                    <div class="dialog-file">
	                    	<input type="password" name="vip[vip_pass]" id="room_password" class="allInput"> 
	                    </div>
	                </li>
	                <li>
	                	<div class="xieyi">
						<input type="checkbox" name="" checked="checked" id="ck"> 
						我已阅读并同意<a href="http://www.goniu8.com/state" target="_blank">《构牛财经协议》</a>
						</div>
	                </li>
	                <li>
	                	<label>&nbsp;</label>
					    <div class="dialog-file">
	                        <p>
								<a href="javascript:;" class="btn1" onclick="sub()">确定</a> 
								<a href="http://goniu8.com/living" class="return btn2">返回大厅</a>
							</p>
	                    </div>
	                </li>
	            </ul>
	        </div>
	     </div>
		 <input type="hidden" id="user_id" name="vip[user_id]" value="{{ $lecturer->user_id }}"/>
		 <input type="hidden" id="stream" name="vip[stream]" value="{{ $room->streams_name }}"/>
</div>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});


	if(window.top!=window.self){
		var partHref= document.referrer;
		var newHref = partHref.substring(0,partHref.indexOf('com')+3);
		console.log(newHref);
		$('.return').attr('href',newHref);
	}
	function sub(){
		if($('#room_password').val() == ''){
			layer.msg("请输入房间密码", {icon: 5});
			return false;
		}
		if(!$('#ck')[0].checked){
			layer.msg("请阅读并同意《构牛财经协议》", {icon: 5});
			return false;
		}
		
		$_user_id = $('#user_id').val();
		$_stream = $('#stream').val();
		$_vip_pass = $('#room_password').val();
		$.ajax({
			url: '{{ route('vip_check') }}',
			data: {'user_id':$_user_id, 'stream':$_stream, 'vip_pass':$_vip_pass},
			type: 'POST',
			success:function(res){
				if (res['status']==1){
					//layer.msg(res['message']);
					window.location.href= "/live/"+$_user_id+"/"+$_stream;
				} else {
					layer.msg(res['message'], {icon: 5});
				}
			}		
		})
		
		
	}

</script>


</body>
</html>