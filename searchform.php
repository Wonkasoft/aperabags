<?php
/**
 * Template for displaying search forms in Apera
 *
 * @package apera
 * @subpackage apera
 * @since 1.0.0
 */

$new_id = ( ! empty( $args['aria_label'] ) ) ? esc_html( $args['aria_label'] ) : 'search';

?>
  <form method="get" id="<?php echo esc_attr( $new_id ); ?>" class="search-form wonka-form-inline form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	  <div class="input-group">
	<label for="s" class="assistive-text sr-only"><?php _e( 'Search', 'apera' ); ?></label>
	<input type="text" class="field wonka-form-control form-control search-autocomplete" name="s" id="s<?php echo '-' . esc_attr( $new_id ); ?>" placeholder="<?php esc_attr_e( 'Enter your search...', 'apera' ); ?>" />
	<button type="submit" class="submit wonka-btn" name="submit" id="<?php echo esc_attr( $new_id ); ?>submit"><i class="fa fa-search"></i></button>
	</div>
  </form>
