<?php
/**
 * Al-Kautsar Audit Log — Admin Page
 */

if (!defined('ABSPATH')) exit;
if (!current_user_can('administrator')) {
    wp_die(__('Anda tidak memiliki akses ke halaman ini.', 'alkautsar'));
}

// Handle: simpan retensi
if (isset($_POST['alk_save_retention']) && check_admin_referer('alk_audit_retention_nonce')) {
    $retention = absint($_POST['alk_retention_days']);
    if ($retention < 1) $retention = 90;
    update_option('alk_audit_retention', $retention);
    echo '<div class="notice notice-success"><p>Pengaturan retensi disimpan.</p></div>';
}

// Handle: hapus semua log
if (isset($_POST['alk_clear_logs']) && check_admin_referer('alk_audit_clear_nonce')) {
    alk_audit_clear_all();
    echo '<div class="notice notice-warning"><p>Semua log telah dihapus.</p></div>';
}

// Handle: hapus satu baris log
if (isset($_GET['alk_delete_log']) && isset($_GET['_wpnonce'])) {
    if (wp_verify_nonce(sanitize_text_field($_GET['_wpnonce']), 'alk_delete_log_' . absint($_GET['alk_delete_log']))) {
        global $wpdb;
        $table = $wpdb->prefix . ALK_AUDIT_TABLE;
        $wpdb->delete($table, array('id' => absint($_GET['alk_delete_log'])), array('%d'));
        echo '<div class="notice notice-success"><p>Log dihapus.</p></div>';
    }
}

// Filter params
$current_page  = isset($_GET['paged'])      ? absint($_GET['paged'])                          : 1;
$event_filter  = isset($_GET['event_type']) ? sanitize_text_field($_GET['event_type'])        : '';
$search        = isset($_GET['s'])          ? sanitize_text_field($_GET['s'])                 : '';
$date_from     = isset($_GET['date_from'])  ? sanitize_text_field($_GET['date_from'])         : '';
$date_to       = isset($_GET['date_to'])    ? sanitize_text_field($_GET['date_to'])           : '';
$per_page      = 25;

// Query logs
$result = alk_audit_get_logs(array(
    'per_page'   => $per_page,
    'page'       => $current_page,
    'event_type' => $event_filter,
    'search'     => $search,
    'date_from'  => $date_from,
    'date_to'    => $date_to,
));

$rows       = $result['rows'];
$total      = $result['total'];
$total_pages = ceil($total / $per_page);
$retention  = absint(get_option('alk_audit_retention', 90));

// Event type labels
$event_labels = array(
    'LOGIN_SUCCESS'      => array('label' => 'Login Berhasil',   'color' => '#10b981'),
    'LOGIN_FAILED'       => array('label' => 'Login Gagal',      'color' => '#f59e0b'),
    'BRUTE_FORCE'        => array('label' => 'Brute Force',      'color' => '#ef4444'),
    'LOGOUT'             => array('label' => 'Logout',           'color' => '#6b7280'),
    'POST_CREATED'       => array('label' => 'Post Dibuat',      'color' => '#3b82f6'),
    'POST_UPDATED'       => array('label' => 'Post Diupdate',    'color' => '#8b5cf6'),
    'POST_PUBLISHED'     => array('label' => 'Post Dipublish',   'color' => '#10b981'),
    'POST_UNPUBLISHED'   => array('label' => 'Post Unpublish',   'color' => '#f59e0b'),
    'POST_DELETED'       => array('label' => 'Post Dihapus',     'color' => '#ef4444'),
    'USER_CREATED'       => array('label' => 'User Dibuat',      'color' => '#3b82f6'),
    'USER_UPDATED'       => array('label' => 'User Diupdate',    'color' => '#8b5cf6'),
    'PASSWORD_CHANGED'   => array('label' => 'Password Diganti', 'color' => '#f59e0b'),
    'USER_DELETED'       => array('label' => 'User Dihapus',     'color' => '#ef4444'),
    'SETTINGS_UPDATED'   => array('label' => 'Settings Update',  'color' => '#8b5cf6'),
    'CUSTOMIZER_SAVED'   => array('label' => 'Customizer',       'color' => '#8b5cf6'),
    'PLUGIN_ACTIVATED'   => array('label' => 'Plugin Aktif',     'color' => '#10b981'),
    'PLUGIN_DEACTIVATED' => array('label' => 'Plugin Nonaktif',  'color' => '#6b7280'),
);

$base_url = admin_url('admin.php?page=alk-audit-log');
?>

<div class="wrap">
    <h1 class="wp-heading-inline">📋 Audit Log — Al-Kautsar</h1>
    <hr class="wp-header-end">

    <?php // ── FILTER BAR ── ?>
    <form method="get" action="<?php echo esc_url(admin_url('admin.php')); ?>" style="margin:16px 0;">
        <input type="hidden" name="page" value="alk-audit-log">
        <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:flex-end;">
            <div>
                <label style="display:block;font-size:12px;margin-bottom:4px;">Event</label>
                <select name="event_type">
                    <option value="">— Semua Event —</option>
                    <?php foreach ($event_labels as $key => $meta): ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($event_filter, $key); ?>>
                            <?php echo esc_html($meta['label']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label style="display:block;font-size:12px;margin-bottom:4px;">Dari Tanggal</label>
                <input type="date" name="date_from" value="<?php echo esc_attr($date_from); ?>">
            </div>
            <div>
                <label style="display:block;font-size:12px;margin-bottom:4px;">Sampai Tanggal</label>
                <input type="date" name="date_to" value="<?php echo esc_attr($date_to); ?>">
            </div>
            <div>
                <label style="display:block;font-size:12px;margin-bottom:4px;">Cari User / IP</label>
                <input type="text" name="s" value="<?php echo esc_attr($search); ?>" placeholder="username atau IP..." style="width:180px;">
            </div>
            <div>
                <?php submit_button('Filter', 'secondary', '', false); ?>
                <?php if ($event_filter || $search || $date_from || $date_to): ?>
                    <a href="<?php echo esc_url($base_url); ?>" class="button">Reset</a>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <?php // ── STATS ── ?>
    <p style="color:#666;font-size:13px;">
        Total: <strong><?php echo number_format($total); ?></strong> log ditemukan
        <?php if ($event_filter || $search || $date_from || $date_to): ?>
            (terfilter)
        <?php endif; ?>
    </p>

    <?php // ── TABLE ── ?>
    <table class="wp-list-table widefat fixed striped" style="font-size:13px;">
        <thead>
            <tr>
                <th style="width:140px;">Waktu</th>
                <th style="width:120px;">User</th>
                <th style="width:110px;">Role</th>
                <th style="width:140px;">Event</th>
                <th style="width:90px;">Tipe Objek</th>
                <th>Nama Objek</th>
                <th style="width:110px;">IP Address</th>
                <th style="width:60px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($rows)): ?>
                <tr>
                    <td colspan="8" style="text-align:center;padding:24px;color:#999;">
                        Tidak ada log ditemukan.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($rows as $row): ?>
                    <?php
                    $event_meta = isset($event_labels[$row->event_type])
                        ? $event_labels[$row->event_type]
                        : array('label' => esc_html($row->event_type), 'color' => '#6b7280');
                    $delete_nonce = wp_create_nonce('alk_delete_log_' . $row->id);
                    $delete_url   = esc_url(add_query_arg(array(
                        'page'           => 'alk-audit-log',
                        'alk_delete_log' => $row->id,
                        '_wpnonce'       => $delete_nonce,
                    ), admin_url('admin.php')));
                    ?>
                    <tr>
                        <td style="white-space:nowrap;font-size:12px;">
                            <?php echo esc_html(
                                date_i18n('d M Y H:i:s', strtotime($row->created_at))
                            ); ?>
                        </td>
                        <td>
                            <strong><?php echo esc_html($row->user_login ?: '—'); ?></strong>
                        </td>
                        <td style="font-size:12px;color:#666;">
                            <?php echo esc_html($row->user_role ?: '—'); ?>
                        </td>
                        <td>
                            <span style="
                                display:inline-block;
                                padding:2px 8px;
                                border-radius:4px;
                                font-size:11px;
                                font-weight:600;
                                color:#fff;
                                background:<?php echo esc_attr($event_meta['color']); ?>;
                                white-space:nowrap;
                            ">
                                <?php echo esc_html($event_meta['label']); ?>
                            </span>
                        </td>
                        <td style="font-size:12px;color:#666;">
                            <?php echo esc_html($row->object_type ?: '—'); ?>
                        </td>
                        <td>
                            <?php echo esc_html($row->object_name ?: '—'); ?>
                            <?php if ($row->object_id && in_array($row->object_type, array('post','page','program','kegiatan','laporan_keuangan'))): ?>
                                <a href="<?php echo esc_url(get_edit_post_link($row->object_id)); ?>"
                                   style="font-size:11px;margin-left:4px;" target="_blank">
                                    edit ↗
                                </a>
                            <?php endif; ?>
                        </td>
                        <td style="font-size:12px;font-family:monospace;">
                            <?php echo esc_html($row->ip_address ?: '—'); ?>
                        </td>
                        <td>
                            <a href="<?php echo $delete_url; ?>"
                               onclick="return confirm('Hapus log ini?');"
                               style="color:#ef4444;font-size:12px;">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <?php // ── PAGINATION ── ?>
    <?php if ($total_pages > 1): ?>
        <div style="margin:16px 0;">
            <?php
            $pagination_args = array_filter(array(
                'page'       => 'alk-audit-log',
                'event_type' => $event_filter,
                's'          => $search,
                'date_from'  => $date_from,
                'date_to'    => $date_to,
            ));
            for ($i = 1; $i <= $total_pages; $i++):
                $page_url = esc_url(add_query_arg(
                    array_merge($pagination_args, array('paged' => $i)),
                    admin_url('admin.php')
                ));
            ?>
                <a href="<?php echo $page_url; ?>"
                   style="display:inline-block;padding:4px 10px;margin:0 2px;
                          border:1px solid #ccc;border-radius:4px;font-size:13px;
                          <?php echo $i === $current_page ? 'background:#D4AF37;color:#fff;border-color:#D4AF37;' : 'background:#fff;'; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

    <?php // ── SETTINGS & DANGER ZONE ── ?>
    <div style="display:flex;gap:24px;flex-wrap:wrap;margin-top:32px;">

        <div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:20px;min-width:280px;">
            <h3 style="margin-top:0;">⚙️ Pengaturan Retensi</h3>
            <p style="font-size:13px;color:#666;">Log lebih lama dari jumlah hari ini akan dihapus otomatis setiap hari.</p>
            <form method="post">
                <?php wp_nonce_field('alk_audit_retention_nonce'); ?>
                <div style="display:flex;align-items:center;gap:8px;">
                    <input type="number" name="alk_retention_days"
                           value="<?php echo esc_attr($retention); ?>"
                           min="1" max="3650" style="width:80px;">
                    <span style="font-size:13px;">hari</span>
                    <?php submit_button('Simpan', 'primary small', 'alk_save_retention', false); ?>
                </div>
            </form>
        </div>

        <div style="background:#fff;border:1px solid #fca5a5;border-radius:8px;padding:20px;min-width:280px;">
            <h3 style="margin-top:0;color:#ef4444;">⚠️ Danger Zone</h3>
            <p style="font-size:13px;color:#666;">Hapus semua log secara permanen. Aksi ini tidak dapat dibatalkan.</p>
            <form method="post" onsubmit="return confirm('Yakin ingin menghapus SEMUA log? Aksi ini tidak dapat dibatalkan.');">
                <?php wp_nonce_field('alk_audit_clear_nonce'); ?>
                <?php submit_button('Hapus Semua Log', 'delete', 'alk_clear_logs', false); ?>
            </form>
        </div>

    </div>
</div>