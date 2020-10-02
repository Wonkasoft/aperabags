<?php

/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>
	<div class="MyAccount-navigation-col">
		<nav class="woocommerce-MyAccount-navigation">
			<button class="menu-toggle wonka-btn" aria-controls="myaccount-nav-menu" aria-expanded="false">
				<span><i><svg version="1.1" id="svg2" xml:space="preserve" width="25" height="25" viewBox="0 0 500 500" sodipodi:docname="apera_logo_A_only_white.svg" inkscape:version="0.92.3 (2405546, 2018-03-11)" inkscape:export-filename="/home/lister/Downloads/aperabags/logo/apera_logo_bw200x100.png" inkscape:export-xdpi="96" inkscape:export-ydpi="96"><metadata id="metadata8"><rdf:RDF><cc:Work rdf:about=""><dc:format>image/svg+xml</dc:format><dc:title/></cc:Work></rdf:RDF></metadata><defs id="defs6"/><sodipodi:namedview pagecolor="#ffffff" bordercolor="#666666" borderopacity="1" objecttolerance="10" gridtolerance="10" guidetolerance="10" inkscape:pageopacity="0" inkscape:pageshadow="2" inkscape:window-width="1230" inkscape:window-height="675" id="namedview4" showgrid="false" units="px" fit-margin-top="0" fit-margin-left="0" fit-margin-right="0" fit-margin-bottom="0" inkscape:zoom="0.77083333" inkscape:cx="88.015803" inkscape:cy="242.4555" inkscape:window-x="0" inkscape:window-y="140" inkscape:window-maximized="0" inkscape:current-layer="g12" inkscape:lockguides="false"/><g id="g10" inkscape:groupmode="layer" inkscape:label="ink_ext_XXXXXX" transform="matrix(1.3333333,0,0,-1.3333333,-1.7231138e-4,499.99957)"><g id="g12" transform="matrix(0.18889578,0,0,0.18889578,9.2463299,33.587505)"><path d="m 1472.7964,269.43961 c 0,0 221.5336,-107.34265 419.3909,-261.9102764 13.1318,-10.215312 22.4693,1.5980153 14.85,12.9998264 -7.5784,11.353938 -857.6408,1428.84614 -959.24082,1599.75454 -4.64627,7.7318 -15.40947,7.425 -19.93199,0 C 845.1236,1481.3152 272.04308,510.34465 -19.526687,20.52916 -28.211903,6.1510517 -15.703437,-0.62853237 -6.2751566,6.5585482 398.54964,314.08484 694.543,398.16448 943.15021,398.16448 c 177.33629,0 280.49899,-22.09301 379.69359,-51.6724 3.4568,-1.08205 4.3364,1.23034 1.1966,3.48751 C 1137.5149,483.5297 834.12517,565.93206 600.59504,563.15126 L 938.19202,1122.0404 1472.7964,269.43961" style="fill:#4B5965;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1.02272987;" id="path14" inkscape:connector-curvature="0" inkscape:export-xdpi="96" inkscape:export-ydpi="96"/></g></g></svg></i></span>
			</button>
			<ul id="myaccount-nav-menu" aria-expanded="false">
				<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
					<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
						<a class="wonka-account-btn" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
							<span><?php echo esc_html( $label ); ?></span>
							<div class="myaccount-svg">

								<?php
								switch ( $endpoint ) {
									case 'dashboard':
										?>
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="17px" height="17px" viewBox="0 0 750 750" enable-background="new 0 0 750 750" xml:space="preserve">
											<g id="Dashboard_1_">
												<polygon fill="#4B5965" points="741.851,357 375.495,17.476 9.136,357 103,357 103,732 297,732 297,484 458,484 458,732 648,732    648,357  " />
											</g>
										</svg>
										<?php
										break;

									case 'earn-aperacash':
										?>
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="17px" height="17px" viewBox="0 0 750 750" enable-background="new 0 0 750 750" xml:space="preserve">
											<g id="Earn_AperaCash">
												<g>
													<path fill="#4B5965" d="M306.33,9.271h120.887c5.436,0,10.068,1.915,13.885,5.718c3.804,3.816,5.718,8.448,5.718,13.886v22.053    c0,5.449,1.901,10.49,5.718,15.11c3.803,4.633,8.436,7.492,13.885,8.577c46.825,11.983,91.201,34.854,133.139,68.61    c4.352,3.268,6.803,7.632,7.351,13.069c0.536,5.45-0.817,10.35-4.083,14.703l-63.711,90.664    c-3.268,4.365-7.633,7.083-13.068,8.168c-5.45,1.097-10.352,0-14.702-3.268c-27.771-17.421-53.642-29.813-77.597-37.164    c-23.968-7.352-46.021-11.027-66.16-11.027c-5.998,0-12.941,0.141-20.828,0.409c-7.9,0.281-15.392,1.366-22.462,3.267    c-7.083,1.915-12.941,5.042-17.562,9.394c-4.632,4.365-6.942,10.35-6.942,17.969c0,7.632,5.717,14.435,17.152,20.42    c11.435,5.998,24.504,11.167,39.207,15.519c14.702,4.365,28.855,7.76,42.473,10.21c13.604,2.45,22.322,3.957,26.138,4.493    c19.604,3.816,41.108,9.393,64.526,16.745c23.407,7.351,45.332,18.25,65.752,32.671c20.42,14.435,37.574,33.22,51.459,56.359    c13.886,23.151,20.828,52.147,20.828,86.988c0,53.374-14.575,94.749-43.698,124.154c-29.137,29.404-68.203,48.472-117.211,57.176    c-5.449,1.084-10.082,3.803-13.885,8.168c-3.816,4.351-5.718,9.253-5.718,14.702v23.688c0,5.436-1.914,10.068-5.718,13.885    c-3.816,3.803-8.449,5.718-13.885,5.718H306.33c-5.449,0-10.083-1.915-13.885-5.718c-3.816-3.816-5.718-8.449-5.718-13.885    v-33.489c0-5.45-1.774-10.618-5.31-15.52c-3.547-4.9-8.04-8.168-13.477-9.801c-26.137-7.62-50.105-17.689-71.878-30.222    c-21.785-12.521-41.656-26.138-59.626-40.84c-4.365-3.803-6.815-8.577-7.352-14.295c-0.548-5.717,0.817-10.745,4.084-15.11    l62.894-90.664c3.267-4.352,7.619-7.07,13.068-8.169c5.438-1.084,10.338-0.268,14.703,2.451    c29.405,19.067,58.528,34.038,87.397,44.924c28.856,10.899,55.811,16.336,80.864,16.336c23.955,0,42.192-3.395,54.725-10.21    c12.52-6.802,18.786-17.012,18.786-30.63c0-7.07-2.731-12.66-8.168-16.744c-5.45-4.084-12.66-7.479-21.646-10.21    c-8.984-2.718-19.475-4.9-31.446-6.534c-11.983-1.634-24.235-3.804-36.756-6.535c-11.984-2.169-26.01-4.76-42.065-7.759    c-16.068-2.986-32.544-7.352-49.416-13.069c-16.885-5.718-33.629-12.928-50.233-21.645c-16.616-8.704-31.446-19.872-44.516-33.489    c-13.068-13.605-23.56-29.813-31.446-48.6c-7.9-18.787-11.844-40.967-11.844-66.569c0-25.04,3.395-47.234,10.21-66.569    c6.803-19.322,16.195-36.207,28.18-50.641c11.971-14.421,25.729-26.265,41.249-35.531c15.519-9.252,32.263-16.872,50.232-22.87    c5.437-1.633,9.93-4.761,13.477-9.393c3.535-4.62,5.31-9.661,5.31-15.111v-25.32c0-5.438,1.901-10.07,5.718-13.886    C296.248,11.185,300.881,9.271,306.33,9.271z" />
												</g>
											</g>
										</svg>
										<?php
										break;

									case 'orders':
										?>
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="17px" height="17px" viewBox="0 0 750 750" enable-background="new 0 0 750 750" xml:space="preserve">
											<g id="My_Orders">
												<g>
													<polygon fill="#4B5965" points="44.869,156.443 374.583,323.826 704.299,156.443 374.583,8.279   " />
													<g>
														<polygon fill="#4B5965" points="408,741.953 713,562.992 713,227.834 408,385.431    " />
														<polygon fill="#4B5965" points="341,741.953 36,562.992 36,227.834 341,385.431    " />
													</g>
												</g>
											</g>
										</svg>
										<?php
										break;

									case 'edit-account':
										?>
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="17px" height="17px" viewBox="0 0 750 750" enable-background="new 0 0 750 750" xml:space="preserve">
											<g id="My_Account">
												<circle fill="#4B5965" cx="376" cy="193.305" r="190.581" />
												<path fill="#4B5965" d="M660.879,699.045c0,7.518-0.86,47.955-0.86,47.955H92.148c0,0-1.027-39.754-1.027-47.955   c0-157.338,127.545-284.881,284.879-284.881C533.335,414.164,660.879,541.707,660.879,699.045z" />
											</g>
										</svg>
										<?php
										break;

									case 'zip-program':
										?>
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="17px" height="17px" viewBox="0 0 750 750" enable-background="new 0 0 750 750" xml:space="preserve">
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
										</svg>
										<?php
										break;

									case 'ambassador-program':
										?>
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="17px" height="17px" viewBox="0 0 750 750" enable-background="new 0 0 750 750" xml:space="preserve">
											<g id="Ambassadors">
												<g>
													<path fill="#4B5965" d="M725.787,494.786c13.453-38.395,20.793-79.661,20.793-122.648c0-185.455-136.147-339.107-313.945-366.471    C500.617,119.278,625.225,327.155,725.787,494.786z" />
													<path fill="#4B5965" d="M334.054,3.678C148.903,24.411,4.962,181.452,4.962,372.138c0,49.894,9.877,97.474,27.746,140.925    C143.945,325.271,267.622,115.956,334.054,3.678z" />
													<path fill="#4B5965" d="M382.758,186.408L209.316,473.541c119.976-1.434,275.845,40.903,371.669,109.516    c1.614,1.156,1.162,2.346-0.613,1.792c-50.963-15.198-103.959-26.554-195.065-26.554c-80.461,0-170.591,17.158-278.265,69.343    c67.553,71.03,162.969,115.309,268.729,115.309c110.477,0,209.65-48.331,277.582-124.982L382.758,186.408z" />
												</g>
											</g>
										</svg>
										<?php
										break;
								}
								?>
							</div>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	</div><!-- .col-12 -->
	<?php do_action( 'woocommerce_after_account_navigation' ); ?>
