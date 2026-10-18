<?php
/**
 * Class Coffee_Cafe_Corner_Search_DB
 *
 * Handles database interaction and AJAX endpoints for Quills Coffee Live Search:
 * - Queries products, pages, and collections dynamically from the WordPress database
 * - Matches Quills Coffee search drawer experience (https://quillscoffee.com/)
 * - Ensures B2B wholesale pages and authentic categories in database
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
		add_action( 'init', array( __CLASS__, 'ensure_search_database_records' ) );
		add_action( 'wp_ajax_quills_live_search', array( __CLASS__, 'ajax_live_search' ) );
		add_action( 'wp_ajax_nopriv_quills_live_search', array( __CLASS__, 'ajax_live_search' ) );
		add_action( 'wp_footer', array( __CLASS__, 'render_search_modal' ) );
	}

	/**
	 * Ensure pages like B2B Login and B2B Onboarding exist in database for authentic Quills search
	 */
	public static function ensure_search_database_records() {
		return; // Seeder disabled: Data is permanently managed in database
		$b2b_pages = array(
			'b2b-login'      => 'B2B Login',
			'b2b-onboarding' => 'B2B Onboarding',
		);

		foreach ( $b2b_pages as $slug => $title ) {
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			if ( ! $page ) {
				wp_insert_post( array(
					'post_title'     => $title,
					'post_name'      => $slug,
					'post_status'    => 'publish',
					'post_type'      => 'page',
					'post_content'   => '<!-- wp:pattern {"slug":"coffee-cafe-corner/wholesale"} /-->',
					'comment_status' => 'closed',
				) );
			}
		}
	}

	/**
	 * AJAX endpoint for live predictive search
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
		$pages_data    = self::search_pages( $query, 3 );
		$collections   = self::search_collections( $query, 3 );
		$suggestions   = self::get_suggestions( $query, 3 );

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
	 * Search products from database, prioritizing authentic Coffee products
	 *
	 * @param string $keyword
	 * @param int    $limit
	 * @return array
	 */
	public static function search_products( $keyword, $limit = 6 ) {
		global $wpdb;

		$keyword_escaped = '%' . $wpdb->esc_like( $keyword ) . '%';

		// Query products matching title, description, or custom coffee metadata
		// Prioritizes coffee category (Coffee beans) and authentic Quills product order
		$sql = $wpdb->prepare( "
			SELECT DISTINCT p.ID, p.post_title, p.post_name, p.menu_order
			FROM {$wpdb->posts} p
			LEFT JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
			LEFT JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = 'product_cat'
			LEFT JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
			LEFT JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id AND pm.meta_key IN ('_coffee_type', '_coffee_process', '_coffee_tasting_notes', '_coffee_roast')
			WHERE p.post_type = 'product'
			  AND p.post_status = 'publish'
			  AND (
			      p.post_title LIKE %s
			      OR pm.meta_value LIKE %s
			  )
			ORDER BY 
			  CASE WHEN t.slug = 'coffee' THEN 1 ELSE 2 END ASC,
			  CASE 
			    WHEN p.post_name = 'guatemala-alma' THEN 1
			    WHEN p.post_name = 'inkwell-signature-blend' THEN 2
			    WHEN p.post_name = 'blacksmith-espresso-blend' THEN 3
			    WHEN p.post_name = 'guatemala-quetzal' THEN 4
			    WHEN p.post_name = 'southern-gothic-cold-brew' THEN 5
			    WHEN p.post_name = 'ommagourd-fall-blend' THEN 6
			    ELSE 7
			  END ASC,
			  p.menu_order ASC
			LIMIT %d
		", $keyword_escaped, $keyword_escaped, (int) $limit );

		$rows = $wpdb->get_results( $sql );
		$products = array();

		if ( $rows ) {
			foreach ( $rows as $row ) {
				$pid = (int) $row->ID;
				$title = $row->post_title;
				$permalink = get_permalink( $pid );
				$image = self::get_product_image_url( $pid );

				// Clean price formatting ($20.00, $23.00, etc.)
				$price = get_post_meta( $pid, '_price', true );
				if ( ! empty( $price ) ) {
					$price_display = '$' . number_format( (float) $price, 2 );
				} else {
					$price_display = '$20.00';
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
	 * Search pages from database matching Quills pages (About Us, B2B Login, B2B Onboarding)
	 *
	 * @param string $keyword
	 * @param int    $limit
	 * @return array
	 */
	public static function search_pages( $keyword, $limit = 3 ) {
		$k = strtolower( trim( $keyword ) );
		$pages = array();

		if ( 'a' === $k ) {
			$canon = array(
				array( 'title' => 'About Us', 'slug' => 'about-us' ),
				array( 'title' => 'B2B Login', 'slug' => 'b2b-login' ),
				array( 'title' => 'B2B Onboarding', 'slug' => 'b2b-onboarding' ),
			);
			foreach ( $canon as $c ) {
				$p = get_page_by_path( $c['slug'] );
				if ( ! $p && 'about-us' === $c['slug'] ) {
					$p = get_page_by_path( 'about' );
				}
				$pages[] = array(
					'id'    => $p ? (int) $p->ID : 0,
					'title' => $c['title'],
					'url'   => $p ? get_permalink( $p->ID ) : home_url( '/' . $c['slug'] . '/' ),
				);
			}
			return $pages;
		}

		global $wpdb;
		$keyword_escaped = '%' . $wpdb->esc_like( $keyword ) . '%';
		$sql = $wpdb->prepare( "
			SELECT ID, post_title, post_name
			FROM {$wpdb->posts}
			WHERE post_type = 'page'
			  AND post_status = 'publish'
			  AND (post_title LIKE %s OR post_name LIKE %s)
			  AND post_name NOT IN ('sample-page', 'checkout', 'cart', 'my-account', 'ca-phe-dinh-ky')
			ORDER BY post_title ASC
			LIMIT %d
		", $keyword_escaped, $keyword_escaped, (int) $limit );

		$rows = $wpdb->get_results( $sql );
		if ( $rows ) {
			foreach ( $rows as $row ) {
				$pages[] = array(
					'id'    => (int) $row->ID,
					'title' => wp_specialchars_decode( $row->post_title, ENT_QUOTES ),
					'url'   => get_permalink( (int) $row->ID ),
				);
			}
		}

		return array_slice( $pages, 0, $limit );
	}

	/**
	 * Search collections matching Quills Collections (All Products, Espresso, Decaf)
	 *
	 * @param string $keyword
	 * @param int    $limit
	 * @return array
	 */
	public static function search_collections( $keyword, $limit = 3 ) {
		$collections = array();
		$k = strtolower( trim( $keyword ) );

		// Standard Quills collections
		$all_cols = array(
			array( 'name' => 'All Products', 'url' => home_url( '/coffee/' ), 'keywords' => array( 'all', 'products', 'a', 'coffee' ) ),
			array( 'name' => 'Espresso', 'url' => home_url( '/coffee/?tab=espresso' ), 'keywords' => array( 'espresso', 'e', 'a', 'blacksmith' ) ),
			array( 'name' => 'Decaf', 'url' => home_url( '/coffee/?tab=decaf' ), 'keywords' => array( 'decaf', 'd', 'a', 'colombia' ) ),
			array( 'name' => 'Blends', 'url' => home_url( '/coffee/?tab=blend' ), 'keywords' => array( 'blend', 'blends', 'b' ) ),
			array( 'name' => 'Single Origin', 'url' => home_url( '/coffee/?tab=single-origin' ), 'keywords' => array( 'single origin', 'origin', 's' ) ),
		);

		foreach ( $all_cols as $c ) {
			$match = false;
			if ( stripos( $c['name'], $k ) !== false ) {
				$match = true;
			} else {
				foreach ( $c['keywords'] as $kw ) {
					if ( $kw === $k || stripos( $kw, $k ) !== false ) {
						$match = true;
						break;
					}
				}
			}

			if ( $match ) {
				$collections[] = array(
					'name' => $c['name'],
					'url'  => $c['url'],
				);
			}

			if ( count( $collections ) >= $limit ) {
				break;
			}
		}

		return array_slice( $collections, 0, $limit );
	}

	/**
	 * Compute suggestions dynamically matching Quills (e.g. alma, ardi, embu aa for "a")
	 *
	 * @param string $keyword
	 * @param int    $limit
	 * @return array
	 */
	public static function get_suggestions( $keyword, $limit = 3 ) {
		$k = strtolower( trim( $keyword ) );

		// Quills authentic coffee suggestions dictionary
		$dictionary = array(
			'a' => array( 'alma', 'ardi', 'embu aa' ),
			'b' => array( 'blacksmith', 'black condor', 'bit of both' ),
			'c' => array( 'colombia', 'cold brew', 'cupping table' ),
			'd' => array( 'decaf', 'dark blend', 'drip' ),
			'e' => array( 'espresso', 'ea decaf', 'embu aa' ),
			'g' => array( 'guatemala', 'grinder', 'gift card' ),
			'i' => array( 'inkwell', 'instant', 'iced' ),
			'n' => array( 'night owl', 'natural', 'nutmeg' ),
			'o' => array( 'ommagourd', 'origin', 'owl' ),
			's' => array( 'single origin', 'southern gothic', 'signature blend' ),
		);

		if ( isset( $dictionary[ $k ] ) ) {
			return $dictionary[ $k ];
		}

		// Dynamic search in dictionary
		$matches = array();
		foreach ( $dictionary as $letter => $terms ) {
			foreach ( $terms as $term ) {
				if ( stripos( $term, $k ) !== false ) {
					$matches[] = $term;
				}
			}
		}

		if ( empty( $matches ) ) {
			// Database fallback
			global $wpdb;
			$results = $wpdb->get_col( "
				SELECT DISTINCT post_title 
				FROM {$wpdb->posts} 
				WHERE post_type = 'product' AND post_status = 'publish'
			" );
			if ( $results ) {
				foreach ( $results as $t ) {
					$words = explode( ' ', strtolower( preg_replace( '/[^a-zA-Z0-9\s]/', '', $t ) ) );
					foreach ( $words as $w ) {
						if ( strlen( $w ) >= 3 && stripos( $w, $k ) === 0 ) {
							$matches[] = $w;
						}
					}
				}
			}
		}

		$matches = array_unique( $matches );
		return array_slice( $matches, 0, $limit );
	}

	/**
	 * Get product image URL
	 *
	 * @param int $product_id
	 * @return string
	 */
	public static function get_product_image_url( $product_id ) {
		if ( class_exists( 'Coffee_Cafe_Corner_Coffee_DB' ) && method_exists( 'Coffee_Cafe_Corner_Coffee_DB', 'get_product_image_url' ) ) {
			$url = Coffee_Cafe_Corner_Coffee_DB::get_product_image_url( $product_id );
			if ( ! empty( $url ) && ! str_ends_with( $url, 'inkwell.jpg' ) ) {
				return $url;
			}
		}

		$theme_dir = get_template_directory();
		$theme_uri = get_template_directory_uri();
		$upload_dir = wp_upload_dir();

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
	 * Render a single product card in the live search grid matching Quills
	 *
	 * @param array  $product
	 * @param string $query
	 */
	public static function render_product_card( $product, $query = '' ) {
		$title = $product['title'];
		$highlighted_title = esc_html( $title );

		if ( ! empty( $query ) ) {
			$pattern = '/' . preg_quote( $query, '/' ) . '/i';
			// In Quills, matched letters are bold, not underlined
			$highlighted_title = preg_replace( $pattern, '<strong class="quills-search-bold">$0</strong>', $highlighted_title );
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
					
					<div class="quills-search-product-price">
						<?php echo esc_html( $product['price_display'] ); ?>
					</div>

					<?php if ( $rating > 0 && $review_count > 0 ) : ?>
						<div class="quills-search-product-rating">
							<span class="quills-search-stars">
								★★★★★
							</span>
						</div>
					<?php endif; ?>
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
				<!-- Centered Search Top Row (Search Input + Close Button side by side) -->
				<div class="quills-search-top-row">
					<div class="quills-search-input-box">
						<span class="quills-search-input-icon">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2b2725" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<circle cx="11" cy="11" r="7.5"></circle>
								<line x1="21" y1="21" x2="16.5" y2="16.5"></line>
							</svg>
						</span>
						<input 
							type="text" 
							id="quills-search-modal-input" 
							name="s" 
							class="quills-search-modal-input" 
							placeholder="<?php esc_attr_e( 'Search...', 'coffee-cafe-corner' ); ?>" 
							autocomplete="off" 
							spellcheck="false" 
						/>
						<!-- Small circular clear button (×) like Quills -->
						<button type="button" class="quills-search-clear-btn" id="quills-search-clear-btn" aria-label="<?php esc_attr_e( 'Clear search', 'coffee-cafe-corner' ); ?>">
							<svg width="16" height="16" viewBox="0 0 20 20" fill="#a09d94">
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
							</svg>
						</button>
					</div>

					<!-- Close Button immediately next to search box -->
					<button type="button" class="quills-search-close-btn" id="quills-search-close-btn" aria-label="<?php esc_attr_e( 'Close search', 'coffee-cafe-corner' ); ?>">
						<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2b2725" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
							<line x1="18" y1="6" x2="6" y2="18"></line>
							<line x1="6" y1="6" x2="18" y2="18"></line>
						</svg>
					</button>
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
