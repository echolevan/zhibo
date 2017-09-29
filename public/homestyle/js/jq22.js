
$(function(){		
	//设计案例切换
	$('.title-list li').mouseover(function(){
		var liindex = $('.title-list li').index(this);
		$(this).addClass('on').siblings().removeClass('on');
		$('.product-wrap div.product').eq(liindex).fadeIn(150).siblings('div.product').hide();
		var liWidth = $('.title-list li').width();
	
	});
	
	});

$(document).ready(function(){

    startTimer();

    /** Main Slider **/
    var timer;
    var slideCount = $('.thumbs li').length;
    var currSlide = $('.thumbs li').filter('.curr').index();
    var nextSlide = currSlide + 1;
    var fadeSpeed = 1000;
	
    //Start slides timer functions
    function startTimer() {
        return;
        timer = setInterval(function () {
            $('.slide-item').eq(currSlide).fadeOut(fadeSpeed);
            $('.slide-item, .thumbs li').removeClass('curr');

            $('.slide-item').eq(nextSlide).addClass('curr').fadeIn(fadeSpeed);
            $('.thumbs li').eq(nextSlide).addClass('curr');

            currSlide = nextSlide;
            nextSlide = currSlide + 1 < slideCount ? currSlide + 1 : 0;

        }, 5000);
    }

    $('.thumbs li').click(function () {
        clearInterval(timer);
        startTimer();
        currSlide = $(this).index();
        nextSlide = currSlide + 1 < slideCount ? currSlide + 1 : 0;;
        $('.slide-item').fadeOut(fadeSpeed);
        $('.slide-item, .thumbs li').removeClass('curr');

        $('.slide-item').eq($(this).index()).addClass('curr').fadeIn(fadeSpeed);
        $(this).addClass('curr');
    });

});

// JavaScript Document
(function($){
	$.fn.extend({
		"slideUp":function(value){
			
			var docthis = this;
			//默认参数
			value=$.extend({
				 "li_h":"20",
				 "time":2000,
				 "movetime":1000
			},value)
			
			//向上滑动动画
			function autoani(){
				$("li:first",docthis).animate({"margin-top":-value.li_h},value.movetime,function(){
					$(this).css("margin-top",0).appendTo(".line");
				})
			}
			
			//自动间隔时间向上滑动
			var anifun = setInterval(autoani,value.time);
			
			//悬停时停止滑动，离开时继续执行
			$(docthis).children("li").hover(function(){
				clearInterval(anifun);			//清除自动滑动动画
			},function(){
				anifun = setInterval(autoani,value.time);	//继续执行动画
			})
		}	
	})
})(jQuery)



jQuery.fn.customInput = function(){
				$(this).each(function(i){
					if($(this).is('[type=checkbox],[type=radio]')){
						var input = $(this);
						//get the associated label using the input's id
						var label = $('label[for='+input.attr('id')+']');
						//get type,for classname suffix
						var inputType = (input.is('[type=checkbox]')) ? 'checkbox' : 'radio';
						//wrap the input + label in a div
						$('<div class="custom-'+ inputType +'"></div>').insertBefore(input).append(input,label);
						//find all inputs in this set using the shared name attribute
						var allInputs = $('input[name='+input.attr('name')+']');
						//necessary for browsers that don't support the :hover pseudo class on labels
						label.hover(function(){
							$(this).addClass('hover');
							if(inputType == 'checkbox' && input.is(':checked')) {
								$(this).addClass('checkedHover');
							}
						},function(){
							$(this).removeClass('hover checkedHover');
						});
						
						//bind custom event, trigger it, bind click,focus,blur events
						input.bind('updateState',function(){
							if(input.is(':checked')){
								if(input.is(':radio')){
									allInputs.each(function(){
										$('label[for='+$(this).attr('id')+']').removeClass('checked');
									});
								};
								label.addClass('checked');
							} else {
								label.removeClass('checked checkedHover checkedFocus');
							}
						})
						.trigger('updateState')
						.click(function(){
							$(this).trigger('updateState');
						})
						.focus(function(){
							label.addClass('focus');
							if(inputType == 'checkbox' && input.is(':checked')) {
								$(this).addClass('checkedFocus');
							}
						})
						.blur(function(){
							label.removeClass('focus checkedFocus');
						});					
					}
				});
			}
