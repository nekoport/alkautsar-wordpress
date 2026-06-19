<?php get_header(); ?>

<div class="page-header">
    <div class="container">
        <?php alk_breadcrumb(); ?>
        <h1><?php the_archive_title(); ?></h1>
        <p><?php the_archive_description(); ?></p>
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
                <p><?php _e('Tidak ada konten.', 'alkautsar'); ?></p>
            <?php endif; ?>
        </main>
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
