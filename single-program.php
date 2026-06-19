<?php get_header(); ?>

<div class="page-header">
    <div class="container">
        <?php alk_breadcrumb(); ?>
        <h1><?php the_title(); ?></h1>
    </div>
</div>

<div class="content-area page-content-full">
    <div class="container">
        <main class="main-content" style="max-width:800px;margin:0 auto;">
            <?php while (have_posts()) : the_post(); ?>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="single-post-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                <div class="single-post-body">
                    <?php the_content(); ?>
                    <?php if (function_exists('get_field')) : ?>
                        <?php $schedule = get_field('program_schedule'); if ($schedule) : ?>
                            <p style="margin-top:24px;color:var(--color-gold);font-weight:600;">&#128197; <?php echo esc_html($schedule); ?></p>
                        <?php endif; ?>
                        <?php $status = get_field('program_status'); if ($status) : ?>
                            <p style="margin-top:8px;"><span style="display:inline-block;padding:4px 12px;border-radius:20px;font-size:0.85rem;font-weight:600;background:<?php echo $status === 'aktif' ? '#d4edda' : '#f8d7da'; ?>;color:<?php echo $status === 'aktif' ? '#155724' : '#721c24'; ?>;"><?php echo $status === 'aktif' ? __('Aktif', 'alkautsar') : __('Nonaktif', 'alkautsar'); ?></span></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </main>
    </div>
</div>

<?php get_footer(); ?>
