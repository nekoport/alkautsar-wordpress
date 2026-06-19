<?php
function alk_register_cpts() {
    $labels = array(
        'name'                  => __('Program', 'alkautsar'),
        'singular_name'         => __('Program', 'alkautsar'),
        'add_new'               => __('Tambah Program', 'alkautsar'),
        'add_new_item'          => __('Tambah Program Baru', 'alkautsar'),
        'edit_item'             => __('Edit Program', 'alkautsar'),
        'view_item'             => __('Lihat Program', 'alkautsar'),
        'all_items'             => __('Semua Program', 'alkautsar'),
        'search_items'          => __('Cari Program', 'alkautsar'),
        'not_found'             => __('Program tidak ditemukan.', 'alkautsar'),
        'not_found_in_trash'    => __('Tidak ada program di tong sampah.', 'alkautsar'),
    );
    $args = array(
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-megaphone',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'      => array('slug' => 'program'),
        'show_in_rest' => true,
    );
    register_post_type('program', $args);

    $labels = array(
        'name'                  => __('Kegiatan', 'alkautsar'),
        'singular_name'         => __('Kegiatan', 'alkautsar'),
        'add_new'               => __('Tambah Kegiatan', 'alkautsar'),
        'add_new_item'          => __('Tambah Kegiatan Baru', 'alkautsar'),
        'edit_item'             => __('Edit Kegiatan', 'alkautsar'),
        'view_item'             => __('Lihat Kegiatan', 'alkautsar'),
        'all_items'             => __('Semua Kegiatan', 'alkautsar'),
        'search_items'          => __('Cari Kegiatan', 'alkautsar'),
        'not_found'             => __('Kegiatan tidak ditemukan.', 'alkautsar'),
        'not_found_in_trash'    => __('Tidak ada kegiatan di tong sampah.', 'alkautsar'),
    );
    $args = array(
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-calendar-alt',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'      => array('slug' => 'kegiatan'),
        'show_in_rest' => true,
    );
    register_post_type('kegiatan', $args);

    $labels = array(
        'name'                  => __('Laporan Keuangan', 'alkautsar'),
        'singular_name'         => __('Laporan Keuangan', 'alkautsar'),
        'add_new'               => __('Tambah Laporan', 'alkautsar'),
        'add_new_item'          => __('Tambah Laporan Baru', 'alkautsar'),
        'edit_item'             => __('Edit Laporan', 'alkautsar'),
        'view_item'             => __('Lihat Laporan', 'alkautsar'),
        'all_items'             => __('Semua Laporan', 'alkautsar'),
        'search_items'          => __('Cari Laporan', 'alkautsar'),
        'not_found'             => __('Laporan tidak ditemukan.', 'alkautsar'),
        'not_found_in_trash'    => __('Tidak ada laporan di tong sampah.', 'alkautsar'),
    );
    $args = array(
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-chart-area',
        'supports'     => array('title', 'editor', 'thumbnail'),
        'rewrite'      => array('slug' => 'laporan-keuangan'),
        'show_in_rest' => true,
    );
    register_post_type('laporan_keuangan', $args);

    $labels = array(
        'name'                  => __('Penerima Manfaat', 'alkautsar'),
        'singular_name'         => __('Penerima Manfaat', 'alkautsar'),
        'add_new'               => __('Tambah Penerima', 'alkautsar'),
        'add_new_item'          => __('Tambah Penerima Baru', 'alkautsar'),
        'edit_item'             => __('Edit Penerima', 'alkautsar'),
        'view_item'             => __('Lihat Penerima', 'alkautsar'),
        'all_items'             => __('Semua Penerima', 'alkautsar'),
        'search_items'          => __('Cari Penerima', 'alkautsar'),
        'not_found'             => __('Penerima tidak ditemukan.', 'alkautsar'),
        'not_found_in_trash'    => __('Tidak ada penerima di tong sampah.', 'alkautsar'),
    );
    $args = array(
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-groups',
        'supports'     => array('title'),
        'rewrite'      => array('slug' => 'penerima-manfaat'),
        'show_in_rest' => true,
    );
    register_post_type('beneficiary', $args);

    register_taxonomy('program_category', 'program', array(
        'label'        => __('Kategori Program', 'alkautsar'),
        'rewrite'      => array('slug' => 'program/kategori'),
        'show_in_rest' => true,
        'hierarchical' => true,
    ));

    register_taxonomy('kegiatan_category', 'kegiatan', array(
        'label'        => __('Kategori Kegiatan', 'alkautsar'),
        'rewrite'      => array('slug' => 'kegiatan/kategori'),
        'show_in_rest' => true,
        'hierarchical' => true,
    ));
}
add_action('init', 'alk_register_cpts');

function alk_add_donasi_page_template() {
    $templates = array(
        'pages/template-donasi.php' => __('Halaman Donasi', 'alkautsar'),
        'pages/template-full-width.php' => __('Full Width', 'alkautsar'),
    );
    return $templates;
}
add_filter('theme_page_templates', 'alk_add_donasi_page_template');

function alk_load_page_template($template) {
    if (is_page() && !is_front_page()) {
        $template_slug = get_page_template_slug();
        if ($template_slug && file_exists(ALK_THEME_DIR . '/' . $template_slug)) {
            return ALK_THEME_DIR . '/' . $template_slug;
        }
    }
    return $template;
}
add_filter('template_include', 'alk_load_page_template');
