<?php
/*
Version: 151204
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
$GLOBALS['wp_php_rv'] = '5.4'; // Require PHP vX.x+.

if (require(dirname(__FILE__).'/src/vendor/websharks/wp-php-rv/src/includes/check.php')) {
    require_once dirname(__FILE__).'/src/vendor/autoload.php';
    new WebSharks\WpSuperSnow\Plugin(__FILE__);
} else {
    wp_php_rv_notice('WP Super Snow');
}
