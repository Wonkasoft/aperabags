<?php
/**
 * Template for displaying search forms in Apera
 *
 * @package apera
 * @subpackage apera
 * @since 1.0.0
 */
?>
  <form method="get" id="searchform" class="wonka-form-inline form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  	<div class="input-group">
    <label for="s" class="assistive-text sr-only"><?php _e( 'Search', 'apera' ); ?></label>
    <input type="text" class="field wonka-form-control form-control search-autocomplete" name="s" id="s" placeholder="<?php esc_attr_e( 'Enter your search...', 'apera' ); ?>" />
    <button type="submit" class="submit wonka-btn" name="submit" id="searchsubmit"><i class="fa fa-search"></i></button>
	</div>
  </form>