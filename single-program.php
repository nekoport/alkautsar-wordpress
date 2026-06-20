<?php get_header(); ?>

<?php while (have_posts()): the_post();
    $schedule = get_field('program_schedule');
    $status   = get_field('program_status');
    $status_label = ($status === 'aktif') ? __('Aktif', 'alkautsar') : __('Nonaktif', 'alkautsar');
    $status_class = ($status === 'aktif') ? 'status-aktif' : 'status-nonaktif';
?>

<div class="program-single-wrap">
    <div class="container">

        <nav class="breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Beranda', 'alkautsar'); ?></a>
            <span>/</span>
            <a href="<?php echo esc_url(get_post_type_archive_link('program')); ?>"><?php _e('Program', 'alkautsar'); ?></a>
            <span>/</span>
            <span><?php the_title(); ?></span>
        </nav>

        <div class="program-single-layout">

            <div class="program-single-main">

                <div class="program-single-hero">
                    <?php if (has_post_thumbnail()): ?>
                    <div class="program-hero-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                    <?php else: ?>
                    <div class="program-hero-placeholder">
                        <span>&#x1F54C;</span>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="program-single-info">
                    <div class="program-single-badges">
                        <span class="program-status-badge <?php echo $status_class; ?>"><?php echo $status_label; ?></span>
                    </div>

                    <h1 class="program-single-title"><?php the_title(); ?></h1>

                    <?php if ($schedule): ?>
                    <div class="program-single-schedule">
                        <div class="schedule-item">
                            <span class="schedule-icon-large">&#x1F550;</span>
                            <div>
                                <div class="schedule-label"><?php _e('Jadwal Pelaksanaan', 'alkautsar'); ?></div>
                                <div class="schedule-value"><?php echo esc_html($schedule); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (get_the_content()): ?>
                    <div class="program-single-content">
                        <h3><?php _e('Tentang Program', 'alkautsar'); ?></h3>
                        <?php the_content(); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="program-navigation">
                    <a href="<?php echo esc_url(get_post_type_archive_link('program')); ?>" class="btn-back-program">
                        &larr; <?php _e('Kembali ke Program', 'alkautsar'); ?>
                    </a>
                </div>

            </div>

            <div class="program-single-sidebar">

                <div class="program-join-card">
                    <div class="join-card-header">
                        <span>&#x1F4CB;</span>
                        <h3><?php _e('Ikuti Program Ini', 'alkautsar'); ?></h3>
                    </div>
                    <p><?php _e('Bergabunglah dengan program masjid dan raih keberkahan bersama jamaah.', 'alkautsar'); ?></p>
                    <a href="<?php echo esc_url(home_url('/kontak')); ?>" class="btn-join">&#x1F4DE; <?php _e('Hubungi Kami', 'alkautsar'); ?></a>
                </div>

                <div class="program-info-card">
                    <h3><?php _e('Informasi Program', 'alkautsar'); ?></h3>
                    <ul class="program-info-list">
                        <li>
                            <span class="info-icon">&#x1F3F7;&#xFE0F;</span>
                            <div>
                                <small><?php _e('Status', 'alkautsar'); ?></small>
                                <strong><?php echo $status_label; ?></strong>
                            </div>
                        </li>
                        <?php if ($schedule): ?>
                        <li>
                            <span class="info-icon">&#x1F550;</span>
                            <div>
                                <small><?php _e('Jadwal', 'alkautsar'); ?></small>
                                <strong><?php echo esc_html($schedule); ?></strong>
                            </div>
                        </li>
                        <?php endif; ?>
                        <li>
                            <span class="info-icon">&#x1F4CD;</span>
                            <div>
                                <small><?php _e('Lokasi', 'alkautsar'); ?></small>
                                <strong><?php _e('Masjid Al-Kautsar', 'alkautsar'); ?></strong>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="program-donasi-mini">
                    <p><?php _e('Dukung program ini dengan donasi', 'alkautsar'); ?></p>
                    <a href="<?php echo esc_url(home_url('/donasi')); ?>" class="btn-donasi-mini">&#x1F49D; <?php _e('Donasi Sekarang', 'alkautsar'); ?></a>
                </div>

            </div>
        </div>
    </div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
