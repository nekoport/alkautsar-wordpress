<?php get_header(); ?>

<div class="page-header">
    <div class="container">
        <h1 style="font-size:6rem;color:var(--color-gold);margin-bottom:0;">404</h1>
        <h1><?php _e('Halaman Tidak Ditemukan', 'alkautsar'); ?></h1>
        <p><?php _e('Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.', 'alkautsar'); ?></p>
        <div style="margin-top:24px;">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary"><?php _e('Kembali ke Beranda', 'alkautsar'); ?></a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
