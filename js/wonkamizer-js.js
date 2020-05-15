/*============================================
=            For Google Analytics            =
============================================*/
if ( wonkasoft_request.ga_id !== '' ) 
{
	(function(i,s,o,g,r,a,m)
	{
		i.GoogleAnalyticsObject=r;i[r]=i[r]||function()
		{
			(i[r].q=i[r].q||[]).push(arguments);
		}; 

		i[r].l=1*new Date();
		a=s.createElement(o);
		m=s.getElementsByTagName(o)[0];
		a.async=1;
		a.src=g;
		m.parentNode.insertBefore(a,m);
	} )( window,document,'script','https://www.google-analytics.com/analytics.js','ga' );

	ga('create', wonkasoft_request.ga_id, 'auto');
	ga('send', 'pageview');
}
/*=====  End of For Google Analytics  ======*/
var placeSearch, autocomplete;
var componentForm;

( function( $ )
{
	/*===============================================
	=            vars set for script use            =
	===============================================*/
	var last_scroll_top = 0,
	scroll_direction,
	scroll_distance,
	admin_bar,
	message_timer,
	admin_height,
	drop_down,
	header_el,
	header_height,
	config = { attributes: true, childList: true },
	xhr;
	if ( document.querySelector( '.fp_apply_reward' ) ) 
	{
		if ( document.querySelector( '.redeemit' ) ) 
		{
			var redeem_it_btn = document.querySelector( '.redeemit' );
			var redeem_it_form = document.querySelector( 'form.checkout_redeeming' );
			redeem_it_btn.classList.add( 'wonka-btn' );
			redeem_it_btn.addEventListener( 'click', function( e ) 
				{
					e.stopPropagation();
					redeem_it_form.style = 'display: block;';
					setTimeout( function() 
						{
							if ( redeem_it_form.classList.contains( 'show' ) ) 
							{
								redeem_it_form.classList.remove( 'show' );
								
								setTimeout( function() 
									{
										redeem_it_form.style = 'display: none;';
									}, 200 );
							}
							else
							{
								redeem_it_form.classList.add( 'show' );
								
							}
						}, 200 );
				});
		}
		var apply_reward_container = document.querySelector( '.fp_apply_reward' );
		var new_div_group = document.createElement( 'DIV' );
		var input_text = apply_reward_container.querySelectorAll( 'input' )[0];
		var input_btn = apply_reward_container.querySelectorAll( 'input' )[1];
		new_div_group.classList.add( 'input-group' );
		new_div_group.appendChild( input_text );
		new_div_group.appendChild( input_btn );
		apply_reward_container.appendChild( new_div_group );
	}

	if ( document.querySelector( 'body.woocommerce-checkout' ) ) 
	{

		if ( document.querySelector( '#shipping_address_1' ) ) 
		{
			$( 'docmuent body' ).on( 'update_checkout', function( e ) 
				{
					e.stopImmediatePropagation();
				});

			$( '#shipping_address_1' ).on( 'keydown', function( e ) 
				{
					e.stopImmediatePropagation();
				});

			document.querySelector( '#shipping_address_1' ).addEventListener( 'focus', function( e ) 
				{
					if ( document.querySelector( '.pac-container' ) ) 
					{
						if ( document.querySelector( '.pac-container' ).style.display === 'none' ) 
						{
							document.querySelector( '.pac-container' ).style.display = 'block';
						}
					}
				});
		}
	}

	/* vars set for single product page */
	if ( document.querySelector( '.product-img-section' ) ) 
	{
		var product_img_section, product_img_section_height, wonka_single_product_img_area, summary_section, thumbnail_controls, slide_control, active_slide, active_slide_img, win_y, img_area_top, target_stop, one_click = true;
	}
	/*=====  End of vars set for script use  ======*/

	/**
	 * This is for the zip and ambassador thank you pages.
	 * 
	 */
	if (document.getElementById("ambassadar-first-name") || document.getElementById("zip-first-name") || document.getElementById("confirm-email") ) {
		if ( getUrlVars().firstname ) 
		{
			var firstname = decodeURIComponent( getUrlVars().firstname ).replace( /\+/gi, ' ' );
			document.getElementById("ambassadar-first-name").innerHTML = "HI " + firstname + "!";
		}

		if ( getUrlVars().fname ) 
		{
			var zip_firstname = decodeURIComponent( getUrlVars().fname ).replace( /\+/gi, ' ' );
			document.getElementById("zip-first-name").innerHTML = "HI " + zip_firstname + "!";
		}

		if ( getUrlVars().email ) 
		{
			var confirm_email = decodeURIComponent( getUrlVars().email ).replace( /\+/gi, ' ' );
			document.getElementById("confirm-email").innerHTML = confirm_email;
		}
	}

	if ( document.getElementById("for-fname") ) {
		if ( getUrlVars().email ) 
		{
			var for_email = decodeURIComponent( getUrlVars().email ).replace( /\+/gi, ' ' );
			document.getElementById("for-email").innerHTML = for_email;
		}

		if ( getUrlVars().fname ) 
		{
			var for_fname = decodeURIComponent( getUrlVars().fname ).replace( /\+/gi, ' ' );
			document.getElementById("for-fname").innerHTML = for_fname;
		}

		if ( getUrlVars().lname ) 
		{
			var for_lname = decodeURIComponent( getUrlVars().lname ).replace( /\+/gi, ' ' );
			document.getElementById("for-lname").innerHTML = for_lname;
		}
	}

	if ( document.querySelector( '#tag' ) ) 
	{
		if ( getUrlVars().email ) 
		{
			var email = decodeURIComponent( getUrlVars().email ).replace( /\+/gi, ' ' );
			document.getElementById("email").innerHTML = email;
		}

		if ( getUrlVars().tag ) 
		{
			var tag = decodeURIComponent( getUrlVars().tag ).replace( /\+/gi, ' ' );
			document.getElementById("tag").innerHTML = tag;
		}

	}

	if ( document.querySelector( '#subscriber-email' ) ) 
	{
		if ( getUrlVars().email ) 
		{
			var subscriber_email = decodeURIComponent( getUrlVars().email ).replace( /\+/gi, ' ' );
			document.getElementById("subscriber-email").innerHTML = subscriber_email;
		}
	}

	if ( document.querySelector( 'input[type=file].custom-file-input' ) ) 
	{
		var file_input = document.querySelector( 'input[type=file].custom-file-input' );
		var input_label = document.querySelector( 'label.custom-file-label' );
		var file_name;
		var current_logo_wrap = document.querySelector( 'div.current-logo-wrap' );
		var agree_to_fee_modal_wrap;
		var inner_markup = '';
		var closebtns;
		var consent_checkbox;

		document.ongform_post_render = function( event, form_id, current_page )
		{

			if ( document.querySelector( '#agree-to-fee-modal' ) ) 
			{
				agree_to_fee_modal_wrap = document.querySelector( '#agree-to-fee-modal' );
			}
			else
			{
				agree_to_fee_modal_wrap = document.createElement('DIV');
				agree_to_fee_modal_wrap.classList.add( 'agree-to-fee-modal-wrap');
				agree_to_fee_modal_wrap.classList.add( 'modal');
				agree_to_fee_modal_wrap.classList.add( 'fade');
				agree_to_fee_modal_wrap.setAttribute( 'id', 'agree-to-fee-modal');

				inner_markup += '<div class="modal-dialog modal-dialog-centered">';
				inner_markup += '<div class="modal-content">';
				inner_markup += '<!-- Modal Header -->';
				inner_markup += '<div class="modal-header">';
				inner_markup += '<button type="button" class="btn close" data-dismiss="modal">&times;</button>';
				inner_markup += '</div>';
				inner_markup += '<!-- Modal body -->';
				inner_markup += '<div class="modal-body">';
				inner_markup += '<p><strong>Oops!</strong> Looks like you are not uploading an .ai, .eps, .pdf, or vector image. Please close this box and upload your logo as one of those image files.</p>';
				inner_markup += '<p>Don’t worry, if you do not have your logo as one of those file types, we can create one for you! Simply check the box below to continue submitting this image and accept the one-time $75 design fee.</p>';
				inner_markup += '<p>';
				inner_markup += '<div id="agree-to-fee-input-group" class="input-group">';
				inner_markup += '</div>';
				inner_markup += '</p>';
				inner_markup += '</div>';
				inner_markup += '<!-- Modal footer -->';
				inner_markup += '<div class="modal-footer">';
				inner_markup += '<button type="button" class="wonka-btn" data-dismiss="modal">Close</button>';
				inner_markup += '</div>';
				inner_markup += '</div>';
				inner_markup += '</div>';
				agree_to_fee_modal_wrap.innerHTML = inner_markup;
				document.body.appendChild( agree_to_fee_modal_wrap );
				agree_to_fee_form_wrap = document.querySelector( '#agree-to-fee-input-group' );
				agree_to_fee_form = document.querySelector( 'form.wonka-design-fees-form' ).parentElement;
				agree_to_fee_form_wrap.appendChild( agree_to_fee_form );
			}
			closebtns = document.querySelectorAll( '#agree-to-fee-modal button' );

			$( '.ginput_card_expiration' ).select2();

			file_input.addEventListener( 'change', function( e ) 
				{
					if ( '' === file_input.value ) 
					{
						input_label.innerText = 'Choose file';
					}
					else
					{
						file_name = file_input.value.split('\\')[file_input.value.split('\\').length - 1];
						input_label.innerText = file_name;
					}

					if ( file_name.includes( '.png' ) !== false || file_name.includes( '.jpg' ) !== false || file_name.includes( '.jpeg' ) !== false || file_name.includes( '.gif' ) !== false ) 
					{
						closebtns.forEach( function( btn, i ) 
							{
								btn.addEventListener( 'click', function( e ) 
									{
										consent_checkbox = document.querySelector( '.agree-to-fees-consent input[type=checkbox]' );
										if ( true !== consent_checkbox.checked ) 
										{
											file_input.value = '';
											input_label.innerText = 'Choose file';
										}
									} );
							});

						agree_to_fee_modal_wrap.addEventListener( 'click', function( e ) 
							{
								if ( e.target.classList.contains( 'show' ) && agree_to_fee_modal_wrap.classList.contains( 'show' ) ) 
								{
									consent_checkbox = document.querySelector( '.agree-to-fees-consent input[type=checkbox]' );
									if ( true !== consent_checkbox.checked ) 
									{
										document.querySelector( 'button[data-dismiss=modal]' ).click();
									}
								}
							});

						$( '#agree-to-fee-modal' ).modal({ backdrop: 'static', keyboard: false });
						if ( document.querySelector( '.agree-to-fees-consent input[type=checkbox]' ) ) 
						{
							consent_checkbox = document.querySelector( '.agree-to-fees-consent input[type=checkbox]' );
							consent_checkbox.addEventListener( 'change', function( e ) 
								{
									if ( true === consent_checkbox.checked ) 
									{
										closebtns.forEach( function( btn, i ) 
										{
											btn.removeAttribute( 'data-dismiss' );
										});
										$( '#agree-to-fee-modal' ).modal({ backdrop: 'static', keyboard: false });
									}
									else
									{
										closebtns.forEach( function( btn, i ) 
										{
											if ( null === btn.getAttribute( 'data-dismiss' ) ) 
											{
												btn.setAttribute( 'data-dismiss', 'modal' );
											}
										});
										$( '#agree-to-fee-modal' ).modal({ backdrop: true, keyboard: true });
									}
								});
						}
					}

				} );
 
			document.ongform_confirmation_loaded = function( event, formId ) 
				{
					var parent_el;
					var add_close_btn;
					var close_btn_text;
					var text;
					parent_el = agree_to_fee_form_wrap.parentElement;
					if ( parent_el ) 
					{
						parent_el.innerHTML = '';
					}

					var data = {
						'url': wonkasoft_request.ajax,
						'action': 'wonkasoft_parse_account_logo_or_process_fees',
						'form_id': formId,
						'security': wonkasoft_request.security
					};
					var query_string = Object.keys( data ).map( function( key ) { return key + '=' + data[key]; } ).join('&');
					xhr = new XMLHttpRequest();
					xhr.onreadystatechange = function() {

						if ( this.readyState == 4 && this.status == 200 ) 
						{
							var response = JSON.parse( this.responseText );

							if ( response.success && 'Design Fees Capture' === response.data.form_title ) 
							{
								parent_el.appendChild( agree_to_fee_form_wrap );
								document.querySelector( '.hidden-agree-to-fees input[type=hidden]' ).value = response.data.consent_text;
								closebtns.forEach( function( btn, i ) 
								{
									if ( null === btn.getAttribute( 'data-dismiss' ) ) 
									{
										btn.setAttribute( 'data-dismiss', 'modal' );
									}
								});
								$( '#agree-to-fee-modal' ).modal({ backdrop: true, keyboard: true });
							}
							else
							{
								if ( null === response.success && 'Design Fees Capture' === response.data.form_title ) 
								{
									document.querySelector( '#agree-to-fee-input-group' ).innerHTML = 'There was a error during processing. please contact our Customer Care.';

									parent_el.appendChild( agree_to_fee_form_wrap );
									closebtns.forEach( function( btn, i ) 
									{
										if ( null === btn.getAttribute( 'data-dismiss' ) ) 
										{
											btn.setAttribute( 'data-dismiss', 'modal' );
										}
									});
									$( '#agree-to-fee-modal' ).modal({ backdrop: true, keyboard: true });
								}
							}

							if ( response.success && 'Media Upload' === response.data.form_title ) 
							{
								current_logo_wrap.innerHTML = response.data.content;
							}
							else
							{
								if ( 'Media Upload' === response.data.form_title ) 
								{
									current_logo_wrap.innerText = 'There was an issue with your upload. Please try again.';
								}
							}
						}
					};

					xhr.open('GET', data.url + "?" + query_string );
					xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhr.send();
				};
    	};

	}

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
		var multistep_link_list = document.querySelector( '#wonka-checkout-nav-steps' );
		var multistep_links = document.querySelectorAll( '#wonka-checkout-nav-steps li a.nav-link' );
		var info_table_contact_cells = document.querySelectorAll( '.contact-email-cell' );
		var info_table_ship_cells = document.querySelectorAll( '.ship-to-address-cell' );
		var contact_change_links = document.querySelectorAll( '.contact-email-change-link' );
		var ship_to_change_links = document.querySelectorAll( '.ship-to-address-change-link' );
		var ship_method_change_links = document.querySelectorAll( '.ship-method-change-link' );
		var multistep_btns = document.querySelectorAll( '.wonka-multistep-checkout-btn' );

		/**
		 * Add Shipping method to current status table
		 *
		 * @author Carlos
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
								xhr = new XMLHttpRequest();
								if ( target.checked && target.id == 'bill-to-different-address-checkbox2' ) 
								{
									wonka_ajax_request( xhr, 'shipping_to_billing', '&opt_set=billing' );
									billing_address_form.classList.add( 'active' );
										copy_to_billing();
								}
								else
								{
									wonka_ajax_request( xhr, 'shipping_to_billing', '&opt_set=shipping' );
									if ( billing_address_form.classList.contains( 'active' ) ) 
									{
										billing_address_form.classList.remove( 'active' );
										copy_to_billing();
									}
								}
								
							});
					});
				/*=====  End of Copying Shipping info to Billing info  ======*/
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
						
						switch( target.id ) {
							
							case 'wonka_customer_information_tab':
								multistep_link_list.classList = 'nav nav-fill shipping-address';
								break;

							case 'wonka_shipping_method_tab':
								multistep_link_list.classList = 'nav nav-fill shipping-address delivery-options';
								break;

							case 'wonka_payment_method_tab':
								multistep_link_list.classList = 'nav nav-fill shipping-address delivery-options payment-methods';
								break;

							case 'place_order':
								multistep_link_list.classList = 'nav nav-fill shipping-address delivery-options payment-methods completed';
								break;
							
							default:
								multistep_link_list.classList = 'nav nav-fill shipping-address';
								break;
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
							var shipping_form_fields = document.querySelectorAll( '.woocommerce-shipping-fields input' );
							var validation_checker = true;
							var field_count = shipping_form_fields.length;
							next_tab = document.querySelector( e.target.getAttribute( 'data-target' ) );
							shipping_form_fields.forEach( function( input, i ) 
								{
									if ( input.name !== 'shipping_company' && input.name !== 'shipping_address_2'  && input.name !== 'mc4wp-subscribe'  )
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
										scrollToSection( 'wonka_shipping_method_tab', 15 );
										if ( document.querySelector( '.pac-container' ) ) 
										{
											document.querySelector( '.pac-container' ).style.display = 'none';
										}
									}
								});
						}

						if ( e.target.getAttribute( 'data-target' ) === '#wonka_payment_method_tab' ) 
						{
							e.preventDefault();
							next_tab = document.querySelector( e.target.getAttribute( 'data-target' ) );
							ship_method.forEach( function( method, i ) 
								{
									if ( method.checked ) 
									{
										next_tab.classList.remove( 'disabled' );
										next_tab.click();
									}
								});
						}

						if ( e.target.getAttribute( 'data-target' ) === '#wonka_customer_information_tab' ) 
						{
							e.preventDefault();
							next_tab = document.querySelector( e.target.getAttribute( 'data-target' ) );
							next_tab.click();
						}

						/*===================================================================================
						=            This is for validation from clicking the place order button            =
						===================================================================================*/
						if ( e.target.getAttribute( 'data-target' ) === '#place_order' ) 
						{
							e.preventDefault();
							next_tab = document.querySelector( e.target.getAttribute( 'data-target' ) );

							if ( document.querySelector( '#payment_method_cybersource' ).checked ) 
							{
								var cybersource_inputs_for_validation = document.querySelectorAll( '.payment_box.payment_method_cybersource input' );
								var cybersource_selects_for_validation = document.querySelectorAll( '.payment_box.payment_method_cybersource select' );
								var feedback_div;
								cybersource_inputs_for_validation.forEach( function( input, i ) 
									{
										input.required = true;
										if ( input.name === 'cybersource_accountNumber' ) 
										{
											feedback_div = document.createElement( 'DIV' );
											feedback_div.classList.add( 'invalid-feedback' );
											feedback_div.innerText = 'Credit Card Number is a required field';
											if ( !input.parentElement.querySelector( '.invalid-feedback' ) ) 
											{
												input.parentElement.appendChild( feedback_div );
											}
											if ( input.reportValidity() === false ) 
											{
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

										if ( input.name === 'cybersource_cvNumber' ) 
										{
											feedback_div = document.createElement( 'DIV' );
											feedback_div.classList.add( 'invalid-feedback' );
											feedback_div.innerText = 'CCV is a required field';
											if ( !input.parentElement.querySelector( '.invalid-feedback' ) ) 
											{
												input.parentElement.appendChild( feedback_div );
											}
											if ( input.reportValidity() === false ) 
											{
												input.classList.add( 'is-invalid' );
												input.style.width = 100 + 'px';
											}
											else
											{
												if ( input.reportValidity() && input.classList.contains( 'is-invalid' ) ) 
												{
													input.classList.remove( 'is-invalid' );
													input.style.width = '';
												}
											}
										}
									});

								cybersource_selects_for_validation.forEach( function( select, i ) 
									{
										if ( select.name === 'cybersource_cardType' ) 
										{
											feedback_div = document.createElement( 'DIV' );
											feedback_div.classList.add( 'invalid-feedback' );
											feedback_div.innerText = 'Select Card Type is a required field';
											if ( !select.parentElement.querySelector( '.invalid-feedback' ) ) 
											{
												select.parentElement.appendChild( feedback_div );
											}
											if ( select.selectedIndex === 0 ) 
											{
												select.classList.add( 'is-invalid' );
											}
											else
											{
												if ( select.selectedIndex > 0 && select.classList.contains( 'is-invalid' ) ) 
												{
													select.classList.remove( 'is-invalid' );
												}
											}
										}

										if ( select.name === 'cybersource_expirationMonth' ) 
										{
											feedback_div = document.createElement( 'DIV' );
											feedback_div.classList.add( 'invalid-feedback', 'invalid-feedback-month' );
											feedback_div.innerText = 'Expiration Month is a required field';
											if ( !select.parentElement.querySelector( '.invalid-feedback.invalid-feedback-month' ) ) 
											{
												select.parentElement.appendChild( feedback_div );
											}
											if ( select.selectedIndex === 0 ) 
											{
												select.classList.add( 'is-invalid' );
											}
											else
											{
												if ( select.selectedIndex > 0 && select.classList.contains( 'is-invalid' ) ) 
												{
													select.classList.remove( 'is-invalid' );
												}
											}
										}

										if ( select.name === 'cybersource_expirationYear' ) 
										{
											feedback_div = document.createElement( 'DIV' );
											feedback_div.classList.add( 'invalid-feedback', 'invalid-feedback-year' );
											feedback_div.innerText = 'Expiration Year is a required field';
											if ( !select.parentElement.querySelector( '.invalid-feedback.invalid-feedback-year' ) ) 
											{
												select.parentElement.appendChild( feedback_div );
											}
											if ( select.selectedIndex === 0 ) 
											{
												select.classList.add( 'is-invalid' );
											}
											else
											{
												if ( select.selectedIndex > 0 && select.classList.contains( 'is-invalid' ) ) 
												{
													select.classList.remove( 'is-invalid' );
												}
											}
										}
									});
							}

							if ( document.querySelector( '.woocommerce-billing-fields__field-wrapper' ) ) 
							{
								var billing_form_fields = document.querySelectorAll( '.woocommerce-billing-fields__field-wrapper input' );
								var billing_form_selects = document.querySelectorAll( '.woocommerce-billing-fields__field-wrapper select' );
								var billing_field_count = billing_form_fields.length;
								var validation_billing_checker = true;



								billing_form_selects.forEach( function( select, i ) 
									{
										if ( select.selectedIndex === 0 ) 
										{
											validation_billing_checker = false;
											select.classList.add( 'is-invalid' );
										}
										else
										{
											if ( select.selectedIndex > 0 && select.classList.contains( 'is-invalid' ) ) 
											{
												select.classList.remove( 'is-invalid' );
											}
										}
									});

								billing_form_fields.forEach( function( input, i ) 
									{
										if ( input.name !== 'billing_company' && input.name !== 'billing_address_2' ) 
										{
											input.required = true;
											if ( input.reportValidity() === false ) 
											{
												validation_billing_checker = false;
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

										if ( i === field_count - 1 && validation_billing_checker )
										{
											next_tab.click();
										}
									});
							}

							if ( document.querySelector( '#bill-to-different-address-checkbox1' ).checked ) 
							{
								next_tab.click();
							}
						}
						/*=====  End of This is for validation from clicking the place order button  ======*/
					});
			});
	}
	/*=====  End of This is for the checkout multistep tabs  ======*/
	
	/*===================================================================
	=            This is area for writing callable functions            =
	===================================================================*/

	function add_transparent( height ) {

		if ( document.body.scrollTop > height || document.documentElement.scrollTop > height ) {
			document.querySelector('#masthead').classList.add('transparent-header');
			
		} else {
			document.querySelector('#masthead').classList.remove('transparent-header');
		}
	}

	function add_fixed_header( win_y_offset, header_el, header_height ) 
	{
		var content_area = document.querySelector( '#content' );
		if ( win_y_offset > header_height ) 
		{
			if ( document.querySelector( '#wpadminbar' ) ) 
			{
				admin_bar = document.querySelector( '#wpadminbar' );
				admin_height = document.querySelector( '#wpadminbar' ).offsetHeight;
				
				if ( getComputedStyle( admin_bar ).position == 'fixed' ) 
				{
					header_el.classList.add( 'fixed' );
					content_area.style = 'padding-top: ' + header_height + 'px;';
					if ( '' == header_el.style.height ) 
					{
						drop_down = setTimeout( function() 
						{
							if ( window.pageYOffset > header_height ) 
							{
								header_el.style = 'height: ' + header_height + 'px; top: ' + admin_height + 'px;';
								setTimeout( function() 
									{
										header_el.style = 'height: ' + header_height + 'px; top: ' + admin_height + 'px; overflow: unset;';

									}, 400 );
							}
							else
							{
								header_el.style = '';
							}
						}, 300 );
					}
				}
				else
				{
					header_el.classList.add( 'fixed' );
					content_area.style = 'padding-top: ' + header_height + 'px;';
					if ( '' == header_el.style.height ) 
					{
						drop_down = setTimeout( function() 
						{
							if ( window.pageYOffset > header_height ) 
							{
								header_el.style = 'height: ' + header_height + 'px; top: 0;';
								setTimeout( function() 
									{
										header_el.style = 'height: ' + header_height + 'px; top: 0; overflow: unset;';

									}, 400 );
							}
							else
							{
								header_el.style = '';
							}
						}, 300 );
					}
				}
			}
			else
			{
				header_el.classList.add( 'fixed' );
				content_area.style = 'padding-top: ' + header_height + 'px;';
				if ( '' == header_el.style.height ) 
				{
					drop_down = setTimeout( function() 
					{
						header_el.style = 'height: ' + header_height + 'px; top: 0;';
						setTimeout( function() 
							{
								header_el.style = 'height: ' + header_height + 'px; top: 0; overflow: unset;';

							}, 400 );
					}, 300 );
				}
			}

		} 
		else
		{
			if ( 0 === win_y_offset ) 
			{
				if ( header_el.classList.contains( 'fixed' ) ) 
				{
					header_el.classList.remove( 'fixed' );
					content_area.style = '';
				}
				clearTimeout( drop_down );
				header_el.style = '';
			}
		}
	}

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
			search_field.setAttribute( 'autocomplete', 'false' );
	
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
								else
								{
									search_results.setAttribute( 'style', 'display: none;');
								}
							});
					}	
				};
		
				xhr.open('GET', wonkasoft_request.ajax + "?" + "action=" + action + "&security=" + wonkasoft_request.security);
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.send();
			});
			search_close.addEventListener( 'click', function ( e ) 
			{
				e.preventDefault();
				search_results.setAttribute( 'style', 'display: none;');
				search_field.value = '';
			});
		}
		
		if ( action === "shipping_to_billing" ) 
		{

			xhr.onreadystatechange = function() {

				if ( this.readyState == 4 && this.status == 200 ) 
				{
					var response = JSON.parse( this.responseText );
				}
			};
			xhr.open('GET', wonkasoft_request.ajax + "?" + "action=" + action + data + "&security=" + wonkasoft_request.security);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send();
		}

	}
	/*===== This is for Keyfeatures | Product Specs links on shor description ====*/
	function scrollToSection( scroll_to_id, adjustment ) 
	{
		var current_el = document.querySelector( '#' + scroll_to_id );
		$('body,html').animate({
			scrollTop : $('#' + scroll_to_id).offset().top - 125                   // Scroll to top of body
		}, 1000);
	}

	function load_page_vars() 
	{
		if ( document.querySelector( '.wonka-cart-open a' ) ) 
		{
			var cart_btn = document.querySelector( '#cart-menu-desktop .wonka-cart-open a' );
			cart_btn.addEventListener( 'click', function( e ) 
				{
					e.preventDefault();
				});
		}

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
		adjustment = window.innerHeight,
		height_set;

		img_for_sizing.src = top_slide_img_holder.getAttribute( 'data-img-url' );
		img_for_sizing.style.width = window.innerWidth + 'px';
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
		if ( document.querySelector( 'footer#colophon' ) ) 
		{
			var footer_height = document.querySelector( 'footer#colophon' ).offsetHeight,
			new_space;

			new_space = document.getElementById( 'footer-spacer' );
			new_space.style.width = '100%';
			new_space.style.height = footer_height + 'px';
		}
	}

	// Open the full screen search box 
	function openSearch( e )
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
	function closeSearch( e ) 
	{
		e.preventDefault();
  		document.querySelector( '#search_overlay' ).style.left = '100%';
  		document.querySelector( '#search_overlay' ).style.opacity = 0;

		setTimeout( function() {
			document.getElementById( "search_overlay" ).style.display = "none";
			document.getElementById( "search_overlay" ).removeAttribute( 'style' );
		}, 300);
	}

	function getUrlVars() {
	   var vars = {};
	   var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
	       vars[key] = value;
	   });
	   return vars;
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
			parallax_adjust = parseFloat( ( window.pageYOffset - top_slider_section.offsetTop ) / ( top_slider_section.offsetHeight / 50 ) ).toFixed( 5 );
			slide_imgs = top_slider_section.querySelectorAll( '.top-slide-img-holder' );
			slide_imgs.forEach( function( el, i ) 
				{
					el.style.backgroundPositionY = parallax_adjust + 'vh';
				});
		}

		if ( window.pageYOffset <= top_slider_section.offsetTop ) 
		{
			slide_imgs = top_slider_section.querySelectorAll( '.top-slide-img-holder' );
			slide_imgs.forEach( function( el, i ) 
				{
					el.style.backgroundPositionY = '';
				});
		}
		/*=====  End of This is for the top slider section for parallax  ======*/

		/*=======================================================================
		=            This is for the cta slider section for parallax            =
		=======================================================================*/
		if ( window.pageYOffset > cta_section.offsetTop && window.pageYOffset < cta_section.offsetTop + cta_section.offsetHeight ) 
		{
			parallax_adjust = parseFloat( (window.pageYOffset - cta_section.offsetTop ) / ( cta_section.offsetHeight / 50 ) ).toFixed( 5 );
			slide_imgs = cta_section.querySelectorAll( '.cta-slide-img-holder' );
			slide_imgs.forEach( function( el, i ) 
				{
					el.style.backgroundPositionY = parallax_adjust + 'vh';
				});
		}

		if ( window.pageYOffset <= cta_section.offsetTop ) 
		{
			slide_imgs = cta_section.querySelectorAll( '.cta-slide-img-holder' );
			slide_imgs.forEach( function( el, i ) 
				{
					el.style.backgroundPositionY = '';
				});
		}
		/*=====  End of This is for the top slider section for parallax  ======*/
		
	}

	function stickyThumbnails( header_el, header_height ) 
	{
		img_area_top = product_img_section.parentElement.offsetTop + wonka_single_product_img_area.offsetTop - 80;
		target_stop = wonka_single_product_img_area.offsetHeight - thumbnail_controls.offsetHeight;
		var scrolling_spacer = document.querySelector( 'div.sticky-spacer' );
		win_y = window.pageYOffset;

		if ( win_y + header_height < img_area_top ) 
		{
			thumbnail_controls.classList.remove( 'sticky-on' );
			thumbnail_controls.removeAttribute( 'style' );
			scrolling_spacer.removeAttribute( 'style' );
		}
		else if ( win_y + header_height - img_area_top > target_stop ) 
		{
			thumbnail_controls.style.top = target_stop + 'px';
			thumbnail_controls.classList.remove( 'sticky-on' );
			scrolling_spacer.style.top = target_stop + 'px';
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
					thumbnail_controls.style.top = header_height + 'px';
					scrolling_spacer.style.top = 0;
				}
				else
				{
					thumbnail_controls.classList.add( 'sticky-on' );
					thumbnail_controls.style.top = admin_height + header_height + 'px';
					scrolling_spacer.style.top = admin_height + 'px';
				}
			}
			else
			{
				thumbnail_controls.classList.add( 'sticky-on' );
				thumbnail_controls.style.top = header_height + 'px';
				scrolling_spacer.style.top = 0;
			}
		} 
	}

	function stickySummary( header_el, header_height ) 
	{
		img_area_top = product_img_section.parentElement.offsetTop + wonka_single_product_img_area.offsetTop - 80;
		target_stop = wonka_single_product_img_area.offsetHeight - summary_section.offsetHeight;
		win_y = window.pageYOffset;

		if ( wonka_single_product_img_area.offsetHeight > summary_section.offsetHeight ) 
		{
			if ( window.innerWidth > 767 + header_height && win_y + header_height < img_area_top ) 
			{
				summary_section.classList.remove( 'sticky-on' );
				summary_section.removeAttribute( 'style' );
			}
			else if ( window.innerWidth > 767 && win_y + header_height - img_area_top > target_stop ) 
			{
				summary_section.style.top = target_stop + 'px';
				summary_section.classList.remove( 'sticky-on' );
			}
			else if ( window.innerWidth > 767 )
			{
				if ( document.querySelector( '#wpadminbar' ) ) 
				{
					admin_bar = document.querySelector( '#wpadminbar' );
					admin_height = document.querySelector( '#wpadminbar' ).offsetHeight;
					
					if ( getComputedStyle( admin_bar ).position == 'absolute' && window.pageYOffset > admin_height ) 
					{
						summary_section.classList.add( 'sticky-on' );
						summary_section.style.top = header_height + 'px';
					}
					else
					{
						summary_section.classList.add( 'sticky-on' );
						summary_section.style.top = admin_height + header_height + 'px';
					}
				}
				else
				{
					summary_section.classList.add( 'sticky-on' );
					summary_section.style.top = header_height + 'px';
				}
			}
		}
	}

	function imageZoom( imgID, resultID ) 
	{
	  var img, lens, result, cx, cy;
	  img = imgID;
	  result = document.getElementById( resultID );
	  /*create lens:*/
	  if ( document.querySelector( '#img-zoom-lens-id' ) ) 
	  {
	  	document.querySelector( '#img-zoom-lens-id' ).parentElement.removeChild( document.querySelector( '#img-zoom-lens-id' ) );
	  }
	  lens = document.createElement( "DIV" );
	  lens.id = 'img-zoom-lens-id';
	  lens.setAttribute( "class", "img-zoom-lens" );
	  /*insert lens:*/
	  img.parentElement.insertBefore( lens, img );
	  /*calculate the ratio between result DIV and lens:*/
	  cx = result.offsetWidth / lens.offsetWidth;
	  cy = result.offsetHeight / lens.offsetHeight;
	  /*set background properties for the result DIV:*/
	  result.style.backgroundImage = "url('" + img.src + "')";
	  result.style.backgroundSize = ( img.width * cx ) + "px " + ( img.height * cy ) + "px";
	  /*execute a function when someone moves the cursor over the image, or the lens:*/
	  lens.addEventListener( "mousemove", moveLens );
	  img.addEventListener( "mousemove", moveLens );
	  /*and also for touch screens:*/
	  lens.addEventListener( "touchmove", moveLens );
	  img.addEventListener( "touchmove", moveLens );

	  function moveLens( e ) 
	  {
	    var pos, x, y;
	    /*prevent any other actions that may occur when moving over the image:*/
	    e.preventDefault();
	    /*get the cursor's x and y positions:*/
	    pos = getCursorPos( e );
	    /*calculate the position of the lens:*/
	    x = pos.x - ( lens.offsetWidth / 2 );
	    y = pos.y - ( lens.offsetHeight / 2 );
	    /*prevent the lens from being positioned outside the image:*/
	    if ( x > img.width - lens.offsetWidth ) { x = img.width - lens.offsetWidth; }
	    if ( x < 0) { x = 0; }
	    if ( y > img.height - lens.offsetHeight ) { y = img.height - lens.offsetHeight; }
	    if ( y < 0 ) { y = 0; }
	    /*set the position of the lens:*/
	    lens.style.left = x + "px";
	    lens.style.top = y + "px";
	    /*display what the lens "sees":*/
	    result.style.backgroundPosition = "-" + ( x * cx ) + "px -" + ( y * cy ) + "px";
	  }

	  function getCursorPos( e ) 
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
	    return { x : x, y : y };
	  }
	}

	function setup_for_reviews( comment_list )
	{
		var first_three_height = 0;
		for ( var i = 0; i < comment_list.children.length; i++ ) 
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

		if ( document.getElementById( 'bill-to-different-address-checkbox2' ) ) 
		{
			if ( document.getElementById( 'bill-to-different-address-checkbox2' ).checked === true ) 
			{
				document.getElementById( "billing_address_1" ).classList.remove( 'input-text' );
				document.getElementById( "billing_address_1" ).removeEventListener( 'change', function() { return; }, true );
				document.getElementById( "billing_address_1" ).removeEventListener( 'keydown', function() { return; }, true );
				document.getElementById( "billing_address_2" ).classList.remove( 'input-text' );
				document.getElementById( "billing_address_2" ).removeEventListener( 'change', function() { return; }, true );
				document.getElementById( "billing_address_2" ).removeEventListener( 'keydown', function() { return; }, true );
				document.getElementById( "billing_city" ).classList.remove( 'input-text' );
				document.getElementById( "billing_city" ).removeEventListener( 'change', function() { return; }, true );
				document.getElementById( "billing_city" ).removeEventListener( 'keydown', function() { return; }, true );

				document.getElementById( "billing_state" ).addEventListener( 'change', function( e ) { e.stopImmediatePropagation(); return; } );
				document.getElementById( "billing_postcode" ).classList.remove( 'input-text' );
				document.getElementById( "billing_postcode" ).removeEventListener( 'change', function() { return; }, true );
				document.getElementById( "billing_postcode" ).removeEventListener( 'keydown', function() { return; }, true );
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

	} 

	function set_password_events() {
		var password_toggle_btns = document.querySelectorAll( 'div.input-group-text' );
		password_toggle_btns.forEach( function( password_toggle_btn )
		{

			password_toggle_btn.addEventListener( 'click', function( e )
			{
				e.stopImmediatePropagation();
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

	/**
	 * Single Product variant set up for images
	 * @author Rudy
	 * @return {[type]} [description]
	 * @since  1.0.0
	 */
	function single_product_variants_setup()
	{
		var variant_lis = document.querySelectorAll( 'ul[data-attribute_name="attribute_pa_color"] li' );
		var thumb_lis = document.querySelectorAll( 'div.wonka-thumbnails [data-variant-check="true"]' );
		var thumb_lis_parent = document.querySelector( 'div.wonka-thumbnails ul' );
		var full_imgs = document.querySelectorAll( 'div.wonka-image-viewer [data-variant-check="true"]' );
		var full_imgs_parent = document.querySelector( 'div.wonka-image-viewer' );
		var variant_selected;
		var thumbs_set;
		var imgs_set;

		if ( variant_lis.length ) 
		{
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

					}
					
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

					item.addEventListener( 'click', function( event ) 
					{
						var variant = event.target;

						if ( variant.nodeName === 'SPAN' ) 
						{
							variant = variant.parentElement;
						}

						if ( variant.getAttribute( 'data-value' ) )
						{
							variant_selected = variant.getAttribute( 'data-value' );
						}

						if ( variant.nodeName === 'A' ) 
						{
							variant = variant.parentElement;
						}

						if ( window.innerWidth < 480 ) 
						{
							$( '.wonka-image-viewer' ).slick( 'unslick' );
						}

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

							if ( window.innerWidth < 480 ) 
							{
								setTimeout( function() 
									{
										$( '.wonka-image-viewer' ).slick({
											slidesToShow: 1,
											slidesToScroll: 1,
											adaptiveHeight: true,
											mobileFirst: true,
											dots: false,
											prevArrow: '<button class="slick-prev" type="button"><i class="far fa-arrow-alt-circle-left"></i></button>',
											nextArrow: '<button class="slick-next" type="button"><i class="far fa-arrow-alt-circle-right"></i></button>',
											responsive: [
												{
												  breakpoint: 768,
												  settings: 'unslick',
												},
											],
										});
									}, 10 );
							}
						}

						if ( variant.firstElementChild.classList.contains( 'reset_variations' ) ) 
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

							if ( window.innerWidth < 480 ) 
							{
								setTimeout( function() 
									{
										$( '.wonka-image-viewer' ).slick({
											slidesToShow: 1,
											slidesToScroll: 1,
											adaptiveHeight: true,
											mobileFirst: true,
											dots: false,
											prevArrow: '<button class="slick-prev" type="button"><i class="far fa-arrow-alt-circle-left"></i></button>',
											nextArrow: '<button class="slick-next" type="button"><i class="far fa-arrow-alt-circle-right"></i></button>',
											responsive: [
												{
												  breakpoint: 768,
												  settings: 'unslick',
												},
											],
										});
									}, 20 );
							}
						}
						
						
					});
				});
		}
		else 
		{
			full_imgs.forEach( function( item, i ) 
				{
					item.classList.add( 'variant-show' );
				});

			thumb_lis.forEach( function( item, i ) 
				{
					item.classList.add( 'variant-show' );
				});
		}

		full_imgs.forEach( function( item, i ) 
			{
				// working on image zoom here

				// item.addEventListener( 'mouseover', function( event )
				// {
				// 	var target = event.target;
				// 	var my_result;
				// 	if ( document.querySelector( '#myresult' ) ) 
				// 	{
				// 		document.querySelector( '#myresult' ).parentElement.removeChild( document.querySelector( '#myresult' ) );
				// 	}
				// 	my_result = document.createElement( 'DIV' );
				// 	my_result.id = 'myresult';
				// 	my_result.classList.add( 'img-zoom-result' );

				// 	if ( target.nodeName === 'DIV' ) 
				// 	{
				// 		target = target.querySelector( 'img' );
				// 	}
				// 	console.log(target);
				// 	if ( target !== null ) 
				// 	{
				// 		target.parentElement.appendChild( my_result );
				// 	}
				// 	my_result.style.height = target.offsetHeight + 'px';
				// 	my_result.style.width = target.offsetWidth + 'px';
				// 	my_result.style.position = 'absolute';
				// 	my_result.style.top = '0';
				// 	// target.classList.add( 'vanish' );
				// 	// imageZoom( target, 'myresult' );
				// });   
				
				// item.addEventListener( 'mouseleave', function( event ) 
				// {
				// 	var target = event.target;

				// 	if ( target.nodeName === 'DIV' ) 
				// 	{
				// 		target = target.querySelector( 'img' );
				// 	}

				// 	if ( target.classList.contains( 'vanish' ) ) 
				// 	{
				// 		target.classList.remove( 'vanish' );
				// 	}

				// 	if ( document.querySelector( '#myresult' ) ) 
				// 	{
				// 		document.querySelector( '#myresult' ).parentElement.removeChild( document.querySelector( '#myresult' ) );
				// 	}

				// 	if ( document.querySelector( '#img-zoom-lens-id' ) ) 
				// 	{
				// 		document.querySelector( '#img-zoom-lens-id' ).parentElement.removeChild( document.querySelector( '#img-zoom-lens-id' ) );
				// 	}
				// } );

				item.addEventListener( 'click', function( event )                   
					{
						var top_adjustment = getComputedStyle( full_imgs_parent.parentElement ).top;
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

	function get_product_imgs() 
	{
		var page_offset = window.pageYOffset;
		var product_imgs = document.querySelectorAll( 'li.product img' );
		if ( 166 < page_offset ) 
		{
			product_imgs.forEach( function( img, i ) 
				{
					img.src = img.getAttribute( 'data-src' );
					img.srcset = img.getAttribute( 'data-srcset' );
				} );
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
		/**
		 * Allows register side on my account page to slide out and in.
		 *
		 * @auther  Carlos
		 */
		if ( document.querySelector( '.create-account-full' ) )
		{
			create_toggle_btn = document.querySelector( '.create-account-full' );
			login_toggle_btn = document.querySelector( '.login-slide-btn' );
			login_col = document.querySelector( 'div.login' );
			register_col = document.querySelector( 'div.register' );
			register_form = document.querySelector( '.apera-registration-form-container' );
			loggin_toggle_wrapper = document.querySelector( 'div.loggin-toggle-wrapper' );

			create_toggle_btn.addEventListener( 'click', function( e )
			{
				create_toggle_btn.classList.toggle('btn-create-toggle');
				setTimeout( function() 
				{
					create_toggle_btn.classList.toggle('display-none');
					create_toggle_btn.toggleAttribute('disabled');
					login_col.classList.toggle( 'collapse-col-login' );
					register_col.classList.toggle( 'col-lg-12' );
					register_form.classList.toggle( 'form-register-toggle' );
					loggin_toggle_wrapper.classList.toggle( 'loggin-toggle-wrapper-visable' );
				}, 200 );
			});

			login_toggle_btn.addEventListener( 'click', function( e )
			{
				create_toggle_btn.classList.toggle('btn-create-toggle');
				setTimeout( function() 
				{
					create_toggle_btn.toggleAttribute('disabled');
					login_col.classList.toggle( 'collapse-col-login' );
					register_col.classList.toggle( 'col-lg-12' );
					register_form.classList.toggle( 'form-register-toggle' );
					loggin_toggle_wrapper.classList.toggle( 'loggin-toggle-wrapper-visable' );
					create_toggle_btn.classList.toggle('display-none');
				}, 200 );
			});
			
			if ( '1' === getUrlVars().create ) 
			{
				create_toggle_btn.click();
			}
		}

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
		
		/*==========================================================
		=            For parallax on front page sliders            =
		==========================================================*/
		if ( document.querySelector( '.home' ) ) 
		{

			var screen_height = window.innerHeight;
			add_transparent( screen_height );

			window.onscroll = function()
			{
				shifting_parallax();
				add_transparent( screen_height );
				get_product_imgs();
			};
			
		}

		if ( document.querySelector( 'body:not(.home) #masthead' ) ) 
		{
			header_el = document.querySelector( '#masthead' );
			header_height = header_el.offsetHeight;
			add_fixed_header( window.pageYOffset, header_el, header_height );

			window.onscroll = function() 
			{
				add_fixed_header( window.pageYOffset, header_el, header_height );
			};
		}
		/*=====  End of For parallax on front page sliders  ======*/
		
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
		
		/*=================================
		=            For Popup            =
		=================================*/
		if ( document.querySelector( 'div.wonka-newsletter-wrap' ) ) 
		{
			var popup_wrap = document.querySelector( 'div.wonka-newsletter-wrap' );
			var time_to_pop = document.querySelector( 'div.wonka-newsletter-wrap' ).getAttribute('time-to-pop') * 1000;
			var popup_dismiss_btns = document.querySelectorAll( 'a.wonka-newsletter-close-btn' );
			setTimeout( function() 
				{
					popup_wrap.classList.add( 'popped-up' );
				}, time_to_pop );

			popup_dismiss_btns.forEach( function( btn, i ) 
				{
					btn.addEventListener( 'click', function( e ) 
					{
						e.preventDefault();
						var el = e.target;
						var data = {};
						data.action = 'wonkasoft_dismiss_popup';
						data.security = wonkasoft_request.security;
						
						if ( el.nodeName === 'SPAN' ) 
						{
							el = el.parentElement;
						}
						
						if ( popup_wrap.classList.contains( 'popped-up' ) ) 
						{
							popup_wrap.classList.remove( 'popped-up' );
						}

						xhr = new XMLHttpRequest();
				        xhr.onreadystatechange = function() {
					        if ( this.readyState == 4 && this.status == 200 )  {
					        	var response =   this;
					        }
				        };
				        xhr.open('POST', wonkasoft_request.ajax + '?action=' + data.action + '&security=' + data.security );
				        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				        xhr.send();

					});
				});
		}
		/*=====  End of For Popup  ======*/

		/**************************************************************************
		 * This allow the user to view their password in the the sign in form CARLOS
		 **************************************************************************/
		if ( document.querySelectorAll( 'div.input-group-append' ) )
		{
			set_password_events();
			document.body.addEventListener( 'keyup', set_password_events );
			document.body.addEventListener( 'change', set_password_events );
		}
		/*===============================================================================
		=            This is the setup for the Wonka Express Checkout Button            =
		===============================================================================*/
		if ( document.querySelector( 'body.woocommerce-checkout' ) ) 
		{
			if ( window.location.href.indexOf( '?add-to-cart' ) > 0 ) 
			{
				window.location = window.location.href.split( '?' )[0];
				if ( document.querySelector( 'div.woocommerce-message' ) ) 
				{
					setTimeout( function() 
						{
							document.querySelector( 'div.woocommerce-message' ).style.display = 'none';
						}, 3500 );
				}
			}

			/*===============================================================
			=            This is for the geolocate of google api            =
			===============================================================*/
			if ( document.querySelector( '#shipping_address_1' ) ) 
			{
		    	document.querySelector( '#shipping_address_1' ).setAttribute( 'onfocus', 'geolocate()' );
			}
			/*=====  End of This is for the geolocate of google api  ======*/
			if ( document.querySelector( 'label[for="shipping_method_free_shipping:4_free_shipping4"]' ) ) 
			{
				var free_shipping_label = document.querySelector( 'label[for="shipping_method_free_shipping:4_free_shipping4"]' );
				var free_text = free_shipping_label.innerText.split( ' ' )[3];
				free_shipping_label.innerHTML = free_shipping_label.innerText.replace( free_text, '<span id="free-shipping-label">' + free_text + '</span>' );
			}
		}
		/*==========================================================
		=            This is for setting up the reviews            =
		==========================================================*/
		if ( document.querySelector( '#write-review' ) ) 
		{
			var write_review = document.querySelector( '#write-review' ),
			comment_form_wrapper = document.querySelector( 'div#review_form_wrapper' ),
			reviews_top = document.querySelector( '.wonka-section-reviews' ),
			more_reviews,
			comment_list;

			if ( document.querySelector( 'ol.commentlist' ) ) 
			{
				comment_list = document.querySelector( 'ol.commentlist' );
				setup_for_reviews( comment_list );
			}

			if ( document.querySelector( '#more-reviews' ) ) 
			{
				more_reviews = document.querySelector( '#more-reviews' );

				more_reviews.addEventListener( 'click', function( e ) 
					{
						e.preventDefault();
						if ( more_reviews.innerText.toLowerCase() === 'less reviews' ) 
						{
							setup_for_reviews( comment_list );
							setTimeout( function() 
								{
									reviews_top.scrollIntoView( { behavior: 'smooth' } );
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

			var write_review_initial_text = write_review.innerText;
			var comment_wrapper_height = comment_form_wrapper.offsetHeight;
			var review_form = document.querySelector( '#review_form' );
			write_review.addEventListener( 'click', function( e ) 
				{
					e.preventDefault();
					if ( comment_form_wrapper.offsetHeight <= 35 ) 
					{
						comment_form_wrapper.style.height = review_form.offsetHeight + 'px';
						write_review.innerText = 'Cancel';
					}
					else
					{
						comment_form_wrapper.style.height = comment_wrapper_height + 'px';
						write_review.innerText = write_review_initial_text;
					}
				});

			/***********************************************************************
			 * This is for Review length
			 **********************************************************************/
			var read_more_btn = document.querySelectorAll( 'a.ws-data-comment-btn' );

			read_more_btn.forEach(function( item, i )
			{

				item.addEventListener( 'click', function( e )
				{
					e.preventDefault();
					var target = e.target;
					var comment_el = target.previousElementSibling;
					var inner_comment = comment_el.innerText;
					var data_comment = comment_el.getAttribute( 'ws-data-comment' );

					if ( document.querySelector( '#more-reviews' ) ) 
					{
						more_reviews = document.querySelector( '#more-reviews' );
					
						if ( comment_el.classList.contains( 'full_comment' ) )
						{
							comment_el.classList.toggle( 'full_comment' );
							comment_el.innerText = data_comment;
							comment_el.setAttribute( 'ws-data-comment', inner_comment );
							target.innerHTML = " <i class='fa fa-angle-down'></i> read more";
							
							if ( more_reviews.innerText.toLowerCase() === 'more reviews' || comment_list.children.length <= 3 )
							{
								setup_for_reviews( comment_list );
							}
						} 
						else 
						{
							comment_el.classList.toggle( 'full_comment' );
							comment_el.innerText = data_comment;
							comment_el.setAttribute( 'ws-data-comment', inner_comment );
							target.innerHTML = " <i class='fa fa-angle-up'></i> read less";
							
							if ( more_reviews.innerText.toLowerCase() === 'more reviews' || comment_list.children.length <= 3 )
							{
								setup_for_reviews( comment_list );
							}

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
										target.innerHTML = " <i class='fa fa-angle-down'></i> read more";
										
										if ( more_reviews.innerText.toLowerCase() === 'more reviews' || comment_list.children.length <= 3 )
										{
											setup_for_reviews( comment_list );
										}
									}
								});
						}
					}
					else
					{
						more_reviews = document.querySelector( '#more-reviews' );
					
						if ( comment_el.classList.contains( 'full_comment' ) )
						{
							comment_el.classList.toggle( 'full_comment' );
							comment_el.innerText = data_comment;
							comment_el.setAttribute( 'ws-data-comment', inner_comment );
							target.innerHTML = " <i class='fa fa-angle-down'></i> read more";
							
							if ( comment_list.children.length <= 3 )
							{
								setup_for_reviews( comment_list );
							}
						} 
						else 
						{
							comment_el.classList.toggle( 'full_comment' );
							comment_el.innerText = data_comment;
							comment_el.setAttribute( 'ws-data-comment', inner_comment );
							target.innerHTML = " <i class='fa fa-angle-up'></i> read less";
							
							if ( comment_list.children.length <= 3 )
							{
								setup_for_reviews( comment_list );
							}

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
										target.innerHTML = " <i class='fa fa-angle-down'></i> read more";
										
										if ( comment_list.children.length <= 3 )
										{
											setup_for_reviews( comment_list );
										}
									}
								});
						}
					}

				});
			});
			/**
			 * End of Review length
			 */
		}

		/**
		 *  This function handles the submit reviews form
		 *  @author Louis Lister
		 *
		 * @since  1.0.0
		 */
		
		if ( document.querySelector( '.comment-form-comment' ) )  {
			    var commentform = document.querySelector( '#commentform' ); // find the comment form
			    var comment_status = document.createElement( 'DIV' );
			    var comment_errors = document.createElement( 'DIV' );
			    comment_status.setAttribute( 'id', 'comment-status' );
			    comment_errors.setAttribute( 'id', 'comment-errors' );
			    commentform.insertBefore( comment_status, document.querySelector( '.comment-form-rating' ) ); // add info panel before the form to provide feedback or errors
			    commentform.insertBefore( comment_errors, document.querySelector( '.comment-form-rating' ) ); // add info panel before the form to provide feedback or errors
			    var statusdiv = document.querySelector( '#comment-status' );
			    var status_errors = document.querySelector( '#comment-errors' );
					var commentform_inputs = commentform.querySelectorAll( 'input' );
			    var errors;
			    //serialize and store form data in a variable
			    var formdata = {};
			    commentform.onsubmit = function( e ) 
			    {
			    	statusdiv.innerHTML = '';
			    	status_errors.innerHTML = '';
			    	errors = '';
			        //Add a status message
			        statusdiv.innerHTML = '<span class="processing-form">Processing... <div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div></span>';
			    	var field_checker = true;

			    	if ( commentform.querySelector( 'select#rating' ).selectedIndex === 0 ) 
			    	{
			    		field_checker = false;
			    		if ( errors !== '' ) 
			    		{
			    			errors += '<p class="ajax-error">You must pick your rating before you can submit this review</p>';
			    		}
			    		else
			    		{
			    			errors = '<p class="ajax-error">You must pick your rating before you can submit this review</p>';
			    		}
			    	}
			    	else
			    	{
			    		formdata.rating = commentform.querySelector( 'select#rating' ).value;
			    	}
			    	if ( commentform.querySelector( 'textarea#comment' ).value === '' ) 
			    	{
			    		field_checker = false;
			    		commentform.querySelector( 'textarea#comment' ).classList.add( 'form-control', 'is-invalid' );
			    		if ( errors !== '' ) 
			    		{
			    			errors += '<p class="ajax-error">You cannot submit a blank review</p>';
			    		}
			    		else
			    		{
			    			errors = '<p class="ajax-error">You cannot submit a blank review</p>';
			    		}
			    	}
			    	else
			    	{
			    		if ( commentform.querySelector( 'textarea#comment' ).classList.contains( 'is-invalid' ) && commentform.querySelector( 'textarea#comment' ).value !== '' ) 
			    		{
			    			commentform.querySelector( 'textarea#comment' ).classList.remove( 'form-control', 'is-invalid' );
			    			formdata.comment = commentform.querySelector( 'textarea#comment' ).value;
			    		}
			    		else
			    		{
			    			formdata.comment = commentform.querySelector( 'textarea#comment' ).value;
			    		}
			    	}

			    	if ( commentform.querySelectorAll( 'input' ).length ) 
			    	{
				    	commentform_inputs.forEach( function( input, i )
				    		{
				    			if ( input.id === 'author' ) 
				    			{
							    	if ( input.value === '' ) 
							    	{
							    		field_checker = false;
							    		input.classList.add( 'form-control', 'is-invalid' );
							    		if ( errors !== '' ) 
							    		{
							    			errors += '<p class="ajax-error">' + input.id + ' is a required field.</p>';
							    		}
							    		else
							    		{
							    			errors = '<p class="ajax-error">' + input.id + ' is a required field.</p>';
							    		}
							    	}

						    		if ( input.value !== '' && input.classList.contains( 'is-invalid' ) ) 
						    		{
						    			input.classList.remove( 'form-control', 'is-invalid' );
						    			formdata.author = document.querySelector( '#author' ).value;
						    		}
						    		else if ( input.value !== '' )
						    		{
						    			formdata.author = document.querySelector( '#author' ).value;
						    		}
				    			}

				    			if ( input.id === 'email' ) 
				    			{
							    	if ( input.value === '' ) 
							    	{
							    		field_checker = false;
							    		input.classList.add( 'form-control', 'is-invalid' );
							    		if ( errors !== '' ) 
							    		{
							    			errors += '<p class="ajax-error" >' + input.id + ' is a required field.</p>';
							    		}
							    		else
							    		{
							    			errors = '<p class="ajax-error" >' + input.id + ' is a required field.</p>';
							    		}
							    	}
							    	else
							    	{
							    		if ( input.value !== '' && input.classList.contains( 'is-invalid' ) ) 
							    		{
							    			input.classList.remove( 'form-control', 'is-invalid' );
							    			formdata.email = document.querySelector( '#email' ).value;
							    		}
							    		else
							    		{
							    			formdata.email = document.querySelector( '#email' ).value;
							    		}
							    	}
				    			}
				    		});
			    	}

			    	formdata.comment_post_ID = commentform.querySelector( 'input[name="comment_post_ID"]').value;

			        //Extract action URL from commentform
			        var formurl = commentform.getAttribute( 'action' );
			        if ( field_checker ) 
			        {

				        //Post Form with data
				        xhr = new XMLHttpRequest();
				        xhr.onreadystatechange = function() {
					        if ( this.readyState == 4 && this.status == 200 )  {
					        	var response =   this;
				                    statusdiv.innerHTML = '<p class="ajax-success" >Thanks for your post. We appreciate your response.</p>';
				                    setTimeout( function() 
				                    	{
				                    		statusdiv.innerHTML = '';
				                    	}, 3000 );

					        }
				        };
				        xhr.open('POST', formurl );
				        xhr.setRequestHeader("Content-type", "application/json");
				        xhr.send( formdata );
	                    
	                    return true;
			        }

			        if ( field_checker === false ) 
			        {
			        	e.preventDefault();
				    	setTimeout( function() 
				    		{
	                    		statusdiv.innerHTML = '';
	                    		status_errors.innerHTML = errors;
				    		}, 3000 );

				    	return false;
			        }
			    };
			}
		/*=====  End of This is for setting up the reviews  ======*/
		

		/*============================================================================================
		=            This is for reordering the placement of elements in add to cart area            =
		============================================================================================*/
		if ( document.querySelector( '.variations .label' ) ) 
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
			var colors_ul;
			var qty_label = document.createElement( 'TH' );
			var qty_label_text = '<span>Quantity</span>';
			var qty_cell = document.createElement( 'TD' );
			var qty_box = document.querySelector( '.woocommerce-variation-add-to-cart .quantity' );
			var clear_li = document.createElement( 'LI' );
			var clear_btn = document.querySelector( '.variations .value .reset_variations' );


			if ( document.querySelector( '.variations .value .color-variable-wrapper' ) ) 
			{
				colors_ul = document.querySelector( '.variations .value .color-variable-wrapper' );
			}
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

			if ( colors_ul ) 
			{
				clear_li.appendChild( clear_btn );
				colors_ul.appendChild( clear_li );
			}
			table_body.appendChild( color_new_swatches_row );
			table.classList.add( 'table' );
			entry_summary.classList.add( 'loaded' );
		}

		if ( document.querySelector( '.stock.out-of-stock' ) ) 
		{
			document.querySelector( '.summary.entry-summary' ).classList.add( 'loaded' );
		}
		/*=====  End of This is for reordering the placement of elements in add to cart area  ======*/

		/*========================================================================================
		=            This will move paypal checkout buttons into express checkout box            =
		========================================================================================*/
		if ( document.querySelector( 'div.wonka-row-express-checkout-btns div.express-checkout-btns' ) ) 
		{
			// var express_box = document.querySelector( 'div.wonka-row-express-checkout-btns div.express-checkout-btns' );
		
			// if ( document.querySelector( '#checkout_paypal_message' ) ) 
			// {
			// 	var iframe_btns = document.querySelector( '.angelleye_smart_button_checkout_top' );

			// 	express_box.appendChild( iframe_btns );	
			// }

			// if ( document.querySelector( '#pay_with_amazon' ) ) 
			// {
			// 	var amazon_quick = document.querySelector( '#pay_with_amazon' );

			// 	express_box.appendChild( amazon_quick );
			// }
		}
		/*=====  End of This will move paypal checkout buttons into express checkout box  ======*/
		
		
		/*===================================================================
		=            This is to kill the about us video on close            =
		===================================================================*/
		if ( document.querySelector( 'div#videoModal' ) ) 
		{
			var about_vid_modal = document.querySelector( 'div#videoModal' );
			var about_vid_close = document.querySelector( 'div#videoModal button.close' );
			var about_vid_iframe;
			about_vid_modal.style.opacity = 0;
			
			document.getElementById("about-modal-link").addEventListener("click", function(e) {
				e.preventDefault();
				var data = {
					'url': wonkasoft_request.ajax,
					'action': 'wonkasoft_add_youtube_source',
					'section': 'about',
					'security': wonkasoft_request.security
				};
				var query_string = Object.keys( data ).map( function( key ) { return key + '=' + data[key]; } ).join('&');
				xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) 
					{
						var response = JSON.parse( this.responseText );
						if ( response.success ) 
						{
							about_vid_modal.style.opacity = 1;
							document.getElementById('about-youtube-source').innerHTML = response.data.src;
						}
						else
						{
							console.log('error '+ response);
						}
					}
				};

				xhr.open('GET', data.url + "?" + query_string );
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.send();
			});

			about_vid_close.onclick = function()
			{
				about_vid_iframe = document.querySelector( 'div#videoModal iframe' );
				about_vid_iframe.src = '';
				about_vid_modal.style.opacity = 0;
			};

			about_vid_modal.onclick = function() 
			{
				about_vid_iframe = document.querySelector( 'div#videoModal iframe' );
				about_vid_iframe.src = '';
				about_vid_modal.style.opacity = 0;
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
			var cause_vid_iframe;
			cause_vid_modal.style.opacity = 0;
			
			document.getElementById("cause-modal-link").addEventListener("click", function(e) {
				e.preventDefault();
				var data = {
					'url': wonkasoft_request.ajax,
					'action': 'wonkasoft_add_youtube_source',
					'section': 'cause',
					'security': wonkasoft_request.security
				};
				var query_string = Object.keys( data ).map( function( key ) { return key + '=' + data[key]; } ).join('&');
				xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {

					if ( this.readyState == 4 && this.status == 200 ) 
					{
						var response = JSON.parse( this.responseText );
						if ( response.success ) 
						{
							cause_vid_modal.style.opacity = 1;
							document.getElementById('cause-youtube-source').innerHTML = response.data.src;
						}
						else
						{
							console.log('error '+ response);
						}
					}
				};

				xhr.open('GET', data.url + "?" + query_string );
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.send();
			});

			cause_vid_close.onclick = function()
			{
				cause_vid_iframe = document.querySelector( 'div#videoModalpop iframe' );
				cause_vid_iframe.src = '';
				cause_vid_modal.style.opacity = 0;
			};

			cause_vid_modal.onclick = function() 
			{
				cause_vid_iframe = document.querySelector( 'div#videoModalpop iframe' );
				cause_vid_iframe.src = '';
				cause_vid_modal.style.opacity = 0;
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
		if (document.querySelector('span.closebtn'))
		{
			var search_btn = document.querySelectorAll( 'li.top-menu-s-btn i' ),
			close_btn = document.querySelector( 'span.closebtn' );
			
			search_btn.forEach( function( item, i ) {
				item.addEventListener( 'click', openSearch );
			} );
			close_btn.addEventListener( 'click', closeSearch );
		}
		/*=====  End of Search btn actions  ======*/
		
		/*===============================================
		=            For single product page            =
		===============================================*/
		if ( document.querySelector( 'body.single-product' ) ) 
		{	
			/************** For review **********************************/
			if ( document.querySelector( '.woocommerce-product-rating' ) ) 
			{
				var rating_div = document.querySelector( '.woocommerce-product-rating' );
				rating_div.addEventListener( 'click', function( e ) {
					scrollToSection( 'section-reviews', null );
				});
			}

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

			// When the user scrolls the page, execute stickyStatus 
			window.onscroll = function(e) 
			{ 
				stickyThumbnails( header_el, header_height );
				stickySummary( header_el, header_height );
				add_fixed_header( window.pageYOffset, header_el, header_height );
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
			  // adaptiveHeight: true,
			  slidesToShow: 1,
			  slidesToScroll: 1,
			  autoplay: true,
			  autoplaySpeed: 4000,
			  pauseOnFocus: true,
			  pauseOnHover: true,
			  fade: true,
			  dots: false,
			  prevArrow: '<button class="slick-prev" type="button"><i class="far fa-arrow-alt-circle-left"></i></button>',
			  nextArrow: '<button class="slick-next" type="button"><i class="far fa-arrow-alt-circle-right"></i></button>',
			});
		}

		if ( document.querySelector( 'body.home .instagram-wrap') ) 
		{
			var image_containers = document.querySelectorAll( '.wonka-insta-box' );
			var slides_to_show = 0;
			var slides_to_scroll = 0;
			if ( image_containers.length >= 5 ) 
			{
				slides_to_show = 5;
				slides_to_scroll = 3;
			}
			else
			{
				slides_to_show = image_containers.length;
				slides_to_scroll = image_containers.length;
			}
			$( 'body.home .instagram-wrap' ).slick({
			  slidesToShow: slides_to_show,
			  slidesToScroll: slides_to_scroll,
			  autoplay: true,
			  autoplaySpeed: 4000,
			  dots: false,
			  prevArrow: '<button class="slick-prev" type="button"><i class="far fa-arrow-alt-circle-left"></i></button>',
			  nextArrow: '<button class="slick-next" type="button"><i class="far fa-arrow-alt-circle-right"></i></button>',
			  responsive: [
    			{
			      breakpoint: 1200,
			      settings: {
			        slidesToShow: ( slides_to_show < 4) ? slides_to_show: 4,
			        slidesToScroll: slides_to_scroll,
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

		if ( document.querySelector( '.wonka-image-viewer' ) ) 
		{
			$( '.wonka-image-viewer' ).slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: true,
				mobileFirst: true,
				dots: false,
				prevArrow: '<button class="slick-prev" type="button"><i class="far fa-arrow-alt-circle-left"></i></button>',
				nextArrow: '<button class="slick-next" type="button"><i class="far fa-arrow-alt-circle-right"></i></button>',
				responsive: [
					{
					  breakpoint: 768,
					  settings: 'unslick',
					},
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
							scrollToSection( 'keyfeatures', 15 );
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
							scrollToSection( 'product-specification', 15 );
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
							scrollToSection( 'section-reviews', 15 );
						}
					} );
			}

			if ( document.querySelector( '#faq-general' ) ) 
			{
				var faq_general_jump = document.querySelector( '#faq-general a' );

				faq_general_jump.addEventListener( 'click', function( e ) 
					{
						e.preventDefault();
						if ( e.target.tagName.toLowerCase() === 'a') 
						{
							one_click = false;
							scrollToSection( 'general', 15 );
						}
					} );
			}

			if ( document.querySelector( '#faq-payment' ) ) 
			{
				var faq_payment_jump = document.querySelector( '#faq-payment a' );

				faq_payment_jump.addEventListener( 'click', function( e ) 
					{
						e.preventDefault();
						if ( e.target.tagName.toLowerCase() === 'a') 
						{
							one_click = false;
							scrollToSection( 'payment', 15 );
						}
					} );
			}

			if ( document.querySelector( '#faq-shipping' ) ) 
			{
				var faq_shipping_jump = document.querySelector( '#faq-shipping a' );

				faq_shipping_jump.addEventListener( 'click', function( e ) 
					{
						e.preventDefault();
						if ( e.target.tagName.toLowerCase() === 'a') 
						{
							one_click = false;
							scrollToSection( 'shipping-returns', 15 );
						}
					} );
			}

			if ( document.querySelector( '#faq-perks' ) ) 
			{
				var faq_perks_jump = document.querySelector( '#faq-perks a' );

				faq_perks_jump.addEventListener( 'click', function( e ) 
					{
						e.preventDefault();
						if ( e.target.tagName.toLowerCase() === 'a') 
						{
							one_click = false;
							scrollToSection( 'perks', 15 );
						}
					} );
			}

			if ( document.querySelector( '#faq-ambassador' ) ) 
			{
				var faq_ambassador_jump = document.querySelector( '#faq-ambassador a' );

				faq_ambassador_jump.addEventListener( 'click', function( e ) 
					{
						e.preventDefault();
						if ( e.target.tagName.toLowerCase() === 'a') 
						{
							one_click = false;
							scrollToSection( 'ambassador', 15 );
						}
					} );
			}

			if ( document.querySelector( '#faq-zip' ) ) 
			{
				var faq_zip_jump = document.querySelector( '#faq-zip a' );

				faq_zip_jump.addEventListener( 'click', function( e ) 
					{
						e.preventDefault();
						if ( e.target.tagName.toLowerCase() === 'a') 
						{
							one_click = false;
							scrollToSection( 'zip', 15 );
						}
					} );
			}

		/*=====  End of This is for single product page short description scrolling  ======*/
	

		/**
		 * This is for login form validation
		 * first if checks for the right pages to validate
		 * 
		 */

		if ( document.querySelector( 'main.main-my-account' ) || document.querySelector( 'main.main-checkout' ) || document.querySelector( 'form.woocommerce-ResetPassword' ) ) 
		{
			
			var validation_div = document.querySelector( '.woocommerce-error' );
			var validation_li = document.querySelectorAll( '.woocommerce-error li' );
			var password_inputs = document.querySelectorAll( 'input#password_current, input#password_1, input#password_2' );
			var invalid_text = document.querySelectorAll( 'div.invalid-feedback' );
			var count = 0;

			/** Form structure for edit my account  */
			if ( document.querySelector( 'form.woocommerce-EditAccountForm' ) || document.querySelector('form.woocommerce-ResetPassword') && document.querySelector( 'form.strength-checker #password_1' ) )
			{
				var password_one = document.querySelector( 'form.strength-checker #password_1' );
				var password_parent = document.querySelector( 'form.strength-checker #password_1' ).parentElement;

				password_one.addEventListener( 'keyup', function ( e ) 
				{
					setTimeout( function() 
						{
							var i_icon = password_parent.querySelector( '.input-group-append' );
							var strength_meter = password_parent.querySelector( '.woocommerce-password-strength' );
							if ( strength_meter ) 
							{
								password_parent.insertBefore( i_icon, strength_meter );
							}
						}, 10 );
				}, true );
			
			}
			/** End Form structure for edit my account */

			if ( validation_div ) 
			{
				var validation_text = validation_div.innerText.trim();
				var validation_text_1 = validation_text.split(' ').slice(1).join(' ');
				var validation_text_2 = validation_text_1.split('.').slice(0,1).join();
				switch( validation_text_2 )
				{
					
					case "Username is required":
						document.querySelector( 'input#username' ).classList.add( "is-invalid" );
						document.querySelector( 'div.invalid-feedback.username' ).innerText = validation_text;
						break;

					case "The password field is empty":
						document.querySelector( 'input#password' ).classList.add( "is-invalid" );
						document.querySelector( 'div.invalid-feedback.password' ).innerText = validation_text;
						break;

					case "Too many failed login attempts":
						document.querySelector( 'input#username' ).classList.add( "is-invalid" );
						document.querySelector( 'input#password' ).classList.add( "is-invalid" );
						document.querySelector( 'div.invalid-feedback.username' ).innerText = validation_text;
						document.querySelector( 'div.invalid-feedback.password' ).innerText = validation_text;
						break;

					case "Incorrect username or password":
						document.querySelector( 'input#username' ).classList.add( "is-invalid" );
						document.querySelector( 'input#password' ).classList.add( "is-invalid" );
						document.querySelector( 'div.invalid-feedback.username' ).innerText = validation_text;
						document.querySelector( 'div.invalid-feedback.password' ).innerText = validation_text;
						break;
						
					case "Please provide a valid email address":
						document.querySelector( 'input#reg_email' ).classList.add( "is-invalid" );
						document.querySelector( 'div.invalid-feedback.reg_email' ).innerText = validation_text;
						break;

					case "An account is already registered with your email address":
						document.querySelector( 'input#reg_email' ).classList.add( "is-invalid" );
						document.querySelector( 'div.invalid-feedback.reg_email' ).innerText = validation_text;
						break;

					case "Please enter an account password":
						document.querySelector( 'input#register_password' ).classList.add( "is-invalid" );
						document.querySelector( 'div.invalid-feedback.register_password' ).innerText = validation_text;
						break;
				}
				validation_li.forEach(function(item)
				{
					validation_text =item.innerText.trim();
					switch (validation_text)
					{
						// Validation for lost password
						case "Enter a username or email address.":
							document.querySelector('input#user_login').classList.add("is-invalid");
							document.querySelector( 'div.invalid-feedback.user_login' ).innerText = validation_text;
							break;

						case "Invalid username or email.":
							document.querySelector('input#user_login').classList.add("is-invalid");
							document.querySelector( 'div.invalid-feedback.user_login' ).innerText = validation_text;
							break;

						// Validation for account edit page
						case "First name is a required field.":
							document.querySelector( 'input#account_first_name' ).classList.add( "is-invalid" );
							document.querySelector( 'div.invalid-feedback.account_first_name' ).innerText = validation_text;
							break;

						case "Last name is a required field.":
							document.querySelector( 'input#account_last_name' ).classList.add( "is-invalid" );
							document.querySelector( 'div.invalid-feedback.account_last_name' ).innerText = validation_text;
							break;

						case "Display name is a required field.":
							document.querySelector( 'input#account_display_name' ).classList.add( "is-invalid" );
							document.querySelector( 'div.invalid-feedback.account_display_name' ).innerText = validation_text;
							break;

						case "Email address is a required field.":
							document.querySelector( 'input#account_email' ).classList.add( "is-invalid" );
							document.querySelector( 'div.invalid-feedback.account_email' ).innerText = validation_text;
							break;
	
						case "Please fill out all password fields.":
							password_inputs.forEach( function(item) 
							{
								item.classList.add("is-invalid");
								invalid_text.forEach(function(item)
								{
									item.innerText = validation_text;
								});
	
							});
							break;
	
						case "New passwords do not match.":
							password_inputs.forEach( function(item, i) 
							{
								if (i !== 0){
									item.classList.add("is-invalid");
									invalid_text.forEach(function(item)
									{
										item.innerText = validation_text;
									});	
								}
							});
							break;

						case "Please enter your password.":
							password_inputs.forEach( function(item, i) 
							{
									item.classList.add("is-invalid");
									invalid_text.forEach(function(item)
									{
										item.innerText = validation_text;
									});	
							});
							break;

						case "Passwords do not match.":
							password_inputs.forEach( function(item, i) 
							{
									item.classList.add("is-invalid");
									invalid_text.forEach(function(item)
									{
										item.innerText = validation_text;
									});	
							});
							break;
					}
				});


			}
		}

		/**
		 * Settup for the compare plugin No Scroll
		 *
		 * @author Carlos
		 */		
 		if(document.querySelector('table.compare-list')) {
 			var compare_table = document.querySelector('table.compare-list');

			compare_table.classList.add('table');
		}

		if ( document.querySelector('a.compare.button') ) 
		{
			var compare_btns = document.querySelector('a.compare.button');
			var body_element = document.querySelectorAll('body')[0];
			var html_element = document.querySelectorAll('html')[0];


			compare_btns.addEventListener( 'click', function ( e ) 
			{

				$(document).bind( 'DOMNodeInserted', function( e )
				{

					if ( document.querySelector('#colorbox').style.display == 'block'  )
					{

						var cboxOverlay_element = document.querySelector('#cboxOverlay');
						var compare_close_btn = document.querySelector('#cboxClose');

						body_element.classList.add('no-scroll');
						html_element.classList.add('no-scroll');

						if ( compare_close_btn )
						{

							compare_close_btn.addEventListener( 'click', function( e )
							{
								if ( body_element.classList.contains( 'no-scroll' ) )
								{
									body_element.classList.remove( 'no-scroll' );
									html_element.classList.remove( 'no-scroll' );
								}
							});
						}
						
						cboxOverlay_element.addEventListener( 'click', function( e )
						{
							if ( body_element.classList.contains( 'no-scroll' ) )
							{
								body_element.classList.remove( 'no-scroll' );
								html_element.classList.remove( 'no-scroll' );
							}
						});
						
					}

				});

			});
				
		}
		/**********  End of Settup for the compare plugin No Scroll  *********/

	
		/*=================================================
		=            Setup for the search form            =
		=================================================*/
		if ( document.querySelector('input#s') )
		{
			xhr = new XMLHttpRequest();
			wonka_ajax_request( xhr, "search_site", null);
		}
		/*=====  End of Setup for the search form  ======*/
		/*=====  End of Setup for the nabar menu transparency  ======*/

		/*=======================================================
		=            This is for the google maps api            =
		=======================================================*/
		if ( document.querySelector( 'body.woocommerce-checkout' ) ) 
		{

			// This example displays an address form, using the autocomplete feature
			// of the Google Places API to help users fill in the information.

			// This example requires the Places library. Include the libraries=places
			// parameter when you first load the API. For example:
			// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

		    componentForm = 
		    {
		        street_number: 'long_name', // Address_1 Numbers only
		        route: 'short_name', // Street only
		        locality: 'long_name', // City Name
		        administrative_area_level_1: 'short_name', // State
		        postal_code: 'long_name', // Zip Code
		        postal_code_suffix: 'long_name', // Zip Code
		    };	

		}

		if ( document.querySelector( '.ui-datepicker-trigger' ) ) 
		{
			
			var datepicker_triggers = document.querySelectorAll( '.ui-datepicker-trigger' );
			var datepicker_div = document.querySelector( '#ui-datepicker-div' );

			datepicker_triggers.forEach( function( picker, i ) 
				{
					var parent_el = picker.parentElement;
					var close_span = parent_el.querySelector( 'span.input-group-text' );
					close_span.appendChild( picker );
				});

			var observer_callback = function( mutationsList, observer ) 
			{
				mutationsList.forEach( function( mutation ) {
					if ( 'childList' === mutation.type ) 
					{
						document.querySelector( '.ui-datepicker-prev span' ).innerText = 'Prev';
					}
				});
			};

			var observer = new MutationObserver( observer_callback );
			observer.observe( datepicker_div, config);
		}

		if ( document.querySelector( '.sbi_photo' ) ) 
		{
			var sbi_photos = document.querySelectorAll( '.sbi_photo' );

			sbi_photos.forEach( function( photo_link ) 
				{
					photo_link.href = 'https://aperabags.com/shop/';
					photo_link.target = '_self';
				});
		}
	
		if( document.querySelector('#perks-upgrade-btn')  ) 
		{
			var upgrade_btn = document.querySelector("#perks-upgrade-btn");
			var upgrade_btn_wrapper = document.querySelector("#upgrade-btn-wrapper");

			upgrade_btn.addEventListener( 'click', function( e ) {
					e.preventDefault();
					var data = {
						'url': wonkasoft_request.ajax,
						'action': 'wonkasoft_upgrade_account_perks',
						'user_id': upgrade_btn.getAttribute('data-user'),
						'security': wonkasoft_request.security
					};
					var query_string = Object.keys( data ).map( function( key ) { return key + '=' + data[key]; } ).join('&');
					xhr = new XMLHttpRequest();
					xhr.onreadystatechange = function() {
	
						if ( this.readyState == 4 && this.status == 200 ) 
						{
							var response = JSON.parse( this.responseText );
							if ( response.success ) 
							{
								if ( 'role added' === response.data.msg || 'roles added' === response.data.msg ) {
									upgrade_btn_wrapper.remove();
									document.location.reload( true );
								}
							}
							else
							{
								console.log('error '+ response);
							}
						}
					};
	
					xhr.open('POST', data.url );
					xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhr.send( query_string );
			});
		}
		
		if ( $('#shipping_phone').length ) {

			$('#shipping_phone').inputmask('1 (999) 999-9999');
		}

		$('#loader-wrapper').fadeOut();
		
		$('[data-toggle="tooltip"]').tooltip();

		if ( document.querySelector( '#earn-aperacash-modal' ) ) 
		{
			var the_modal_title = document.querySelector( '#earn-aperacash-modal .modal-header h3' );
			var the_modal_content = document.querySelector( '#earn-aperacash-modal .modal-body' );
			var aperacash_btns = document.querySelectorAll( 'a[data-target="#earn-aperacash-modal"]' );
			var modal_contents = {
				birthday: {
					title: document.querySelector( '#birthday-for-modal' ).getAttribute( 'data-title' ),
					content: document.querySelector( '#birthday-for-modal' )
				},
				refer: {
					title: document.querySelector( '#refer-for-modal' ).getAttribute( 'data-title' ),
					content: document.querySelector( '#refer-for-modal' )
				},
				review: {
					title: document.querySelector( '#review-for-modal' ).getAttribute( 'data-title' ),
					content: document.querySelector( '#review-for-modal' )
				},
				signup: {
					title: document.querySelector( '#signup-for-modal' ).getAttribute( 'data-title' ),
					content: document.querySelector( '#signup-for-modal' )
				}
			};
			aperacash_btns.forEach( function( btn, i ) 
				{
					btn.addEventListener( 'click', function( e ) 
						{
							e.preventDefault();
							var target = this;
							var target_id = target.id.split( '-' )[0];
							var target_header = modal_contents[target_id].title;
							var target_content = modal_contents[target_id].content;
							the_modal_title.innerText = '';
							the_modal_title.innerText = target_header;
							the_modal_content.innerHTML = '';
							the_modal_content.appendChild( target_content );
							if ( 'review' === target_id ) {
								var go_btn = document.querySelector( '#review-product-btn' );
								var product_select = document.querySelector( '#product-select-box' );
								go_btn.addEventListener( 'click', function( e ) {
									e.preventDefault();
									var url = document.querySelector( '#product-select-box' ).value;
									
									window.location.href = url;
								});
							}

						});
				});
		}

		if ( document.querySelectorAll( 'button[data-btn_id]' ) ) 
		{
			var save_btns = document.querySelectorAll( 'button[data-btn_id]' );
			
			save_btns.forEach( function( btn, i ) 
				{
					btn.addEventListener( 'click', function( e ) 
						{
							e.preventDefault();
							var target = this;
							var form = document.querySelector( 'form.' + target.getAttribute( 'data-btn_id' ) );
							var form_submit_btn = document.querySelector( 'form.' + target.getAttribute( 'data-btn_id' ) + ' *[type=submit]' );
							if ( 'form-contact-details' === target.getAttribute( 'data-btn_id' ) ) 
							{
								form.appendChild( document.querySelector( '#save-account-details-nonce') );
								form_submit_btn.click();
							}
							else 
							{
								form_submit_btn.click();
							}
						});
				});
		}

		if ( document.querySelector( 'form.post-password-form' ) ) {
			if ( getUrlVars().canregister ) 
			{
				var canregister = decodeURIComponent( getUrlVars().canregister ).replace( /\+/gi, ' ' );
				document.querySelector( 'form.post-password-form input[name="post_password"]' ).value = canregister;
				document.querySelector( 'form.post-password-form input[type="submit"]' ).click();
			}
		}

		if ( document.querySelector( '.wonkasoft-wsc-chng' ) ) {
			var qty_changers = document.querySelectorAll( '.wonkasoft-wsc-chng' );

			qty_changers.forEach( function( qty_changer, i ) {
				if ( qty_changer.classList.contains( 'wonkasoft-wsc-plus' ) ) {
					var evt;
					var qty_input_for_event = qty_changer.parentElement.querySelector( 'input' );
					qty_input_for_event.addEventListener( 'input', function( e ) {
						
						var endpoint = 'xoo_wsc_update_cart';
						endpoint += e.target.value > 0 ? '&xoo_wsc_qty_update' : '';

						$.ajax({
							url: xoo_wsc_localize.wc_ajax_url.toString().replace( '%%endpoint%%', endpoint ),
							type: 'POST',
							data: {
								cart_key: e.target.parentElement.parentElement.getAttribute( 'data-product' ),
								new_qty: e.target.value
							},
							success: function(response){
								if(response.fragments){
									var fragments = response.fragments,
										cart_hash =  response.cart_hash;
										console.log( response );
									//Set fragments
							   		$.each( response.fragments, function( key, value ) {
										$( key ).replaceWith( value );
										$( key ).stop( true ).css( 'opacity', '1' ).unblock();
									});

							   		if(wc_cart_fragments_params){
								   		var cart_hash_key = wc_cart_fragments_params.ajax_url.toString() + '-wc_cart_hash';
										//Set cart hash
										sessionStorage.setItem( wc_cart_fragments_params.fragment_name, JSON.stringify( fragments ) );
										localStorage.setItem( cart_hash_key, cart_hash );
										sessionStorage.setItem( cart_hash_key, cart_hash );
									}

									$(document.body).trigger('wc_fragments_loaded');
									$(document.body).trigger('xoo_wsc_cart_updated');

									var single_price = e.target.parentElement.parentElement.querySelector( '.product-name .woocommerce-Price-amount' ).innerHTML.replace( '<span class="woocommerce-Price-currencySymbol">$</span>', '' );
									console.log(single_price * e.target.value );
									var new_subtotal = single_price * e.target.value;
									var product_subtotal_html = '<span class="woocommerce-Price-currencySymbol">$</span>' + new_subtotal.toFixed( 2 );
									var product_subtotal = e.target.parentElement.parentElement.parentElement.querySelector( '.product-total .woocommerce-Price-amount' ).innerHTML = product_subtotal_html;
								}
								else{
									//Print error
									show_notice('error',response.error);
								}
							}

						});
					});
				}

				qty_changer.addEventListener( 'click', function( e ) {
					var qty_input = qty_changer.parentElement.querySelector( 'input' );
					var qty_input_value = qty_changer.parentElement.querySelector( 'input' ).value;
					var evt;
					if ( this.classList.contains( 'wonkasoft-wsc-minus' ) && 1 < qty_input_value ) {
						qty_input.value = parseFloat( qty_input_value ) - 1;
						if ( qty_input_value != qty_input.value ) {
							if ("createEvent" in document) {
							    evt = document.createEvent("HTMLEvents");
							    evt.initEvent("input", false, true);
							    qty_input.dispatchEvent(evt);
							}
							else {
							    qty_input.fireEvent("input");
							}
						}
					}

					if ( this.classList.contains( 'wonkasoft-wsc-plus' ) ) {
						qty_input.value = parseFloat( qty_input_value ) + 1;
						if ( qty_input_value != qty_input.value ) {
							if ("createEvent" in document) {
							    evt = document.createEvent("HTMLEvents");
							    evt.initEvent("input", false, true);
							    qty_input.dispatchEvent(evt);
							}
							else {
							    qty_input.fireEvent("input");
							}
						}
					}
				});
			});
		}
	};
		/*=====  End of This is for running after document is ready  ======*/

})( jQuery );

function initAutocomplete() 
{
  // Create the autocomplete object, restricting the search to geographical
  // location types.
  try {
	  autocomplete = new google.maps.places.Autocomplete(
	      /** @type {!HTMLInputElement} */( document.getElementById( 'shipping_address_1' ) ),
	      {types: ['geocode']});
  }
  catch( err ) {
  	console.log( err );
  	return;
  }

  // Avoid paying for data that you don't need by restricting the set of
	// place fields that are returned to just the address components.
  autocomplete.setFields(['address_component']);

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() 
{
	// Get the place details from the autocomplete object.
	var place = autocomplete.getPlace();
	var addressType = '';
	var val = '';
	var current_street_number = '';
	var shipping_address_1 = document.getElementById( 'shipping_address_1' );
	var shipping_city = document.getElementById( 'shipping_city' );
	var shipping_state = document.getElementById( 'shipping_state' );
	var select2_shipping_state = document.getElementById( 'select2-shipping_state-container' );
	var shipping_postcode = document.getElementById( 'shipping_postcode' );
	// Get each component of the address from the place details
	// and fill the corresponding field on the form.
	for (var i = 0; i < place.address_components.length; i++) 
	{
		addressType = '';
		addressType = place.address_components[i].types[0];
		if ( addressType === 'street_number' ) 
		{
			val = place.address_components[i][componentForm[addressType]];
			current_street_number = val;
		}

		if ( addressType === 'route' ) 
		{
			val = place.address_components[i][componentForm[addressType]];
			if ( i === 0 ) 
			{
				shipping_address_1.value = shipping_address_1.value.split( ' ' )[0];
				shipping_address_1.value += ' ' + val;
			}
			else
			{
				shipping_address_1.value = current_street_number + ' ' + val;
			}
		}

		if ( addressType === 'locality' ) 
		{
			shipping_city.value = '';
			val = place.address_components[i][componentForm[addressType]];
			shipping_city.value = val;
		}

		if ( addressType === 'administrative_area_level_1' ) 
		{
			shipping_state.value = '';
			val = place.address_components[i][componentForm[addressType]];
			shipping_state.value = val;
			select2_shipping_state.title = shipping_state.options[shipping_state.selectedIndex].innerText;
			select2_shipping_state.innerText = shipping_state.options[shipping_state.selectedIndex].innerText;
		}

		if ( addressType === 'postal_code' ) 
		{
			shipping_postcode.value = '';
			val = place.address_components[i][componentForm[addressType]];
			shipping_postcode.value = val;
		}

		if ( addressType === 'postal_code_suffix' ) 
		{
			val = place.address_components[i][componentForm[addressType]];
			shipping_postcode.value += '-' + val;
		}
	}
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() 
{
  if ( navigator.geolocation ) 
  {
    navigator.geolocation.getCurrentPosition( function( position ) 
    {
      var geolocation = 
      {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle(
      {
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds( circle.getBounds() );
    });
  }
}
/*=====  End of This is for the google maps api  ======*/