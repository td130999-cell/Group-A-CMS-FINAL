<?php
/**
 * Class Coffee_Cafe_Corner_Search_DB
 *
 * Handles database interaction and AJAX endpoints for Quills Coffee Live Search:
 * - Queries products, pages, and collections dynamically from the WordPress database
 * - Provides live predictive search with two-column layout (Products vs Suggestions/Pages/Collections)
 * - Renders the Quills-style Search Modal with linen background and 4 featured category cards
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Coffee_Cafe_Corner_Search_DB {

	/**
	 * Initialize hooks
	 */
	public static function init() {
		add_action( 'wp_ajax_quills_live_search', array( __CLASS__, 'ajax_live_search' ) );
		add_action( 'wp_ajax_nopriv_quills_live_search', array( __CLASS__, 'ajax_live_search' ) );
		add_action( 'wp_footer', array( __CLASS__, 'render_search_modal' ) );
	}

	/**
	 * AJAX endpoint for live search
	 */
	public static function ajax_live_search() {
		$query = isset( $_REQUEST['q'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['q'] ) ) : '';
		if ( empty( $query ) ) {
			$query = isset( $_REQUEST['s'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) : '';
		}

		$query = trim( $query );

		if ( empty( $query ) ) {
			wp_send_json_success( array(
				'query'        => '',
				'total_count'  => 0,
				'products'     => '',
				'suggestions'  => array(),
				'pages'        => array(),
				'collections'  => array(),
			) );
		}

		$products_data = self::search_products( $query, 6 );
		$pages_data    = self::search_pages( $query, 5 );
		$collections   = self::search_collections( $query, 5 );
		$suggestions   = self::get_suggestions( $query, 6 );

		// Render HTML for products
		ob_start();
		if ( ! empty( $products_data ) ) {
			foreach ( $products_data as $product ) {
				self::render_product_card( $product, $query );
			}
		} else {
			?>
			<div class="quills-search-no-results">
				<p><?php printf( esc_html__( 'No products found for "%s".', 'coffee-cafe-corner' ), esc_html( $query ) ); ?></p>
			</div>
			<?php
		}
		$products_html = ob_get_clean();

		wp_send_json_success( array(
			'query'        => $query,
			'total_count'  => count( $products_data ),
			'products'     => $products_html,
			'suggestions'  => $suggestions,
			'pages'        => $pages_data,
			'collections'  => $collections,
			'view_all_url' => esc_url( home_url( '/?s=' . urlencode( $query ) ) ),
		) );
	}

	/**
	 * Search products from database using WP_Query
	 *
	 * @param string $keyword
	 * @param int    $limit
	 * @return array
	 */
	public static function search_products( $keyword, $limit = 6 ) {
		global $wpdb;

		$keyword_escaped = '%' . $wpdb->esc_like( $keyword ) . '%';

		// Query products matching title, content, or metadata in database
		$sql = $wpdb->prepare( "
			SELECT DISTINCT p.ID, p.post_title, p.post_name
			FROM {$wpdb->posts} p
			LEFT JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
			WHERE p.post_type = 'product'
			  AND p.post_status = 'publish'
			  AND (
			      p.post_title LIKE %s
			      OR p.post_content LIKE %s
			      OR (pm.meta_key IN ('_coffee_type', '_coffee_process', '_coffee_tasting_notes', '_coffee_roast') AND pm.meta_value LIKE %s)
			  )
			ORDER BY 
			  CASE 
			    WHEN p.post_title LIKE %s THEN 1
			    ELSE 2
			  END,
			  p.menu_order ASC,
			  p.post_title ASC
			LIMIT %d
		", $keyword_escaped, $keyword_escaped, $keyword_escaped, '%' . $wpdb->esc_like( $keyword ) . '%', (int) $limit );

		$rows = $wpdb->get_results( $sql );
		$products = array();

		if ( $rows ) {
			foreach ( $rows as $row ) {
				$pid = (int) $row->ID;
				$title = $row->post_title;
				$permalink = get_permalink( $pid );
				$image = self::get_product_image_url( $pid );

				// Price
				$price_display = get_post_meta( $pid, '_price_display', true );
				if ( empty( $price_display ) ) {
					$price = get_post_meta( $pid, '_price', true );
					if ( ! empty( $price ) ) {
						$price_display = '$' . number_format( (float) $price, 2 );
					} else {
						$price_display = 'FROM $20.00';
					}
				}

				// Ratings
				$rating = (float) get_post_meta( $pid, '_wc_average_rating', true );
				$review_count = (int) get_post_meta( $pid, '_wc_review_count', true );

				$products[] = array(
					'id'           => $pid,
					'title'        => $title,
					'permalink'    => $permalink,
					'image'        => $image,
					'price_display'=> $price_display,
					'rating'       => $rating,
					'review_count' => $review_count,
				);
			}
		}

		return $products;
	}

	/**
	 * Search pages from database
	 *
	 * @param string $keyword
	 * @param int    $limit
	 * @return array
	 */
	public static function search_pages( $keyword, $limit = 5 ) {
		global $wpdb;

		$keyword_escaped = '%' . $wpdb->esc_like( $keyword ) . '%';

		$sql = $wpdb->prepare( "
			SELECT ID, post_title, post_name
			FROM {$wpdb->posts}
			WHERE post_type = 'page'
			  AND post_status = 'publish'
			  AND post_title LIKE %s
			  AND post_name NOT IN ('sample-page', 'checkout', 'cart', 'my-account')
			ORDER BY post_title ASC
			LIMIT %d
		", $keyword_escaped, (int) $limit );

		$rows = $wpdb->get_results( $sql );
		$pages = array();
		$seen_titles = array();

		if ( $rows ) {
			foreach ( $rows as $row ) {
				$clean_title = wp_specialchars_decode( $row->post_title, ENT_QUOTES );
				$normalized = strtolower( trim( $clean_title ) );
				if ( in_array( $normalized, $seen_titles, true ) ) {
					continue;
				}
				$seen_titles[] = $normalized;

				$pages[] = array(
					'id'    => (int) $row->ID,
					'title' => $clean_title,
					'url'   => get_permalink( (int) $row->ID ),
				);
			}
		}

		return $pages;
	}

	/**
	 * Search collections (product categories) from database
	 *
	 * @param string $keyword
	 * @param int    $limit
	 * @return array
	 */
	public static function search_collections( $keyword, $limit = 5 ) {
		global $wpdb;

		$keyword_escaped = '%' . $wpdb->esc_like( $keyword ) . '%';

		$sql = $wpdb->prepare( "
			SELECT t.term_id, t.name, t.slug
			FROM {$wpdb->terms} t
			INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
			WHERE tt.taxonomy = 'product_cat'
			  AND (t.name LIKE %s OR t.slug LIKE %s)
			  AND t.slug != 'uncategorized'
			ORDER BY t.name ASC
			LIMIT %d
		", $keyword_escaped, $keyword_escaped, (int) $limit );

		$rows = $wpdb->get_results( $sql );
		$collections = array();

		// Mapping custom page routes if available
		$route_map = array(
			'coffee'        => home_url( '/coffee/' ),
			'subscriptions' => home_url( '/subscriptions/' ),
			'brew-gear'     => home_url( '/brew-gear/' ),
			'merch'         => home_url( '/merch/' ),
		);

		// If user typed "all" or "all products", include All Products collection
		if ( stripos( 'all products', $keyword ) !== false || stripos( 'products', $keyword ) !== false ) {
			$collections[] = array(
				'name' => 'All Products',
				'url'  => home_url( '/coffee/' ),
			);
		}

		if ( $rows ) {
			foreach ( $rows as $row ) {
				$url = isset( $route_map[ $row->slug ] ) ? $route_map[ $row->slug ] : get_term_link( (int) $row->term_id, 'product_cat' );
				if ( is_wp_error( $url ) ) {
					$url = home_url( '/?product_cat=' . $row->slug );
				}
				$collections[] = array(
					'name' => $row->name,
					'url'  => $url,
				);
			}
		}

		// Also check coffee types (Espresso, Decaf, Blend, Single Origin) as virtual collections
		$coffee_types = array(
			'Espresso'      => home_url( '/coffee/?tab=espresso' ),
			'Decaf'         => home_url( '/coffee/?tab=decaf' ),
			'Blends'        => home_url( '/coffee/?tab=blend' ),
			'Single Origin' => home_url( '/coffee/?tab=single-origin' ),
		);

		foreach ( $coffee_types as $type_name => $type_url ) {
			if ( stripos( $type_name, $keyword ) !== false ) {
				// Avoid duplicates
				$exists = false;
				foreach ( $collections as $c ) {
					if ( strcasecmp( $c['name'], $type_name ) === 0 ) {
						$exists = true;
						break;
					}
				}
				if ( ! $exists ) {
					$collections[] = array(
						'name' => $type_name,
						'url'  => $type_url,
					);
				}
			}
		}

		return array_slice( $collections, 0, $limit );
	}

	/**
	 * Compute suggestions dynamically from database product names, categories, and attributes
	 *
	 * @param string $keyword
	 * @param int    $limit
	 * @return array
	 */
	public static function get_suggestions( $keyword, $limit = 6 ) {
		global $wpdb;

		$keyword_lower = strtolower( trim( $keyword ) );
		$suggestions = array();

		// Words source: product titles, coffee types, processes
		$results = $wpdb->get_col( "
			SELECT DISTINCT post_title 
			FROM {$wpdb->posts} 
			WHERE post_type = 'product' AND post_status = 'publish'
		" );

		$candidates = array();

		// Built-in authentic Quills search terms
		$quills_known_terms = array(
			'alma', 'ardi', 'embu aa', 'inkwell', 'blacksmith', 'southern gothic',
			'night owl', 'black condor', 'bit of both', 'ommagourd', 'decaf',
			'colombia', 'guatemala', 'espresso', 'single origin', 'blend',
			'cold brew', 'french press', 'pour over', 'whole bean', 'ground',
			'baratza', 'breville', 'hoodie', 'tote bag', 'hat', 'mug'
		);

		foreach ( $quills_known_terms as $term ) {
			if ( stripos( $term, $keyword_lower ) !== false ) {
				$candidates[] = $term;
			}
		}

		if ( $results ) {
			foreach ( $results as $title ) {
				$clean = strtolower( trim( preg_replace( '/[|()™]/', ' ', $title ) ) );
				$parts = array_filter( array_map( 'trim', explode( ' ', $clean ) ) );

				// Check each part
				foreach ( $parts as $part ) {
					if ( strlen( $part ) >= 3 && stripos( $part, $keyword_lower ) !== false ) {
						$candidates[] = $part;
					}
				}

				// Check 2-word combinations
				if ( stripos( $clean, $keyword_lower ) !== false ) {
					$candidates[] = $clean;
				}
			}
		}

		$candidates = array_unique( array_filter( $candidates ) );

		// Prioritize terms starting with the keyword
		usort( $candidates, function( $a, $b ) use ( $keyword_lower ) {
			$a_starts = ( stripos( $a, $keyword_lower ) === 0 );
			$b_starts = ( stripos( $b, $keyword_lower ) === 0 );
			if ( $a_starts && ! $b_starts ) return -1;
			if ( ! $a_starts && $b_starts ) return 1;
			return strlen( $a ) - strlen( $b );
		} );

		return array_slice( $candidates, 0, $limit );
	}

	/**
	 * Get product image URL by checking multiple metadata options and directories
	 *
	 * @param int $product_id
	 * @return string
	 */
	public static function get_product_image_url( $product_id ) {
		// If class Coffee DB has a resolver, use it
		if ( class_exists( 'Coffee_Cafe_Corner_Coffee_DB' ) && method_exists( 'Coffee_Cafe_Corner_Coffee_DB', 'get_product_image_url' ) ) {
			$url = Coffee_Cafe_Corner_Coffee_DB::get_product_image_url( $product_id );
			if ( ! empty( $url ) && ! str_ends_with( $url, 'inkwell.jpg' ) ) {
				return $url;
			}
		}

		$theme_dir = get_template_directory();
		$theme_uri = get_template_directory_uri();
		$upload_dir = wp_upload_dir();

		// Check meta keys
		$keys = array( '_coffee_image', '_coffee_fallback_image', '_brew_gear_image', '_merch_image', '_subscription_image' );
		foreach ( $keys as $k ) {
			$val = get_post_meta( $product_id, $k, true );
			if ( ! empty( $val ) ) {
				$rel = ltrim( $val, '/\\' );
				if ( file_exists( $upload_dir['basedir'] . '/' . $rel ) ) {
					return $upload_dir['baseurl'] . '/' . $rel;
				}
				if ( file_exists( $theme_dir . '/assets/images/' . $rel ) ) {
					return trailingslashit( $theme_uri ) . 'assets/images/' . $rel;
				}
				$base = basename( $rel );
				if ( file_exists( $theme_dir . '/assets/images/coffee/' . $base ) ) {
					return trailingslashit( $theme_uri ) . 'assets/images/coffee/' . $base;
				}
				if ( file_exists( $theme_dir . '/assets/images/brew-gear/' . $base ) ) {
					return trailingslashit( $theme_uri ) . 'assets/images/brew-gear/' . $base;
				}
				if ( file_exists( $theme_dir . '/assets/images/merch/' . $base ) ) {
					return trailingslashit( $theme_uri ) . 'assets/images/merch/' . $base;
				}
			}
		}

		if ( has_post_thumbnail( $product_id ) ) {
			return get_the_post_thumbnail_url( $product_id, 'medium' );
		}

		return trailingslashit( $theme_uri ) . 'assets/images/coffee/inkwell.jpg';
	}

	/**
	 * Render a single product card in the live search grid
	 *
	 * @param array  $product
	 * @param string $query
	 */
	public static function render_product_card( $product, $query = '' ) {
		$title = $product['title'];
		$highlighted_title = esc_html( $title );

		if ( ! empty( $query ) ) {
			$pattern = '/' . preg_quote( $query, '/' ) . '/i';
			$highlighted_title = preg_replace( $pattern, '<mark class="quills-search-highlight">$0</mark>', $highlighted_title );
		}

		$rating = (float) $product['rating'];
		$review_count = (int) $product['review_count'];
		?>
		<article class="quills-search-product-card">
			<a href="<?php echo esc_url( $product['permalink'] ); ?>" class="quills-search-product-link">
				<div class="quills-search-product-media">
					<img src="<?php echo esc_url( $product['image'] ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="quills-search-product-img" loading="lazy" />
				</div>
				<div class="quills-search-product-info">
					<span class="quills-search-product-brand"><?php esc_html_e( 'QUILLS COFFEE', 'coffee-cafe-corner' ); ?></span>
					<h4 class="quills-search-product-title"><?php echo wp_kses_post( $highlighted_title ); ?></h4>
					
					<div class="quills-search-product-rating">
						<span class="quills-search-stars">
							<?php
							$rounded = round( $rating );
							for ( $i = 1; $i <= 5; $i++ ) {
								if ( $i <= $rounded && $rating > 0 ) {
									echo '<span class="quills-star quills-star--filled">★</span>';
								} else {
									echo '<span class="quills-star quills-star--empty">☆</span>';
								}
							}
							?>
						</span>
						<?php if ( $review_count > 0 ) : ?>
							<span class="quills-search-review-count">(<?php echo (int) $review_count; ?>)</span>
						<?php endif; ?>
					</div>

					<div class="quills-search-product-price">
						<?php echo esc_html( $product['price_display'] ); ?>
					</div>
				</div>
			</a>
		</article>
		<?php
	}

	/**
	 * Render the Search Modal markup into wp_footer
	 */
	public static function render_search_modal() {
		$theme_uri = get_template_directory_uri();
		?>
		<!-- Quills Search Modal Drawer -->
		<div id="quills-search-modal" class="quills-search-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Search dialog', 'coffee-cafe-corner' ); ?>">
			<div class="quills-search-backdrop" id="quills-search-backdrop"></div>
			
			<div class="quills-search-container">
				<!-- Header Close Button -->
				<button type="button" class="quills-search-close-btn" id="quills-search-close-btn" aria-label="<?php esc_attr_e( 'Close search', 'coffee-cafe-corner' ); ?>">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#151515" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<line x1="18" y1="6" x2="6" y2="18"></line>
						<line x1="6" y1="6" x2="18" y2="18"></line>
					</svg>
				</button>

				<!-- Search Input Bar -->
				<div class="quills-search-bar-wrap">
					<form role="search" method="get" class="quills-search-modal-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<div class="quills-search-input-box">
							<span class="quills-search-input-icon">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#151515" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<circle cx="11" cy="11" r="7.5"></circle>
									<line x1="21" y1="21" x2="16.5" y2="16.5"></line>
								</svg>
							</span>
							<input 
								type="search" 
								id="quills-search-modal-input" 
								name="s" 
								class="quills-search-modal-input" 
								placeholder="<?php esc_attr_e( 'Search...', 'coffee-cafe-corner' ); ?>" 
								autocomplete="off" 
								spellcheck="false" 
							/>
							<button type="button" class="quills-search-clear-btn" id="quills-search-clear-btn" aria-label="<?php esc_attr_e( 'Clear search', 'coffee-cafe-corner' ); ?>">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#151515" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<line x1="18" y1="6" x2="6" y2="18"></line>
									<line x1="6" y1="6" x2="18" y2="18"></line>
								</svg>
							</button>
						</div>
					</form>
				</div>

				<!-- Modal Body Area -->
				<div class="quills-search-modal-body">
					<!-- State 1: Initial Empty View (4 Featured Categories) -->
					<div id="quills-search-initial-view" class="quills-search-initial-view">
						<div class="quills-search-categories-grid">
							<!-- Category 1: Blends -->
							<a href="<?php echo esc_url( home_url( '/coffee/?tab=blend' ) ); ?>" class="quills-search-cat-card">
								<div class="quills-search-cat-img-wrap">
									<img src="<?php echo esc_url( $theme_uri . '/assets/images/coffee/inkwell.jpg' ); ?>" alt="<?php esc_attr_e( 'Blends', 'coffee-cafe-corner' ); ?>" class="quills-search-cat-img" />
								</div>
								<h3 class="quills-search-cat-title"><?php esc_html_e( 'Blends', 'coffee-cafe-corner' ); ?></h3>
							</a>

							<!-- Category 2: Single Origin -->
							<a href="<?php echo esc_url( home_url( '/coffee/?tab=single-origin' ) ); ?>" class="quills-search-cat-card">
								<div class="quills-search-cat-img-wrap">
									<img src="<?php echo esc_url( $theme_uri . '/assets/images/coffee/black-condor.jpg' ); ?>" alt="<?php esc_attr_e( 'Single Origin', 'coffee-cafe-corner' ); ?>" class="quills-search-cat-img" />
								</div>
								<h3 class="quills-search-cat-title"><?php esc_html_e( 'Single Origin', 'coffee-cafe-corner' ); ?></h3>
							</a>

							<!-- Category 3: Espresso -->
							<a href="<?php echo esc_url( home_url( '/coffee/?tab=espresso' ) ); ?>" class="quills-search-cat-card">
								<div class="quills-search-cat-img-wrap">
									<img src="<?php echo esc_url( $theme_uri . '/assets/images/coffee/blacksmith.jpg' ); ?>" alt="<?php esc_attr_e( 'Espresso', 'coffee-cafe-corner' ); ?>" class="quills-search-cat-img" />
								</div>
								<h3 class="quills-search-cat-title"><?php esc_html_e( 'Espresso', 'coffee-cafe-corner' ); ?></h3>
							</a>

							<!-- Category 4: Decaf -->
							<a href="<?php echo esc_url( home_url( '/coffee/?tab=decaf' ) ); ?>" class="quills-search-cat-card">
								<div class="quills-search-cat-img-wrap">
									<img src="<?php echo esc_url( $theme_uri . '/assets/images/coffee/colombia-ea-decaf.jpg' ); ?>" alt="<?php esc_attr_e( 'Decaf', 'coffee-cafe-corner' ); ?>" class="quills-search-cat-img" />
								</div>
								<h3 class="quills-search-cat-title"><?php esc_html_e( 'Decaf', 'coffee-cafe-corner' ); ?></h3>
							</a>
						</div>
					</div>

					<!-- State 2: Live Predictive Results View (2 Columns) -->
					<div id="quills-search-live-view" class="quills-search-live-view" style="display: none;">
						<!-- Loading Spinner -->
						<div id="quills-search-loader" class="quills-search-loader" style="display: none;">
							<div class="quills-search-spinner"></div>
						</div>

						<!-- Two Column Results Container -->
						<div class="quills-search-results-grid">
							<!-- Left Column: Products -->
							<div class="quills-search-col-products">
								<h2 class="quills-search-col-heading"><?php esc_html_e( 'Products', 'coffee-cafe-corner' ); ?></h2>
								
								<div id="quills-search-products-list" class="quills-search-products-list">
									<!-- Injected via AJAX -->
								</div>

								<div class="quills-search-view-all-wrap">
									<a href="#" id="quills-search-view-all-btn" class="quills-search-view-all-btn">
										<?php esc_html_e( 'VIEW ALL', 'coffee-cafe-corner' ); ?>
									</a>
								</div>
							</div>

							<!-- Right Column: Suggestions, Pages, Collections -->
							<aside class="quills-search-col-aside">
								<!-- Suggestions Section -->
								<div class="quills-search-aside-section" id="quills-search-section-suggestions">
									<h3 class="quills-search-aside-title"><?php esc_html_e( 'Suggestions', 'coffee-cafe-corner' ); ?></h3>
									<ul class="quills-search-aside-list" id="quills-search-suggestions-list">
										<!-- Injected via AJAX -->
									</ul>
								</div>

								<hr class="quills-search-aside-divider" id="quills-search-divider-1" />

								<!-- Pages Section -->
								<div class="quills-search-aside-section" id="quills-search-section-pages">
									<h3 class="quills-search-aside-title"><?php esc_html_e( 'Pages', 'coffee-cafe-corner' ); ?></h3>
									<ul class="quills-search-aside-list" id="quills-search-pages-list">
										<!-- Injected via AJAX -->
									</ul>
								</div>

								<hr class="quills-search-aside-divider" id="quills-search-divider-2" />

								<!-- Collections Section -->
								<div class="quills-search-aside-section" id="quills-search-section-collections">
									<h3 class="quills-search-aside-title"><?php esc_html_e( 'Collections', 'coffee-cafe-corner' ); ?></h3>
									<ul class="quills-search-aside-list" id="quills-search-collections-list">
										<!-- Injected via AJAX -->
									</ul>
								</div>
							</aside>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

Coffee_Cafe_Corner_Search_DB::init();
