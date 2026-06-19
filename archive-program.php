<?php get_header(); ?>

<div class="page-header">
    <div class="container">
        <?php alk_breadcrumb(); ?>
        <h1><?php _e('Program & Galeri', 'alkautsar'); ?></h1>
        <p><?php _e('Program dan kegiatan Masjid Al-Kautsar', 'alkautsar'); ?></p>
    </div>
</div>

<div class="content-area page-content-full">
    <div class="container">
        <main>
            <?php
            $cats = get_terms(array('taxonomy' => 'program_category', 'hide_empty' => false));
            if (!empty($cats)) : ?>
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:32px;justify-content:center;">
                    <a href="<?php echo get_post_type_archive_link('program'); ?>" class="btn btn-outline btn-sm"><?php _e('Semua', 'alkautsar'); ?></a>
                    <?php foreach ($cats as $cat) : ?>
                        <a href="<?php echo get_term_link($cat); ?>" class="btn btn-outline btn-sm"><?php echo $cat->name; ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (have_posts()) : ?>
                <div class="gallery-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php
                        $img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        if (!$img_url) $img_url = ALK_THEME_URI . '/assets/images/placeholder.svg';
                        ?>
                        <div class="gallery-item" onclick="openLightbox('<?php echo esc_url($img_url); ?>')">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                            <div class="gallery-item-overlay">
                                <span><?php the_title(); ?></span>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="pagination">
                    <?php echo paginate_links(array('prev_text' => '&laquo;', 'next_text' => '&raquo;')); ?>
                </div>
            <?php else : ?>
                <p style="text-align:center;color:var(--color-text-light);"><?php _e('Belum ada program.', 'alkautsar'); ?></p>
            <?php endif; ?>
        </main>
    </div>
</div>

<div class="lightbox" id="lightbox">
    <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
    <button class="lightbox-prev" onclick="prevLightbox()">&#8249;</button>
    <img id="lightboxImg" src="" alt="">
    <button class="lightbox-next" onclick="nextLightbox()">&#8250;</button>
</div>

<?php get_footer(); ?>
