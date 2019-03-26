( function($)
{
	"use strict";

	/*===============================================
	=            vars set for script use            =
	===============================================*/
	var last_scroll_top = 0,
	scroll_direction,
	scroll_distance,
	one_click = true;
	/*=====  End of vars set for script use  ======*/
	

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
		new_space;

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
		var top_slider_section = document.querySelector( '.header-slider-section' );
		var cta_section = document.querySelector( '.desirable-slider-section' );
		var parallax_adjust, slide_imgs, admin_bar, admin_height;

		// Get the offset position of the navbar
		var sticky = shop_section.offsetTop;

		if ( window.pageYOffset > last_scroll_top ) {
			scroll_direction = 'scrolled down';
			scroll_distance = window.pageYOffset - last_scroll_top;
		}

		if ( window.pageYOffset < last_scroll_top )
		{
			scroll_direction = 'scrolled up';
			scroll_distance = last_scroll_top - window.pageYOffset;
		}

		last_scroll_top = window.pageYOffset;

		/*=======================================================================
		=            This is for the top slider section for parallax            =
		=======================================================================*/
		if ( window.pageYOffset > top_slider_section.offsetTop && window.pageYOffset < top_slider_section.offsetTop + top_slider_section.offsetHeight ) 
		{
			parallax_adjust = parseFloat( (window.pageYOffset - top_slider_section.offsetTop ) / ( top_slider_section.offsetHeight / 2 ) ).toFixed( 5 );
			slide_imgs = top_slider_section.querySelectorAll( '.top-slide-img-holder' );
			slide_imgs.forEach( function( el, i ) 
				{
					el.style.backgroundPosition = 'center ' + parallax_adjust + 'vh';
				});
		}

		if ( window.pageYOffset < top_slider_section.offsetTop ) 
		{
			slide_imgs = top_slider_section.querySelectorAll( '.top-slide-img-holder' );
			slide_imgs.forEach( function( el, i ) 
				{
					el.style.backgroundPosition = '';
				});
		}
		/*=====  End of This is for the top slider section for parallax  ======*/

		/*=======================================================================
		=            This is for the cta slider section for parallax            =
		=======================================================================*/
		if ( window.pageYOffset > cta_section.offsetTop && window.pageYOffset < cta_section.offsetTop + cta_section.offsetHeight ) 
		{
			parallax_adjust = parseFloat( (window.pageYOffset - cta_section.offsetTop ) / ( cta_section.offsetHeight / 2 ) ).toFixed( 5 );
			slide_imgs = cta_section.querySelectorAll( '.cta-slide-img-holder' );
			slide_imgs.forEach( function( el, i ) 
				{
					el.style.backgroundPosition = 'center ' + parallax_adjust + 'vh';
				});
		}

		if ( window.pageYOffset < cta_section.offsetTop ) 
		{
			slide_imgs = cta_section.querySelectorAll( '.cta-slide-img-holder' );
			slide_imgs.forEach( function( el, i ) 
				{
					el.style.backgroundPosition = '';
				});
		}
		/*=====  End of This is for the top slider section for parallax  ======*/
		
	   	if ( document.querySelector( '#wpadminbar' ) ) 
	   	{
	   		admin_bar = document.querySelector( '#wpadminbar' );
	   		admin_height = admin_bar.offsetHeight;
	   		header_notice.style.position = 'fixed';

	   		if ( getComputedStyle( admin_bar ).position == 'absolute' && window.pageYOffset > admin_height ) 
	   		{
	   			header_notice.style.top = 0;
	   		}
	   		else
	   		{
	   			header_notice.style.top = admin_height + 'px';
	   		}
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
					header.style.overflow = 'visible';
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
					
					if ( getComputedStyle( admin_bar ).position == 'absolute' && window.pageYOffset > admin_height ) 
					{
						header_notice.style.top = 0;
					}
					else
					{
						header_notice.style.top = admin_height + 'px';
					}
				}
				else
				{
					header_notice.style.position = 'fixed';
					header_notice.style.top = 0;
					header.style.overflow = 'visible';
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
		img_area = document.querySelector( '.product-img-section' ),
		target_scrolling = img_area.offsetHeight - summary_section.offsetHeight,
		win_y = window.pageYOffset;

		if ( window.innerWidth > 792 && win_y - img_area.offsetTop > target_scrolling ) 
		{
			summary_section.classList.remove( 'sticky-on' );
			summary_section.style.top = target_scrolling - parseInt( window.getComputedStyle( summary_section ).marginTop ) + 'px';
		}
		else if ( window.innerWidth > 792 )
		{
			summary_section.classList.add( 'sticky-on' );
			summary_section.style.top = 15 + 'px';
		}
	}
	
	if ( document.querySelector( '.wonka-single-product-img' ) ) 
	{
		var img_area = document.querySelector( '.wonka-single-product-img' );
		var img_area_top = img_area.parentElement.offsetTop;
	}

	function thumbnail_scroll(e)
	{
		
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

		/*===================================================================
		=            This is to kill the about us video on close            =
		===================================================================*/
		if ( document.querySelector( 'div#videoModal' ) ) 
		{
			var about_vid_modal = document.querySelector( 'div#videoModal' );
			var about_vid_close = document.querySelector( 'div#videoModal button.close' );
			var about_vid_iframe = document.querySelector( 'div#videoModal iframe' );
			var about_vid_iframe_link = document.querySelector( 'div#videoModal iframe' ).src;

			about_vid_close.onclick = function()
			{
				about_vid_iframe.src = '';
				about_vid_iframe.src = about_vid_iframe_link;
			};

			about_vid_modal.onclick = function() 
			{
				about_vid_iframe.src = '';
				about_vid_iframe.src = about_vid_iframe_link;
			};
		}
		/*=====  End of This is to kill the about us video on close  ======*/
		
		/*============================================================================
		=            This removes the title attribute from product images            =
		============================================================================*/
		if ( document.querySelector( '.products img' ) ) 
		{
			var imgs_w_title = document.querySelectorAll( '.products img' );
			imgs_w_title.forEach( function( el, i ) 
				{
					el.removeAttribute( 'title' );
				});
		}

		if ( document.querySelector( '.product-img-section img' ) ) 
		{
			var product_page_imgs_w_title = document.querySelectorAll( '.product-img-section img' );
			product_page_imgs_w_title.forEach( function( el, i ) 
				{
					el.removeAttribute( 'title' );
				});
		}
		
		/*=====  End of This removes the title attribute from product images  ======*/
		

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
		if ( document.querySelector( '.home' ) ) 
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
			  arrows: true,
			  appendArrows: $( '.top-page-slider-wrap .slick-list' ),
			  appendDots: $( '.top-page-slider-wrap .slick-list' ),
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
			  arrows: true,
			  appendArrows: $( '.cta-section-slider-wrap .slick-list' ),
			  appendDots: $( '.cta-section-slider-wrap .slick-list' ),
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
