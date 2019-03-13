<?php
/**
 * Template for displaying search forms in Apera
 *
 * @package apera
 * @subpackage apera
 * @since 1.0.0
 */
?>
  <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="s" class="assistive-text sr-only"><?php _e( 'Search', 'apera' ); ?></label>
    <input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'apera' ); ?>" />
    <button type="submit" class="submit wonka-btn" name="submit" id="searchsubmit"><i class="fa fa-search"></i></button>
  </form>