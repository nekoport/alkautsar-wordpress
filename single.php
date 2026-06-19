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
                    <div class="article-meta">
                        <span class="meta-item">&#128340; <?php echo alk_tanggal_indo(); ?></span>
                        <span class="meta-item">&#128101; <?php _e('Oleh', 'alkautsar'); ?> <?php the_author(); ?></span>
                        <?php
                        $content = get_the_content();
                        $word_count = str_word_count(strip_tags($content));
                        $reading_time = max(1, ceil($word_count / 200));
                        ?>
                        <span class="meta-item">&#x1F4D6; <?php echo $reading_time; ?> <?php _e('menit baca', 'alkautsar'); ?></span>
                    </div>

                    <?php
                    $cats = get_the_category();
                    if ($cats):
                    ?>
                    <div class="article-category-banner">
                        <?php foreach ($cats as $cat): ?>
                        <a href="<?php echo get_category_link($cat->term_id); ?>" class="article-cat-badge"><?php echo $cat->name; ?></a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="single-post-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="article-content">
                        <?php the_content(); ?>
                    </div>

                    <div class="article-navigation">
                        <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>" class="btn-back">
                            &larr; <?php _e('Kembali ke Berita', 'alkautsar'); ?>
                        </a>
                        <div class="post-nav-links">
                            <?php
                            $prev = get_previous_post();
                            $next = get_next_post();
                            ?>
                            <?php if ($prev) : ?>
                            <a href="<?php echo get_permalink($prev); ?>" class="post-nav prev">
                                &larr; <?php echo get_the_title($prev); ?>
                            </a>
                            <?php endif; ?>
                            <?php if ($next) : ?>
                            <a href="<?php echo get_permalink($next); ?>" class="post-nav next">
                                <?php echo get_the_title($next); ?> &rarr;
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php
                    $related = new WP_Query(array(
                        'post__not_in'   => array(get_the_ID()),
                        'posts_per_page' => 3,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ));
                    if ($related->have_posts()):
                    ?>
                    <div class="related-posts">
                        <h3 class="related-title">&#x1F4F0; <?php _e('Artikel Terkait', 'alkautsar'); ?></h3>
                        <div class="related-grid">
                            <?php while ($related->have_posts()): $related->the_post(); ?>
                            <article class="related-card">
                                <?php if (has_post_thumbnail()): ?>
                                <div class="related-thumb">
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                                </div>
                                <?php else: ?>
                                <div class="related-thumb no-img">
                                    <a href="<?php the_permalink(); ?>"><span>&#x1F4F0;</span></a>
                                </div>
                                <?php endif; ?>
                                <div class="related-info">
                                    <span class="related-date"><?php echo alk_tanggal_indo(); ?></span>
                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                </div>
                            </article>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </article>
            <?php endwhile; ?>
        </main>
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
