( function($)
{
	"use strict";

	/*===================================================================
	=            This is area for writing callable functions            =
	===================================================================*/
	function first_function()
	{

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
			var header_slider_section = document.querySelector( '.header-slider-section' ),
			cta_slider = document.querySelector( '.header-slider-section' ),
			cta_slider_section = document.querySelector( '.desirable-slider-section' ),
			header_topbar = document.querySelector( '.topbar-notice' ),
			adjustment = document.querySelector( '.topbar-notice' ).offsetHeight + document.querySelector( '.topbar-notice' ).offsetTop;
			header_slider_section.style.height = (window.innerHeight - adjustment) + 'px';
			cta_slider_section.style.height = (window.innerHeight - adjustment) + 'px';
			
			// $( '.top-page-slider' ).slick({
			//   dots: true,
			//   infinite: true,
			//   adaptiveHeight: false,
			//   speed: 300,
			//   slidesToShow: 1,
			//   slidesToScroll: 1,
			// });
		}
	};
	/*=====  End of This is for running after document is ready  ======*/
	
})(jQuery);