<?php get_header(); ?>

<div class="page-header">
    <div class="container">
        <?php alk_breadcrumb(); ?>
        <h1><?php printf(__('Hasil Pencarian: %s', 'alkautsar'), esc_html(get_search_query())); ?></h1>
        <p><?php global $wp_query; printf(__('Ditemukan %s hasil', 'alkautsar'), $wp_query->found_posts); ?></p>
    </div>
</div>

<div class="content-area">
    <div class="container">
        <main class="main-content">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article <?php post_class('post-card'); ?>>
                        <div class="post-card-inner">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-card-image">
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                                </div>
                            <?php endif; ?>
                            <div class="post-card-body">
                                <div class="post-card-meta"><?php echo alk_tanggal_indo(); ?></div>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="post-card-excerpt"><?php the_excerpt(); ?></div>
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline"><?php _e('Baca Selengkapnya', 'alkautsar'); ?></a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
                <div class="pagination">
                    <?php echo paginate_links(array('prev_text' => '&laquo;', 'next_text' => '&raquo;')); ?>
                </div>
            <?php else : ?>
                <p><?php _e('Maaf, tidak ada hasil yang ditemukan. Silakan coba kata kunci lain.', 'alkautsar'); ?></p>
            <?php endif; ?>
        </main>
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
