<?php
/**
 * Al-Kautsar Audit Log — Core
 * Membuat tabel, fungsi logging, dan cleanup otomatis.
 */

if (!defined('ABSPATH')) exit;

define('ALK_AUDIT_TABLE', 'alk_audit_log');
define('ALK_AUDIT_VERSION', '1.0.0');
define('ALK_AUDIT_RETENTION_DEFAULT', 90);

// ============================================================
// 1. CREATE TABLE saat tema diaktifkan
// ============================================================
function alk_audit_create_table() {
    global $wpdb;
    $table = $wpdb->prefix . ALK_AUDIT_TABLE;
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS {$table} (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT UNSIGNED NULL DEFAULT NULL,
        user_login VARCHAR(60) NULL DEFAULT NULL,
        user_role VARCHAR(50) NULL DEFAULT NULL,
        event_type VARCHAR(50) NOT NULL,
        object_type VARCHAR(50) NULL DEFAULT NULL,
        object_id BIGINT UNSIGNED NULL DEFAULT NULL,
        object_name VARCHAR(255) NULL DEFAULT NULL,
        ip_address VARCHAR(45) NULL DEFAULT NULL,
        user_agent VARCHAR(255) NULL DEFAULT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY idx_event_type (event_type),
        KEY idx_user_id (user_id),
        KEY idx_created_at (created_at)
    ) {$charset};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);

    update_option('alk_audit_version', ALK_AUDIT_VERSION);
}
add_action('after_switch_theme', 'alk_audit_create_table');

// Pastikan tabel ada jika belum dibuat (tema sudah aktif)
function alk_audit_maybe_create_table() {
    if (get_option('alk_audit_version') !== ALK_AUDIT_VERSION) {
        alk_audit_create_table();
    }
}
add_action('init', 'alk_audit_maybe_create_table');

// ============================================================
// 2. FUNGSI UTAMA LOGGING
// ============================================================
function alk_audit_log($event_type, $args = array()) {
    global $wpdb;
    $table = $wpdb->prefix . ALK_AUDIT_TABLE;

    // Ambil data user saat ini jika tidak disuplai
    $user_id    = isset($args['user_id'])    ? absint($args['user_id'])              : get_current_user_id();
    $user_login = isset($args['user_login']) ? sanitize_text_field($args['user_login']) : '';
    $user_role  = isset($args['user_role'])  ? sanitize_text_field($args['user_role'])  : '';

    // Jika user_login kosong, ambil dari user_id
    if (empty($user_login) && $user_id > 0) {
        $user = get_userdata($user_id);
        if ($user) {
            $user_login = $user->user_login;
            $user_role  = !empty($user->roles) ? implode(', ', $user->roles) : '';
        }
    }

    // Ambil IP address (support proxy)
    $ip = '';
    $ip_headers = array(
        'HTTP_CF_CONNECTING_IP',   // Cloudflare
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_REAL_IP',
        'REMOTE_ADDR',
    );
    foreach ($ip_headers as $header) {
        if (!empty($_SERVER[$header])) {
            $ip = sanitize_text_field(explode(',', $_SERVER[$header])[0]);
            break;
        }
    }

    // Ambil user agent
    $ua = isset($_SERVER['HTTP_USER_AGENT'])
        ? sanitize_text_field(substr($_SERVER['HTTP_USER_AGENT'], 0, 255))
        : '';

    $wpdb->insert(
        $table,
        array(
            'user_id'     => $user_id > 0 ? $user_id : null,
            'user_login'  => $user_login ?: null,
            'user_role'   => $user_role  ?: null,
            'event_type'  => sanitize_text_field($event_type),
            'object_type' => isset($args['object_type']) ? sanitize_text_field($args['object_type']) : null,
            'object_id'   => isset($args['object_id'])   ? absint($args['object_id'])                : null,
            'object_name' => isset($args['object_name']) ? sanitize_text_field(substr($args['object_name'], 0, 255)) : null,
            'ip_address'  => $ip  ?: null,
            'user_agent'  => $ua  ?: null,
            'created_at'  => current_time('mysql'),
        ),
        array('%d', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s')
    );
}

// ============================================================
// 3. QUERY LOG — untuk halaman admin
// ============================================================
function alk_audit_get_logs($args = array()) {
    global $wpdb;
    $table = $wpdb->prefix . ALK_AUDIT_TABLE;

    $defaults = array(
        'per_page'   => 50,
        'page'       => 1,
        'event_type' => '',
        'search'     => '',
        'date_from'  => '',
        'date_to'    => '',
    );
    $args = wp_parse_args($args, $defaults);

    $where  = array('1=1');
    $params = array();

    if (!empty($args['event_type'])) {
        $where[]  = 'event_type = %s';
        $params[] = $args['event_type'];
    }

    if (!empty($args['search'])) {
        $where[]  = '(user_login LIKE %s OR object_name LIKE %s OR ip_address LIKE %s)';
        $like     = '%' . $wpdb->esc_like($args['search']) . '%';
        $params[] = $like;
        $params[] = $like;
        $params[] = $like;
    }

    if (!empty($args['date_from'])) {
        $where[]  = 'created_at >= %s';
        $params[] = sanitize_text_field($args['date_from']) . ' 00:00:00';
    }

    if (!empty($args['date_to'])) {
        $where[]  = 'created_at <= %s';
        $params[] = sanitize_text_field($args['date_to']) . ' 23:59:59';
    }

    $where_sql = implode(' AND ', $where);
    $offset    = ($args['page'] - 1) * $args['per_page'];

    // Total rows
    $count_sql = "SELECT COUNT(*) FROM {$table} WHERE {$where_sql}";
    $total     = $params
        ? $wpdb->get_var($wpdb->prepare($count_sql, $params))
        : $wpdb->get_var($count_sql);

    // Data rows
    $data_sql = "SELECT * FROM {$table} WHERE {$where_sql} ORDER BY created_at DESC LIMIT %d OFFSET %d";
    $all_params = array_merge($params, array($args['per_page'], $offset));
    $rows = $wpdb->get_results($wpdb->prepare($data_sql, $all_params));

    return array(
        'rows'  => $rows ?: array(),
        'total' => (int) $total,
    );
}

// ============================================================
// 4. WP CRON — auto cleanup log lama
// ============================================================
function alk_audit_schedule_cleanup() {
    if (!wp_next_scheduled('alk_audit_cleanup_event')) {
        wp_schedule_event(time(), 'daily', 'alk_audit_cleanup_event');
    }
}
add_action('wp', 'alk_audit_schedule_cleanup');

function alk_audit_run_cleanup() {
    global $wpdb;
    $table     = $wpdb->prefix . ALK_AUDIT_TABLE;
    $retention = absint(get_option('alk_audit_retention', ALK_AUDIT_RETENTION_DEFAULT));
    if ($retention < 1) $retention = ALK_AUDIT_RETENTION_DEFAULT;

    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$table} WHERE created_at < DATE_SUB(NOW(), INTERVAL %d DAY)",
            $retention
        )
    );
}
add_action('alk_audit_cleanup_event', 'alk_audit_run_cleanup');

// Hapus cron saat tema di-deactivate
function alk_audit_deactivate_cleanup() {
    wp_clear_scheduled_hook('alk_audit_cleanup_event');
}
add_action('switch_theme', 'alk_audit_deactivate_cleanup');

// ============================================================
// 5. HAPUS SEMUA LOG (manual dari admin)
// ============================================================
function alk_audit_clear_all() {
    global $wpdb;
    $table = $wpdb->prefix . ALK_AUDIT_TABLE;
    $wpdb->query("TRUNCATE TABLE {$table}");
}