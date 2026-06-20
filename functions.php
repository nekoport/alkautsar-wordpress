<?php
/**
 * Al-Kautsar Theme Functions
 */

define('ALK_VERSION', '1.0.2');

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

// Register custom page templates manually
add_filter('theme_page_templates', function($templates) {
    $templates['jadwal-sholat.php'] = 'Jadwal Sholat';
    $templates['donasi.php']        = 'Halaman Donasi';
    $templates['transparansi.php']  = 'Transparansi';
    $templates['profil.php']        = 'Profil';
    $templates['kontak.php']        = 'Kontak';
    return $templates;
});
