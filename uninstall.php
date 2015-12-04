<?php
if (!defined('WPINC')) { // MUST have WordPress.
    exit('Do NOT access this file directly: '.basename(__FILE__));
}
$GLOBALS['wp_php_rv'] = '5.4'; // Require PHP vX.x+.

if (require(dirname(__FILE__).'/src/vendor/websharks/wp-php-rv/src/includes/check.php')) {
    require_once dirname(__FILE__).'/src/vendor/autoload.php';
    WebSharks\WpSuperSnow\Plugin::uninstall();
}
