<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;
$user       = wp_get_current_user();
$user_roles = $user->roles;

?>
<section class="account-detail-first">
	<p>
	<?php
		printf(
			__( 'Welcome to your account details page. Here, you may view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' ),
			esc_url( wc_get_endpoint_url( 'orders' ) ),
			'#ship-billing-address',
			'#password_current'
		);
		?>
		</p>
</section>
<section class="apera-programs-section">
	<h4 class="apera-programs-title">
		My Apera Programs
	</h4>
	<p>
	<?php
		printf(
			__( 'Manage your Apera <a href="%1$s">Zip</a> and <a href="%2$s">Ambassador</a> Program memberships', 'woocommerce' ),
			esc_url( wc_get_endpoint_url( 'zip-program' ) ),
			esc_url( wc_get_endpoint_url( 'ambassador-program' ) )
		);
		?>
		</p>
		<div class="program-wrapper">
			<div class="apera-programs-side apera-programs-left-side">
				<?php
					$zip_title  = ( in_array( 'apera_zip_affiliate', $user_roles ) ) ? 'My Zip Program >' : 'Learn More >';
					$zip_status = ( in_array( 'apera_zip_affiliate', $user_roles ) ) ? 'Approved' : 'Non-member';
					$zip_link   = ( in_array( 'apera_zip_affiliate', $user_roles ) ) ? esc_url( wc_get_endpoint_url( 'zip-program' ) ) : get_site_url() . '/zip';
					$zip_class  = ( in_array( 'apera_zip_affiliate', $user_roles ) ) ? 'active-account' : '';
				?>
				<a class="program-save-wonka-btn" href="<?php echo $zip_link; ?>"><span class="icon-prepend"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="17px" height="17px" viewBox="0 0 750 750" enable-background="new 0 0 750 750" xml:space="preserve">
											<g id="Zip_Program">
												<g>
													<path fill="#4B5965" d="M546.275,81.087c4.747,2.457-3.247,25.73-18.983,56.13L270.883,632.544    c-15.733,30.394-32.316,54.596-35.762,49.626l-32.237-13.502c-3.445-4.97,4.856-30.271,20.589-60.666l256.41-495.327    c15.735-30.4,30.711-50.06,35.456-47.603L546.275,81.087z" />
													<path fill="#4B5965" d="M717.765,249.712c-3.897,7.531-13.858,8.447-25.098,2.629l-183.123-94.795    c-11.239-5.816-18.245-15.696-13.415-22.747l24.533-49.672c4.827-7.049,16.622-8.695,27.859-2.878l183.124,94.795    c11.24,5.818,15.425,16.055,11.529,23.582L717.765,249.712z" />
													<path fill="#4B5965" d="M639.81,400.308c-3.899,7.53-13.859,8.448-25.099,2.63l-183.124-94.795    c-11.237-5.817-18.245-15.696-13.415-22.748l24.534-49.672c4.826-7.048,16.622-8.695,27.858-2.878L653.69,327.64    c11.238,5.817,15.424,16.055,11.528,23.582L639.81,400.308z" />
													<path fill="#4B5965" d="M463.119,213.369c-3.898,7.531-13.858,8.447-25.099,2.63l-183.124-94.796    c-11.237-5.816-18.244-15.696-13.415-22.747l24.534-49.672c4.828-7.049,16.622-8.695,27.859-2.878L477,140.701    c11.238,5.818,15.424,16.055,11.528,23.582L463.119,213.369z" />
													<path fill="#4B5965" d="M385.162,363.965c-3.898,7.53-13.859,8.446-25.098,2.629L176.94,271.799    c-11.237-5.817-18.244-15.696-13.415-22.748l24.534-49.672c4.827-7.048,16.622-8.695,27.858-2.878l183.125,94.795    c11.238,5.818,15.426,16.055,11.527,23.583L385.162,363.965z" />
													<path fill="#4B5965" d="M561.853,550.904c-3.898,7.529-13.859,8.446-25.098,2.629l-183.125-94.796    c-11.237-5.816-18.244-15.695-13.415-22.747l24.534-49.673c4.828-7.048,16.623-8.694,27.859-2.877l183.125,94.796    c11.239,5.816,15.426,16.055,11.529,23.582L561.853,550.904z" />
													<path fill="#4B5965" d="M483.896,701.5c-3.897,7.531-13.859,8.446-25.098,2.629l-183.125-94.795    c-11.237-5.816-18.244-15.697-13.415-22.748l24.534-49.671c4.828-7.05,16.622-8.695,27.859-2.879l183.125,94.795    c11.237,5.818,15.425,16.056,11.529,23.582L483.896,701.5z" />
													<path fill="#4B5965" d="M307.206,514.561c-3.898,7.529-13.859,8.446-25.098,2.629L98.983,422.394    c-11.237-5.816-18.244-15.695-13.415-22.747l24.534-49.671c4.828-7.049,16.622-8.695,27.859-2.878l183.125,94.795    c11.239,5.817,15.426,16.056,11.529,23.583L307.206,514.561z" />
													<path fill="#4B5965" d="M229.249,665.156c-3.898,7.53-13.859,8.447-25.098,2.629L21.027,572.99    C9.79,567.174,2.783,557.293,7.612,550.242l24.534-49.671c4.827-7.05,16.622-8.695,27.858-2.879l183.125,94.795    c11.238,5.819,15.425,16.056,11.529,23.582L229.249,665.156z" />
												</g>
											</g>
										</svg></span> <?php echo $zip_title; ?></a>
				<ul>
				<li>
					<p>Zip Program</p>
				</li>
				<li>
					<p>Status: <span class="program-status <?php echo $zip_class; ?>"><?php echo $zip_status; ?></span></p>
				</li>	
				</ul>
			</div>
			<div class="apera-programs-side apera-programs-right-side">
				<?php
					$ambassador_title  = ( in_array( 'apera_ambassador_affiliate', $user_roles ) ) ? 'My Ambassador Program >' : 'Learn More >';
					$ambassador_status = ( in_array( 'apera_ambassador_affiliate', $user_roles ) ) ? 'Approved' : 'Non-member';
					$ambassador_link   = ( in_array( 'apera_ambassador_affiliate', $user_roles ) ) ? esc_url( wc_get_endpoint_url( 'ambassador-program' ) ) : get_site_url() . '/ambassador';
					$ambassador_class  = ( in_array( 'apera_ambassador_affiliate', $user_roles ) ) ? 'active-account' : '';
				?>
				<a class="program-save-wonka-btn" href="<?php echo $ambassador_link; ?>"><span class="icon-prepend"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="17px" height="17px" viewBox="0 0 750 750" enable-background="new 0 0 750 750" xml:space="preserve">
					<g id="Ambassadors">
						<g>
							<path fill="#4B5965" d="M725.787,494.786c13.453-38.395,20.793-79.661,20.793-122.648c0-185.455-136.147-339.107-313.945-366.471    C500.617,119.278,625.225,327.155,725.787,494.786z" />
							<path fill="#4B5965" d="M334.054,3.678C148.903,24.411,4.962,181.452,4.962,372.138c0,49.894,9.877,97.474,27.746,140.925    C143.945,325.271,267.622,115.956,334.054,3.678z" />
							<path fill="#4B5965" d="M382.758,186.408L209.316,473.541c119.976-1.434,275.845,40.903,371.669,109.516    c1.614,1.156,1.162,2.346-0.613,1.792c-50.963-15.198-103.959-26.554-195.065-26.554c-80.461,0-170.591,17.158-278.265,69.343    c67.553,71.03,162.969,115.309,268.729,115.309c110.477,0,209.65-48.331,277.582-124.982L382.758,186.408z" />
						</g>
					</g>
				</svg></span> <?php echo $ambassador_title; ?></a>
				<ul>
					<li><p>Ambassador Program</p></li>
					<li><p>Status: <span class="program-status <?php echo $ambassador_class; ?>"><?php echo $ambassador_status; ?></span></p></li>
				</ul>
			</div>
		</div>
</section>
<section class="myaccount-section-divider">
	<div class="myaccount-divider">
		<h4 id="contact-details-section"><?php esc_html_e( 'Contact Details', 'apera-bags' ); ?></h4>
		<button class="btn save-wonka-btn" data-btn_id="form-contact-details"><i class="fas fa-check-circle"></i> Save & Update</button>
	</div>
</section>
<section class="myaccount-contact-details">
	<form class="woocommerce-EditAccountForm edit-account strength-checker form-contact-details" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >
	<fieldset>
	<div class="form-row wonka-form-row first-row">
		<div class="col">
			<label for="account_first_name" class="sr-only"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control wonka-form-control" placeholder="<?php esc_html_e( 'First name *', 'woocommerce' ); ?>" name="account_first_name" id="top_account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
			<div class="invalid-feedback account_first_name"></div>
		</div>
		<div class="col">
			<label for="account_last_name" class="sr-only"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control wonka-form-control" placeholder="<?php esc_html_e( 'Last name *', 'woocommerce' ); ?>" name="account_last_name" id="top_account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
			<div class="invalid-feedback account_last_name"></div>
		</div>
	</div>
	<div class="form-row wonka-form-row">
		<div class="col">
			<label for="account_display_name" class="sr-only"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control wonka-form-control" placeholder="<?php esc_html_e( 'Display name *', 'woocommerce' ); ?>" name="account_display_name" id="top_account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> 
			<div class="invalid-feedback account_display_name"></div>
		</div>
		<div class="col">
			<label for="account_email" class="sr-only"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="email" class="woocommerce-Input woocommerce-Input--email input-text form-control wonka-form-control" placeholder="<?php esc_html_e( 'Email address *', 'woocommerce' ); ?>" name="account_email" id="top_account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
			<div class="invalid-feedback account_email"></div>
		</div>
	</div>
</fieldset>
	<p>
		<button type="submit" class="woocommerce-Button button save-wonka-btn" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>
</form>
</section>
<section class="myaccount-section-divider">
	<div class="myaccount-divider">
		<h4 id="shipping-address-section"><?php esc_html_e( 'Shipping Address', 'apera-bags' ); ?></h4>
		<button class="btn save-wonka-btn" data-btn_id="form-shipping-address"><i class="fas fa-check-circle"></i> Save & Update</button>
	</div>
</section>
<section class="myaccount-shipping-address-section">
		<?php do_action( 'woocommerce_account_edit-address_endpoint', 'shipping' ); ?>
</section>
<section class="myaccount-section-divider">
	<div class="myaccount-divider">
		<h4 id="billing-address-section"><?php esc_html_e( 'Billing Address', 'apera-bags' ); ?></h4>
		<button class="btn save-wonka-btn" data-btn_id="form-billing-address"><i class="fas fa-check-circle"></i> Save & Update</button>
	</div>
</section>
<section class="myaccount-billing-address-section">
	<?php do_action( 'woocommerce_account_edit-address_endpoint', 'billing' ); ?>
</section>
<section class="myaccount-section-divider">
	<div class="myaccount-divider">
		<h4 id="payment-method-section"><?php esc_html_e( 'Billing & Payment Methods', 'apera-bags' ); ?></h4>
	</div>
</section>
<section class="payment-methods-section">
	<?php do_action( 'woocommerce_account_payment-methods_endpoint' ); ?>
</section>
<section class="myaccount-section-divider">
	<div class="myaccount-divider">
		<h4 id="account-password-section"><?php esc_html_e( 'Apera Account Password', 'apera-bags' ); ?></h4>
		<button class="btn save-wonka-btn" data-btn_id="form-password-changes"><i class="fas fa-check-circle"></i> Save & Update</button>
	</div>
</section>
<section class="apera-account-password">
<?php do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account strength-checker form-password-changes" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >
	<div class="form-row wonka-form-row first-row" style="display: none;">
		<div class="col">
			<label for="account_first_name" class="sr-only"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control wonka-form-control" placeholder="<?php esc_html_e( 'First name *', 'woocommerce' ); ?>" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
			<div class="invalid-feedback account_first_name"></div>
		</div>
		<div class="col">
			<label for="account_last_name" class="sr-only"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control wonka-form-control" placeholder="<?php esc_html_e( 'Last name *', 'woocommerce' ); ?>" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
			<div class="invalid-feedback account_last_name"></div>
		</div>
	</div>
	<div class="form-row wonka-form-row" style="display: none;">
		<div class="col">
			<label for="account_display_name" class="sr-only"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control wonka-form-control" placeholder="<?php esc_html_e( 'Display name *', 'woocommerce' ); ?>" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> 
			<div class="invalid-feedback account_display_name"></div>
		</div>
		<div class="col">
			<label for="account_email" class="sr-only"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="email" class="woocommerce-Input woocommerce-Input--email input-text form-control wonka-form-control" placeholder="<?php esc_html_e( 'Email address *', 'woocommerce' ); ?>" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
			<div class="invalid-feedback account_email"></div>
		</div>
	</div>
	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
	<fieldset>
		<legend><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>
		<div class="form-group form-row">
			<label for="password_current" class="sr-only"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<div class="input-group woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control wonka-form-control" placeholder="<?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?>" name="password_current" id="password_current" autocomplete="off" /><div class="input-group-append"><div class="input-group-text"><i toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></i></div></div>
				<div class="invalid-feedback current-password"></div>
			</div>
		</div>
		<div class="form-group form-row">
			<label for="password_1" class="sr-only"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<div class="password_1 input-group woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control wonka-form-control" placeholder="<?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?>" name="password_1" id="password_1" autocomplete="off" /><div class="input-group-append"><div class="input-group-text"><i toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></i></div></div>
				<div class="invalid-feedback password-1"></div>
			</div>
		</div>
		<div class="form-group form-row">
			<label for="password_2" class="sr-only"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
			<div class="input-group woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control wonka-form-control" placeholder="<?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?>" name="password_2" id="password_2" autocomplete="off" /><div class="input-group-append"><div class="input-group-text"><i toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></i></div></div>
				<div class="invalid-feedback password-2"></div>
			</div>
		</div>
	</fieldset>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p>
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="woocommerce-Button button save-wonka-btn" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>
</section>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
