<?php
function alk_theme_setup() {
    load_theme_textdomain('alkautsar', ALK_THEME_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 60,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('align-wide');

    register_nav_menus(array(
        'primary' => __('Menu Utama', 'alkautsar'),
        'footer'  => __('Menu Footer', 'alkautsar'),
    ));

    set_post_thumbnail_size(600, 400, true);
    add_image_size('alk-gallery', 800, 800, true);
    add_image_size('alk-hero', 1400, 800, true);
}
add_action('after_setup_theme', 'alk_theme_setup');

function alk_content_width() {
    $GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'alk_content_width', 0);

function alk_fallback_menu() {
    echo '<ul class="primary-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Beranda', 'alkautsar') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/berita')) . '">' . __('Berita', 'alkautsar') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/program')) . '">' . __('Program', 'alkautsar') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/jadwal-sholat')) . '">' . __('Jadwal Sholat', 'alkautsar') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/donasi')) . '">' . __('Donasi', 'alkautsar') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/kontak')) . '">' . __('Kontak', 'alkautsar') . '</a></li>';
    echo '</ul>';
}

function alk_customize_register($wp_customize) {
    $wp_customize->add_section('alk_hero', array(
        'title'    => __('Hero Section', 'alkautsar'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('alk_hero_title', array(
        'default'           => 'Selamat Datang di ',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('alk_hero_title', array(
        'label'   => __('Hero Title', 'alkautsar'),
        'section' => 'alk_hero',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
        'label'    => __('Hero Background Image', 'alkautsar'),
        'section'  => 'alk_hero',
        'settings' => 'hero_image',
    )));

    $wp_customize->add_setting('alk_hero_desc', array(
        'default'           => 'Rusunawa Green Jagakarsa. Bersama membangun komunitas islami yang berkah, modern, dan bermanfaat untuk semua.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('alk_hero_desc', array(
        'label'   => __('Hero Description', 'alkautsar'),
        'section' => 'alk_hero',
        'type'    => 'textarea',
    ));

    $wp_customize->add_section('alk_info', array(
        'title'    => __('Informasi Masjid', 'alkautsar'),
        'priority' => 35,
    ));

    $wp_customize->add_setting('alk_subtitle', array(
        'default'           => 'Masjid Al-Kautsar',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('alk_subtitle', array(
        'label'   => __('Subtitle Header', 'alkautsar'),
        'section' => 'alk_info',
        'type'    => 'text',
    ));

    $fields = array(
        'alk_address' => array('label' => __('Alamat', 'alkautsar'), 'type' => 'textarea', 'default' => 'Rusunawa Green Jagakarsa, Jakarta Selatan'),
        'alk_phone'   => array('label' => __('Telepon', 'alkautsar'), 'type' => 'text', 'default' => '021-12345678'),
        'alk_email'   => array('label' => __('Email', 'alkautsar'), 'type' => 'text', 'default' => 'info@masjid-alkautsar.my.id'),
        'alk_footer_desc' => array('label' => __('Footer Description', 'alkautsar'), 'type' => 'textarea', 'default' => 'Masjid Al-Kautsar Rusunawa Green Jagakarsa. Menjadi pusat ibadah, pendidikan, dan pemberdayaan masyarakat yang islami, modern, dan berkah.'),
        'alk_bsi_account' => array('label' => __('No. Rek BSI', 'alkautsar'), 'type' => 'text', 'default' => '7112345678'),
        'alk_mandiri_account' => array('label' => __('No. Rek Mandiri', 'alkautsar'), 'type' => 'text', 'default' => '1234567890'),
    );

    foreach ($fields as $key => $field) {
        $wp_customize->add_setting($key, array(
            'default'           => $field['default'],
            'sanitize_callback' => $field['type'] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field',
        ));
        $wp_customize->add_control($key, array(
            'label'   => $field['label'],
            'section' => 'alk_info',
            'type'    => $field['type'],
        ));
    }
}
add_action('customize_register', 'alk_customize_register');

function alk_customize_donasi($wp_customize) {
    $wp_customize->add_section('alk_donasi', array(
        'title'    => __('Informasi Donasi', 'alkautsar'),
        'priority' => 35,
    ));

    $wp_customize->add_setting('alk_qris_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'alk_qris_image', array(
        'label'    => __('Upload Gambar QRIS', 'alkautsar'),
        'section'  => 'alk_donasi',
        'settings' => 'alk_qris_image',
    )));

    $wp_customize->add_setting('alk_bank_name', array(
        'default'           => 'Bank Muamalat',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('alk_bank_name', array(
        'label'   => __('Nama Bank', 'alkautsar'),
        'section' => 'alk_donasi',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('alk_rekening', array(
        'default'           => '010 235 692 (147)',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('alk_rekening', array(
        'label'   => __('Nomor Rekening', 'alkautsar'),
        'section' => 'alk_donasi',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('alk_atas_nama', array(
        'default'           => 'Masjid Al-Kautsar Green Jagakarsa',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('alk_atas_nama', array(
        'label'   => __('Atas Nama', 'alkautsar'),
        'section' => 'alk_donasi',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'alk_customize_donasi');

function alk_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'alkautsar'),
        'id'            => 'sidebar-1',
        'description'   => __('Sidebar utama', 'alkautsar'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 1', 'alkautsar'),
        'id'            => 'footer-1',
        'description'   => __('Widget footer kolom pertama', 'alkautsar'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'alk_widgets_init');
