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
    <label for="s" class="assistive-text"><?php _e( 'Search', 'twentyeleven' ); ?></label>
    <input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'twentyeleven' ); ?>" />
    <input type="submit" class="submit wonka-btn" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'apera' ); ?>" />
  </form>