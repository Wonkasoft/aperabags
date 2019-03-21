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
	function openSearch(e) 
	{
		e.preventDefault();
	  	document.getElementById( "search_overlay" ).style.display = "block";

	  	setTimeout( function() {
	  		document.querySelector( '#search_overlay' ).style.opacity = 1;
	  		document.querySelector( '#search_overlay' ).style.left = 0;
	  	}, 300);
	}

	// Close the full screen search box 
	function closeSearch(e) 
	{
		e.preventDefault();
  		document.querySelector( '#search_overlay' ).style.left = '100%';
  		document.querySelector( '#search_overlay' ).style.opacity = 0;

		setTimeout( function() {
			document.getElementById( "search_overlay" ).style.display = "none";
			document.getElementById( "search_overlay" ).removeAttribute( 'style' );
		}, 300);
	}

	// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
	function stickyStatus() 
	{	
		// Get the header
		var header = document.querySelector('.site-header');
		var header_notice = document.querySelector('.topbar-notice');
		var shop_section = document.querySelector( '.shop-section' );
		var admin_height;

		// Get the offset position of the navbar
		var sticky = shop_section.offsetTop;

	   	if ( document.querySelector( '#wpadminbar' ) ) 
	   	{
	   		admin_height = document.querySelector( '#wpadminbar' ).offsetHeight;
	   		header_notice.style.position = 'fixed';
	   		header_notice.style.top = admin_height + 'px';
	   	}
	   	else
	   	{
	   		header_notice.style.position = 'fixed';
	   		header_notice.style.top = 0;
	   	}

		if ( window.pageYOffset > header.offsetHeight - header_notice.offsetHeight && window.innerWidth > 782 && window.pageYOffset < sticky ) 
		{
			header.style.height = header_notice.offsetHeight + 'px';
		}

		if ( window.pageYOffset > sticky && window.innerWidth > 782 ) 
		{
			header.classList.add( 'sticky' );
			header_notice.style.position = 'absolute';
	   		header_notice.style.top = 0;
			document.querySelector( '.sticky' ).style.top = admin_height + 'px';
			if ( window.pageYOffset > sticky && header.offsetHeight == header_notice.offsetHeight ) 
			{
				setTimeout( function( header ) 
				{
					header.style.height = '120px';
					header.style.background = '#646371';
				}, 120, header );
			}
		} 
		else 
		{
			header.style.height = header_notice.offsetHeight + 'px';
			header.style.background = 'transparent';
			setTimeout( function( header, header_notice ) 
			{
				if ( document.querySelector( '#wpadminbar' ) ) 
				{
					admin_height = document.querySelector( '#wpadminbar' ).offsetHeight;
					header_notice.style.position = 'fixed';
					header_notice.style.top = admin_height + 'px';
				}
				else
				{
					header_notice.style.position = 'fixed';
					header_notice.style.top = 0;
				}
				header.classList.remove( 'sticky' );
			}, 120, header, header_notice );

		}

		if ( window.pageYOffset == 0 ) 
		{
			header.removeAttribute( 'style' );
		}
	}

	function stickySummary() 
	{
		var summary_section = document.querySelector( '.summary.entry-summary' ),
		img_area = document.querySelector( '.wonka-single-product-img' ),
		target_scrolling = img_area.offsetHeight - summary_section.offsetHeight,
		win_y = window.pageYOffset;

		if ( window.innerWidth > 792 && win_y - summary_section.parentElement.offsetTop > target_scrolling ) 
		{
			summary_section.style.position = 'relative';
			summary_section.style.top = target_scrolling - parseInt( window.getComputedStyle( summary_section ).marginTop ) + 'px';
		}
		else
		{
			summary_section.style.position = 'sticky';
			summary_section.style.top = 15 + 'px';
		}
	}

	var last_scroll_top = 0,
	thumbnail_counter = 1,
	one_click = true;
	if ( document.querySelector( '.wonka-single-product-img' ) ) 
	{
		var img_area = document.querySelector( '.wonka-single-product-img' );
		var img_area_top = img_area.parentElement.offsetTop;
	}

	function thumbnail_scroll(e)
	{
		var control_list = document.querySelector( '.flex-control-nav' ),
		win_y = window.pageYOffset,
		control_wrapper,
		thumbnail_count = control_list.childElementCount,
		scroll_direction,
		flex_active = document.querySelector( '.flex-active' ),
		this_body = document.body,
		this_html = document.documentElement;
		thumbnail_counter = ( win_y < img_area_top ) ? 1: thumbnail_counter;

		if ( window.pageYOffset > last_scroll_top ) {
			scroll_direction = 'scrolled down';
		}

		if ( window.pageYOffset < last_scroll_top )
		{
			scroll_direction = 'scrolled up';
		}

		last_scroll_top = window.pageYOffset;

		if ( !document.querySelector( 'div.flex-control-wrapper' ) ) 
		{
			control_wrapper = document.createElement( 'DIV' );
			control_wrapper.setAttribute( 'class', 'flex-control-wrapper');
			control_list.parentElement.insertBefore( control_wrapper, control_list );
			control_wrapper.appendChild( control_list );
		}

		if ( window.pageYOffset > img_area_top && scroll_direction == 'scrolled down' && flex_active.parentElement.nextElementSibling != null ) 
		{
			this_body.scrollTop = img_area_top;
			this_html.scrollTop = img_area_top;
			if ( flex_active.parentElement.nextElementSibling != null && one_click ) 
			{
				one_click = false;
				setTimeout( function() {
					thumbnail_counter++;
					flex_active.parentElement.nextElementSibling.firstElementChild.click();
					one_click = true;
				}, 500);
			}
		}

		if ( window.pageYOffset < img_area_top && scroll_direction == 'scrolled up' && flex_active.parentElement.previousElementSibling != null )
		{
			this_body.scrollTop = img_area_top;
			this_html.scrollTop = img_area_top;
			if ( flex_active.parentElement.previousElementSibling != null && one_click ) 
			{
				one_click = false;
				setTimeout( function() {
					thumbnail_counter--;
					flex_active.parentElement.previousElementSibling.firstElementChild.click();
					one_click = true;
				}, 500);
			}
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
		/*===========================================================================================
		=            This makes the adjustment of space for the footer to show correctly            =
		===========================================================================================*/
		footer_adjustment();
		/*=====  End of This makes the adjustment of space for the footer to show correctly  ======*/

		/*==========================================
		=            Search btn actions            =
		==========================================*/
		var search_btn = document.querySelectorAll( 'li.top-menu-s-btn i' ),
		close_btn = document.querySelector( 'span.closebtn' );
		

		search_btn.forEach( function( item, i ) {
			item.addEventListener( 'click', openSearch );
		} );
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
		
		/*===============================================
		=            For single product page            =
		===============================================*/
		if ( document.querySelector( '.single-product' ) ) 
		{
			// When the user scrolls the page, execute stickyStatus 
			window.onscroll = function(e) 
			{ 
				thumbnail_scroll(e);
				stickySummary(e); 
			};
		}
		/*=====  End of For single product page  ======*/

		/*================================================================
		=            For setting up sliders on the front page            =
		================================================================*/
		if ( document.querySelector( '.header-slider-section' ) ) 
		{
			slide_adjustment();
			
			$( '.top-page-slider-wrap' ).slick({
			  slidesToShow: 1,
			  slidesToScroll: 1,
			  autoplay: true,
			  autoplaySpeed: 7000,
			  fade: true,
			  dots: true,
			  appendArrows: document.querySelector( '.top-page-slider-wrap>.slick-list' ),
			  appendDots: document.querySelector( '.top-page-slider-wrap>.slick-list' ),
			  prevArrow: '<button class="slick-prev" type="button"></button>',
			  nextArrow: '<button class="slick-next" type="button"></button>',
			});
		}

		if ( document.querySelector( '.desirable-slider-section' ) ) 
		{
			
			$( '.cta-section-slider-wrap' ).slick({
			  slidesToShow: 1,
			  slidesToScroll: 1,
			  autoplay: true,
			  autoplaySpeed: 7000,
			  fade: true,
			  dots: true,
			  appendArrows: document.querySelector( '.cta-section-slider-wrap>.slick-list' ),
			  appendDots: document.querySelector( '.cta-section-slider-wrap>.slick-list' ),
			  prevArrow: '<button class="slick-prev" type="button"></button>',
			  nextArrow: '<button class="slick-next" type="button"></button>',
			});
		}
		/*=====  End of For setting up sliders on the front page  ======*/

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
