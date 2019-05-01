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
	admin_height,
	xhr = new XMLHttpRequest();



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
		if( document.querySelector( '#wonka_payment_method_tab' ) )
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
						console.log( target );
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

		var cybersource_form_field_group = document.querySelectorAll( '.payment_box.payment_method_cybersource .form-row' );
		cybersource_form_field_group.forEach( function( field_group, i ) 
			{
				var new_container, new_row_container;
				if ( i === 0 )
				{
					new_container = document.createElement( 'DIV' );
					new_container.classList.add( 'form-group', 'form-row' );
					new_container.innerHTML = field_group.innerHTML;
					field_group.parentElement.insertBefore( new_container, field_group );
					field_group.remove();
				}

				if ( i === 1 ) 
				{
					new_row_container = document.createElement( 'DIV' );
					new_row_container.classList.add( 'form-row', 'form-inline', 'justify-content-between', 'wonka-form-row' );
					new_container = document.createElement( 'DIV' );
					new_container.classList.add( 'form-group' );
					new_container.innerHTML = field_group.innerHTML;
					new_row_container.appendChild( new_container );
					field_group.parentElement.insertBefore( new_row_container, field_group );
					field_group.remove();
				}

				if ( i > 1 ) 
				{
					new_container = document.createElement( 'DIV' );
					new_container.classList.add( 'form-group', 'form-inline' );
					new_container.innerHTML = field_group.innerHTML;
					field_group.parentElement.querySelector( '.wonka-form-row' ).appendChild( new_container );
					field_group.parentElement.querySelector( '.clear' ).remove();
					field_group.remove();
				}
			});
		
		var cybersource_labels = document.querySelectorAll( '.payment_box.payment_method_cybersource label' );
		cybersource_labels.forEach( function( label, i ) 
			{
				label.classList.add( 'sr-only' );
			});

		var cybersource_inputs = document.querySelectorAll( '.payment_box.payment_method_cybersource input' );
		cybersource_inputs.forEach( function( input, i ) 
			{
				input.classList.add( 'form-control' );
				if ( input.id === 'cybersource_cvNumber' ) 
				{
					input.setAttribute( 'placeholder', 'CCV' );
				}
				else
				{
					input.setAttribute( 'placeholder', input.parentElement.querySelector( 'label' ).innerText );
				}
			});

		var cybersource_select_boxes = document.querySelectorAll( '.payment_box.payment_method_cybersource select' );
		cybersource_select_boxes.forEach( function( select, i ) 
			{
				select.classList.add( 'form-control' );
				if ( select.name === 'cybersource_cardType' ) 
				{
					select.firstElementChild.innerText = select.parentElement.querySelector( 'label' ).innerText;
				}

				if ( select.name === 'cybersource_expirationMonth' ) 
				{
					select.style.marginRight = 15 + 'px';
				}
			});
		
		multistep_btns.forEach( function( item, i ) 
			{
				item.addEventListener( 'click', function( e ) 
					{
						var next_tab;
						if ( e.target.getAttribute( 'data-target' ) === '#wonka_shipping_method_tab' ) 
						{
							e.preventDefault();
							console.log( e.target );
							var shipping_form_fields = document.querySelectorAll( '.woocommerce-shipping-fields input' );
							var validation_checker = true;
							var field_count = shipping_form_fields.length;
							next_tab = document.querySelector( e.target.getAttribute( 'data-target' ) );
							shipping_form_fields.forEach( function( input, i ) 
								{
									if ( input.name !== 'shipping_company' && input.name !== 'shipping_address_2' ) 
									{
										input.required = true;
										if ( input.reportValidity() === false ) 
										{
											validation_checker = false;
											input.classList.add( 'is-invalid' );
										}
										else
										{
											if ( input.reportValidity() && input.classList.contains( 'is-invalid' ) ) 
											{
												input.classList.remove( 'is-invalid' );
											}
										}

									}

									if ( i === field_count - 1 && validation_checker )
									{
										next_tab.classList.remove( 'disabled' );
										next_tab.click();
									}
								});
						}

						if ( e.target.getAttribute( 'data-target' ) === '#wonka_payment_method_tab' ) 
						{
							e.preventDefault();
							next_tab = document.querySelector( e.target.getAttribute( 'data-target' ) );
							ship_method.forEach( function( method, i ) 
								{
									if ( method.selected ) 
									{
										next_tab.classList.remove( 'disabled' );
										next_tab.click();
									}
								});
						}
					});
			});
	}
	/*=====  End of This is for the checkout multistep tabs  ======*/

	/*===================================================================
	=            This is area for writing callable functions            =
	===================================================================*/

	function wonka_ajax_request( xhr, action, data ) 
	{
		if ( action === "search_site" ) 
		{
			var search_results = document.createElement( 'DIV' );
			var search_field = document.querySelector( 'input#s' );
			var search_close = document.querySelector( 'span.closebtn' );
			var data_value;
			var field_position;
		

			search_results.classList.add( 'autocomplete-suggestions' );
			document.querySelector( 'body' ).appendChild( search_results );
			search_field.setAttribute( 'autocomplete', 'off' );
	
			search_field.addEventListener( 'focus', function () 
			{
				xhr.onreadystatechange = function() 
				{
					if ( this.readyState == 4 && this.status == 200 ) 
					{
					
						var response = JSON.parse( this.responseText );
						field_position = search_field.getBoundingClientRect();
		
						search_field.addEventListener( 'keyup', function() 
							{
								data_value = search_field.value;
								search_results.innerHTML = '';
								if ( search_field.value.length >= 2 ) 
								{
									response.data.forEach( function( item, i )
										{
											if ( item.toLowerCase().match( search_field.value.toLowerCase() ) ) 
											{
												var title_element = document.createElement( 'DIV' );
												title_element.classList.add( 'autocomplete-suggestion' );
												title_element.setAttribute( 'data-index', i );
												title_element.innerText = item;
												search_results.appendChild( title_element );
												title_element.addEventListener( 'mouseover', function() 
													{
														search_field.value = title_element.innerText;
													});
												title_element.addEventListener( 'mouseleave', function() 
													{
														search_field.value = data_value;
													});
												title_element.addEventListener( 'click', function(e) 
													{
														search_field.value = title_element.innerText;
														data_value = search_field.value;
														search_results.style.display = 'none';
														search_results.style.position = '';
														search_results.style.width = '';
														search_results.style.left = '';
														search_results.style.top = '';
													});
											}
										});
		
									if ( document.querySelector( '.autocomplete-suggestions' ).hasChildNodes() ) 
									{
										search_results.style.display = 'block';
										search_results.style.position = 'fixed';
										search_results.style.width = field_position.width.toFixed(2) + 'px';
										search_results.style.left = field_position.x.toFixed(2) + 'px';
										search_results.style.top = field_position.bottom.toFixed(2) + 'px';
									}
								}
							});
					}	
				};
		
				xhr.open('GET', wonkasoft_request.ajax + "?" + "action=" + action + "&security=" + wonkasoft_request.security);
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.send();
			});
			search_close.addEventListener( 'click', function () 
			{
				search_results.style.display = 'none';
				search_results.style.position = '';
				search_results.style.width = '';
				search_results.style.left = '';
				search_results.style.top = '';
			});
		}
		
		if ( action === "shipping_field_validation" ) 
		{
			xhr.onreadystatechange = function() {

				if ( this.readyState == 4 && this.status == 200 ) 
				{
					var response = JSON.parse( this.responseText );
				}
			};
			xhr.open('GET', wonkasoft_request.ajax + "?" + "action=" + action + "&security=" + wonkasoft_request.security);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send();
		}

	}
	/*===== This is for Keyfeatures | Product Specs links on shor description ====*/
	function scrollToSection( scroll_to_id, adjustment ) 
	{
		var current_el = document.querySelector( '#' + scroll_to_id );
  		current_el.scrollIntoView( { behavior: "smooth" } );
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
		top_slide_img_holder = top_slide.querySelectorAll( '.top-slide-img-holder' )[0],
		cta_slider_section = document.querySelector( '.desirable-slider-section' ),
		img_for_sizing = new Image(),
		adjustment,
		height_set;

		img_for_sizing.src = 'https:' + top_slide_img_holder.getAttribute( 'data-img-url' );
		img_for_sizing.style.width = window.innerWidth + 'px';
		console.log(getComputedStyle( img_for_sizing ) );
		if ( document.querySelector( '#wpadminbar' ) )
		{
			adjustment -= document.querySelector( '#wpadminbar' ).offsetHeight;
		}

		header_slider_section.style.height = adjustment + 'px';
		cta_slider_section.style.height = adjustment + 'px';
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


	function shifting_parallax() 
	{	
		var top_slider_section = document.querySelector( '.header-slider-section' );
		var cta_section = document.querySelector( '.desirable-slider-section' );
		var parallax_adjust, slide_imgs;

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
		
	}

	function stickyThumbnails() 
	{
		img_area_top = product_img_section.parentElement.offsetTop + wonka_single_product_img_area.offsetTop - 40;
		target_stop = wonka_single_product_img_area.offsetHeight - thumbnail_controls.offsetHeight;
		var scrolling_spacer = document.querySelector( 'div.sticky-spacer' );
		win_y = window.pageYOffset;

		if ( win_y < img_area_top ) 
		{
			thumbnail_controls.classList.remove( 'sticky-on' );
			thumbnail_controls.removeAttribute( 'style' );
			scrolling_spacer.classList.remove( 'spacing-now' );
			scrolling_spacer.removeAttribute( 'style' );
		}
		else if ( win_y - img_area_top > target_stop ) 
		{
			thumbnail_controls.style.top = target_stop + 'px';
			thumbnail_controls.classList.remove( 'sticky-on' );
			scrolling_spacer.style.top = target_stop + 'px';
			scrolling_spacer.classList.remove( 'spacing-now' );
		} 
		else
		{
			if ( document.querySelector( '#wpadminbar' ) ) 
			{
				admin_bar = document.querySelector( '#wpadminbar' );
				admin_height = document.querySelector( '#wpadminbar' ).offsetHeight;
				
				if ( getComputedStyle( admin_bar ).position == 'absolute' && window.pageYOffset > admin_height ) 
				{
					thumbnail_controls.classList.add( 'sticky-on' );
					thumbnail_controls.style.top = 30 + 'px';
					scrolling_spacer.classList.add( 'spacing-now' );
					scrolling_spacer.style.top = 0;
				}
				else
				{
					thumbnail_controls.classList.add( 'sticky-on' );
					thumbnail_controls.style.top = admin_height + 30 + 'px';
					scrolling_spacer.classList.add( 'spacing-now' );
					scrolling_spacer.style.top = admin_height + 'px';
				}
			}
			else
			{
				thumbnail_controls.classList.add( 'sticky-on' );
				thumbnail_controls.style.top = 30 + 'px';
				scrolling_spacer.classList.add( 'spacing-now' );
				scrolling_spacer.style.top = 0;
			}
		} 
	}

	function stickySummary() 
	{
		img_area_top = product_img_section.parentElement.offsetTop + wonka_single_product_img_area.offsetTop - 40;
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
			first_three_height += comment_list.children[i].offsetHeight;
			if ( i === 2 ) 
			{
				comment_list.style.height = first_three_height + 'px';
				break;
			}

			if ( i === comment_list.children.length - 1 ) 
			{
				comment_list.style.height = first_three_height + 'px';
				break;
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
		var variant_lis = document.querySelectorAll( 'ul[data-attribute_name="attribute_pa_color"] li');
		var thumb_lis = document.querySelectorAll( 'div.wonka-thumbnails [data-variant-check="true"]');
		var thumb_lis_parent = document.querySelector( 'div.wonka-thumbnails ul');
		var full_imgs = document.querySelectorAll( 'div.wonka-image-viewer [data-variant-check="true"]');
		var full_imgs_parent = document.querySelector( 'div.wonka-image-viewer');
		var variant_selected;
		var thumbs_set;
		var imgs_set;

		variant_lis.forEach( function( item, i ) 
			{	
				if ( item.classList.contains( 'selected' ) ) 
				{
					variant_selected = item.getAttribute( 'data-value' );

					full_imgs_parent.innerHTML = '';
					full_imgs.forEach( function( img_tainers, i ) 
						{
							if ( i === 0 ) 
							{
								img_tainers.setAttribute( 'data-variant-color', variant_selected );
							}

							if ( img_tainers.getAttribute( 'data-variant-color' ) === variant_selected ) 
							{
								img_tainers.classList.add( 'variant-show' );
								full_imgs_parent.appendChild( img_tainers );
							}

							if ( img_tainers.getAttribute( 'data-variant-color' ) !== variant_selected && img_tainers.classList.contains( 'variant-show' ) ) 
							{
								img_tainers.classList.remove( 'variant-show' );
							}
						});

					thumb_lis_parent.innerHTML = '';
					thumb_lis.forEach( function( img_tainers, i ) 
						{
							if ( img_tainers.getAttribute( 'data-variant-color' ) === variant_selected ) 
							{
								img_tainers.classList.add( 'variant-show' );
								thumb_lis_parent.appendChild( img_tainers );
							}

							if ( img_tainers.getAttribute( 'data-variant-color' ) !== variant_selected && img_tainers.classList.contains( 'variant-show' ) ) 
							{
								img_tainers.classList.remove( 'variant-show' );
							}
						});

					if ( item.selectedIndex === 0 ) 
					{
						full_imgs_parent.innerHTML = '';
						full_imgs.forEach( function( img_tainers, i ) 
							{
								img_tainers.classList.add( 'variant-show' );
							});

						thumb_lis_parent.innerHTML = '';
						thumb_lis.forEach( function( img_tainers, i ) 
							{
								img_tainers.classList.add( 'variant-show' );
							});
					}
				}

				item.addEventListener( 'click', function( event ) 
				{

					var variant = event.target;
					if ( variant.nodeName === 'SPAN' ) 
					{
						variant = variant.parentElement;
					}
					
					variant_selected = variant.getAttribute( 'data-value' );

					if ( variant_selected !== null ) 
					{
						full_imgs_parent.innerHTML = '';
						full_imgs.forEach( function( img_tainers, i ) 
							{
								if ( i === 0 ) 
								{
									img_tainers.setAttribute( 'data-variant-color', variant_selected );
								}

								if ( img_tainers.getAttribute( 'data-variant-color' ) === variant_selected ) 
								{
									img_tainers.classList.add( 'variant-show' );
									full_imgs_parent.appendChild( img_tainers );
								}

								if ( img_tainers.getAttribute( 'data-variant-color' ) !== variant_selected && img_tainers.classList.contains( 'variant-show' ) ) 
								{
									img_tainers.classList.remove( 'variant-show' );
								}
							});

						thumb_lis_parent.innerHTML = '';
						thumb_lis.forEach( function( img_tainers, i ) 
							{
								if ( img_tainers.getAttribute( 'data-variant-color' ) === variant_selected ) 
								{
									img_tainers.classList.add( 'variant-show' );
									thumb_lis_parent.appendChild( img_tainers );
								}

								if ( img_tainers.getAttribute( 'data-variant-color' ) !== variant_selected && img_tainers.classList.contains( 'variant-show' ) ) 
								{
									img_tainers.classList.remove( 'variant-show' );
								}
							});
					}

					if ( variant.classList.contains( 'reset_variations' ) ) 
					{
						full_imgs_parent.innerHTML = '';
						full_imgs.forEach( function( img_tainers, i ) 
							{
								img_tainers.classList.add( 'variant-show' );
								full_imgs_parent.appendChild( img_tainers );
							});

						thumb_lis_parent.innerHTML = '';
						thumb_lis.forEach( function( img_tainers, i ) 
							{
								img_tainers.classList.add( 'variant-show' );
								thumb_lis_parent.appendChild( img_tainers );
							});
					}
				});
			});

		thumb_lis.forEach( function( item, i ) 
			{
				item.addEventListener( 'click', function( event )                   
					{
						var top_adjustment = getComputedStyle( thumb_lis_parent.parentElement ).top;
						event.preventDefault();
						var el = event.target;
						if ( el.nodeName === 'IMG' )
						{
							el = el.parentElement;
						}
						var el_scroll_to_id = el.getAttribute( 'href' ).replace( '#', '' );
						scrollToSection( el_scroll_to_id, top_adjustment );
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
		// if ( document.querySelector( 'div.xoo-wsc-modal' ) ) 
		// {
		// 	var side_cart_btn = document.querySelector( '.wonka-cart-open' );
		// 	var side_cart_modal = document.querySelector( 'div.xoo-wsc-modal' );
		// 	var side_cart_container = document.querySelector( 'div.xoo-wsc-container' );
		// 	var side_cart_header = document.querySelector( 'div.xoo-wsc-header' );
		// 	var side_cart_body = document.querySelector( 'div.xoo-wsc-body' );
		// 	var side_cart_body_content = document.querySelector( 'div.xoo-wsc-content' );
		// 	var side_cart_footer = document.querySelector( 'div.xoo-wsc-footer' );
		// 	var side_cart_footer_content = document.querySelector( 'div.xoo-wsc-footer-content' );
		// 	var footer_btn_container = document.createElement( 'DIV' );
		// 	var footer_btn = document.createElement( 'A' );
		// 	var footer_btn_text = 'Checkout <i class="fa fa-angle-down"></i>';
		// 	footer_btn_container.classList.add( 'wonka-btn-container' );
		// 	footer_btn.classList.add( 'wonka-btn' );
		// 	footer_btn.setAttribute( 'href', '#' );
		// 	footer_btn.innerHTML = footer_btn_text;
		// 	footer_btn_container.appendChild( footer_btn );

		// 	console.log( side_cart_footer );
		// 	side_cart_btn.
		// 	document.addEventListener( 'scroll', function(e)  
		// 		{
		// 			console.log(e);
		// 		});
			
		// 	side_cart_body_content.onload = function( e ) 
		// 		{
		// 			console.log( e );
		// 			if ( side_cart_body.scrollTop > 0 ) 
		// 			{
		// 				side_cart_footer.insertBefore( footer_btn_container, side_cart_footer_content );
		// 				side_cart_footer.style.bottom = - side_cart_footer.offsetHeight + footer_btn_container.offsetHeight + 15 + 'px';

		// 				setTimeout( function() 
		// 					{
		// 						footer_btn_container.style.opacity = 1;
		// 						side_cart_body.style.height = side_cart_container.offsetHeight - side_cart_header.offsetHeight - footer_btn_container.offsetHeight - 15 + 'px';
		// 					}, 350 );
		// 			}
					
		// 		};

		// 	footer_btn.addEventListener( 'click', function( e ) 
		// 		{
		// 			footer_btn_container.style.opacity = 0;
		// 			side_cart_footer.style.bottom = 0;
		// 			setTimeout( function( side_cart_body ) 
		// 				{
		// 					side_cart_footer.removeChild( footer_btn_container );
		// 					side_cart_body.style.height = side_cart_container.offsetHeight - side_cart_header.offsetHeight - side_cart_footer.offsetHeight + 'px';
		// 				}, 350, side_cart_body );
		// 		});
		// }
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

		/**************************************************************************
		 * This allow the user to view their password in the the sign in form CARLOS
		 **************************************************************************/
		if ( document.querySelectorAll( 'div.input-group-append' ) )
		{
			var password_toggle_btns = document.querySelectorAll( 'div.input-group-append' );
			password_toggle_btns.forEach( function( password_toggle_btn )
			{
				password_toggle_btn.addEventListener( 'click', function( e )
				{
					var parent_input, password_input, password_icon_btn, password_type;
					var target = e.target;

					if ( target.nodeName === 'DIV' ) 
					{
						password_icon_btn = target.firstElementChild;
						parent_input = target.parentElement.parentElement;
						password_input = parent_input.firstElementChild;
						password_type = password_input.getAttribute( "type" );
					}

					if ( target.nodeName === "I" ) 
					{
						password_icon_btn = target;
						target = target.parentElement;
						parent_input = target.parentElement.parentElement;
						password_input = parent_input.firstElementChild;
						password_type = password_input.getAttribute( "type" );
					}

					if( password_type === "password" )
					{
						password_icon_btn.classList.toggle( 'fa-eye' );
						password_icon_btn.classList.toggle( 'fa-eye-slash' );
						password_input.type = "text";
					}

					if ( password_type === "text" ) 
					{
						password_icon_btn.classList.toggle( 'fa-eye' );
						password_icon_btn.classList.toggle( 'fa-eye-slash' );
						password_input.type = "password";
					}
				});
			});
		}
		/*===============================================================================
		=            This is the setup for the Wonka Express Checkout Button            =
		===============================================================================*/
		if ( document.querySelector( 'body.woocommerce-checkout' ) ) 
		{

		}

		/*==========================================================
		=            This is for setting up the reviews            =
		==========================================================*/
		if ( document.querySelector( '#reviews' ) ) 
		{
			var write_review = document.querySelector( '#write-review' ),
			comment_form_wrapper = document.querySelector( 'div#review_form_wrapper' ),
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
						if ( more_reviews.innerText.toLowerCase() === 'less reviews' ) 
						{
							setup_for_reviews( comment_list );
							setTimeout( function() 
								{
									reviews_top.scrollIntoView({behavior: 'smooth'});
									more_reviews.innerText = 'More Reviews';
								}, 500 );
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
					if ( getComputedStyle( comment_form_wrapper ).height === '25px' ) 
					{
						comment_form_wrapper.style.height = 415 + 'px';
					}
					else
					{
						comment_form_wrapper.style.height = 25 + 'px';
					}
				});

			/***********************************************************************
			 * This is for Review length
			 **********************************************************************/
			var read_more_btn = document.querySelectorAll( 'button.ws-data-comment-btn' );

			read_more_btn.forEach(function( item, i ){

				item.addEventListener( 'click', function( e )
				{
					e.preventDefault();
					var target = e.target;
					var comment_el = target.previousElementSibling;
					var inner_comment = comment_el.innerText;
					var data_comment = comment_el.getAttribute( 'ws-data-comment' );
					more_reviews = document.querySelector( '#more-reviews' );

					target.addEventListener( 'blur', function( e ) 
						{
							var target = e.target;
							var comment_el = target.previousElementSibling;
							var inner_comment = comment_el.innerText;
							var data_comment = comment_el.getAttribute( 'ws-data-comment' );

							if ( comment_el.classList.contains( 'full_comment' ) )
							{
								comment_el.classList.toggle( 'full_comment' );
								comment_el.innerText = data_comment;
								comment_el.setAttribute( 'ws-data-comment', inner_comment );
								target.innerText = "Read More";
								if ( more_reviews.innerText.toLowerCase() === 'more reviews' )
								{
									setup_for_reviews( comment_list );
								}
							}
						});
				
					if ( comment_el.classList.contains( 'full_comment' ) )
					{
						comment_el.classList.toggle( 'full_comment' );
						comment_el.innerText = data_comment;
						comment_el.setAttribute( 'ws-data-comment', inner_comment );
						target.innerText = "Read More";
						if ( more_reviews.innerText.toLowerCase() === 'more reviews' )
						{
							setup_for_reviews( comment_list );
						}
					} 
					else 
					{
						comment_el.classList.toggle( 'full_comment' );
						comment_el.innerText = data_comment;
						comment_el.setAttribute( 'ws-data-comment', inner_comment );
						target.innerText = "Read Less";
						if ( more_reviews.innerText.toLowerCase() === 'more reviews' )
						{
							setup_for_reviews( comment_list );
						}
					}
				});
			});
			/**
			 * End of Review length
			 */
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
			var about_vid_iframe_link = about_vid_iframe.src;

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

		/*===================================================================
		=            This is to kill the about us video on close            =
		===================================================================*/
		if ( document.querySelector( 'div#videoModalpop' ) ) 
		{
			var cause_vid_modal = document.querySelector( 'div#videoModalpop' );
			var cause_vid_close = document.querySelector( 'div#videoModalpop button.close' );
			var cause_vid_iframe = document.querySelector( 'div#videoModalpop iframe' );
			var cause_vid_iframe_link = cause_vid_iframe.src;

			cause_vid_close.onclick = function()
			{
				cause_vid_iframe.src = '';
				cause_vid_iframe.src = cause_vid_iframe_link;
			};

			cause_vid_modal.onclick = function() 
			{
				cause_vid_iframe.src = '';
				cause_vid_iframe.src = cause_vid_iframe_link;
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
				scrollToSection( 'main', 15 );
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
			  prevArrow: '<button class="slick-prev" type="button"><i class="far fa-arrow-alt-circle-left"></i></button>',
			  nextArrow: '<button class="slick-next" type="button"><i class="far fa-arrow-alt-circle-right"></i></button>',
			});
		}

		if ( document.querySelector( 'body.home .instagram-wrap') ) 
		{
			$( 'body.home .instagram-wrap' ).slick({
			  slidesToShow: 5,
			  slidesToScroll: 3,
			  autoplay: true,
			  autoplaySpeed: 4000,
			  dots: false,
			  prevArrow: '<button class="slick-prev" type="button"><i class="far fa-arrow-alt-circle-left"></i></button>',
			  nextArrow: '<button class="slick-next" type="button"><i class="far fa-arrow-alt-circle-right"></i></button>',
			  responsive: [
    			{
			      breakpoint: 1200,
			      settings: {
			        slidesToShow: 4,
			        slidesToScroll: 3,
			      }
			    },
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
							scrollToSection( 'product-statement', 15 );
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
							scrollToSection( 'product-statement', 15 );
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
							scrollToSection( 'reviews', 15 );
						}
					} );
			}
		/*=====  End of This is for single product page short description scrolling  ======*/
	

		/********************************************************************************
		 * this is For Checkout validation 
		 ********************************************************************************/
			// var checkout_error_ul;
			// if (document.querySelector( 'main.main-checkout' ))
			// {
				 
				// console.log(document.querySelector( 'main.main-checkout' ));
				// // checkout_error_ul = document.querySelector( 'ul.woocommerce-error' );
				// var checkout_error_form = document.querySelector( 'form.woocommerce-checkout' );  
				// console.log(checkout_error_form);

				// if (checkout_error_form.childElementCount) {
				// 	checkout_error_ul = checkout_error_form.children;
				// 	console.log(checkout_error_ul);
				// // if ( checkout_error_ul ) 
				// // {	
				// // 	console.log(checkout_error_ul.innerText);
				// // }	
				// }
		/***********************************************************************************
		 * End For Checkout validation
		 * ****************************************************************************** */

		 		/********************************************************************************
		 * this is form credit Card form placeholders
		 ********************************************************************************/
		// var checkout_error_ul;
		if (document.querySelector( 'main.main-checkout' ))
		{
			 var payment_accountnumber_label = document.querySelector( 'label[for="cybersource_accountNumber"]' );
			 var payment_acountnumber_input = document.querySelector( 'input#cybersource_accountNumber' );
			 var payment_cardtype_label = document.querySelector( 'label[for="cybersource_cardType"]' );
			 var payment_cardtype_select = document.querySelector( 'select.cybersource_cardType' );
			 var payment_xpdate_label = document.querySelector( 'label[for="cybersource_expirationMonth"]' );
			 var payment_xpmonth_select = document.querySelector( 'select#cybersource_expirationMonth' );
			 var payment_xpyear_select = document.querySelector( 'select#cybersource_expirationYear' );
			 var payment_cvnumber_label = document.querySelector( 'label[for="cybersource_cvNumber"]' );
		   var payment_cvnumber_select = document.querySelector( 'input#cybersource_accountNumber' );

			 payment_accountnumber_label.classList.add('sr-only');
			 var paymentmethod_cybersource_labels = document.querySelectorAll( 'div.payment_method_cybersource label' );
			 paymentmethod_cybersource_labels.forEach(function (item, index) {
				item.classList.add( 'sr-only' );
				// item.nextElementSibling.setAttribute("placeholder", item.innerText);
			 });

		}
	/***********************************************************************************
	 * End for Credit card form placeholders
	 * ****************************************************************************** */
		

		/**
		 * This is for login form validation
		 * 
		 */
		if ( document.querySelector( 'main.main-my-account' ) ) 
		{
			var validation_div = document.querySelector( '.woocommerce-error' );

			if ( validation_div ) 
			{
				var validation_text = validation_div.innerText.trim();
				validation_text = validation_text.split(' ').slice(1).join(' ');
				var validation_text_2 = validation_text.split('.').slice(0,1).join();

				switch(validation_text_2)
				{

					case "Username is required":
						document.querySelector( 'input#username' ).classList.add("is-invalid");
						document.querySelector( 'div.invalid-feedback.username' ).innerText = validation_text;
						break;
					case "The password field is empty":
						document.querySelector( 'input#password' ).classList.add("is-invalid");
						document.querySelector( 'div.invalid-feedback.password' ).innerText = validation_text;
						break;
					case "Too many failed login attempts":
						document.querySelector( 'input#username' ).classList.add("is-invalid");
						document.querySelector( 'input#password' ).classList.add("is-invalid");
						document.querySelector( 'div.invalid-feedback.username' ).innerText = validation_text;
						document.querySelector( 'div.invalid-feedback.password' ).innerText = validation_text;
						break;
					case "Incorrect username or password":
						document.querySelector( 'input#username' ).classList.add("is-invalid");
						document.querySelector( 'input#password' ).classList.add("is-invalid");
						document.querySelector( 'div.invalid-feedback.username' ).innerText = validation_text;
						document.querySelector( 'div.invalid-feedback.password' ).innerText = validation_text;
						break;
						
					case "Please provide a valid email address":
						document.querySelector( 'input#reg_email' ).classList.add("is-invalid");
						document.querySelector( 'div.invalid-feedback.reg_email' ).innerText = validation_text;
						break;

					case "An account is already registered with your email address":
						document.querySelector( 'input#reg_email' ).classList.add("is-invalid");
						document.querySelector( 'div.invalid-feedback.reg_email' ).innerText = validation_text;
						break;

					case "Please enter an account password":
						document.querySelector( 'input#register_password' ).classList.add("is-invalid");
						document.querySelector( 'div.invalid-feedback.register_password' ).innerText = validation_text;
						break;
					}

			}
		}

	/*=================================================
	=            Setup for the search form            =
	=================================================*/
	wonka_ajax_request( xhr, "search_site", null);
	/*=====  End of Setup for the search form  ======*/
};
	/*=====  End of This is for running after document is ready  ======*/

})(jQuery);