<?php get_header(); ?>

<div class="page-header">
    <div class="container">
        <h1><?php _e('Berita', 'alkautsar'); ?></h1>
        <p><?php _e('Informasi dan kegiatan terbaru Masjid Al-Kautsar', 'alkautsar'); ?></p>
    </div>
</div>

<div class="content-area">
    <div class="container">
        <main class="main-content">
            <?php if (have_posts()) : ?>
                <div class="posts-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article <?php post_class('post-card'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium_large'); ?></a>
                                </div>
                            <?php else : ?>
                                <div class="post-thumbnail no-image">
                                    <a href="<?php the_permalink(); ?>"><div class="post-placeholder">&#x1F4F0;</div></a>
                                </div>
                            <?php endif; ?>
                            <div class="post-card-content">
                                <div class="post-meta">
                                    <span class="post-category"><?php $cats = get_the_category(); if ($cats) echo esc_html($cats[0]->name); ?></span>
                                    <span class="post-date"><?php echo alk_tanggal_indo(); ?></span>
                                </div>
                                <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <p class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                                <a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Baca Selengkapnya', 'alkautsar'); ?> &rarr;</a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                <div class="pagination-wrapper">
                    <?php
                    $total_pages = $wp_query->max_num_pages;
                    if ($total_pages > 1):
                        $current_page = max(1, get_query_var('paged'));
                    ?>
                    <nav class="pagination">
                        <?php if ($current_page > 1): ?>
                        <a href="<?php echo esc_url(get_pagenum_link($current_page - 1)); ?>" class="page-btn prev">&larr; <?php _e('Sebelumnya', 'alkautsar'); ?></a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="<?php echo esc_url(get_pagenum_link($i)); ?>" class="page-btn <?php echo ($i === $current_page) ? 'active' : ''; ?>"><?php echo absint($i); ?></a>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages): ?>
                        <a href="<?php echo esc_url(get_pagenum_link($current_page + 1)); ?>" class="page-btn next"><?php _e('Selanjutnya', 'alkautsar'); ?> &rarr;</a>
                        <?php endif; ?>
                    </nav>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <p><?php _e('Belum ada berita.', 'alkautsar'); ?></p>
            <?php endif; ?>
        </main>
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
