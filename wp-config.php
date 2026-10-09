<?php
/**
 * The base configuration for WordPress
 * Configured dynamically for Docker environment
 */

// ** Database settings from environment variables with sensible defaults ** //
define( 'DB_NAME', getenv('WORDPRESS_DB_NAME') ?: 'wordpress' );
define( 'DB_USER', getenv('WORDPRESS_DB_USER') ?: 'wordpress' );
define( 'DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: 'wordpress' );
define( 'DB_HOST', getenv('WORDPRESS_DB_HOST') ?: 'db:3306' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 */
define( 'AUTH_KEY',         getenv('WORDPRESS_AUTH_KEY') ?: 'm&o{4r*@$T,b59a?|x+^h(lZ&c;a2j<k#991j_k9!A@s~&D^1k!94' );
define( 'SECURE_AUTH_KEY',  getenv('WORDPRESS_SECURE_AUTH_KEY') ?: '9.u_p)g6K?|u-j4X,z[w/n!E%#+v1r&r:3z4q99x@b%^a~&b(02' );
define( 'LOGGED_IN_KEY',    getenv('WORDPRESS_LOGGED_IN_KEY') ?: '3@e_7w;c~4x,i]v=k%9g$1m#7y!p*2l)8a(5s^&j+z@t:?b|c!8' );
define( 'NONCE_KEY',        getenv('WORDPRESS_NONCE_KEY') ?: 'k?+x8q=r:9l~2w%#1t!p*4v)5m(7s^&j_6a~&d|e+z@g-3c$8u/n' );
define( 'AUTH_SALT',        getenv('WORDPRESS_AUTH_SALT') ?: '4~&b)0z%^a:3z+v/n!E%#1r&r-j4X,z[9.u_p)g6K?|u8m*@$T,b' );
define( 'SECURE_AUTH_SALT', getenv('WORDPRESS_SECURE_AUTH_SALT') ?: 'y!p*2l)8a(5s^&j+z@t:?b|c!83@e_7w;c~4x,i]v=k%9g$1m#7' );
define( 'LOGGED_IN_SALT',   getenv('WORDPRESS_LOGGED_IN_SALT') ?: '5m(7s^&j_6a~&d|e+z@g-3c$8u/nk?+x8q=r:9l~2w%#1t!p*4v)' );
define( 'NONCE_SALT',       getenv('WORDPRESS_NONCE_SALT') ?: 'r*@$T,b59a?|x+^h(lZ&c;a2j<k#991j_k9!A@s~&D^1k!94m&o{' );
/**#@-*/

/**
 * WordPress database table prefix.
 */
$table_prefix = getenv('WORDPRESS_TABLE_PREFIX') ?: 'wp_';

/**
 * Debugging mode.
 */
$debug_mode = getenv('WORDPRESS_DEBUG');
define( 'WP_DEBUG', filter_var($debug_mode ?: false, FILTER_VALIDATE_BOOLEAN) );

/**
 * Direct filesystem method to allow installing plugins/themes without FTP prompts.
 */
define( 'FS_METHOD', 'direct' );

/**
 * Disable WP-Cron loopback requests in Docker container to prevent slow page load timeouts.
 */
define( 'DISABLE_WP_CRON', true );

/**
 * Handle reverse proxies and SSL termination.
 */
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
	$_SERVER['HTTPS'] = 'on';
}

/**
 * Dynamically configure WP_SITEURL and WP_HOME based on incoming HTTP request
 * so that any developer on localhost, custom port, LAN IP, or tunnel can view the site
 * without redirect loops or domain mismatch.
 */
if ( isset( $_SERVER['HTTP_HOST'] ) ) {
	$scheme = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' ) ? 'https://' : 'http://';
	if ( ! defined( 'WP_SITEURL' ) ) {
		define( 'WP_SITEURL', $scheme . $_SERVER['HTTP_HOST'] );
	}
	if ( ! defined( 'WP_HOME' ) ) {
		define( 'WP_HOME', $scheme . $_SERVER['HTTP_HOST'] );
	}
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

