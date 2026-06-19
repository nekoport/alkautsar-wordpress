<?php
/**
 * Template Name: Halaman Donasi
 */

get_header(); ?>

<div class="page-header">
    <div class="container">
        <?php alk_breadcrumb(); ?>
        <h1><?php the_title(); ?></h1>
        <p><?php _e('Dukung program dan kegiatan Masjid Al-Kautsar', 'alkautsar'); ?></p>
    </div>
</div>

<div class="content-area page-content-full">
    <div class="container">
        <main class="main-content">
            <?php while (have_posts()) : the_post(); ?>
                <div class="single-post-body">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; ?>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;margin-top:48px;">
                <div style="background:var(--color-card);border-radius:var(--radius);padding:40px;box-shadow:var(--shadow);">
                    <h3 style="font-family:var(--font-primary);margin-bottom:24px;">&#128179; <?php _e('Transfer Bank', 'alkautsar'); ?></h3>
                    <div style="display:grid;gap:20px;">
                        <div style="padding:20px;background:var(--color-bg-alt);border-radius:var(--radius-sm);border-left:4px solid var(--color-gold);">
                            <div style="font-size:0.85rem;color:var(--color-text-light);margin-bottom:4px;"><?php _e('Bank Syariah Indonesia (BSI)', 'alkautsar'); ?></div>
                            <div style="font-size:1.5rem;font-weight:700;color:var(--color-gold);font-family:var(--font-heading);" id="alkBsiAccount"><?php echo esc_html(get_theme_mod('alk_bsi_account', '7112345678')); ?></div>
                            <div style="font-size:0.9rem;color:var(--color-text);margin-top:4px;"><?php _e('a.n. Masjid Al-Kautsar', 'alkautsar'); ?></div>
                        </div>
                        <div style="padding:20px;background:var(--color-bg-alt);border-radius:var(--radius-sm);border-left:4px solid var(--color-gold);">
                            <div style="font-size:0.85rem;color:var(--color-text-light);margin-bottom:4px;"><?php _e('Bank Mandiri', 'alkautsar'); ?></div>
                            <div style="font-size:1.5rem;font-weight:700;color:var(--color-gold);font-family:var(--font-heading);" id="alkMandiriAccount"><?php echo esc_html(get_theme_mod('alk_mandiri_account', '1234567890')); ?></div>
                            <div style="font-size:0.9rem;color:var(--color-text);margin-top:4px;"><?php _e('a.n. Masjid Al-Kautsar', 'alkautsar'); ?></div>
                        </div>
                    </div>
                    <button class="btn btn-primary" style="margin-top:24px;width:100%;" onclick="alert('Silakan transfer ke rekening di atas. Konfirmasi via WhatsApp.')"><?php _e('Konfirmasi Donasi', 'alkautsar'); ?></button>
                </div>

                <div style="background:var(--color-card);border-radius:var(--radius);padding:40px;box-shadow:var(--shadow);text-align:center;">
                    <h3 style="font-family:var(--font-primary);margin-bottom:24px;">&#128247; <?php _e('Scan QRIS', 'alkautsar'); ?></h3>
                    <div style="width:240px;height:240px;margin:0 auto 24px;background:var(--color-bg-alt);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;border:2px dashed var(--color-border);">
                        <div style="text-align:center;color:var(--color-silver-medium);">
                            <div style="font-size:3rem;margin-bottom:8px;">&#128247;</div>
                            <div style="font-size:0.85rem;"><?php _e('QRIS Placeholder', 'alkautsar'); ?></div>
                        </div>
                    </div>
                    <p style="font-size:0.9rem;color:var(--color-text-light);"><?php _e('Scan QRIS di atas untuk donasi via GoPay, OVO, DANA, LinkAja, dan lainnya.', 'alkautsar'); ?></p>
                </div>
            </div>
        </main>
    </div>
</div>

<?php get_footer(); ?>
