<?php
/*
Version: 131203
Text Domain: wp-super-snow
Plugin Name: WP Super Snow

Author: WebSharks, Inc.
Author URI: http://websharks-inc.com

Plugin URI: http://websharks-inc.com/product/wp-super-snow/
Description: Beautiful falling snow plugin for any WordPress holiday or Christmas site.

Adds a customizable falling snow effect to any holiday or Christmas site.
*/
if (!defined('WPINC')) { // MUST have WordPress.
    exit('Do NOT access this file directly: '.basename(__FILE__));
}
if (version_compare(PHP_VERSION, '5.3', '<')) {
    function wp_super_snow_php53_dashboard_notice()
    {
        echo __('<div class="error"><p>Plugin NOT active. This version of WP Super Snow requires PHP v5.3+.</p></div>', 'wp-super-snow');
    }
    add_action('all_admin_notices', 'wp_super_snow_php53_dashboard_notice');
} else {
    require_once dirname(__FILE__).'/wp-super-snow.inc.php';
}
