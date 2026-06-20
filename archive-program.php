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
            <div class="program-grid">
                <?php while (have_posts()) : the_post();
                    $schedule = get_field('program_schedule');
                    $status   = get_field('program_status');
                    $status_label = ($status === 'aktif') ? __('Aktif', 'alkautsar') : __('Nonaktif', 'alkautsar');
                    $status_class = ($status === 'aktif') ? 'status-aktif' : 'status-nonaktif';
                ?>
                <article class="program-card">
                    <?php if (has_post_thumbnail()): ?>
                    <div class="program-thumb">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium_large'); ?></a>
                        <span class="program-status-badge <?php echo $status_class; ?>"><?php echo $status_label; ?></span>
                    </div>
                    <?php else: ?>
                    <div class="program-thumb no-image">
                        <a href="<?php the_permalink(); ?>">
                            <div class="program-icon-wrap"><span class="program-emoji">&#x1F54C;</span></div>
                        </a>
                        <span class="program-status-badge <?php echo $status_class; ?>"><?php echo $status_label; ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="program-card-body">
                        <h3 class="program-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <?php if ($schedule): ?>
                        <div class="program-schedule">
                            <span>&#x1F550;</span>
                            <span><?php echo esc_html($schedule); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (has_excerpt()): ?>
                        <p class="program-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>" class="program-link"><?php _e('Lihat Detail', 'alkautsar'); ?> &rarr;</a>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>
            <div class="pagination">
                <?php echo paginate_links(array('prev_text' => '&laquo;', 'next_text' => '&raquo;')); ?>
            </div>
            <?php else : ?>
            <div class="no-program">
                <span>&#x1F54C;</span>
                <p><?php _e('Belum ada program yang tersedia.', 'alkautsar'); ?></p>
            </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php get_footer(); ?>
