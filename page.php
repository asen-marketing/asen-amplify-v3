<?php get_header(); ?>

<main role="main">
    <?php while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>">
        <?php the_content(); ?>
    </article><!-- #post-<?php the_ID(); ?> -->
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
