<?php
/**
 * Class Coffee_Cafe_Corner_Admin_Meta
 *
 * Provides custom Meta Box and management in wp-admin for Quills Products:
 * - Tasting notes, Roast profile, Process, Coffee type, Origins, Tag/Badge, Merch sizes, Low stock
 * - Saves directly to WordPress Database (wp_postmeta)
 * - Automatically clears transient caches (real-time sync to Frontend)
 * - Keeps review counts & average ratings in sync when comments are edited in wp-admin
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Coffee_Cafe_Corner_Admin_Meta {

	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_meta_boxes' ) );
		add_action( 'save_post_product', array( __CLASS__, 'save_product_meta' ), 10, 2 );

		// Clear caches on comment status/edit changes
		add_action( 'comment_post', array( __CLASS__, 'sync_review_cache' ), 10, 2 );
		add_action( 'edit_comment', array( __CLASS__, 'sync_review_cache_by_id' ), 10, 1 );
		add_action( 'transition_comment_status', array( __CLASS__, 'sync_review_status_change' ), 10, 3 );
	}

	/**
	 * Register Custom Meta Box on WooCommerce Product edit screen
	 */
	public static function register_meta_boxes() {
		add_meta_box(
			'quills_product_custom_meta',
			__( 'Quills Coffee & Merch - Thuộc tính chi tiết (Custom Attributes)', 'coffee-cafe-corner' ),
			array( __CLASS__, 'render_meta_box' ),
			'product',
			'normal',
			'high'
		);
	}

	/**
	 * Render Meta Box HTML in wp-admin
	 */
	public static function render_meta_box( $post ) {
		wp_nonce_field( 'quills_product_meta_nonce', 'quills_product_meta_nonce_field' );

		$id = $post->ID;

		// Read current values directly from database
		$tasting_notes = get_post_meta( $id, '_coffee_tasting_notes', true );
		if ( empty( $tasting_notes ) ) {
			$tasting_notes = get_post_meta( $id, '_quills_tasting_notes', true );
		}

		$roast = get_post_meta( $id, '_coffee_roast', true );
		if ( empty( $roast ) ) {
			$roast = get_post_meta( $id, '_quills_roast_profile', true );
		}

		$process = get_post_meta( $id, '_coffee_process', true );
		if ( is_array( $process ) ) {
			$process = implode( ' & ', $process );
		}
		if ( empty( $process ) ) {
			$process = get_post_meta( $id, '_quills_process', true );
		}

		$coffee_type = get_post_meta( $id, '_coffee_type', true );
		if ( empty( $coffee_type ) ) {
			$coffee_type = get_post_meta( $id, '_quills_coffee_type', true );
		}

		$origins = get_post_meta( $id, '_coffee_origins', true );
		if ( empty( $origins ) ) {
			$origins = get_post_meta( $id, '_quills_country', true );
		}

		$subtitle = get_post_meta( $id, '_coffee_subtitle', true );

		// Merch specific
		$raw_sizes = get_post_meta( $id, '_merch_sizes', true );
		$sizes_str = is_array( $raw_sizes ) ? implode( ', ', $raw_sizes ) : (string) $raw_sizes;
		$default_size = get_post_meta( $id, '_merch_default_size', true ) ?: 'M';
		$low_stock    = get_post_meta( $id, '_merch_low_stock', true );

		// Home bestsellers tags
		$tag       = get_post_meta( $id, '_quills_tag', true );
		$tag_color = get_post_meta( $id, '_quills_tag_color', true ) ?: '#E5A823';
		$tag_desc  = get_post_meta( $id, '_quills_tag_desc', true );

		// Subscriptions rollover
		$rollover = get_post_meta( $id, '_subscription_rollover_html', true );
		?>
		<style>
			.quills-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px 25px; margin-top: 10px; }
			.quills-meta-field { display: flex; flex-direction: column; gap: 6px; }
			.quills-meta-field.full { grid-column: 1 / -1; }
			.quills-meta-field label { font-weight: 600; color: #1e293b; font-size: 13px; }
			.quills-meta-field input[type="text"], .quills-meta-field select, .quills-meta-field textarea { width: 100%; padding: 6px 10px; border-radius: 4px; border: 1px solid #cbd5e1; font-size: 13px; }
			.quills-meta-field .desc { font-size: 12px; color: #64748b; margin-top: 2px; }
			.quills-meta-section-title { grid-column: 1 / -1; margin-top: 15px; margin-bottom: 5px; font-size: 14px; font-weight: 700; color: #b45309; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px; }
		</style>

		<div class="quills-meta-grid">
			<div class="quills-meta-section-title">☕ THUỘC TÍNH CÀ PHÊ (COFFEE ATTRIBUTES)</div>

			<div class="quills-meta-field full">
				<label for="quills_tasting_notes"><?php esc_html_e( 'Tasting Notes (Ghi chú hương vị)', 'coffee-cafe-corner' ); ?></label>
				<input type="text" id="quills_tasting_notes" name="quills_tasting_notes" value="<?php echo esc_attr( $tasting_notes ); ?>" placeholder="vd: Graham cracker, cooked cherries, vanilla" />
				<span class="desc"><?php esc_html_e( 'Hiển thị trên thẻ sản phẩm trang Coffee, trang chi tiết PDP, trang Subscriptions và Cart Drawer.', 'coffee-cafe-corner' ); ?></span>
			</div>

			<div class="quills-meta-field">
				<label for="quills_roast"><?php esc_html_e( 'Roast Profile (Độ rang)', 'coffee-cafe-corner' ); ?></label>
				<select id="quills_roast" name="quills_roast">
					<option value="Light" <?php selected( $roast, 'Light' ); ?>>Light</option>
					<option value="Medium" <?php selected( $roast, 'Medium' ); ?>>Medium</option>
					<option value="Dark" <?php selected( $roast, 'Dark' ); ?>>Dark</option>
				</select>
				<span class="desc"><?php esc_html_e( 'Bộ lọc Roast Profile trang Coffee.', 'coffee-cafe-corner' ); ?></span>
			</div>

			<div class="quills-meta-field">
				<label for="quills_process"><?php esc_html_e( 'Process (Phương pháp chế biến)', 'coffee-cafe-corner' ); ?></label>
				<input type="text" id="quills_process" name="quills_process" value="<?php echo esc_attr( $process ); ?>" placeholder="Washed, Natural, Honey, Washed & Natural, Sugarcane EA Decaf" />
				<span class="desc"><?php esc_html_e( 'Bộ lọc Process trang Coffee.', 'coffee-cafe-corner' ); ?></span>
			</div>

			<div class="quills-meta-field">
				<label for="quills_coffee_type"><?php esc_html_e( 'Coffee Type (Phân loại cà phê)', 'coffee-cafe-corner' ); ?></label>
				<input type="text" id="quills_coffee_type" name="quills_coffee_type" value="<?php echo esc_attr( $coffee_type ); ?>" placeholder="Signature Blend, Single Origin, Dark Blend, Espresso" />
				<span class="desc"><?php esc_html_e( 'Phân loại Blend, Single Origin, v.v.', 'coffee-cafe-corner' ); ?></span>
			</div>

			<div class="quills-meta-field">
				<label for="quills_origins"><?php esc_html_e( 'Origins (Xuất xứ / Vùng trồng)', 'coffee-cafe-corner' ); ?></label>
				<input type="text" id="quills_origins" name="quills_origins" value="<?php echo esc_attr( $origins ); ?>" placeholder="Colombia, Guatemala, Ethiopia" />
			</div>

			<div class="quills-meta-field full">
				<label for="quills_subtitle"><?php esc_html_e( 'Subtitle / Phụ đề thẻ cà phê', 'coffee-cafe-corner' ); ?></label>
				<input type="text" id="quills_subtitle" name="quills_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" placeholder="Our Signature House Blend" />
			</div>

			<div class="quills-meta-section-title">👕 THUỘC TÍNH SẢN PHẨM MERCH (MERCHANDISE ATTRIBUTES)</div>

			<div class="quills-meta-field">
				<label for="quills_merch_sizes"><?php esc_html_e( 'Sizes (Kích thước hỗ trợ, phân cách bằng dấu phẩy)', 'coffee-cafe-corner' ); ?></label>
				<input type="text" id="quills_merch_sizes" name="quills_merch_sizes" value="<?php echo esc_attr( $sizes_str ); ?>" placeholder="S, M, L, XL, 2XL" />
			</div>

			<div class="quills-meta-field">
				<label for="quills_default_size"><?php esc_html_e( 'Default Size (Size mặc định)', 'coffee-cafe-corner' ); ?></label>
				<input type="text" id="quills_default_size" name="quills_default_size" value="<?php echo esc_attr( $default_size ); ?>" placeholder="M" />
			</div>

			<div class="quills-meta-field full">
				<label for="quills_low_stock"><?php esc_html_e( 'Low Stock Notice (Cảnh báo số lượng ít)', 'coffee-cafe-corner' ); ?></label>
				<input type="text" id="quills_low_stock" name="quills_low_stock" value="<?php echo esc_attr( $low_stock ); ?>" placeholder="vd: Only 4 left in stock" />
			</div>

			<div class="quills-meta-section-title">🏷️ THUỘC TÍNH TRANG CHỦ & ĐĂNG KÝ (HOME BESTSELLERS & SUBSCRIPTIONS)</div>

			<div class="quills-meta-field">
				<label for="quills_tag"><?php esc_html_e( 'Tag Tiêu đề Trang chủ (vd: BLACKSMITH)', 'coffee-cafe-corner' ); ?></label>
				<input type="text" id="quills_tag" name="quills_tag" value="<?php echo esc_attr( $tag ); ?>" placeholder="BLACKSMITH" />
			</div>

			<div class="quills-meta-field">
				<label for="quills_tag_color"><?php esc_html_e( 'Màu Tag Trang chủ (Mã màu HEX)', 'coffee-cafe-corner' ); ?></label>
				<input type="text" id="quills_tag_color" name="quills_tag_color" value="<?php echo esc_attr( $tag_color ); ?>" placeholder="#E5A823" />
			</div>

			<div class="quills-meta-field full">
				<label for="quills_tag_desc"><?php esc_html_e( 'Mô tả ngắn thẻ Bestseller Trang chủ', 'coffee-cafe-corner' ); ?></label>
				<input type="text" id="quills_tag_desc" name="quills_tag_desc" value="<?php echo esc_attr( $tag_desc ); ?>" placeholder="The F1 car of our lineup..." />
			</div>

			<div class="quills-meta-field full">
				<label for="quills_rollover_html"><?php esc_html_e( 'Rollover HTML (Nội dung hover thẻ Subscriptions)', 'coffee-cafe-corner' ); ?></label>
				<textarea id="quills_rollover_html" name="quills_rollover_html" rows="3"><?php echo esc_textarea( $rollover ); ?></textarea>
			</div>
		</div>
		<?php
	}

	/**
	 * Save Meta Box values to Database on Product Save
	 */
	public static function save_product_meta( $post_id, $post ) {
		// Nonce check
		if ( ! isset( $_POST['quills_product_meta_nonce_field'] ) || ! wp_verify_nonce( $_POST['quills_product_meta_nonce_field'], 'quills_product_meta_nonce' ) ) {
			return;
		}

		// Autosave check
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Permissions check
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// 1. Tasting notes
		if ( isset( $_POST['quills_tasting_notes'] ) ) {
			$tasting = sanitize_text_field( wp_unslash( $_POST['quills_tasting_notes'] ) );
			update_post_meta( $post_id, '_coffee_tasting_notes', $tasting );
			update_post_meta( $post_id, '_quills_tasting_notes', $tasting );
		}

		// 2. Roast
		if ( isset( $_POST['quills_roast'] ) ) {
			$roast = sanitize_text_field( wp_unslash( $_POST['quills_roast'] ) );
			update_post_meta( $post_id, '_coffee_roast', $roast );
			update_post_meta( $post_id, '_quills_roast_profile', $roast );
		}

		// 3. Process
		if ( isset( $_POST['quills_process'] ) ) {
			$process = sanitize_text_field( wp_unslash( $_POST['quills_process'] ) );
			update_post_meta( $post_id, '_coffee_process', $process );
			update_post_meta( $post_id, '_quills_process', $process );
		}

		// 4. Coffee type
		if ( isset( $_POST['quills_coffee_type'] ) ) {
			$type = sanitize_text_field( wp_unslash( $_POST['quills_coffee_type'] ) );
			update_post_meta( $post_id, '_coffee_type', $type );
			update_post_meta( $post_id, '_quills_coffee_type', $type );
		}

		// 5. Origins
		if ( isset( $_POST['quills_origins'] ) ) {
			$origins = sanitize_text_field( wp_unslash( $_POST['quills_origins'] ) );
			update_post_meta( $post_id, '_coffee_origins', $origins );
			update_post_meta( $post_id, '_quills_country', $origins );
		}

		// 6. Subtitle
		if ( isset( $_POST['quills_subtitle'] ) ) {
			update_post_meta( $post_id, '_coffee_subtitle', sanitize_text_field( wp_unslash( $_POST['quills_subtitle'] ) ) );
		}

		// 7. Merch sizes
		if ( isset( $_POST['quills_merch_sizes'] ) ) {
			$raw_sizes = sanitize_text_field( wp_unslash( $_POST['quills_merch_sizes'] ) );
			$sizes_arr = array_values( array_filter( array_map( 'trim', explode( ',', $raw_sizes ) ) ) );
			update_post_meta( $post_id, '_merch_sizes', $sizes_arr );
		}

		if ( isset( $_POST['quills_default_size'] ) ) {
			update_post_meta( $post_id, '_merch_default_size', sanitize_text_field( wp_unslash( $_POST['quills_default_size'] ) ) );
		}

		if ( isset( $_POST['quills_low_stock'] ) ) {
			update_post_meta( $post_id, '_merch_low_stock', sanitize_text_field( wp_unslash( $_POST['quills_low_stock'] ) ) );
		}

		// 8. Tags & Home bestsellers
		if ( isset( $_POST['quills_tag'] ) ) {
			update_post_meta( $post_id, '_quills_tag', sanitize_text_field( wp_unslash( $_POST['quills_tag'] ) ) );
		}
		if ( isset( $_POST['quills_tag_color'] ) ) {
			update_post_meta( $post_id, '_quills_tag_color', sanitize_text_field( wp_unslash( $_POST['quills_tag_color'] ) ) );
		}
		if ( isset( $_POST['quills_tag_desc'] ) ) {
			update_post_meta( $post_id, '_quills_tag_desc', sanitize_text_field( wp_unslash( $_POST['quills_tag_desc'] ) ) );
		}

		// 9. Rollover html
		if ( isset( $_POST['quills_rollover_html'] ) ) {
			update_post_meta( $post_id, '_subscription_rollover_html', wp_kses_post( wp_unslash( $_POST['quills_rollover_html'] ) ) );
		}

		// Invalidate caches so frontend updates immediately!
		self::clear_all_product_caches( $post_id );
	}

	/**
	 * Invalidate all transients & caches for real-time frontend update
	 */
	public static function clear_all_product_caches( $product_id ) {
		delete_transient( 'quills_card_html_' . $product_id );
		delete_transient( 'quills_sp_reviews_' . $product_id );
		delete_transient( 'quills_filter_counts' );
		delete_transient( 'wc_average_rating_' . $product_id );
		clean_post_cache( $product_id );

		// Clear WooCommerce product cache
		if ( function_exists( 'wc_delete_product_transients' ) ) {
			wc_delete_product_transients( $product_id );
		}
	}

	/**
	 * Review cache sync helpers
	 */
	public static function sync_review_cache( $comment_id, $comment_approved ) {
		$comment = get_comment( $comment_id );
		if ( $comment && ! empty( $comment->comment_post_ID ) ) {
			self::recalc_product_reviews( $comment->comment_post_ID );
		}
	}

	public static function sync_review_cache_by_id( $comment_id ) {
		$comment = get_comment( $comment_id );
		if ( $comment && ! empty( $comment->comment_post_ID ) ) {
			self::recalc_product_reviews( $comment->comment_post_ID );
		}
	}

	public static function sync_review_status_change( $new_status, $old_status, $comment ) {
		if ( $comment && ! empty( $comment->comment_post_ID ) ) {
			self::recalc_product_reviews( $comment->comment_post_ID );
		}
	}

	public static function recalc_product_reviews( $product_id ) {
		delete_transient( 'quills_sp_reviews_' . $product_id );
		delete_transient( 'quills_card_html_' . $product_id );

		// Recalculate WC stats
		$comments = get_comments( array(
			'post_id'  => $product_id,
			'status'   => 'approve',
			'type__in' => array( 'review', '', 'comment' ),
		) );

		$count = count( $comments );
		$total = 0;
		if ( $count > 0 ) {
			foreach ( $comments as $c ) {
				$r = (int) get_comment_meta( $c->comment_ID, 'rating', true );
				if ( ! $r ) $r = 5;
				$total += $r;
			}
			$avg = number_format( round( $total / $count, 1 ), 1, '.', '' );
		} else {
			$avg = '0.0';
		}

		update_post_meta( $product_id, '_wc_review_count', $count );
		update_post_meta( $product_id, '_wc_average_rating', $avg );
	}
}

Coffee_Cafe_Corner_Admin_Meta::init();
