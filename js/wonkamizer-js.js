( function($)
{
	"use strict";

	/*===============================================
	=            vars set for script use            =
	===============================================*/
	var last_scroll_top = 0,
	scroll_direction,
	scroll_distance,
	admin_bar,
	message_timer,
	admin_height;


	/* vars set for single product page */
	if ( document.querySelector( '.product-img-section' ) ) 
	{
		var product_img_section, product_img_section_height, wonka_single_product_img_area, summary_section, thumbnail_controls, slide_control, active_slide, active_slide_img, win_y, img_area_top, target_stop, one_click = true;
	}
	/*=====  End of vars set for script use  ======*/

	
	/**
	 * This is for the checkout multistep tabs 
	 * @author Rudy
	 * 
	 * @since 1.0.0
	 */
	if ( document.querySelector( '#wonka-checkout-nav-steps' ) ) 
	{
		var ship_ul = document.querySelector( 'ul#shipping_method' );
		var ship_method = document.querySelectorAll('input[name="shipping_method[0]"]');
		var multistep_links = document.querySelectorAll( '#wonka-checkout-nav-steps li a.nav-link' );
		var info_table_contact_cells = document.querySelectorAll( '.contact-email-cell' );
		var info_table_ship_cells = document.querySelectorAll( '.ship-to-address-cell' );
		var contact_change_links = document.querySelectorAll( '.contact-email-change-link' );
		var ship_to_change_links = document.querySelectorAll( '.ship-to-address-change-link' );
		var ship_method_change_links = document.querySelectorAll( '.ship-method-change-link' );
		var multistep_btns = document.querySelectorAll( '.wonka-multistep-checkout-btn' );

		/**
		 * Add Shipping method to current status table
		 * @author Carlos
		 *
		 * @since 1.0.0
		 */
		if(document.querySelector( '#wonka_payment_method_tab' ))
		{
			document.querySelector( '#wonka_payment_method_tab' ).addEventListener( 'click', function( event ) {
				event.preventDefault();

				/*================================================================
				=            Copying Shipping info to Billing info           =
				================================================================*/

				var billing_to_radios = document.querySelectorAll( 'input[name="ship_to_different_address"]' );
				var billing_address_form = document.querySelector( '.billing_address' );

				billing_to_radios.forEach( function( item, i ) 
					{
						
						item.addEventListener( 'change', function( event ) 
							{
								var target = event.target;
								if ( target.checked && target.id == 'bill-to-different-address-checkbox2' ) 
								{
									billing_address_form.classList.add( 'active' );
										copy_to_billing();
								}
								else
								{
									if ( billing_address_form.classList.contains( 'active' ) ) 
									{
										billing_address_form.classList.remove( 'active' );
										copy_to_billing();
									}
								}
								
							});
					});
				/*=====  End of Copying Shipping info to Billing info  ======*/

				var shippping_radios = document.querySelectorAll( 'input[name="shipping_method[0]"]' );
				shippping_radios.forEach( function( item, i ) {
					if ( item.checked ){
						var shipping_label = item.nextSibling.innerText;
						var ship_to_cells = document.querySelectorAll( '.ship-method-cell' );
						var checkout_total = document.querySelector( '.order-total td .woocommerce-Price-amount' );
						var money_symbol = document.querySelector( '.order-total td .woocommerce-Price-currencySymbol' );
					}
			});

			ship_ul.addEventListener('load', function( event ) {
				ship_method.forEach( function( item, i ) {
					item.addEventListener( 'change', function( event ) {
						var target = event.target;

						if (target.checked){
							var shipping_label = item.nextSibling.innerText;
							var ship_to_cells = document.querySelectorAll( '.ship-method-cell' );
							var checkout_total = document.querySelector( '.order-total td .woocommerce-Price-amount' );
							var money_symbol = document.querySelector( '.order-total td .woocommerce-Price-currencySymbol' );

							ship_to_cells.forEach( function( item, i ) 
							{
								item.innerHTML = shipping_label;
							});
						}	
					});
				});	
			});

		});
	}
		

		contact_change_links.forEach( function( item, i ) 
			{
				item.addEventListener( 'click', function( event ) 
					{
						event.preventDefault();
						document.querySelector( '#wonka_customer_information_tab' ).click();
					});
			});

		ship_to_change_links.forEach( function( item, i ) 
			{
				item.addEventListener( 'click', function( event ) 
					{
						event.preventDefault();
						document.querySelector( '#wonka_customer_information_tab' ).click();
					});
			});

		ship_method_change_links.forEach( function( item, i ) 
			{
				item.addEventListener( 'click', function( event ) 
					{
						event.preventDefault();
						document.querySelector( '#wonka_shipping_method_tab' ).click();
					});
			});

		multistep_links.forEach( function( item, i ) 
			{
				if ( item.classList.contains( 'active' ) ) 
				{
					item.classList.add( 'completed' );
				}

				item.addEventListener( 'click', function( event ) 
					{
						var target = event.target;
						if ( target.nodeName === 'SPAN' ) 
						{
							target = target.parentElement;
						}
						var completed_check = false;

						if ( target.id === 'wonka_shipping_method_tab' ) 
						{
							var get_shipping_set = document.querySelector( '#shipping_method' );
							
						}

						if ( !target.classList.contains( 'active' ) ) 
						{
							copy_to_billing();
							var leaving_panel = document.querySelector( '#wonka-checkout-steps2 .show.active' );
							var leaving_btns = document.querySelector( '#wonka-checkout-step-buttons .show.active' );
							var new_panel = document.querySelector( target.getAttribute( 'data-secondary' ) );
							var new_btns = document.querySelector( target.getAttribute( 'data-btns' ) );
							leaving_panel.classList.remove( 'show', 'active' );
							leaving_btns.classList.remove( 'show', 'active' );
							new_panel.classList.add( 'show', 'active' );
							new_btns.classList.add( 'show', 'active' );

							setTimeout( function() {
								var children_array = target.parentElement.parentElement.childNodes;
								
								children_array.forEach( function( item, i ) 
									{

										if ( completed_check === true ) 
										{
											if ( item.firstElementChild.classList.contains( 'completed' ) && item === children_array.lastElementChild ) 
											{
												setTimeout( function( cur_el ) 
													{
														cur_el.firstElementChild.classList.remove( 'completed' );
													}, 600, item );
											}
											else
											{
												item.firstElementChild.classList.remove( 'completed' );
											}
										}

										if ( completed_check === false ) 
										{
											if ( item === children_array.lastElementChild ) 
											{
												setTimeout( function( cur_el ) 
													{
														cur_el.firstElementChild.classList.add( 'completed' );
													}, 600, item );
											}
											else
											{
												item.firstElementChild.classList.add( 'completed' );
											}

											if ( item.firstElementChild.classList.contains( 'active' ) ) 
											{
												completed_check = true;
											}
										}
									});
							}, 250 );
						}
					});
			});

		multistep_btns.forEach( function( item, i ) 
			{
				item.addEventListener( 'click', function( e ) 
					{
						if ( e.target.getAttribute( 'data-target' ) !== '#cart' ) 
						{
							e.preventDefault();
							document.querySelector( e.target.getAttribute( 'data-target' ) ).click();
						}
					});
			});
	}
	/*=====  End of This is for the checkout multistep tabs  ======*/

	/*===================================================================
	=            This is area for writing callable functions            =
	===================================================================*/
	/*===== This is for Keyfeatures | Product Specs links on shor description ====*/
	function scrollToSection( scroll_to_id ) 
	{
		var current_el = document.querySelector( '#' + scroll_to_id );
  		current_el.scrollIntoView({behavior: 'smooth'});
	}

	function load_page_vars() 
	{
		if ( document.querySelector( '.product-img-section' ) ) 
		{
			product_img_section = document.querySelector( '.product-img-section' );
			product_img_section_height = document.querySelector( '.product-img-section' ).offsetHeight;
			wonka_single_product_img_area = document.querySelector( '.wonka-single-product-img-area' );
			thumbnail_controls = document.querySelector( 'div.wonka-thumbnails' );
			summary_section = document.querySelector( '.summary.entry-summary' );
		}
	}

	function one_click_timer() 
	{
		setTimeout( function() 
			{
				one_click = true;
			}, 400 );
	}

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
	  		document.querySelector( '#searchform input[name="s"]' ).focus();
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
		var parallax_adjust, slide_imgs;

		// Get the offset position of the navbar
		var sticky = shop_section.offsetTop;

		if ( window.pageYOffset > last_scroll_top ) 
		{
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
			parallax_adjust = parseFloat( ( window.pageYOffset - top_slider_section.offsetTop ) / ( top_slider_section.offsetHeight / 2 ) ).toFixed( 5 );
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

	function stickyThumbnails() 
	{
		img_area_top = product_img_section.parentElement.offsetTop + wonka_single_product_img_area.offsetTop;
		target_stop = wonka_single_product_img_area.offsetHeight - thumbnail_controls.offsetHeight;
		win_y = window.pageYOffset;

		if ( window.innerWidth > 792 && win_y < img_area_top ) 
		{
			thumbnail_controls.classList.remove( 'sticky-on' );
			thumbnail_controls.removeAttribute( 'style' );
		}
		else if ( window.innerWidth > 792 && win_y - img_area_top > target_stop ) 
		{
			thumbnail_controls.style.top = target_stop + 'px';
			thumbnail_controls.classList.remove( 'sticky-on' );
		}
		else if ( window.innerWidth > 792 )
		{
			if ( document.querySelector( '#wpadminbar' ) ) 
			{
				admin_bar = document.querySelector( '#wpadminbar' );
				admin_height = document.querySelector( '#wpadminbar' ).offsetHeight;
				
				if ( getComputedStyle( admin_bar ).position == 'absolute' && window.pageYOffset > admin_height ) 
				{
					thumbnail_controls.classList.add( 'sticky-on' );
					thumbnail_controls.style.top = 30 + 'px';
				}
				else
				{
					thumbnail_controls.classList.add( 'sticky-on' );
					thumbnail_controls.style.top = admin_height + 30 + 'px';
				}
			}
			else
			{
				thumbnail_controls.classList.add( 'sticky-on' );
				thumbnail_controls.style.top = 30 + 'px';
			}
		}

	}

	function stickySummary() 
	{
		img_area_top = product_img_section.parentElement.offsetTop + wonka_single_product_img_area.offsetTop;
		target_stop = wonka_single_product_img_area.offsetHeight - summary_section.offsetHeight;
		win_y = window.pageYOffset;

		if ( window.innerWidth > 792 && win_y < img_area_top ) 
		{
			summary_section.classList.remove( 'sticky-on' );
			summary_section.removeAttribute( 'style' );
		}
		else if ( window.innerWidth > 792 && win_y - img_area_top > target_stop ) 
		{
			summary_section.style.top = target_stop + 'px';
			summary_section.classList.remove( 'sticky-on' );
		}
		else if ( window.innerWidth > 792 )
		{
			if ( document.querySelector( '#wpadminbar' ) ) 
			{
				admin_bar = document.querySelector( '#wpadminbar' );
				admin_height = document.querySelector( '#wpadminbar' ).offsetHeight;
				
				if ( getComputedStyle( admin_bar ).position == 'absolute' && window.pageYOffset > admin_height ) 
				{
					summary_section.classList.add( 'sticky-on' );
					summary_section.style.top = 30 + 'px';
				}
				else
				{
					summary_section.classList.add( 'sticky-on' );
					summary_section.style.top = admin_height + 30 + 'px';
				}
			}
			else
			{
				summary_section.classList.add( 'sticky-on' );
				summary_section.style.top = 30 + 'px';
			}
		}

	}

	function imageZoom(imgID, resultID) 
	{
	  var img, lens, result, cx, cy;
	  img = document.getElementById(imgID);
	  result = document.getElementById(resultID);
	  /*create lens:*/
	  lens = document.createElement("DIV");
	  lens.setAttribute("class", "img-zoom-lens");
	  /*insert lens:*/
	  img.parentElement.insertBefore(lens, img);
	  /*calculate the ratio between result DIV and lens:*/
	  cx = result.offsetWidth / lens.offsetWidth;
	  cy = result.offsetHeight / lens.offsetHeight;
	  /*set background properties for the result DIV:*/
	  result.style.backgroundImage = "url('" + img.src + "')";
	  result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
	  /*execute a function when someone moves the cursor over the image, or the lens:*/
	  lens.addEventListener("mousemove", moveLens);
	  img.addEventListener("mousemove", moveLens);
	  /*and also for touch screens:*/
	  lens.addEventListener("touchmove", moveLens);
	  img.addEventListener("touchmove", moveLens);
	  function moveLens(e) 
	  {
	    var pos, x, y;
	    /*prevent any other actions that may occur when moving over the image:*/
	    e.preventDefault();
	    /*get the cursor's x and y positions:*/
	    pos = getCursorPos(e);
	    /*calculate the position of the lens:*/
	    x = pos.x - (lens.offsetWidth / 2);
	    y = pos.y - (lens.offsetHeight / 2);
	    /*prevent the lens from being positioned outside the image:*/
	    if (x > img.width - lens.offsetWidth) { x = img.width - lens.offsetWidth; }
	    if (x < 0) { x = 0; }
	    if (y > img.height - lens.offsetHeight) { y = img.height - lens.offsetHeight; }
	    if (y < 0) { y = 0; }
	    /*set the position of the lens:*/
	    lens.style.left = x + "px";
	    lens.style.top = y + "px";
	    /*display what the lens "sees":*/
	    result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
	  }
	  function getCursorPos(e) 
	  {
	    var a, x = 0, y = 0;
	    e = e || window.event;
	    /*get the x and y positions of the image:*/
	    a = img.getBoundingClientRect();
	    /*calculate the cursor's x and y coordinates, relative to the image:*/
	    x = e.pageX - a.left;
	    y = e.pageY - a.top;
	    /*consider any page scrolling:*/
	    x = x - window.pageXOffset;
	    y = y - window.pageYOffset;
	    return {x : x, y : y};
	  }
	}

	function setup_for_reviews( comment_list )
	{
		var first_three_height = 0;
		for (var i = 0; i < comment_list.children.length; i++) 
		{
			first_three_height += comment_list.children[i].offsetHeight + 15;
			if ( i === 2 ) 
			{
				comment_list.style.height = first_three_height + 'px';
				return first_three_height;
			}

			if ( i === comment_list.children.length - 1 ) 
			{
				comment_list.style.height = first_three_height + 'px';
				return first_three_height;
			}
		}
	}

	function set_message_timer( message, wrapper )
	{
		clearTimeout( message_timer );

		wrapper.innerHTML = '<span class="wonka-express-checkout-message">' + message + '</span>';
		document.querySelector( '.wonka-express-checkout-message' ).scrollIntoView( {behavior: 'smooth'} );
		message_timer = setTimeout( function( wrapper ) 
			{
				document.querySelector( '.wonka-express-checkout-message' ).style.opacity = 0;
				setTimeout( function( wrapper ) 
					{
						wrapper.innerHTML = '';
					}, 2500, wrapper );
			}, 3000, wrapper );
	}


	/*----------  Copying the shipping fields to billing  ----------*/
	function copy_to_billing() {
		var email = document.getElementsByName("shipping_email")[0].value;
		var first_name = document.getElementsByName("shipping_first_name")[0].value;
		var last_name = document.getElementsByName("shipping_last_name")[0].value;
		var company = document.getElementsByName("shipping_company")[0].value;
		var address_1 = document.getElementsByName("shipping_address_1")[0].value;
		var address_2 = document.getElementsByName("shipping_address_2")[0].value;
		var city = document.getElementsByName("shipping_city")[0].value;
		var state = document.getElementById("shipping_state").value;
		var postcode = document.getElementsByName("shipping_postcode")[0].value;
		var phone = document.getElementsByName("shipping_phone")[0].value;
		var contact_cells = document.querySelectorAll( '.contact-email-cell' );
		var ship_to_cells = document.querySelectorAll( '.ship-to-address-cell' );

		contact_cells.forEach( function( item, i ) 
			{
				item.innerText = email;
			});

		ship_to_cells.forEach( function( item, i ) 
			{
				item.innerHTML = '<span class="address-number">' +address_1 + ' ' + address_2 + '</span> <span class="city-state-zip">' + city + ', ' + state + ' ' + postcode + '</span>';
			});

		if ( document.getElementById( 'bill-to-different-address-checkbox2' ).checked === true ) 
		{
			console.log( 'entered make blank form' );
			document.getElementsByName("billing_email")[0].value = '';
			document.getElementsByName("billing_first_name")[0].value = '';
			document.getElementsByName("billing_last_name")[0].value = '';
			document.getElementsByName("billing_company")[0].value = '';
			document.getElementsByName("billing_address_1")[0].value = '';
			document.getElementsByName("billing_address_2")[0].value = '';
			document.getElementsByName("billing_city")[0].value = '';
			document.getElementById("billing_state").value = '';
			document.getElementsByName("billing_postcode")[0].value = '';
			document.getElementsByName("billing_phone")[0].value = '';
		}
		else
		{
			document.getElementsByName("billing_email")[0].value = email;
			document.getElementsByName("billing_first_name")[0].value = first_name;
			document.getElementsByName("billing_last_name")[0].value = last_name;
			document.getElementsByName("billing_company")[0].value = company;
			document.getElementsByName("billing_address_1")[0].value = address_1;
			document.getElementsByName("billing_address_2")[0].value = address_2;
			document.getElementsByName("billing_city")[0].value = city;
			document.getElementById("billing_state").value = state;
			document.getElementsByName("billing_postcode")[0].value = postcode;
			document.getElementsByName("billing_phone")[0].value = phone;
		}

	} 

	function single_product_variants_setup()
	{
		var thumb_lis = document.querySelectorAll( 'div.wonka-thumbnails li');
		var variant_lis = document.querySelectorAll( 'ul[data-attribute_name="attribute_pa_color"] li');
		var all_imgs = document.querySelectorAll( '.woocommerce-product-gallery__wrapper img');

		variant_lis.forEach( function( item, i ) 
			{
				item.addEventListener( 'click', function( event ) 
				{
					event.preventDefault();
					var variant = event.target;
					if ( variant.nodeName === 'SPAN' ) 
					{
						variant = variant.parentElement;
					}

					var variant_selected = variant.getAttribute( 'data-value' );
					if ( variant_selected ) 
					{
						all_imgs.forEach( function( img, i ) 
							{
								var img_variant = img.getAttribute( 'data-variant-color' );
								if ( variant_selected === img_variant ) 
								{
									img.classList.add( 'variant-show' );
								}

								if ( variant_selected !== img_variant && img.classList.contains( 'variant-show' ) )
								{
									img.classList.remove( 'variant-show' );
								}
							});
					}
				});
			});

		thumb_lis.forEach( function( item, i ) 
			{
				item.addEventListener( 'click', function( event ) 
					{
						event.preventDefault();
						var el = event.target;
						if ( el.nodeName === 'IMG' )
						{
							el = el.parentElement;
						}
						var el_scroll_to_id = el.getAttribute( 'href' ).replace( '#', '' );
						scrollToSection( el_scroll_to_id );
					});
			});
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
		/*========================================================
		=            This loads the vars for the page            =
		========================================================*/
		load_page_vars();
		/*=====  End of This loads the vars for the page  ======*/
		
		/*===========================================================================================
		=            This makes the adjustment of space for the footer to show correctly            =
		===========================================================================================*/
		footer_adjustment();
		/*=====  End of This makes the adjustment of space for the footer to show correctly  ======*/

		/*===============================================================================
		=            This is the setup for the Wonka Express Checkout Button            =
		===============================================================================*/
		if ( document.querySelector( 'body.woocommerce-checkout' ) ) 
		{
			

			// $.ajax( {
			// 	type:     'post',
			// 	url:      get_url( 'update_shipping_method' ),
			// 	data:     data,
			// 	dataType: 'html',
			// 	success:  function( response ) {
			// 		update_cart_totals_div( response );
			// 	},
			// 	complete: function() {
			// 		unblock( $( 'div.cart_totals' ) );
			// 		$( document.body ).trigger( 'updated_shipping_method' );
			// 	}
			// } );

		}

		/*==========================================================
		=            This is for setting up the reviews            =
		==========================================================*/
		if ( document.querySelector( '#reviews' ) ) 
		{

			var write_review = document.querySelector( '#write-review' ),
			comment_form = document.querySelector( '#commentform' ),
			reviews_top = document.querySelector( '.wonka-section-reviews' ),
			more_reviews,
			comment_list,
			get_custom_height;

			if ( document.querySelector( 'ol.commentlist' ) ) 
			{
				comment_list = document.querySelector( 'ol.commentlist' );
				get_custom_height = setup_for_reviews( comment_list );
			}

			if ( document.querySelector( '#more-reviews' ) ) 
			{
				more_reviews = document.querySelector( '#more-reviews' );

				more_reviews.addEventListener( 'click', function(e) 
					{
						e.preventDefault();
						if ( get_custom_height < comment_list.offsetHeight ) 
						{
							setup_for_reviews( comment_list );
							setTimeout( function( comment_list ) 
								{
									reviews_top.scrollIntoView({behavior: 'smooth'});
								}, 500, comment_list );
							more_reviews.innerText = 'More Reviews';
						}
						else
						{
							comment_list.style.height = 100 + '%';
							more_reviews.innerText = 'Less Reviews';
						}
					});
			}



			write_review.addEventListener( 'click', function(e) 
				{
					e.preventDefault();
					if ( getComputedStyle( comment_form ).height === '0px' || comment_form.style.height === 100 + 'px' ) 
					{
						comment_form.style.height = 100 + '%';
						comment_form.style.opacity = 1;
					}
					else
					{
						comment_form.style.height = 0;
						comment_form.style.opacity = 0;
					}
				});
		}
		/*=====  End of This is for setting up the reviews  ======*/
		

		/*============================================================================================
		=            This is for reordering the placement of elements in add to cart area            =
		============================================================================================*/
		if ( document.querySelector( '.summary.entry-summary' ) ) 
		{
			var entry_summary = document.querySelector( '.summary.entry-summary' );
			var table = document.querySelector( '.variations' );
			var table_body = document.querySelector( '.variations tbody' );
			var color_label_row = document.querySelector( '.variations .label' ).parentElement;
			var color_label_cell = document.createElement( 'TH' );
			var color_label_cell_old = document.querySelector( '.variations .label' );
			var color_label = document.querySelector( '.variations .label label' );
			var color_new_swatches_row = document.createElement( 'TR' );
			var color_swatches_cell = document.querySelector( '.variations .value' );
			var qty_label = document.createElement( 'TH' );
			var qty_label_text = '<span>Quantity</span>';
			var qty_cell = document.createElement( 'TD' );
			var qty_box = document.querySelector( '.woocommerce-variation-add-to-cart .quantity' );
			var colors_ul = document.querySelector( '.variations .value .color-variable-wrapper' );
			var clear_li = document.createElement( 'LI' );
			var clear_btn = document.querySelector( '.variations .value .reset_variations' );

			color_label_cell.className = "label";
			qty_label.className = "qty-label";
			qty_cell.className = "qty-cell";
			qty_label.innerHTML = qty_label_text;
			color_label_cell.appendChild( color_label );
			color_label_row.appendChild( color_label_cell );
			color_label_row.appendChild( qty_label );
			color_label_cell_old.remove();
			color_new_swatches_row.appendChild( color_swatches_cell );
			color_new_swatches_row.appendChild( qty_cell );
			qty_cell.appendChild( qty_box );

			table_body.appendChild( color_new_swatches_row );
			colors_ul.appendChild( clear_li );
			clear_li.appendChild( clear_btn );
			table.classList.add( 'table' );
			entry_summary.classList.add( 'loaded' );

		}
		/*=====  End of This is for reordering the placement of elements in add to cart area  ======*/

		/*========================================================================================
		=            This will move paypal checkout buttons into express checkout box            =
		========================================================================================*/
		if ( document.querySelector( 'div.wonka-row-express-checkout-btns div.express-checkout-btns' ) ) 
		{
			var express_box = document.querySelector( 'div.wonka-row-express-checkout-btns div.express-checkout-btns' );
		
			if ( document.querySelector( '#checkout_paypal_message' ) ) 
			{
				var iframe_btns = document.querySelector( '.angelleye_smart_button_checkout_top' );

				express_box.appendChild( iframe_btns );	
			}

			if ( document.querySelector( '#pay_with_amazon' ) ) 
			{
				var amazon_quick = document.querySelector( '#pay_with_amazon' );

				express_box.appendChild( amazon_quick );
			}
		}
		/*=====  End of This will move paypal checkout buttons into express checkout box  ======*/
		
		
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
		if ( document.querySelector( 'body.home' ) ) 
		{
			// When the user scrolls the page, execute stickyStatus 
			window.onscroll = function() { stickyStatus(); };
		}
		/*=====  End of For Sticky Header  ======*/
		
		/*===============================================
		=            For single product page            =
		===============================================*/
		if ( document.querySelector( 'body.single-product' ) ) 
		{	
			$('body.single-product').scrollspy({ target: ".navbar", offset: 30 });
			single_product_variants_setup();
			
			/*----------  For variant products  ----------*/
			if ( document.querySelector( 'div.wonka-express-checkout-wrap' ) ) 
			{
				/*----------  loading vars  ----------*/
				var express_btn_wrap = document.querySelector( 'div.wonka-express-checkout-wrap' ),
				express_btn = document.querySelector( 'a#express_checkout_btn' ),
				express_attributes = JSON.parse( document.querySelector( '.variations_form.cart' ).getAttribute( 'data-product_variations' ) ),
				express_variants = {},
				express_variant_id = 0,
				express_qty = document.querySelector( '.quantity input[type="number"]' ),
				express_btn_notice_wrapper = document.querySelector( '.woocommerce-notices-wrapper' ),
				express_notice_text = '',
				express_btn_href = express_btn.href,
				variant = [],
				attribute_count = 0;
				/*===================================================
				=            setting up the variant list            =
				===================================================*/
				express_attributes.forEach( function( express_attribute, i ) 
					{
						var attribute = Object.keys( express_attribute.attributes )[0];

						if ( !( 'variants' in express_variants ) ) 
						{
							var variants_array = [];

							if ( !variants_array.includes( attribute )  ) 
							{
								attribute_count++;
								variants_array.push( attribute );
							}
							express_variants.variants = variants_array;
							express_variants.variant_count = attribute_count;
						}
					});
				/*=====  End of setting up the variant list  ======*/
				/*========================================================
				=            This is the click event function            =
				========================================================*/
				express_btn.addEventListener( 'click', function(e)
					{
						e.preventDefault();
						var target = e.target;
						express_variants.variants.forEach( function( item, w ) 
							{
								variant[item] = document.querySelector( '[name="' + item + '"]');
							});
						
						for ( var v in variant )
						{
							if ( !variant[v].value ) 
							{
								express_notice_text = 'Please select a product variation in order to checkout!';
								
								set_message_timer( express_notice_text, express_btn_notice_wrapper );

							}
							else
							{
								express_btn_notice_wrapper.innerHTML =  '';
								for (var i in express_attributes )
								{
									if ( express_attributes[i].attributes[v] === variant[v].value ) 
									{
										express_variant_id = express_attributes[i].variation_id;
										if ( express_attributes[i].is_in_stock ) 
										{
											express_btn.href = express_btn_href + express_variant_id + '&quantity=' + express_qty.value;
											window.location = express_btn.href;
										}
										else
										{
											express_notice_text = 'Product variation is currently out of stock.';

											set_message_timer( express_notice_text, express_btn_notice_wrapper );
										}
									}
								}
							}
						}
					});
				/*=====  End of This is the click event function  ======*/
				
			}
			/*=====  End of This is the setup for the Wonka Express Checkout Button  ======*/

			img_area_top = product_img_section.parentElement.offsetTop + wonka_single_product_img_area.offsetTop;

			if ( window.pageYOffset > document.querySelector( '#main' ).offsetTop ) 
			{
				scrollToSection( 'main' );
			}
			// When the user scrolls the page, execute stickyStatus 
			window.onscroll = function(e) 
			{ 
				stickyThumbnails();
				stickySummary();
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
			  autoplaySpeed: 4000,
			  pauseOnFocus: false,
			  pauseOnHover: false,
			  fade: true,
			  dots: false,
			  arrows: true,
			  appendArrows: $( '.top-page-slider-wrap .slick-list' ),
			  prevArrow: '<button class="slick-prev" type="button"><i class="far fa-arrow-alt-circle-left"></i></button>',
			  nextArrow: '<button class="slick-next" type="button"><i class="far fa-arrow-alt-circle-right"></i></button>',
			});
		}

		if ( document.querySelector( '.desirable-slider-section' ) ) 
		{
			
			$( '.cta-section-slider-wrap' ).slick({
			  slidesToShow: 1,
			  slidesToScroll: 1,
			  autoplay: true,
			  autoplaySpeed: 4000,
			  pauseOnFocus: false,
			  pauseOnHover: false,
			  fade: true,
			  dots: false,
			  arrows: true,
			  appendArrows: $( '.cta-section-slider-wrap .slick-list' ),
			  prevArrow: '<button class="slick-prev" type="button"><i class="far fa-arrow-alt-circle-left"></i></button>',
			  nextArrow: '<button class="slick-next" type="button"><i class="far fa-arrow-alt-circle-right"></i></button>',
			});
		}

		if ( document.querySelector( 'body.home .instagram-wrap') ) 
		{
			$( 'body.home .instagram-wrap' ).slick({
			  slidesToShow: 4,
			  slidesToScroll: 1,
			  autoplay: true,
			  autoplaySpeed: 4000,
			  dots: false,
			  prevArrow: '<button class="slick-prev" type="button"><i class="far fa-arrow-alt-circle-left"></i></button>',
			  nextArrow: '<button class="slick-next" type="button"><i class="far fa-arrow-alt-circle-right"></i></button>',
			  responsive: [
    			{
			      breakpoint: 1024,
			      settings: {
			        slidesToShow: 3,
			        slidesToScroll: 3,
			      }
			    },
			    {
			      breakpoint: 600,
			      settings: {
			        slidesToShow: 2,
			        slidesToScroll: 2
			      }
			    },
			    {
			      breakpoint: 480,
			      settings: {
			        slidesToShow: 1,
			        slidesToScroll: 1
			      }
		        }
		      ],
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
		/*===================================================================================
		=            This is for single product page short description scrolling            =
		===================================================================================*/
			if ( document.getElementById( 'key-features-link' ) ) 
			{
				var key_fea_jump = document.getElementById( 'key-features-link' );

				key_fea_jump.addEventListener( 'click', function( e ) 
					{
						e.preventDefault();
						if ( e.target.tagName.toLowerCase() === 'a') 
						{
							one_click = false;
							scrollToSection( 'product-statement' );
						}
					} );
			}

			if ( document.getElementById( 'product-specs-link' ) ) 
			{
				var spec_jump = document.getElementById( 'product-specs-link' );

				spec_jump.addEventListener( 'click', function( e ) 
					{
						e.preventDefault();
						if ( e.target.tagName.toLowerCase() === 'a') 
						{
							one_click = false;
							scrollToSection( 'product-statement' );
						}
					} );
			}

			if ( document.getElementById( 'review-link' ) ) 
			{
				var reviews_jump = document.getElementById( 'review-link' );

				reviews_jump.addEventListener( 'click', function( e ) 
					{
						e.preventDefault();
						if ( e.target.tagName.toLowerCase() === 'a') 
						{
							one_click = false;
							scrollToSection( 'reviews' );
						}
					} );
			}
		/*=====  End of This is for single product page short description scrolling  ======*/
		

	};
	/*=====  End of This is for running after document is ready  ======*/
})(jQuery);