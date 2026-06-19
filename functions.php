<?php
/**
 * Al-Kautsar Theme Functions
 */

define('ALK_VERSION', '1.0.1');

if (!defined('ALK_THEME_DIR')) {
    define('ALK_THEME_DIR', get_template_directory());
}

if (!defined('ALK_THEME_URI')) {
    define('ALK_THEME_URI', get_template_directory_uri());
}

require_once ALK_THEME_DIR . '/inc/theme-setup.php';
require_once ALK_THEME_DIR . '/inc/enqueue.php';
require_once ALK_THEME_DIR . '/inc/custom-post-types.php';
require_once ALK_THEME_DIR . '/inc/helpers.php';
require_once ALK_THEME_DIR . '/inc/acf-fields.php';
