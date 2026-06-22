<?php
/**
 * Al-Kautsar Audit Log — Hooks
 * Mencatat semua event WordPress ke audit log.
 */

if (!defined('ABSPATH')) exit;

// ============================================================
// AUTH EVENTS
// ============================================================

// Login berhasil
add_action('wp_login', function($user_login, $user) {
    alk_audit_log('LOGIN_SUCCESS', array(
        'user_id'     => $user->ID,
        'user_login'  => $user_login,
        'object_type' => 'auth',
        'object_name' => 'Login berhasil',
    ));
}, 10, 2);

// Login gagal
add_action('wp_login_failed', function($username) {
    alk_audit_log('LOGIN_FAILED', array(
        'user_id'     => 0,
        'user_login'  => sanitize_text_field($username),
        'object_type' => 'auth',
        'object_name' => 'Login gagal',
    ));
});

// Brute force detection — 5 kali gagal dalam 15 menit
add_action('wp_login_failed', function($username) {
    $transient_key = 'alk_login_fail_' . md5(sanitize_text_field($username));
    $attempts = (int) get_transient($transient_key);
    $attempts++;
    set_transient($transient_key, $attempts, 15 * MINUTE_IN_SECONDS);

    if ($attempts === 5) {
        alk_audit_log('BRUTE_FORCE', array(
            'user_id'     => 0,
            'user_login'  => sanitize_text_field($username),
            'object_type' => 'auth',
            'object_name' => '5 kali gagal login dalam 15 menit',
        ));
    }
});

// Reset transient saat login berhasil
add_action('wp_login', function($user_login) {
    $transient_key = 'alk_login_fail_' . md5($user_login);
    delete_transient($transient_key);
}, 10, 1);

// Logout
add_action('wp_logout', function($user_id) {
    $user = get_userdata($user_id);
    alk_audit_log('LOGOUT', array(
        'user_id'     => $user_id,
        'user_login'  => $user ? $user->user_login : '',
        'object_type' => 'auth',
        'object_name' => 'Logout',
    ));
});

// ============================================================
// POST / PAGE EVENTS
// ============================================================

// Post dibuat atau diupdate
add_action('save_post', function($post_id, $post, $update) {
    // Abaikan autosave, revision, dan post type tersembunyi
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (wp_is_post_revision($post_id)) return;
    if (in_array($post->post_type, array('nav_menu_item', 'custom_css', 'customize_changeset'))) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $event = $update ? 'POST_UPDATED' : 'POST_CREATED';

    alk_audit_log($event, array(
        'object_type' => $post->post_type,
        'object_id'   => $post_id,
        'object_name' => $post->post_title ?: '(tanpa judul)',
    ));
}, 10, 3);

// Post dipublish
add_action('publish_post', function($post_id, $post) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    alk_audit_log('POST_PUBLISHED', array(
        'object_type' => $post->post_type,
        'object_id'   => $post_id,
        'object_name' => $post->post_title ?: '(tanpa judul)',
    ));
}, 10, 2);

// Post unpublish (kembali ke draft)
add_action('draft_post', function($post_id, $post) {
    alk_audit_log('POST_UNPUBLISHED', array(
        'object_type' => $post->post_type,
        'object_id'   => $post_id,
        'object_name' => $post->post_title ?: '(tanpa judul)',
    ));
}, 10, 2);

// Post dihapus (masuk trash)
add_action('trashed_post', function($post_id) {
    $post = get_post($post_id);
    if (!$post) return;
    alk_audit_log('POST_DELETED', array(
        'object_type' => $post->post_type,
        'object_id'   => $post_id,
        'object_name' => $post->post_title ?: '(tanpa judul)',
    ));
});

// ============================================================
// USER MANAGEMENT EVENTS
// ============================================================

// User baru dibuat
add_action('user_register', function($user_id) {
    $user = get_userdata($user_id);
    alk_audit_log('USER_CREATED', array(
        'object_type' => 'user',
        'object_id'   => $user_id,
        'object_name' => $user ? $user->user_login : '(unknown)',
    ));
});

// User diupdate
add_action('profile_update', function($user_id, $old_data) {
    $user = get_userdata($user_id);
    alk_audit_log('USER_UPDATED', array(
        'object_type' => 'user',
        'object_id'   => $user_id,
        'object_name' => $user ? $user->user_login : '(unknown)',
    ));
}, 10, 2);

// Password diganti
add_action('password_reset', function($user, $new_pass) {
    alk_audit_log('PASSWORD_CHANGED', array(
        'user_id'     => $user->ID,
        'user_login'  => $user->user_login,
        'object_type' => 'user',
        'object_id'   => $user->ID,
        'object_name' => $user->user_login,
    ));
}, 10, 2);

// User dihapus
add_action('delete_user', function($user_id, $reassign, $user) {
    alk_audit_log('USER_DELETED', array(
        'object_type' => 'user',
        'object_id'   => $user_id,
        'object_name' => $user ? $user->user_login : '(unknown)',
    ));
}, 10, 3);

// ============================================================
// SETTINGS EVENTS
// ============================================================

// WordPress Settings diupdate
add_action('updated_option', function($option_name, $old_value, $new_value) {
    // Abaikan option internal WordPress yang sering berubah
    $ignored = array(
        'cron', '_transient', '_site_transient', 'session_tokens',
        'user_roles', 'recently_activated', 'active_plugins',
        'rewrite_rules', 'wp_user_roles', 'alk_audit_version',
    );
    foreach ($ignored as $ignore) {
        if (strpos($option_name, $ignore) !== false) return;
    }

    // Hanya catat perubahan dari WP Admin
    if (!is_admin()) return;

    alk_audit_log('SETTINGS_UPDATED', array(
        'object_type' => 'settings',
        'object_name' => sanitize_text_field($option_name),
    ));
}, 10, 3);

// Theme Customizer disimpan
add_action('customize_save_after', function($manager) {
    alk_audit_log('CUSTOMIZER_SAVED', array(
        'object_type' => 'settings',
        'object_name' => 'Theme Customizer',
    ));
});

// Plugin diaktifkan
add_action('activated_plugin', function($plugin) {
    alk_audit_log('PLUGIN_ACTIVATED', array(
        'object_type' => 'plugin',
        'object_name' => sanitize_text_field($plugin),
    ));
});

// Plugin dinonaktifkan
add_action('deactivated_plugin', function($plugin) {
    alk_audit_log('PLUGIN_DEACTIVATED', array(
        'object_type' => 'plugin',
        'object_name' => sanitize_text_field($plugin),
    ));
});
