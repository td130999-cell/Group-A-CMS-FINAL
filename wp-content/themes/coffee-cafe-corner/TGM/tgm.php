<?php

require get_template_directory() . '/TGM/class-tgm-plugin-activation.php';
/**
 * Recommended plugins.
 */
function coffee_cafe_corner_register_recommended_plugins() {
	$plugins = array(
		array(
            'name'             => __( 'woocommerce', 'coffee-cafe-corner' ),
            'slug'             => 'woocommerce',
            'required'         => false,
            'force_activation' => false,
        ),
	);
	$config = array();
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'coffee_cafe_corner_register_recommended_plugins' );
