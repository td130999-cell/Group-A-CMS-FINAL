<?php
/**
 * Local Speedup: Immediately terminate outgoing HTTP requests to prevent 15s timeouts
 */
add_filter('pre_http_request', function($pre, $parsed_args, $url) {
    // Allow internal calls if needed
    if (strpos($url, 'localhost') !== false || strpos($url, '127.0.0.1') !== false) {
        return $pre;
    }
    return new WP_Error('http_request_failed', 'Disabled in local environment');
}, 1, 3);
