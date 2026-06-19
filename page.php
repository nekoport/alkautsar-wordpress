<?php get_header(); ?>

<div class="page-header">
    <div class="container">
        <?php alk_breadcrumb(); ?>
        <h1><?php the_title(); ?></h1>
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
        </main>
    </div>
</div>

<?php get_footer(); ?>
