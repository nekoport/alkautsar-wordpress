<aside class="widget-area">
    <div class="sidebar-widget donasi-widget">
        <h3 class="widget-title">&#x1F49D; <?php _e('Dukung Masjid', 'alkautsar'); ?></h3>
        <div class="donasi-info">
            <p class="donasi-label"><?php _e('Salurkan Donasi Via', 'alkautsar'); ?></p>
            <p class="donasi-bank">&#x1F3E6; <?php echo esc_html(get_theme_mod('alk_bank_name', 'Bank Muamalat')); ?></p>
            <p class="donasi-rekening"><?php echo esc_html(get_theme_mod('alk_rekening', '010 235 692 (147)')); ?></p>
            <p class="donasi-atas-nama">a.n. <?php echo esc_html(get_theme_mod('alk_atas_nama', 'Masjid Al-Kautsar')); ?></p>

            <div class="donasi-qris">
                <p class="qris-label">— <?php _e('atau scan QRIS', 'alkautsar'); ?> —</p>
                <?php $qris = get_theme_mod('alk_qris_image', ''); ?>
                <?php if ($qris): ?>
                <div class="qris-image-wrapper">
                    <img src="<?php echo esc_url($qris); ?>" alt="QRIS Masjid Al-Kautsar" class="qris-image">
                    <p class="qris-caption">
                        <?php _e('Scan untuk donasi via QRIS', 'alkautsar'); ?><br>
                        <small><?php _e('Berlaku untuk semua aplikasi pembayaran', 'alkautsar'); ?></small>
                    </p>
                </div>
                <?php else: ?>
                <div class="qris-placeholder">
                    <span>&#x1F4F1;</span>
                    <p><?php _e('QRIS tersedia', 'alkautsar'); ?></p>
                    <small><?php _e('Upload via Appearance &rarr; Customize &rarr; Informasi Donasi', 'alkautsar'); ?></small>
                </div>
                <?php endif; ?>
            </div>

            <a href="<?php echo esc_url(home_url('/donasi')); ?>" class="btn-donasi-sidebar">&#x1F49D; <?php _e('Donasi Sekarang', 'alkautsar'); ?></a>
        </div>
    </div>

    <div class="sidebar-widget">
        <h3 class="widget-title">&#x1F4F0; <?php _e('Berita Terbaru', 'alkautsar'); ?></h3>
        <?php
        $recent = new WP_Query(array('posts_per_page' => 5, 'post_status' => 'publish'));
        if ($recent->have_posts()): ?>
        <ul class="recent-posts-list">
            <?php while ($recent->have_posts()): $recent->the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <span class="post-date"><?php echo alk_tanggal_indo(); ?></span>
            </li>
            <?php endwhile; wp_reset_postdata(); ?>
        </ul>
        <?php endif; ?>
    </div>

    <div class="sidebar-widget">
        <h3 class="widget-title">&#x1F3F7;&#xFE0F; <?php _e('Kategori', 'alkautsar'); ?></h3>
        <?php
        $categories = get_categories(array('hide_empty' => true));
        if ($categories): ?>
        <ul class="category-list">
            <?php foreach ($categories as $cat): ?>
            <li>
                <a href="<?php echo get_category_link($cat->term_id); ?>">
                    <?php echo $cat->name; ?>
                    <span>(<?php echo $cat->count; ?>)</span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</aside>
