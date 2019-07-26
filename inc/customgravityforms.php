<?php
/**
 * Apera Bags Custom Gravity Forms / Ajax and features
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @author Louis Lister <llister@wonkasoft.com>
 * @package aperabags
 * @since 1.0.1 Requested Updates
 */

add_action( 'wp_ajax_nopriv_gf_button_get_form', 'gf_button_ajax_get_form' );
add_action( 'wp_ajax_gf_button_get_form', 'gf_button_ajax_get_form' );

// Add the "button" action to the gravityforms shortcode
// e.g. [gravityforms action="button" id=1 text="button text"]
add_filter( 'gform_shortcode_button', 'gf_button_shortcode', 10, 3 );

function gf_button_shortcode( $shortcode_string, $attributes, $content ) {
	$a = shortcode_atts(
		array(
			'id'   => 0,
			'text' => 'Show me the form!',
		),
		$attributes
	);

	$form_id = absint( $a['id'] );

	if ( $form_id < 1 ) {
		return 'Missing the ID attribute.';
	}
	// Enqueue the scripts and styles
	gravity_form_enqueue_scripts( $form_id, true );

	$ajax_url = admin_url( 'admin-ajax.php' );

	$html  = sprintf( '%s', $form_id, $a['text'] );
	$html .= sprintf( '', $form_id );
	$html .= `
	(function (SHFormLoader, $) {
	$('#gf_button_get_form_{$form_id}').click(function(){
	var button = $(this);
	$.get('{$ajax_url}?action=gf_button_get_form&form_id={$form_id}',function(response){
	$.fancybox.open({
	content: response
	});
	if(window['gformInitDatepicker']) {gformInitDatepicker();}

	});
	});
	}(window.SHFormLoader = window.SHFormLoader || {}, jQuery));
	`;
	return $html;
}
$form_id = isset( $_GET['form_id'] ) ? absint( $_GET['form_id'] ) : 0;

add_filter( 'gform_pre_render_' . $form_id, 'fix_admin_labels' );

function fix_admin_labels( $form ) {
	foreach ( $form['fields'] as $i => $field ) {
		if ( isset( $field['adminLabel'] ) ) {
			$field['adminLabel'] = $field['label'];
		}
	}
	return $form;
};

function gf_button_ajax_get_form() {
	global $form_id;
	gravity_form( $form_id, true, false, false, false, true );
	die();
}
