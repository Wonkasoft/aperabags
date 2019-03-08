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
			header_slider_section.style.height = (window.innerHeight - header_slider_section.offsetTop) + 'px';
		}
	};
	/*=====  End of This is for running after document is ready  ======*/
	
})(jQuery);