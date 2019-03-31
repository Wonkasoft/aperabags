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
<section class="wonka-section-product-statement">
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
				<div class="col">
					<table class="table table-hover wonka-product-specs-table">
						<thead>
							<tr>
								<th colspan="3">
									<h4 id="product-spec">Product Specs</h4>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php if ( $product_specs_data->sub_header1 ) : ?>
								<tr>
									<th>
										<?php _e( $product_specs_data->sub_header1 ); ?>
									</th>
									<?php if ( $product_specs_data->options1 ) : 
										foreach ( $product_specs_data->options1 as $option ) : ?>
											<td>
												<?php _e( $option ); ?>
											</td>
										<?php endforeach; ?>

									<?php endif; ?>
								</tr>
							<?php endif; ?>

							<?php if ( $product_specs_data->sub_header2 ) : ?>
								<tr>
									<th>
										<?php _e( $product_specs_data->sub_header2 ); ?>
									</th>
									<?php if ( $product_specs_data->options2 ) : ?>
										<td colspan="2">
											<?php _e( $product_specs_data->options2 ); ?>
										</td>
									<?php endif; ?>
								</tr>
							<?php endif; ?>

							<?php if ( $product_specs_data->sub_header3 ) : ?>
								<tr>
									<th>
										<?php _e( $product_specs_data->sub_header3 ); ?>
									</th>
									<?php if ( $product_specs_data->options3 ) : ?>
										<td colspan="2">
											<?php _e( $product_specs_data->options3 ); ?>
										</td>
									<?php endif; ?>
								</tr>
							<?php endif; ?>

							<?php if ( $product_specs_data->sub_header4 ) : ?>
								<tr>
									<th>
										<?php _e( $product_specs_data->sub_header4 ); ?>
									</th>
									<?php if ( $product_specs_data->options4 ) : ?>
										<td colspan="2">
											<?php _e( $product_specs_data->options4 ); ?>
										</td>
									<?php endif; ?>
								</tr>
							<?php endif; ?>

							<?php if ( $product_specs_data->sub_header5 ) : ?>
								<tr>
									<th>
										<?php _e( $product_specs_data->sub_header5 ); ?>
									</th>
									<?php if ( $product_specs_data->options5 ) : ?>
										<td colspan="2">
											<?php _e( $product_specs_data->options5 ); ?>
										</td>
									<?php endif; ?>
								</tr>
							<?php endif; ?>

							<?php if ( $product_specs_data->sub_header6 ) : ?>
								<tr>
									<th>
										<?php _e( $product_specs_data->sub_header6 ); ?>
									</th>
									<?php if ( $product_specs_data->options6 ) : ?>
										<td colspan="2">
											<div class="option1">
												<?php _e( $product_specs_data->options6[0] ); ?>
											</div>
											<div class="option2">
												<?php _e( $product_specs_data->options6[1] ); ?>
											</div>
										</td>
									<?php endif; ?>
								</tr>
							<?php endif; ?>
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
							<?php if ( $key_feature_data->features_1 ) : ?>
								<tr>
									<th colspan="3">
										<?php _e( $key_feature_data->features_1 ); ?>
									</th>
								</tr>
							<?php endif; ?>

							<?php if ( $key_feature_data->features_2 ) : ?>
								<tr>
									<th colspan="3">
										<?php _e( $key_feature_data->features_2 ); ?>
									</th>
								</tr>
							<?php endif; ?>

							<?php if ( $key_feature_data->features_3 ) : ?>
								<tr>
									<th colspan="3">
										<?php _e( $key_feature_data->features_3 ); ?>
									</th>
								</tr>
							<?php endif; ?>

							<?php if ( $key_feature_data->features_4 ) : ?>
								<tr>
									<th colspan="3">
										<?php _e( $key_feature_data->features_4 ); ?>
									</th>
								</tr>
							<?php endif; ?>

							<?php if ( $key_feature_data->features_5 ) : ?>
								<tr>
									<th colspan="3">
										<?php _e( $key_feature_data->features_5 ); ?>
									</th>
								</tr>
							<?php endif; ?>

							<?php if ( $key_feature_data->features_6->feature_header ) : ?>
								<tr>
									<th>
										<?php _e( $key_feature_data->features_6->feature_header ); ?>
									</th>
								</tr>
								<tr>
									<?php if ( $key_feature_data->features_6->feature_options ) : ?>
										<td colspan="2">
											<ul class="key-feature-points">
												<li>
													<div class="feature-1">
														<?php _e( $key_feature_data->features_6->feature_options[0] ); ?>
													</div>
												</li>
												<li>
													<div class="feature-2">
														<?php _e( $key_feature_data->features_6->feature_options[1] ); ?>
													</div>
												</li>
												<li>
													<div class="feature-3">
														<?php _e( $key_feature_data->features_6->feature_options[2] ); ?>
													</div>
												</li>
											</ul>
										</td>
									<?php endif; ?>
								</tr>
							<?php endif; ?>

							<?php if ( $key_feature_data->features_7 ) : ?>
								<tr>
									<th colspan="3">
										<?php _e( $key_feature_data->features_7 ); ?>
									</th>
								</tr>
							<?php endif; ?>

							<?php if ( $key_feature_data->features_8 ) : ?>
								<tr>
									<th colspan="3">
										<?php _e( $key_feature_data->features_8 ); ?>
									</th>
								</tr>
							<?php endif; ?>

							<?php if ( $key_feature_data->features_9 ) : ?>
								<tr>
									<th colspan="3">
										<?php _e( $key_feature_data->features_9 ); ?>
									</th>
								</tr>
							<?php endif; ?>

							<?php if ( $key_feature_data->features_10 ) : ?>
								<tr>
									<th colspan="3">
										<?php _e( $key_feature_data->features_10 ); ?>
									</th>
								</tr>
							<?php endif; ?>

							<?php if ( $key_feature_data->features_11 ) : ?>
								<tr>
									<th colspan="3">
										<?php _e( $key_feature_data->features_11 ); ?>
									</th>
								</tr>
							<?php endif; ?>

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