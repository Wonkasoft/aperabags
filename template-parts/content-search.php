<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package aperabags
 */

?>
<div class="col-6 col-md-4">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header wonka-search-header">
		<?php apera_bags_post_thumbnail(); ?>
	</header><!-- .entry-header -->
	<content class="row wonka-row">
		<div class="col-12">
		
		<?php the_title( sprintf( '<h2 class="entry-title wonka-search-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			apera_bags_posted_on();
			apera_bags_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
		</div>
		<div class="col-12">
		<div class="entry-summary wonka-search-excerpt">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

		</div>
	</content>
	<footer class="entry-footer wonka-search-footer">
		<div class="wonka-row">
			<?php apera_bags_entry_footer(); ?>
		</div>
		<div class="wonka-row">
		<a class="btn wonka-btn" href="<?php echo get_permalink(); ?>" rel="bookmark">See Details</a>
		<!-- commented out comments area --> 
		<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'apera-bags' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>',
				get_the_ID(),
				'wonka-btn'
			);
		?>
		</div>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
</div> <!-- .col -->
