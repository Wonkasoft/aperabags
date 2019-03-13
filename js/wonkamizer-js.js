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

	function footer_adjustment()
	{
		var footer_height = document.querySelector( 'footer#colophon' ).offsetHeight,
		content_el = document.querySelector( '#content'),
		new_space;

		if ( !document.getElementById( 'footer-spacer' ) ) {
			new_space = document.createElement( 'DIV' );
			new_space.id = 'footer-spacer';
			content_el.appendChild( new_space );
		}

		new_space = document.getElementById( 'footer-spacer' );
		new_space.style.width = '100%';
		new_space.style.height = footer_height + 'px';
	}

	// Open the full screen search box 
	function openSearch(e) {
	  document.getElementById( "search_overlay" ).style.display = "block";

	  setTimeout( function() {
	  	document.querySelector( '#search_overlay' ).style.opacity = 1;
	  }, 300);
	}

	// Close the full screen search box 
	function closeSearch(e) {
  		document.querySelector( '#search_overlay' ).style.opacity = 0;
		setTimeout( function() {
			document.getElementById( "search_overlay" ).style.display = "none";
			document.getElementById( "search_overlay" ).removeAttribute( 'style' );
		}, 300);
	}

	// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
	function stickyStatus() {
		
		// Get the header
		var header = document.querySelector('.brand-nav-bar');
		var shop_section = document.querySelector( '.shop-section' );

		// Get the offset position of the navbar
		var sticky = shop_section.offsetTop;
		
		 if (window.pageYOffset > sticky) {
		   	header.classList.add("sticky");
		 } else {
		   	header.classList.remove("sticky");
		 }
	}
	/*=====  End of This is area for writing callable functions  ======*/

	/*====================================================================
	=            This is for loading calls on window resizing            =
	====================================================================*/
	window.onresize = function()
	{
		if ( document.querySelector( '.header-slider-section' ) ) 
		{
			slide_adjustment();
		}

		footer_adjustment();
	};
	/*=====  End of This is for loading calls on window resizing  ======*/
	
	/*===================================================================
	=            This is for running after document is ready            =
	===================================================================*/
	window.onload = function()
	{
		
		/*==========================================
		=            Search btn actions            =
		==========================================*/
		var search_btn = document.querySelector( 'li.top-menu-s-btn i' ),
		close_btn = document.querySelector( 'span.closebtn' );
		
		search_btn.addEventListener( 'click', openSearch );
		close_btn.addEventListener( 'click', closeSearch );
		/*=====  End of Search btn actions  ======*/
		
		/*=========================================
		=            For Sticky Header            =
		=========================================*/
		if ( document.querySelector( '.shop-section' ) ) 
		{
			// When the user scrolls the page, execute stickyStatus 
			window.onscroll = function() { stickyStatus(); };
		}
		/*=====  End of For Sticky Header  ======*/

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

		footer_adjustment();



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
