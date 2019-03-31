<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( get_post_meta( get_the_ID(), 'product_statement', true ), 'woocommerce' ) ) );

?>
<section id="product-statement" class="wonka-section-product-statement">
	<?php if ( $heading ) : ?>
		<div class="row wonka-product-statement-header">
			<div class="col text-center">
				<h2><?php echo $heading; ?></h2>
			</div><!-- .col -->
		</div><!-- .row -->
	<?php endif; ?>

	<div class="wonka-product-statement-wrap">
		<div class="row wonka-row-product-statement">
			<div class="col text-center">
				<p>
					<?php the_content(); ?>
				</p>
			</div>
		</div>
		<hr />
		<div class="row wonka-row-product-specs">
			<?php 
			$post_id = get_the_ID();
			$product_specs_data = json_decode( get_post_meta( $post_id, 'product_specs', true ) ); 
			if ( !empty( $product_specs_data ) ) : ?>
				<div id="product-specification" class="col">
					<table class="table table-hover wonka-product-specs-table">
						<thead>
							<tr>
								<th colspan="2">
									<h4 id="product-spec">Product Specs</h4>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach ( $product_specs_data as $spec ) : ?>
								<?php if ( is_string( $spec ) ) : ?>
									<tr>
										<th colspan="2">
											<?php _e( $spec ); ?>
										</th>
									</tr>
								<?php endif; ?>

								<?php if ( is_object( $spec ) ) : ?>
									<?php if ( !empty( $spec ) ) : ?>
										<tr>
											<th>
												<?php _e( $spec->spec_header ); ?>
											</th>
											<?php if ( !empty( $spec->points ) && is_array( $spec->points ) ) : ?>
												<td>
													<ul class="product-spec-points">
												<?php $spec_count = 0;
												foreach ( $spec->points as $point ) : $spec_count++; ?>
														<li class="spec-point-<?php _e( $spec_count ); ?>">
															<?php _e( $point ); ?>
														</li>
												<?php endforeach; ?>
													</ul>
												</td>
											<?php endif; ?>
											<?php if ( !empty( $spec->points ) && is_string( $spec->points ) ) : ?>
												<td>
													<?php _e( $spec->points ); ?>
												</td>
											<?php endif; ?>
										</tr>
									<?php endif; ?>
									<?php if ( !empty( $feature->feature_options ) && is_array( $feature->feature_options ) ) :
										$feature_options_count = 0; ?>
										<tr>
											<td colspan="3">
												<ul class="key-feature-points">
												<?php foreach ( $feature->feature_options as $option ) : $feature_options_count++; ?>
													<li>
														<div class="feature-option-<?php _e( $feature_options_count ); ?>">
															<?php _e( $option ); ?>
														</div>
													</li>
												<?php endforeach; ?>
												</ul>
											</td>
										</tr>
									<?php endif; ?>
								<?php endif; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			<?php endif; ?>
			<?php $key_feature_data = json_decode( get_post_meta( $post_id, 'key_features', true ) );
			if ( !empty( $key_feature_data ) ) : ?>
				<div id="keyfeatures" class="col">
					<table class="table table-hover wonka-key-features-table">
						<thead>
							<tr>
								<th colspan="3">
									<h4>Key Features</h4>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach ( $key_feature_data as $feature ) : 
								if ( is_object( $feature ) ) : ?>
									<?php if ( !empty( $feature->feature_header ) ) : ?>
										<tr>
											<th colspan="3">
												<?php _e( $feature->feature_header ); ?>
											</th>
										</tr>
									<?php endif; ?>
									<?php if ( !empty( $feature->feature_options ) && is_array( $feature->feature_options ) ) :
										$feature_options_count = 0; ?>
										<tr>
											<td colspan="3">
												<ul class="key-feature-points">
												<?php foreach ( $feature->feature_options as $option ) : $feature_options_count++ ?>
													<li>
														<div class="feature-option-<?php _e( $feature_options_count ); ?>">
															<?php _e( $option ); ?>
														</div>
													</li>
												<?php endforeach; ?>
												</ul>
											</td>
										</tr>
									<?php endif; ?>
									<?php if ( !empty( $feature->feature_options ) && is_string( $feature->feature_options ) ) : ?>
										<tr>
											<td colspan="3">
												<?php _e( $option ); ?>
											</td>
										</tr>
									<?php endif; ?>
								<?php endif; ?>

								<?php if ( is_string( $feature ) ) : ?>
									<tr>
										<th colspan="3">
											<?php _e( $feature ); ?>
										</th>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			<?php endif; ?>
		</div><!-- .row -->
		<hr />
		<div class="row wonka-row-product-built">
			<div class="col-6">
				<table class="table wonka-healthy-design-table">
					<thead>
						<tr>
							<th>
								<h4>Healthy by Design</h4>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								Sanitized Freshness
							</td>
						</tr>
						<tr>
							<td>
								Antimicrobial product protection (inside and out, helps fight odor)
							</td>
						</tr>
						<tr>
							<td>
								Water and stain resistant fabric (tdat&#39;s easy to clean)
							</td>
						</tr>
						<tr>
							<td>
								Laser Vented Compartments (allows your gear to breatde)
							</td>
						</tr>
						<tr>
							<td>
								Water resistant base (protects your gear when sitting on wet and damp surfaces)
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-6">
				<table class="table wonka-built-to-last-table">
					<thead>
						<tr>
							<th>
								<h4>Built to Last</h4>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								Lifetime guarantee against manufacture defects (provides peace of mind)
							</td>
						</tr>
						<tr>
							<td>
								Ergonomic and secure zipper pulls (make accessing your gear a snap)
							</td>
						</tr>
						<tr>
							<td>
								Durable fabrics and material (stand up to tde rigors of life)
							</td>
						</tr>
						<tr>
							<td>
								High visibility logo and venting (adds to Apera&#39;s distinct styling)
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>