<?php
/**
 * Theme info page for Coffee Cafe Corner.
 *
 * @package Coffee Cafe Corner
 */

define( 'COFFEE_CAFE_CORNER_DEMO_URL', 'https://legacytheme.net/trial/coffee-cafe-corner/' );
define( 'COFFEE_CAFE_CORNER_THEME_PRO_URL', 'https://www.legacytheme.net/products/coffee-shop-WordPress-theme/' );
define( 'COFFEE_CAFE_CORNER_THEME_DOC_URL', 'https://www.legacytheme.net/tutorial/coffee-cafe-corner/' );
define( 'COFFEE_CAFE_CORNER_THEME_SUPPORT_URL', 'https://WordPress.org/support/theme/coffee-cafe-corner/' );
define( 'COFFEE_CAFE_CORNER_THEME_RATINGS_URL', 'https://WordPress.org/support/theme/coffee-cafe-corner/reviews/' );
define( 'COFFEE_CAFE_CORNER_THEME_UPGRADE_URL', 'https://www.legacytheme.net/products/coffee-shop-WordPress-theme/' );
define( 'COFFEE_CAFE_CORNER_THEME_BUNDLE_URL', 'https://www.legacytheme.net/products/WordPress-theme-bundle/' );


/**
 * Register the theme info submenu.
 */
function coffee_cafe_corner_add_menu() {
	add_theme_page(
		esc_html__( 'Legacy-themes', 'coffee-cafe-corner' ),
		esc_html__( 'Get Theme Info', 'coffee-cafe-corner' ),
		'manage_options',
		'coffee-cafe-corner-theme-info',
		'coffee_cafe_corner_theme_info'
	);
}
add_action( 'admin_menu', 'coffee_cafe_corner_add_menu' );


/**
 * Render the theme info page.
 */
function coffee_cafe_corner_theme_info() {
	$theme = wp_get_theme();
	?>
	<div class="theme-info-get">
		<div class="container">
			<div class="top-section">
				<div class="title">
					<h1 class="info-theme-name">
						<?php esc_html_e( 'Coffee Cafe Corner WordPress Theme', 'coffee-cafe-corner' ); ?>
						<span><?php echo esc_html( $theme->get( 'Version' ) ); ?></span>
					</h1>
					<p><?php echo esc_html( $theme->get( 'Description' ) ); ?></p>
				</div>
			</div>
			<div class="buttons-box">
				<div class="info-btns-link">
					<div class="sidebar">
						<div class="section-box">
							<div class="icon">
								<span class="dashicons dashicons-format-aside"></span>
							</div>
							<div class="heading">
								<h3>
									<a href="<?php echo esc_url( COFFEE_CAFE_CORNER_THEME_DOC_URL ); ?>" target="_blank">
										<?php esc_html_e( 'VIEW DOCUMENTATION', 'coffee-cafe-corner' ); ?>
									</a>
								</h3>
							</div>
						</div>
						<div class="section-box">
							<div class="icon">
								<span class="dashicons dashicons-visibility"></span>
							</div>
							<div class="heading">
								<h3>
									<a href="<?php echo esc_url( COFFEE_CAFE_CORNER_DEMO_URL ); ?>" target="_blank">
										<?php esc_html_e( 'VIEW DEMOS', 'coffee-cafe-corner' ); ?>
									</a>
								</h3>
							</div>
						</div>
						<div class="section-box">
							<div class="icon">
								<span class="dashicons dashicons-admin-generic"></span>
							</div>
							<div class="heading">
								<h3>
									<a href="<?php echo esc_url( COFFEE_CAFE_CORNER_THEME_UPGRADE_URL ); ?>" target="_blank">
										<?php esc_html_e( 'UPGRADE TO PRO', 'coffee-cafe-corner' ); ?>
									</a>
								</h3>
							</div>
						</div>
						<div class="section-box">
							<div class="icon">
								<span class="dashicons dashicons-star-filled"></span>
							</div>
							<div class="heading">
								<h3>
									<a href="<?php echo esc_url( COFFEE_CAFE_CORNER_THEME_RATINGS_URL ); ?>" target="_blank">
										<?php esc_html_e( 'RATE OUR THEME', 'coffee-cafe-corner' ); ?>
									</a>
								</h3>
							</div>
						</div>
						<div class="section-box">
							<div class="icon">
								<span class="dashicons dashicons-sos"></span>
							</div>
							<div class="heading">
								<h3>
									<a href="<?php echo esc_url( COFFEE_CAFE_CORNER_THEME_SUPPORT_URL ); ?>" target="_blank">
										<?php esc_html_e( 'ASK FOR SUPPORT', 'coffee-cafe-corner' ); ?>
									</a>
								</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="middle-section">
				<div class="screnshot-wrapper">
					<div class="scrnsht-box">
						<img class="scrnshot-img" src="<?php echo esc_url( $theme->get_screenshot() ); ?>" alt="<?php esc_attr_e( 'theme screenshot', 'coffee-cafe-corner' ); ?>" />
					</div>
				</div>
			</div>
			<div class="tick-box">
				<div class="comp-box">
					<h2 class="table-heading">
						<?php esc_html_e( 'Why upgrade to Coffee Cafe Corner PRO?', 'coffee-cafe-corner' ); ?>
					</h2>
					<div class="comp-table">
						<table>
							<thead>
								<tr>
									<th class="thead-column1">
										<strong>
											<h4><?php esc_html_e( 'Feature', 'coffee-cafe-corner' ); ?></h4>
										</strong>
									</th>
									<th class="thead-column2">
										<strong>
											<h4><?php esc_html_e( 'Coffee Cafe Corner Free', 'coffee-cafe-corner' ); ?></h4>
										</strong>
									</th>
									<th class="thead-column3">
										<strong>
											<h4><?php esc_html_e( 'Coffee Cafe Corner Pro', 'coffee-cafe-corner' ); ?></h4>
										</strong>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Full Site Editing (FSE) Support', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Global Styles (theme.json)', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Custom Logistics Block Patterns', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Service Card & Booking Button Styles', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Multiple Template Parts (Header, Footer, Sidebar)', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Advanced Template Library', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Multiple Color Palettes & Gradients', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Typography Controls (Fonts, Sizes, Spacing)', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'WooCommerce Block Integration', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Performance Optimized for Logistics Pages', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Animation & Scroll Effects', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Custom Query Loop Designs', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Header & Footer Layout Variations', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Custom 404 & Archive Templates', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr>
									<td class="tbody-column1"><?php esc_html_e( 'Priority Support & SLA', 'coffee-cafe-corner' ); ?></td>
									<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
									<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
								</tr>
								<tr class="last-row">
									<td class="tbody-column1"></td>
									<td class="tbody-column2"></td>
									<td class="tbody-column3">
										<a class="button button-primary button-large" href="<?php echo esc_url( COFFEE_CAFE_CORNER_THEME_PRO_URL ); ?>" target="_blank">
											<?php esc_html_e( 'Upgrade to PRO', 'coffee-cafe-corner' ); ?>
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="bundle-detail">
			<div class="second-side">
				<div class="bundle-wrapper">
					<h3 class="info-theme-name">
						<?php esc_html_e( 'Bundle up and save! Unlock all our modern business themes in one exclusive pack.', 'coffee-cafe-corner' ); ?>
					</h3>
					<div class="scrnsht-box bundlee">
						<img class="scrnshot-img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bundle.png' ); ?>" alt="<?php esc_attr_e( 'bundle image', 'coffee-cafe-corner' ); ?>">
					</div>
					<div class="info-pro-btn">
						<a class="button button-primary button-large bundle-btn" href="<?php echo esc_url( COFFEE_CAFE_CORNER_THEME_BUNDLE_URL ); ?>" target="_blank">
							<?php esc_html_e( 'GET ALL THEMES – $69', 'coffee-cafe-corner' ); ?>
						</a>
					</div>
					<div class="info-pro-btn">
						<a class="button button-primary button-large" href="<?php echo esc_url( COFFEE_CAFE_CORNER_THEME_PRO_URL ); ?>" target="_blank">
							<?php esc_html_e( 'UPGRADE TO PRO', 'coffee-cafe-corner' ); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
