<?php
function alk_enqueue_scripts() {
    wp_enqueue_style('alk-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap', array(), null);
    wp_enqueue_style('alk-style', get_stylesheet_uri(), array(), ALK_VERSION);

    wp_enqueue_script('alk-main', ALK_THEME_URI . '/assets/js/main.js', array(), ALK_VERSION, true);

    wp_localize_script('alk-main', 'alkData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'themeUri' => ALK_THEME_URI,
        'nonce'   => wp_create_nonce('alk_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'alk_enqueue_scripts');

function alk_admin_enqueue($hook) {
    if (in_array($hook, array('post.php', 'post-new.php'))) {
        wp_enqueue_style('alk-admin', ALK_THEME_URI . '/assets/css/admin.css', array(), ALK_VERSION);
    }
}
add_action('admin_enqueue_scripts', 'alk_admin_enqueue');
