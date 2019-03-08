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
			var header_slider_section = document.querySelector( '.header-slider-section' );
			var cta_slider_section = document.querySelector( '.desirable-slider-section' );
			var header_topbar = document.querySelector( '.topbar-notice' );
			var adjustment = document.querySelector( '.topbar-notice' ).offsetHeight + document.querySelector( '.topbar-notice' ).offsetTop;
			header_slider_section.style.height = (window.innerHeight - adjustment) + 'px';
			cta_slider_section.style.height = (window.innerHeight - adjustment) + 'px';
		}
	};
	/*=====  End of This is for running after document is ready  ======*/
	
})(jQuery);