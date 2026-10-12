<?php get_header(); ?>

<main role="main">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>">
                <?php the_title(); ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read more&hellip;</a>
            </article><!-- #post-<?php the_ID(); ?> -->
            
        <?php endwhile;?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
