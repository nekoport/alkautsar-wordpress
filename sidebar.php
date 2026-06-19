<aside class="widget-area">
    <div class="sidebar-widget donasi-widget-premium">
        <div class="donasi-widget-header">
            <div class="donasi-widget-icon">&#x1F932;</div>
            <h3><?php _e('Dukung Masjid', 'alkautsar'); ?></h3>
            <p><?php _e('Setiap donasi Anda adalah amal jariyah yang mengalir pahalanya', 'alkautsar'); ?></p>
        </div>

        <div class="donasi-rekening-premium">
            <div class="donasi-label-kecil"><?php _e('Salurkan Donasi Via', 'alkautsar'); ?></div>
            <?php
            $bank = get_theme_mod('alk_bank_name') ?: 'Bank Muamalat';
            $rek  = get_theme_mod('alk_rekening') ?: '3010 235 692 (147)';
            $an   = get_theme_mod('alk_atas_nama') ?: 'Masjid Al-Kautsar Green Jagakarsa';
            ?>
            <div class="donasi-bank-row">
                <span class="donasi-bank-icon">&#x1F3E6;</span>
                <span class="donasi-bank-text"><?php echo esc_html($bank); ?></span>
            </div>
            <div class="donasi-rek-number"><?php echo esc_html($rek); ?></div>
            <div class="donasi-rek-an">a.n. <?php echo esc_html($an); ?></div>
        </div>

        <?php $qris = get_theme_mod('alk_qris_image', ''); ?>
        <?php if ($qris): ?>
        <div class="donasi-qris-premium">
            <div class="qris-divider-text">— <?php _e('atau scan QRIS', 'alkautsar'); ?> —</div>
            <img src="<?php echo esc_url($qris); ?>" alt="QRIS Masjid Al-Kautsar" class="qris-img-premium">
            <p class="qris-note"><?php _e('Berlaku untuk semua aplikasi pembayaran', 'alkautsar'); ?></p>
        </div>
        <?php endif; ?>

        <a href="<?php echo esc_url(home_url('/donasi')); ?>" class="btn-donasi-premium">&#x1F49D; <?php _e('Donasi Sekarang', 'alkautsar'); ?></a>

        <div class="donasi-footer-note">
            <span>&#x1F512;</span>
            <small>Donasi tercatat &amp; transparan</small>
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
