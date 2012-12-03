jQuery(document).ready(function () { 
	jQuery('.widget_custom_portfolio_entries_slides').cmsmsResponsiveContentSlider( { 
		sliderWidth : '100%', 
		sliderHeight : 'auto', 
		animationSpeed : 500, 
		animationEffect : 'slide', 
		animationEasing : 'easeInOutExpo', 
		pauseTime : 5000, 
		activeSlide : 1, 
		touchControls : true, 
		pauseOnHover : false, 
		arrowNavigation : true, 
		slidesNavigation : false 
	} );
} );