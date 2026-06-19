<?php get_header(); ?>

<?php $hero_image = get_theme_mod('hero_image', ''); ?>
<section class="hero-section" style="<?php if ($hero_image) : ?>background-image: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('<?php echo esc_url($hero_image); ?>');background-size:cover;background-position:center;background-repeat:no-repeat;<?php else : ?>background:linear-gradient(135deg, #1a0e00 0%, #2d1a00 50%, #1a0e00 100%);<?php endif; ?>">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content centered">
            <span class="hero-badge">&#x1F54B; MASJID AL-KAUTSAR</span>
            <h1 class="hero-title"><?php _e('Selamat Datang di', 'alkautsar'); ?><br><span class="hero-title-gold"><?php _e('Masjid Al-Kautsar', 'alkautsar'); ?></span></h1>
            <p class="hero-subtitle"><?php echo esc_html(get_theme_mod('alk_hero_desc', __('Rusunawa Green Jagakarsa. Bersama membangun komunitas islami yang berkah, modern, dan bermanfaat untuk semua.', 'alkautsar'))); ?></p>
            <div class="hero-buttons">
                <a href="<?php echo esc_url(home_url('/donasi')); ?>" class="btn btn-gold"><?php _e('Donasi Sekarang', 'alkautsar'); ?></a>
                <a href="<?php echo esc_url(home_url('/profil')); ?>" class="btn btn-outline"><?php _e('Tentang Kami', 'alkautsar'); ?></a>
            </div>
            <div class="hero-quote">
                <p><em>"<?php _e('Sesungguhnya yang memakmurkan masjid Allah hanyalah orang-orang yang beriman kepada Allah', 'alkautsar'); ?>"</em></p>
                <small>&mdash; QS. At-Taubah: 18</small>
            </div>
        </div>
    </div>
</section>

<section class="prayer-section">
    <div class="container">
        <div class="prayer-card">
            <div class="prayer-header">
                <span class="prayer-icon">&#x1F54C;</span>
                <div>
                    <h3><?php _e('Jadwal Sholat Hari Ini', 'alkautsar'); ?></h3>
                    <p id="prayer-date"><?php
                        $hari = array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
                        $bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
                        $now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                        echo $hari[(int)$now->format('w')] . ', ' . $now->format('j') . ' ' . $bulan[(int)$now->format('n')] . ' ' . $now->format('Y');
                    ?></p>
                </div>
                <div class="prayer-location">
                    <span>&#x1F4CD;</span>
                    <small><?php _e('Jagakarsa, Jakarta Selatan', 'alkautsar'); ?></small>
                </div>
            </div>
            <div class="prayer-times-grid" id="prayer-times-grid">
                <div class="prayer-loading"><?php _e('Memuat jadwal sholat...', 'alkautsar'); ?></div>
            </div>
            <div class="next-prayer-banner" id="next-prayer-banner"></div>
        </div>
    </div>
</section>

<section class="section-berita">
    <div class="container">
        <div class="section-header">
            <h2><?php _e('Berita Terbaru', 'alkautsar'); ?></h2>
            <p><?php _e('Informasi dan kegiatan terbaru dari Masjid Al-Kautsar', 'alkautsar'); ?></p>
        </div>
        <div class="content-with-sidebar">
            <div class="content-main">
                <div class="posts-grid-home">
                    <?php
                    $news_query = new WP_Query(array(
                        'post_type'      => 'post',
                        'posts_per_page' => 3,
                    ));
                    if ($news_query->have_posts()) :
                        while ($news_query->have_posts()) : $news_query->the_post(); ?>
                            <div class="news-card">
                                <div class="news-card-image">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium'); ?>
                                    <?php else : ?>
                                        <span>&#128240;</span>
                                    <?php endif; ?>
                                </div>
                                <div class="news-card-body">
                                    <div class="news-card-date"><?php echo alk_tanggal_indo(); ?></div>
                                    <h3 class="news-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="news-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></div>
                                    <a href="<?php the_permalink(); ?>" class="news-card-more"><?php _e('Baca Selengkapnya', 'alkautsar'); ?> &rarr;</a>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                    else : ?>
                        <p><?php _e('Belum ada berita.', 'alkautsar'); ?></p>
                    <?php endif; ?>
                </div>
                <div class="section-cta">
                    <a href="<?php echo esc_url(home_url('/berita')); ?>" class="btn btn-outline-gold"><?php _e('Lihat Semua Berita', 'alkautsar'); ?></a>
                </div>
                <div class="masjid-stats">
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Jamaah Aktif</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">12+</span>
                        <span class="stat-label">Program Rutin</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">1446H</span>
                        <span class="stat-label">Tahun Berdiri</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">Penerima Manfaat</span>
                    </div>
                </div>
            </div>
            <div class="content-sidebar">
                <div class="sidebar-donasi-home">
                    <div class="donasi-widget-home">
                        <div class="donasi-header">
                            <span class="donasi-icon">&#x1F932;</span>
                            <h3><?php _e('Dukung Masjid', 'alkautsar'); ?></h3>
                            <p><?php _e('Salurkan donasi Anda untuk kemakmuran Masjid Al-Kautsar', 'alkautsar'); ?></p>
                        </div>
                        <div class="donasi-rekening-box">
                            <p class="donasi-via"><?php _e('Salurkan Via Transfer Bank', 'alkautsar'); ?></p>
                            <div class="bank-info">
                                <div class="bank-logo-name">
                                    <span class="bank-icon">&#x1F3E6;</span>
                                    <span class="bank-name"><?php echo esc_html(get_theme_mod('alk_bank_name', 'Bank Muamalat')); ?></span>
                                </div>
                                <div class="rekening-number"><?php echo esc_html(get_theme_mod('alk_rekening', '010 235 692 (147)')); ?></div>
                                <div class="rekening-atas-nama">a.n. <?php echo esc_html(get_theme_mod('alk_atas_nama', 'Masjid Al-Kautsar')); ?></div>
                            </div>
                        </div>
                        <?php $qris = get_theme_mod('alk_qris_image', ''); ?>
                        <?php if ($qris): ?>
                        <div class="donasi-qris-home">
                            <p class="qris-divider">— <?php _e('atau scan QRIS', 'alkautsar'); ?> —</p>
                            <img src="<?php echo esc_url($qris); ?>" alt="QRIS Masjid Al-Kautsar" class="qris-image-home">
                            <p class="qris-caption"><?php _e('Scan untuk donasi via QRIS', 'alkautsar'); ?><br><small><?php _e('Berlaku semua aplikasi pembayaran', 'alkautsar'); ?></small></p>
                        </div>
                        <?php endif; ?>
                        <a href="<?php echo esc_url(home_url('/donasi')); ?>" class="btn-donasi-home">&#x1F49D; <?php _e('Donasi Sekarang', 'alkautsar'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section" style="background:var(--color-bg-alt);">
    <div class="container">
        <div class="section-title">
            <h2><?php _e('Galeri Program', 'alkautsar'); ?></h2>
            <p><?php _e('Dokumentasi kegiatan dan program Masjid Al-Kautsar', 'alkautsar'); ?></p>
        </div>
        <div class="gallery-grid">
            <?php
            $gallery = new WP_Query(array(
                'post_type'      => 'program',
                'posts_per_page' => 7,
            ));
            $count = 0;
            if ($gallery->have_posts()) :
                while ($gallery->have_posts()) : $gallery->the_post();
                    $count++;
                    $has_img = has_post_thumbnail();
                    $extra_class = (!$has_img) ? ' no-image' : '';
                    $extra_class .= ($count === 1 && $has_img) ? ' tall' : '';
                    if ($has_img) :
                        $img_url = get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>
                        <div class="gallery-item<?php echo $extra_class; ?>" onclick="openLightbox('<?php echo esc_url($img_url); ?>')">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                            <div class="gallery-item-overlay">
                                <span><?php the_title(); ?></span>
                            </div>
                        </div>
                    <?php else :
                        $schedule = function_exists('get_field') ? get_field('program_schedule') : ''; ?>
                        <div class="gallery-item<?php echo $extra_class; ?>">
                            <div class="program-card-noimg">
                                <div class="program-card-placeholder">
                                    <span class="program-icon">&#x1F54C;</span>
                                </div>
                                <div class="program-card-info">
                                    <h3><?php the_title(); ?></h3>
                                    <?php if ($schedule) : ?><p><?php echo esc_html($schedule); ?></p><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endwhile;
                wp_reset_postdata();
            else :
                for ($i = 1; $i <= 4; $i++) : ?>
                    <div class="gallery-item<?php echo ($i === 1) ? ' tall' : ''; ?>">
                        <div class="program-placeholder">
                            <div class="placeholder-icon">&#x1F54C;</div>
                            <p class="placeholder-text"><?php _e('Foto Program', 'alkautsar'); ?></p>
                        </div>
                    </div>
                <?php endfor;
            endif; ?>
        </div>
        <div style="text-align:center;margin-top:32px;">
            <a href="<?php echo esc_url(home_url('/program')); ?>" class="btn btn-outline"><?php _e('Lihat Semua Program', 'alkautsar'); ?></a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="donasi-cta">
            <h2><?php _e('Dukung Program Kami', 'alkautsar'); ?></h2>
            <p><?php _e('Setiap donasi Anda akan digunakan untuk kemakmuran masjid dan program pemberdayaan masyarakat. Mari bersama-sama membangun masjid yang lebih baik.', 'alkautsar'); ?></p>
            <a href="<?php echo esc_url(home_url('/donasi')); ?>" class="btn btn-white"><?php _e('Donasi Sekarang', 'alkautsar'); ?></a>
        </div>
    </div>
</section>

<section class="section" style="background:var(--color-bg-alt);">
    <div class="container">
        <div class="section-title">
            <h2><?php _e('Kegiatan Mendatang', 'alkautsar'); ?></h2>
            <p><?php _e('Jadwal kegiatan dan acara mendatang di Masjid Al-Kautsar', 'alkautsar'); ?></p>
        </div>
        <?php
        $events = alk_get_upcoming_events(3);
        if (!empty($events)) : ?>
            <div class="news-grid">
                <?php foreach ($events as $event) : ?>
                    <div class="news-card">
                        <div class="news-card-image" style="background:linear-gradient(135deg,var(--color-gold),var(--color-gold-light));display:flex;align-items:center;justify-content:center;">
                            <span style="font-size:3rem;">&#128197;</span>
                        </div>
                        <div class="news-card-body">
                            <div class="news-card-date"><?php echo esc_html($event['date']); ?></div>
                            <h3 class="news-card-title"><?php echo esc_html($event['title']); ?></h3>
                            <div class="news-card-excerpt"><?php echo esc_html($event['desc']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p style="text-align:center;color:var(--color-text-light);"><?php _e('Belum ada kegiatan mendatang.', 'alkautsar'); ?></p>
        <?php endif; ?>
    </div>
</section>

<div class="lightbox" id="lightbox">
    <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
    <button class="lightbox-prev" onclick="prevLightbox()">&#8249;</button>
    <img id="lightboxImg" src="" alt="">
    <button class="lightbox-next" onclick="nextLightbox()">&#8250;</button>
</div>

<?php get_footer(); ?>
