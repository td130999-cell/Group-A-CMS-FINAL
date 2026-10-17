<?php
/**
 * Plugin Name: Group A Local Performance Engine
 * Description: Optimizes local WordPress Docker performance by instantly blocking external outbound HTTP requests.
 */

// 1. Immediately terminate external outgoing HTTP requests to prevent slow 5-15s timeouts in local Docker
add_filter('pre_http_request', function($pre, $parsed_args, $url) {
    if (strpos($url, 'localhost') !== false || strpos($url, '127.0.0.1') !== false) {
        return $pre;
    }
    return new WP_Error('http_request_failed', 'Disabled in local environment');
}, 1, 3);

// 2. Bypass heavy editor-only WooCommerce & RankMath block metadata scanning on Frontend
add_action('init', function() {
    if (!is_admin() && (!defined('REST_REQUEST') || !REST_REQUEST)) {
        global $wp_filter;
        if (isset($wp_filter['init']->callbacks[10])) {
            foreach ($wp_filter['init']->callbacks[10] as $k => $cb) {
                if (is_array($cb['function']) && is_object($cb['function'][0])) {
                    $cls = get_class($cb['function'][0]);
                    $method = $cb['function'][1];
                    // Only skip third-party plugin block scanners (WooCommerce BlockTypesController & RankMath)
                    if ((strpos($cls, 'Automattic\\WooCommerce\\Blocks\\BlockTypesController') !== false && $method === 'register_blocks') ||
                        (strpos($cls, 'Content_AI_Page') !== false && $method === 'init') ||
                        (strpos($cls, 'RankMath\\Schema\\Blocks') !== false)) {
                        unset($wp_filter['init']->callbacks[10][$k]);
                    }
                }
            }
        }
    }
}, -99999);
