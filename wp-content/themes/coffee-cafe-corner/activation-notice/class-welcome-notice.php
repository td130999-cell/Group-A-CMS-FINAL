<?php

/**
 * Welcome Notice class for Coffee Cafe Corner theme.
 */
class Coffee_Cafe_Corner_Welcome_Notice {

	/**
	** Constructor.
	*/
	public function __construct() {
		add_action( 'admin_notices', [ $this, 'coffee_cafe_corner_render_notice' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'coffee_cafe_corner_admin_enqueue_scripts' ], 5 );
		add_action( 'admin_enqueue_scripts', [ $this, 'coffee_cafe_corner_notice_enqueue_scripts' ], 5 );
		add_action( 'wp_ajax_coffee_cafe_corner_dismissed_handler', [ $this, 'coffee_cafe_corner_dismissed_handler' ] );
		add_action( 'switch_theme', [ $this, 'coffee_cafe_corner_reset_notices' ] );
		add_action( 'after_switch_theme', [ $this, 'coffee_cafe_corner_reset_notices' ] );
	}

	/**
	** Render Notice
	*/
	public function coffee_cafe_corner_render_notice() {
		$screen = get_current_screen();

		if (
			$screen &&
			$screen->id !== 'appearance_page_coffee-cafe-corner-theme-info' &&
			$screen->id !== 'appearance_page_coffee-cafe-corner-demo'
		) {
			$transient_name = sprintf( '%s_activation_notice', get_template() );

			if ( ! get_transient( $transient_name ) ) {
				?>
				<div class="coffee-cafe-corner-notice notice notice-info is-dismissible" data-notice="<?php echo esc_attr( $transient_name ); ?>">
					<button type="button" class="notice-dismiss"></button>
					<?php $this->coffee_cafe_corner_render_notice_content(); ?>
				</div>
				<?php
			}
		}
	}

	/**
	** Render Notice Content
	*/
	public function coffee_cafe_corner_render_notice_content() {
		$action = 'install-activate';
		$redirect_url = 'admin.php?page=coffee-cafe-corner-theme-info';

		?>
		<div class="notice-left-icon-box">
			<span class="dashicons dashicons-businessperson notc-theme-icon"></span>
		</div>
		<div class="welcome-message">
			<div class="notc-contnt">
				<h4><?php esc_html_e( 'Thank you for choosing Legacy Themes!', 'coffee-cafe-corner' ); ?></h4>
				<h1><?php esc_html_e( 'Welcome to Coffee Cafe Corner WordPress Theme!', 'coffee-cafe-corner' ); ?></h1>
				<p>
					<?php esc_html_e( 'Design a modern logistics site with responsive shipment overviews, automated booking prompts, and clear delivery tracking sections.', 'coffee-cafe-corner' ); ?>
				</p>
				<div class="action-buttons">
					<a href="<?php echo esc_url( admin_url( $redirect_url ) ); ?>" class="button notice-btn button-hero" data-action="<?php echo esc_attr( $action ); ?>">
						<span class="notc-btn-txt"><?php esc_html_e( 'Get Started with Coffee Cafe Corner', 'coffee-cafe-corner' ); ?></span>
					</a>
					<a href="<?php echo esc_url( COFFEE_CAFE_CORNER_THEME_BUNDLE_URL ); ?>" target="_blank" class="bundle-btn btn">
						<span class="demo-btn-txt"><?php esc_html_e( 'Get All Themes', 'coffee-cafe-corner' ); ?></span>
					</a>
				</div>
			</div>
		</div>
		<div class="notice-right-img-box">
			<img class="notc-right-img" src="<?php echo esc_url( get_template_directory_uri() . '/activation-notice/img/notice-right.png' ); ?>" alt="<?php esc_attr_e( 'notice themes img', 'coffee-cafe-corner' ); ?>" />
		</div>
		<?php
	}

	/**
	** Reset Notice.
	*/
	public function coffee_cafe_corner_reset_notices() {
		delete_transient( sprintf( '%s_activation_notice', get_template() ) );
	}

	/**
	** Dismissed handler.
	*/
	public function coffee_cafe_corner_dismissed_handler() {
		wp_verify_nonce( null );

		if ( isset( $_POST['notice'] ) ) {
			set_transient( sanitize_text_field( wp_unslash( $_POST['notice'] ) ), true, 0 );
		}
	}

	/**
	** Enqueue notice scripts.
	*/
	public function coffee_cafe_corner_notice_enqueue_scripts( $page ) {
		wp_enqueue_script( 'jquery' );

		ob_start();
		?>
		<script>
			jQuery(function($) {
				$( document ).on( 'click', '.coffee-cafe-corner-notice .notice-dismiss', function () {
					jQuery.post( 'ajax_url', {
						action: 'coffee_cafe_corner_dismissed_handler',
						notice: $( this ).closest( '.coffee-cafe-corner-notice' ).data( 'notice' ),
					});
					$( '.coffee-cafe-corner-notice' ).hide();
				} );
			});
		</script>
		<?php
		$script = str_replace( 'ajax_url', admin_url( 'admin-ajax.php' ), ob_get_clean() );

		wp_add_inline_script( 'jquery', str_replace( ['<script>', '</script>'], '', $script ) );
	}

	/**
	** Register notice styles.
	*/
	public function coffee_cafe_corner_admin_enqueue_scripts( $page ) {
		wp_enqueue_style( 'coffee-cafe-corner-welcome-notice-css', get_template_directory_uri() . '/activation-notice/css/notice-bar.css' );
	}
}

new Coffee_Cafe_Corner_Welcome_Notice();
