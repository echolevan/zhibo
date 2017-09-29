/*!
 *@name     jquery.barrager.js
 *@author   yaseng@uauc.net
 *@url      https://github.com/yaseng/jquery.barrager.js
 */
(function($) {

	$.fn.giftBarrager = function(barrage) {
		barrage = $.extend({
			close:true,
			top: 200,
			max: 10,
			speed: 12,
			color: '#fff',
			old_ie_color : '#000000'
		}, barrage || {});
		var time = new Date().getTime();
		var barrager_id = 'giftbarrage_' + time;
		var id = '#' + barrager_id;
		var div_barrager = $("<div class='barrage giftbarrage' id='" + barrager_id + "'>	</div>").appendTo($(this));
		var window_height = $(window).height() - 100;
		var top = (barrage.top == 0) ? Math.floor(Math.random() * window_height + 40) : barrage.top;
		div_barrager.css("top", top + "px");
		div_barrager_box = $("<div class='barrage_box cl'></div>").appendTo(div_barrager);
                
		if(barrage.img){
			div_barrager_box.append("<a class='portrait z' href='javascript:;'></a>");
			var img = $("<img src='' >").appendTo(id + " .barrage_box .portrait");
			img.attr('src', barrage.img);
		}
                if(barrage.imgbg){
			div_barrager_box.css("background-image","url('"+barrage.imgbg+"')");
		}
                
		
		div_barrager_box.append(" <div class='z p'></div>");
		if(barrage.close){
			div_barrager_box.append(" <div class='close z'></div>");
		}
		
		var content = $("<a title='' href='' target='_blank'></a>").appendTo(id + " .barrage_box .p");
		content.attr({
			'href': barrage.href,
			'id': barrage.id
		}).empty().append(barrage.info);
		if(navigator.userAgent.indexOf("MSIE 6.0")>0  ||  navigator.userAgent.indexOf("MSIE 7.0")>0 ||  navigator.userAgent.indexOf("MSIE 8.0")>0  ){

			content.css('color', barrage.old_ie_color);

		}else{

			content.css('color', barrage.color);

		}
		
		var i = 0;
		div_barrager.css('margin-right', i);
		var looper = setInterval(barrager, barrage.speed);

		function barrager() {


			var window_width = $(window).width() + 500;
			if (i < window_width) {
				i += 1;

				$(id).css('margin-right', i);
			} else {

				$(id).remove();
 				return false;
			}

		}


		div_barrager_box.mouseover(function() {
			clearInterval(looper);
		});

		div_barrager_box.mouseout(function() {
			looper = setInterval(barrager, barrage.speed);
		});

		$(id+'.barrage .barrage_box .close').click(function(){

			$(id).remove();

		})

	}
 
	$.fn.barrager.removeAll=function(){

		 $('.barrage').remove();

	}

})(jQuery);