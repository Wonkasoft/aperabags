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
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;
?>
<div class="row wonka-row-product-specs">
	<?php $post_id = get_the_ID(); ?>

	<?php
	$key_feature_data = json_decode( get_post_meta( $post_id, 'key_features', true ) );
	if ( ! empty( $key_feature_data ) ) :
		?>
		<div id="keyfeatures" class="col">
			<div class="table-responsive">
			<table class="table table-hover wonka-key-features-table">
				<thead>
					<tr>
						<th colspan="3">
							<h4 class="wonka-title wonka-h4">Key Features</h4>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $key_feature_data as $feature ) :
						if ( is_object( $feature ) ) :
							?>
							<?php if ( ! empty( $feature->feature_header ) ) : ?>
								<tr>
									<th colspan="3">
										<?php _e( $feature->feature_header ); ?>
									</th>
								</tr>
							<?php endif; ?>
							<?php
							if ( ! empty( $feature->feature_options ) && is_array( $feature->feature_options ) ) :
								$feature_options_count = 0;
								?>
							<tr>
								<td colspan="3">
									<ul class="key-feature-points">
										<?php
										foreach ( $feature->feature_options as $option ) :
											$feature_options_count++;
											?>
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
							<?php if ( ! empty( $feature->feature_options ) && is_string( $feature->feature_options ) ) : ?>
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
</div><!-- .table-responsive -->
</div>
<?php endif; ?>

<?php
$product_specs_data = json_decode( get_post_meta( $post_id, 'product_specs', true ) );
if ( ! empty( $product_specs_data ) ) :
	?>
	<div id="product-specification" class="col">
		<table class="table table-hover wonka-product-specs-table">
			<thead>
				<tr>
					<th colspan="2">
						<h4 class="wonka-title wonka-h4" id="product-spec">Product Specs</h4>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ( $product_specs_data as $spec ) :
					?>
					<?php if ( is_string( $spec ) ) : ?>
						<tr>
							<th colspan="2">
								<?php _e( $spec ); ?>
							</th>
						</tr>
					<?php endif; ?>

					<?php if ( is_object( $spec ) ) : ?>
						<?php

						if ( ! empty( $spec ) && empty( $spec->disclosure ) ) :
							?>
							<tr>
								<th>	

									<?php _e( $spec->spec_header ); ?>
								</th>
								<?php if ( ! empty( $spec->points ) && is_array( $spec->points ) ) : ?>
								<td>
									<ul class="product-spec-points">
										<?php
										$spec_count = 0;
										foreach ( $spec->points as $point ) :
											$spec_count++;
											?>
											<li class="spec-point-<?php _e( $spec_count ); ?>">
												<?php _e( $point ); ?>
											</li>
										<?php endforeach; ?>
									</ul>
								</td>
							<?php endif; ?>
							<?php if ( ! empty( $spec->points ) && is_string( $spec->points ) ) : ?>
							<td>
								<?php _e( $spec->points ); ?>
							</td>
						<?php endif; ?>
					</tr>
				<?php endif; ?>
			<?php endif; ?>
					<?php if ( ! empty( $spec->disclosure ) && is_object( $spec->disclosure ) ) : ?>
								<tr>
								<td colspan="2" class="product-disclosures">
									<ul class="product-spec-disclosures">
										<?php
										$disclosure_count = 0;
										foreach ( $spec->disclosure as $disclosure ) :
											$disclosure_count++;
											?>
											<li class="disclosure-point-<?php _e( $disclosure_count ); ?>">
												<?php _e( $disclosure ); ?>
											</li>
										<?php endforeach; ?>
									</ul>
								</td>
								</tr>
							<?php endif; ?>
							<?php if ( ! empty( $spec->disclosure ) && is_string( $spec->disclosure ) ) : ?>
							<tr>
								<td colspan="2" class="product-disclosures">
									<?php _e( $spec->disclosure ); ?>
								</td>
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
	<div class="col-12 col-md-6">
		<table class="table table-hover wonka-healthy-design-table">
			<thead>
				<tr>
					<th>
						<h4 class="wonka wonka-h4">Engineered to Perform</h4>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<span>Our bags keep your gear separated and organized. Cutting-edge, anti-microbial fabrics are designed to fight odor. Get the details:</span>
					</td>
				</tr>
				<tr>
					<td>
						<ul>
							<li>
								Antimicrobial protection - bags are treated with Sanitized Freshness <sup>&reg;</sup> to help fight odor
							</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>
						<ul>
							<li>
								Water and stain-resistant fabric - easy to clean
							</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>
						<ul>
							<li>
								Laser-cut venting - allows your gear to breathe
							</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>
						<ul>
							<li>
								Water-resistant base - protects your gear when placed on wet or damp surfaces
							</li>
						</ul>
					</td>
				</tr>
				<?php
					$fit_pockets = [ 'fit pocket x3 - assorted', 'fit pocket x2 - large', 'fit pocket x2 - medium', 'fit pocket x2 - small' ];
				if ( ! in_array( strtolower( $post->post_title ), $fit_pockets ) ) {
					$some_features  = '';
					$some_features .= '<tr>';
					$some_features .= '<td>';
					$some_features .= '<ul>';
					$some_features .= '<li>';
					$some_features .= 'Laser-Cut Venting - allows your gear to breathe';
					$some_features .= '</li>';
					$some_features .= '</ul>';
					$some_features .= '</tr>';
					$some_features .= '</td>';

					$some_features .= '<tr>';
					$some_features .= '<td>';
					$some_features .= '<ul>';
					$some_features .= '<li>';
					$some_features .= 'Water resistant base - protects your gear when sitting on wet and damp surfaces';
					$some_features .= '</li>';
					$some_features .= '</ul>';
					$some_features .= '</td>';
					$some_features .= '</tr>';

					echo $some_features;
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="col-12 col-md-6">
		<table class="table table-hover wonka-built-to-last-table">
			<thead>
				<tr>
					<th>
						<h4 class="wonka wonka-h4">Built to Last</h4>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<span>We use top-quality materials and construction to create tough bags with a lifetime guarantee. Here's where we spared no expense:</span>
					</td>
				</tr>
				<tr>
					<td>
						<ul>
							<li>
								Lifetime guarantee against manufacturer defects - provides peace of mind
							</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>
						<ul>
							<li>
								Ergonomic and secure zipper pulls - make accessing your gear a snap	
							</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>
						<ul>
							<li>
								Durable fabrics and material - stand up to the rigors of life
							</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>
						<ul>
							<li>
								High visibility logo and venting - adds to Apera&#39;s distinct styling
							</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
