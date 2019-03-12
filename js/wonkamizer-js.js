( function($)
{
	"use strict";

	/*===================================================================
	=            This is area for writing callable functions            =
	===================================================================*/
	function slide_adjustment()
	{
		var header_slider_section = document.querySelector( '.header-slider-section' ),
		top_slide = document.querySelector( '.top-page-slide' ),
		cta_slider = document.querySelector( '.header-slider-section' ),
		cta_slider_section = document.querySelector( '.desirable-slider-section' ),
		header_topbar = document.querySelector( '.topbar-notice' ),
		adjustment = document.querySelector( '.topbar-notice' ).offsetHeight + document.querySelector( '.topbar-notice' ).offsetTop;

		header_slider_section.style.height = (window.innerHeight - adjustment) + 'px';
		cta_slider_section.style.height = (window.innerHeight - adjustment) + 'px';
		top_slide.style.height = header_slider_section.offsetHeight;
		top_slide.style.width = header_slider_section.offsetWidth;
	}
	/*=====  End of This is area for writing callable functions  ======*/

	/*====================================================================
	=            This is for loading calls on window resizing            =
	====================================================================*/
	window.onresize = function()
	{

	};
	/*=====  End of This is for loading calls on window resizing  ======*/
	
	/*===================================================================
	=            This is for running after document is ready            =
	===================================================================*/
	window.onload = function()
	{
		if ( document.querySelector( '.header-slider-section' ) ) 
		{
			slide_adjustment();
			
			// $( '.top-page-slider' ).slick({
			//   dots: true,
			//   infinite: true,
			//   adaptiveHeight: false,
			//   speed: 300,
			//   slidesToShow: 1,
			//   slidesToScroll: 1,
			// });
		}

		// ===== Scroll to Top ==== 
		$(window).scroll(function() {
		   if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
		       $('#return-to-top').fadeIn(200);    // Fade in the arrow
		   } else {
		       $('#return-to-top').fadeOut(200);   // Else fade out the arrow
		   }
		});
		$('#return-to-top').click(function() {      // When arrow is clicked
		   $('body,html').animate({
		       scrollTop : 0                       // Scroll to top of body
		   }, 500);
		});
	};
	/*=====  End of This is for running after document is ready  ======*/

})(jQuery);
