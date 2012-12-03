(function(a){a.fn.cmsmsResponsiveContentSlider=function(b){var c={sliderWidth:1e3,sliderHeight:500,animationSpeed:500,animationEffect:"slide",animationEasing:"easeInOutExpo",pauseTime:5e3,activeSlide:1,touchControls:true,pauseOnHover:true,arrowNavigation:true,arrowNavigationHover:false,slidesNavigation:true,slidesNavigationHover:false,afterSliderLoad:function(){},beforeSlideChange:function(){},afterSlideChange:function(){}},d=this,e=d.wrap('<div class="cmsms_content_slider_parent" />').parent(),f=undefined,g={};g={init:function(){g.options=a.extend({},c,b);g.el=d;g.vars={};g.vars.oldSlide=undefined;g.vars.newSlide=undefined;g.vars.active_sl_numb=g.options.activeSlide==="random"?0:Number(g.options.activeSlide-1);g.vars.ifWNumber=typeof g.options.sliderWidth==="number"?true:false;g.vars.ifHNumber=typeof g.options.sliderHeight==="number"?true:false;g.vars.autoHeight=g.options.sliderHeight==="auto"?true:false;g.vars.inPause=true;g.vars.inAnimation=true;g.vars.mouseClicked=false;if(g.options.pauseTime!==0){g.vars.countdown=Math.round(g.options.pauseTime/50);g.vars.countMax=Math.round(g.options.pauseTime/50)}else{g.vars.countdown=-1;g.vars.countMax=-1}if(!g.vars.autoHeight){e.css({height:g.options.sliderHeight})}g.setSliderVars();g.preloadSlider()},setSliderVars:function(){g.vars.sliderWidth=g.vars.ifWNumber?g.options.sliderWidth+"px":g.options.sliderWidth;g.vars.sliderHeight=g.vars.ifHNumber?g.options.sliderHeight+"px":g.options.sliderHeight;g.vars.slides=g.el.find(">li");g.vars.sl_count=g.vars.slides.length;g.vars.first_sl=g.vars.slides.first();g.vars.last_sl=g.vars.slides.eq(g.vars.sl_count-1)},preloadSlider:function(){var b=g.vars.slides.find("img:eq(0)"),c=b.length;if(b.length>0){b.each(function(){var b=new Image,d=a(this).attr("src");b.src=d;a(this).addClass("cmsms_img");var e=setInterval(function(){if(isImageOk(b)||isImageOk(b)==="stop"){clearInterval(e);c-=1;if(c===0){g.buildSlider();g.buildControls();g.attachEvents();g.afterSliderLoad()}}},50)})}else{g.buildSlider();g.buildControls();g.attachEvents();g.afterSliderLoad()}},buildSlider:function(){g.vars.slides.addClass("cmsmsContentSlide").css({left:g.vars.sliderWidth});if(g.options.activeSlide==="random"){g.vars.active_sl_numb=parseInt(Math.random()*g.vars.sl_count)}g.el.css({background:"none"});e.css({width:g.vars.sliderWidth,padding:0,opacity:0});if(g.vars.autoHeight){g.vars.slides.css({height:"auto"});g.setSlideHeight(g.vars.slides.eq(g.vars.active_sl_numb),false)}g.vars.slides.eq(g.vars.active_sl_numb).css({left:0,zIndex:2}).addClass("active");e.animate({opacity:1},g.options.animationSpeed/2,g.options.animationEasing);g.vars.inPause=false;g.vars.inAnimation=false},buildControls:function(){if(g.options.slidesNavigation){e.append('<ul class="cmsms_slides_nav" />');g.vars.slidesNav=e.find("ul.cmsms_slides_nav");if(g.options.slidesNavigationHover){g.vars.slidesNav.css({opacity:0})}for(var a=0;a<g.vars.sl_count;a+=1){g.vars.slidesNav.append('<li><a href="#">'+(a+1)+"</a></li>")}g.vars.slidesNav.find(">li").eq(g.vars.active_sl_numb).addClass("active");g.vars.slidesNavButton=g.vars.slidesNav.find(">li>a")}if(g.options.arrowNavigation){e.parent().prepend('<a href="#" class="cmsms_content_prev_slide"><span /></a>'+'<a href="#" class="cmsms_content_next_slide"><span /></a>');g.vars.prevSlideButton=e.parent().find(".cmsms_content_prev_slide");g.vars.nextSlideButton=e.parent().find(".cmsms_content_next_slide");if(g.options.arrowNavigationHover){g.vars.prevSlideButton.css({left:"-100px",opacity:0});g.vars.nextSlideButton.css({right:"-100px",opacity:0})}}},attachEvents:function(){if(g.options.touchControls){g.vars.slides.bind("mousedown",function(a){g.mouseDoun(a);return false});g.vars.slides.bind("mousemove",function(a){g.mouseMove(a);return false});g.vars.slides.bind("mouseup",function(){g.mouseUp();return false});e.bind("mouseleave",function(){if(!g.vars.mouseClicked){return}g.mouseUp();return false})}if(g.options.arrowNavigation){g.vars.nextSlideButton.bind("click",function(){g.nextSlide();return false});g.vars.prevSlideButton.bind("click",function(){g.prevSlide();return false})}if(g.options.slidesNavigation){g.vars.slidesNavButton.bind("click",function(){if(a(this).parent().is(".active")){return false}else{g.slideChoose(a(this).parent().index())}return false})}if(g.options.pauseOnHover){e.bind("mouseenter",function(){g.vars.inPause=true}).bind("mouseleave",function(){g.vars.inPause=false})}if(g.options.slidesNavigation&&g.options.slidesNavigationHover){e.bind("mouseenter",function(){g.vars.slidesNav.css({opacity:1})}).bind("mouseleave",function(){g.vars.slidesNav.css({opacity:0})})}if(g.options.arrowNavigation&&g.options.arrowNavigationHover){e.bind("mouseenter",function(){g.vars.prevSlideButton.stop().animate({left:"10px",opacity:1},g.options.animationSpeed,g.options.animationEasing);g.vars.nextSlideButton.stop().animate({right:"10px",opacity:1},g.options.animationSpeed,g.options.animationEasing)}).bind("mouseleave",function(){g.vars.prevSlideButton.stop().animate({left:"-100px",opacity:0},g.options.animationSpeed,g.options.animationEasing);g.vars.nextSlideButton.stop().animate({right:"-100px",opacity:0},g.options.animationSpeed,g.options.animationEasing)})}f=setInterval(function(){g.timerController()},50)},getSlVars:function(){g.vars.active_sl=g.el.find(">li.active")},setSlideHeight:function(a,b){if(b){e.animate({height:a[0].scrollHeight+"px"},g.options.animationSpeed,g.options.animationEasing)}else{e.css({height:a[0].scrollHeight+"px"})}},navActiveSl:function(a,b){g.vars.slidesNav.find(">li").eq(a.index()).removeClass("active");g.vars.slidesNav.find(">li").eq(b.index()).addClass("active")},setTimer:function(){g.vars.inPause=false;if(g.options.pauseTime!==0){g.vars.countdown=Math.round(g.options.pauseTime/50);g.vars.countMax=Math.round(g.options.pauseTime/50)}else{g.vars.countdown=-1;g.vars.countMax=-1}},nextSlide:function(){if(g.vars.inAnimation||g.vars.sl_count<2){return false}else{g.vars.inAnimation=true}g.getSlVars();g.setTimer();g.beforeSlideChange();g.vars.oldSlide=g.vars.active_sl;g.vars.newSlide=g.vars.active_sl.index()<g.vars.sl_count-1?g.vars.active_sl.next():g.vars.first_sl;if(g.options.slidesNavigation){g.navActiveSl(g.vars.oldSlide,g.vars.newSlide)}if(g.vars.autoHeight){g.setSlideHeight(g.vars.newSlide,true)}if(g.options.animationEffect==="slide"){g.vars.oldSlide.removeClass("active").animate({left:"-"+g.vars.sliderWidth},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({left:g.vars.sliderWidth,zIndex:1})});g.vars.newSlide.addClass("active").css({zIndex:3}).animate({left:g.vars.ifWNumber?0:"0%"},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({zIndex:2});g.vars.inAnimation=false;g.afterSlideChange()})}else if(g.options.animationEffect==="fade"){g.fadeSlide(g.vars.oldSlide,g.vars.newSlide,true)}},prevSlide:function(){if(g.vars.inAnimation||g.vars.sl_count<2){return false}else{g.vars.inAnimation=true}g.getSlVars();g.setTimer();g.beforeSlideChange();g.vars.oldSlide=g.vars.active_sl;g.vars.newSlide=g.vars.active_sl.index()>0?g.vars.active_sl.prev():g.vars.last_sl;if(g.options.slidesNavigation){g.navActiveSl(g.vars.oldSlide,g.vars.newSlide)}if(g.vars.autoHeight){g.setSlideHeight(g.vars.newSlide,true)}if(g.options.animationEffect==="slide"){g.vars.oldSlide.removeClass("active").animate({left:g.vars.sliderWidth},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({zIndex:1})});g.vars.newSlide.addClass("active").css({left:"-"+g.vars.sliderWidth,zIndex:3}).animate({left:g.vars.ifWNumber?0:"0%"},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({zIndex:2});g.vars.inAnimation=false;g.afterSlideChange()})}else if(g.options.animationEffect==="fade"){g.fadeSlide(g.vars.oldSlide,g.vars.newSlide,false)}},slideChoose:function(b){if(g.vars.inAnimation){return false}else{g.vars.inAnimation=true}g.getSlVars();g.setTimer();g.beforeSlideChange();g.vars.oldSlide=g.vars.active_sl;g.vars.newSlide=g.vars.slides.eq(b);if(g.options.slidesNavigation){g.navActiveSl(g.vars.oldSlide,g.vars.newSlide)}if(g.vars.autoHeight){g.setSlideHeight(g.vars.newSlide,true)}if(g.vars.active_sl.index()<g.vars.newSlide.index()){if(g.options.animationEffect==="slide"){g.vars.oldSlide.removeClass("active").animate({left:"-"+g.vars.sliderWidth},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({left:g.vars.sliderWidth,zIndex:1})});g.vars.newSlide.addClass("active").css({zIndex:3}).animate({left:g.vars.ifWNumber?0:"0%"},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({zIndex:2});g.vars.inAnimation=false;g.afterSlideChange()})}else if(g.options.animationEffect==="fade"){g.fadeSlide(g.vars.oldSlide,g.vars.newSlide,true)}}else{if(g.options.animationEffect==="slide"){g.vars.oldSlide.removeClass("active").animate({left:g.vars.sliderWidth},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({zIndex:1})});g.vars.newSlide.addClass("active").css({left:"-"+g.vars.sliderWidth,zIndex:3}).animate({left:g.vars.ifWNumber?0:"0%"},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({zIndex:2});g.vars.inAnimation=false;g.afterSlideChange()})}else if(g.options.animationEffect==="fade"){g.fadeSlide(g.vars.oldSlide,g.vars.newSlide,false)}}},fadeSlide:function(b,c,d){c.css({left:0});if(d){b.removeClass("active").animate({left:"-"+g.vars.sliderWidth,opacity:0},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({left:g.vars.sliderWidth,opacity:1,zIndex:1});c.addClass("active").css({zIndex:2});g.vars.inAnimation=false;g.afterSlideChange()})}else{b.removeClass("active").animate({left:g.vars.sliderWidth,opacity:0},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({opacity:1,zIndex:1});c.addClass("active").css({zIndex:2});g.vars.inAnimation=false;g.afterSlideChange()})}},mouseDoun:function(a){if(g.vars.inAnimation||g.vars.pj_count<2){return false}else{g.vars.inAnimation=true;g.vars.inPause=true;g.vars.mouseClicked=true;g.vars.startPosX=a.clientX;g.vars.xIndex=0;if(!g.vars.ifWNumber){g.vars.sliderPxWidth=e.width()}else{g.vars.sliderPxWidth=g.options.sliderWidth}g.getSlVars();g.vars.next_sl=g.vars.active_sl.index()!==g.vars.sl_count-1?g.vars.active_sl.next():g.vars.first_sl;g.vars.prev_sl=g.vars.active_sl.index()!==0?g.vars.active_sl.prev():g.vars.last_sl}},mouseMove:function(a){if(!g.vars.mouseClicked){return}g.vars.finishPosX=a.clientX;g.vars.xIndex=Math.round(g.vars.finishPosX-g.vars.startPosX);if(g.options.animationEffect==="slide"){g.vars.active_sl.css({left:g.vars.xIndex+"px"})}else if(g.options.animationEffect==="fade"){g.vars.active_sl.css({left:g.vars.xIndex+"px",opacity:1-(Math.abs(g.vars.xIndex)/Math.round(g.vars.sliderPxWidth*.75)).toFixed(2)})}if(g.vars.xIndex<0){if(g.options.animationEffect==="slide"){g.vars.next_sl.css({left:g.vars.sliderPxWidth+g.vars.xIndex+"px",zIndex:3})}else if(g.options.animationEffect==="fade"){if(g.vars.prevTouch){g.vars.prevTouch=false;g.vars.touchTarget.css({left:g.vars.sliderPxWidth+"px"})}if(!g.vars.nextTouch){g.vars.nextTouch=true}if(g.vars.active_sl.index()!==g.vars.sl_count-1){g.vars.touchTarget=g.vars.active_sl.next()}else{g.vars.touchTarget=g.vars.first_sl}g.vars.touchTarget.css({left:0})}}else if(g.vars.xIndex>0){if(g.options.animationEffect==="slide"){g.vars.prev_sl.css({left:-g.vars.sliderPxWidth+g.vars.xIndex+"px",zIndex:3})}else if(g.options.animationEffect==="fade"){if(g.vars.nextTouch){g.vars.nextTouch=false;g.vars.touchTarget.css({left:g.vars.sliderPxWidth+"px"})}if(!g.vars.prevTouch){g.vars.prevTouch=true}if(g.vars.active_sl.index()!==0){g.vars.touchTarget=g.vars.active_sl.prev()}else{g.vars.touchTarget=g.vars.last_sl}g.vars.touchTarget.css({left:0})}}},mouseUp:function(){if(!g.vars.mouseClicked){return}g.vars.mouseClicked=false;if(g.vars.xIndex<0){if(g.vars.xIndex<-75){g.beforeSlideChange();if(g.options.slidesNavigation){g.navActiveSl(g.vars.active_sl,g.vars.next_sl)}if(g.vars.autoHeight){g.setSlideHeight(g.vars.next_sl,true)}if(g.options.animationEffect==="slide"){if(g.vars.sl_count>2){g.vars.prev_sl.css({left:g.vars.sliderPxWidth+"px",zIndex:1})}g.vars.active_sl.removeClass("active").animate({left:"-"+g.vars.sliderPxWidth+"px"},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({left:g.vars.sliderPxWidth+"px",zIndex:1})});g.vars.next_sl.addClass("active").animate({left:0},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({zIndex:2});g.vars.inAnimation=false;g.setTimer();g.afterSlideChange()})}else if(g.options.animationEffect==="fade"){if(g.vars.sl_count>2){g.vars.prev_sl.css({left:g.vars.sliderPxWidth+"px",opacity:1,zIndex:1})}g.vars.active_sl.removeClass("active").animate({left:"-"+g.vars.sliderPxWidth+"px"},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({left:g.vars.sliderPxWidth+"px",opacity:1,zIndex:1});g.vars.next_sl.addClass("active").css({zIndex:2});g.vars.inAnimation=false;g.setTimer();g.afterSlideChange()})}}else{if(g.options.animationEffect==="slide"){if(g.vars.sl_count>2){g.vars.prev_sl.css({left:g.vars.sliderPxWidth+"px",zIndex:1})}g.vars.active_sl.animate({left:0},g.options.animationSpeed,g.options.animationEasing);g.vars.next_sl.animate({left:g.vars.sliderPxWidth+"px"},g.options.animationSpeed,g.options.animationEasing,function(){g.vars.inAnimation=false;g.vars.inPause=false})}else if(g.options.animationEffect==="fade"){if(g.vars.sl_count>2){g.vars.prev_sl.css({left:g.vars.sliderPxWidth+"px",opacity:1,zIndex:1})}g.vars.active_sl.animate({left:0,opacity:1},g.options.animationSpeed,g.options.animationEasing,function(){g.vars.next_sl.css({left:g.vars.sliderPxWidth+"px"});g.vars.inAnimation=false;g.vars.inPause=false})}}}else if(g.vars.xIndex>=0){if(g.vars.xIndex>75){g.beforeSlideChange();if(g.options.slidesNavigation){g.navActiveSl(g.vars.active_sl,g.vars.prev_sl)}if(g.vars.autoHeight){g.setSlideHeight(g.vars.prev_sl,true)}if(g.options.animationEffect==="slide"){if(g.vars.sl_count>2){g.vars.next_sl.css({left:g.vars.sliderPxWidth+"px",zIndex:1})}g.vars.active_sl.removeClass("active").animate({left:g.vars.sliderPxWidth+"px"},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({zIndex:1})});g.vars.prev_sl.addClass("active").animate({left:0},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({zIndex:2});g.vars.inAnimation=false;g.setTimer();g.afterSlideChange()})}else if(g.options.animationEffect==="fade"){if(g.vars.sl_count>2){g.vars.next_sl.css({left:g.vars.sliderPxWidth+"px",opacity:1,zIndex:1})}g.vars.active_sl.removeClass("active").animate({left:g.vars.sliderPxWidth+"px"},g.options.animationSpeed,g.options.animationEasing,function(){a(this).css({opacity:1,zIndex:1});g.vars.prev_sl.addClass("active").css({zIndex:2});g.vars.inAnimation=false;g.setTimer();g.afterSlideChange()})}}else{if(g.options.animationEffect==="slide"){if(g.vars.sl_count>2){g.vars.next_sl.css({left:g.vars.sliderPxWidth+"px",zIndex:1})}if(g.vars.xIndex!==0){g.vars.active_sl.animate({left:0},g.options.animationSpeed,g.options.animationEasing);g.vars.prev_sl.animate({left:"-"+g.vars.sliderPxWidth+"px"},g.options.animationSpeed,g.options.animationEasing,function(){g.vars.inAnimation=false;g.vars.inPause=false})}else{g.vars.inAnimation=false;g.vars.inPause=false}}else if(g.options.animationEffect==="fade"){if(g.vars.sl_count>2){g.vars.next_sl.css({left:g.vars.sliderPxWidth+"px",opacity:1,zIndex:1})}if(g.vars.xIndex!==0){g.vars.active_sl.animate({left:0,opacity:1},g.options.animationSpeed,g.options.animationEasing,function(){g.vars.prev_sl.css({left:g.vars.sliderPxWidth+"px"});g.vars.inAnimation=false;g.vars.inPause=false})}else{g.vars.inAnimation=false;g.vars.inPause=false}}}}},timerController:function(){if(g.vars.inPause||g.vars.countdown<0){return}if(g.vars.countdown===0){g.nextSlide()}g.vars.countdown-=1},afterSliderLoad:function(){g.options.afterSliderLoad()},beforeSlideChange:function(){g.options.beforeSlideChange()},afterSlideChange:function(){g.options.afterSlideChange()}};g.init()}})(jQuery);








jQuery(document).ready(function() { 
	
	/* Image Preloader */
	(function ($) { 
		var images = jQuery('.preloader img'), 
			max = images.length, 
			img = new Image(), 
			curr = 1;
		
		jQuery('.preloader').each(function () { 
			jQuery('<span class="image_container_img" />').prependTo(jQuery(this));
		} );
		
		images.remove();
		
		if (max > 0) { 
			loadImage(0, max);
		}
		
		function loadImage(index, max) { 
			if (index < max) { 
				$('<span id="img' + (index + 1) + '" class="p_img_container" />').each(function () { 
					$(this).prependTo($('.preloader .image_container_img').eq(index));
				} );
				
				var img = new Image(), 
					curr = $('#img' + (index + 1));
				
				$(img).load(function () { 
					$(curr).append(this);
					
					if ($(this).parent().parent().parent().hasClass('inBlog')) { 
						$(this).parent().parent().parent().css( { 
							height : 'auto', 
							padding : 0 
						} );
					}
					
					$(this).parent().parent().parent().css( { backgroundImage : 'none' } );
					
					$(this).animate( { opacity : 1 }, 500, 'easeInOutExpo');
					
					if (index !== (max - 1)) { 
						loadImage(index + 1, max);
					}
				} ).error(function () { 
					$(curr).remove();
					
					loadImage((index + 1), max);
				} ).attr( { 
					src : $(images[index]).attr('src'), 
					title : $(images[index]).attr('title'), 
					alt : $(images[index]).attr('alt') 
				} ).addClass($(images[index]).attr('class'));
				
				if (index === (max - 1) && $('#middle .pj_sort').find('.p_options_block').html() !== null) {
					loadSorting();
				}
			}
		}
		
		function loadSorting() { 
			if ($.browser.msie && $.browser.version < 9) { 
				$('.p_options_loader').css( { display : 'none' } );
				$('.p_options_block').css( { display : 'block' } );
			} else { 
				$('.p_options_loader').fadeOut(200, function () { 
					$(this).css( { display : 'none' } );
				} );
				
				$('.p_options_block').fadeIn(200);
			}
		}
	} )(jQuery);
} );




/* Correct Image Load Check */
function isImageOk(img) { 
	if (!img.complete) { 
		return false;
	}
	
	if (typeof img.naturalWidth !== undefined && img.naturalWidth === 0) { 
		return 'stop';
	}
	
	return true;
}



