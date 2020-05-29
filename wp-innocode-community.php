<?php
/**
 * Plugin Name: Community
 * Description: Helps to integrate <a href="https://innocode.com/product/community/">Innocode Community</a> with a site.
 * Version: 0.0.1
 * Author: Innocode
 * Author URI: https://innocode.com
 * Tested up to: 5.4.1
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

use Innocode\Community;

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

if (
    defined( 'INNOCODE_COMMUNITY_INSTANCE_URL' ) &&
    defined( 'INNOCODE_COMMUNITY_CONSUMER_KEY' )
) {
    $GLOBALS['innocode_community'] = new Community\Plugin(
        INNOCODE_COMMUNITY_INSTANCE_URL,
        INNOCODE_COMMUNITY_CONSUMER_KEY
    );
}

if ( ! function_exists( 'innocode_community' ) ) {
    function innocode_community() {
        global $innocode_community;

        if ( is_null( $innocode_community ) ) {
            trigger_error(
                'Missing required constant INNOCODE_COMMUNITY_INSTANCE_URL and/or INNOCODE_COMMUNITY_CONSUMER_KEY.',
                E_USER_ERROR
            );
        }

        return $innocode_community;
    }
}
