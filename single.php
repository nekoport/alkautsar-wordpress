<?php get_header(); ?>

<div class="page-header">
    <div class="container">
        <?php alk_breadcrumb(); ?>
        <h1><?php the_title(); ?></h1>
    </div>
</div>

<div class="content-area">
    <div class="container">
        <main class="main-content">
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class('single-post-content'); ?>>
                    <div class="single-post-header">
                        <div class="single-post-meta">
                            <span>&#128340; <?php echo alk_tanggal_indo(); ?></span>
                            <span>&#128101; <?php _e('Oleh', 'alkautsar'); ?> <?php the_author(); ?></span>
                            <?php if (has_category()) : ?>
                                <span>&#128278; <?php the_category(', '); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="single-post-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="single-post-body">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </main>
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
