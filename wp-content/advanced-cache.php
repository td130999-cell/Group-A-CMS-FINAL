<?php
/**
 * Quills Ultra-Fast Drop-in Page Cache
 * Serves cached HTML pages directly from high-speed in-memory RAM (/dev/shm).
 * Completely transparent: does not alter CSS, fonts, or HTML structure.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Only cache GET and HEAD requests
if ( ! isset( $_SERVER['REQUEST_METHOD'] ) || ( $_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'HEAD' ) ) {
    return;
}

// 2. Never cache CLI or Cron
if ( ( defined( 'WP_CLI' ) && WP_CLI ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
    return;
}

// 3. Request URI inspection
$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';

// Exclude admin, login, cron, xmlrpc, rest api, checkout, cart, my-account
$exclude_patterns = array(
    '/wp-admin/',
    'wp-login.php',
    'wp-cron.php',
    'xmlrpc.php',
    '/wp-json/',
    'rest_route=',
    'admin-ajax.php',
    'wc-ajax=',
    '/cart',
    '/checkout',
    '/my-account',
    'add-to-cart=',
    'preview=true',
);

foreach ( $exclude_patterns as $pattern ) {
    if ( strpos( $request_uri, $pattern ) !== false ) {
        return;
    }
}

// 4. Cookie check - Bypass cache if user is logged in or has cart items
if ( ! empty( $_COOKIE ) ) {
    foreach ( $_COOKIE as $cookie_name => $cookie_val ) {
        if ( strpos( $cookie_name, 'wordpress_logged_in_' ) === 0 ||
             strpos( $cookie_name, 'woocommerce_items_in_cart' ) === 0 ||
             strpos( $cookie_name, 'wp_woocommerce_session_' ) === 0 ||
             strpos( $cookie_name, 'woocommerce_cart_hash' ) === 0 ||
             strpos( $cookie_name, 'comment_author_' ) === 0 ) {
            return;
        }
    }
}

// 5. Determine Cache Directory (prefer Linux RAM disk /dev/shm, fallback to WP_CONTENT_DIR/cache)
$cache_dir = is_writable( '/dev/shm' ) ? '/dev/shm/quills_page_cache' : WP_CONTENT_DIR . '/cache/quills_page_cache';
if ( ! is_dir( $cache_dir ) ) {
    @mkdir( $cache_dir, 0777, true );
}

$http_host  = isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : 'localhost';
$cache_key  = md5( $http_host . '_' . $request_uri );
$cache_file = $cache_dir . '/' . $cache_key . '.html';
$cache_ttl  = 43200; // 12 hours

// 6. Check if cached file exists and is still valid
if ( file_exists( $cache_file ) ) {
    $filemtime = @filemtime( $cache_file );
    if ( $filemtime && ( time() - $filemtime ) < $cache_ttl ) {
        header( 'X-Quills-Cache: HIT (RAM)' );
        header( 'Content-Type: text/html; charset=UTF-8' );
        readfile( $cache_file );
        exit;
    }
}

// 7. Cache MISS: Capture the output of this request and store it
header( 'X-Quills-Cache: MISS' );

ob_start( function( $buffer ) use ( $cache_file ) {
    // Only cache if HTTP 200 OK and non-empty HTML
    $status = http_response_code();
    if ( ( $status === 200 || $status === false ) && strlen( $buffer ) > 500 ) {
        // Do not cache error pages or JSON
        if ( stripos( $buffer, '<html' ) !== false && stripos( $buffer, 'Fatal error' ) === false && stripos( $buffer, 'Parse error' ) === false ) {
            @file_put_contents( $cache_file, $buffer . "\n<!-- Quills Page Cache Generated at " . gmdate( 'Y-m-d H:i:s' ) . " GMT -->", LOCK_EX );
        }
    }
    return $buffer;
} );
