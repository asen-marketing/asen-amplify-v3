<?php /* Template Name: Blank Page */

get_header();

?>

<main role="main">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>">
                <?php the_content(); ?>
            </article><!-- #post-<?php the_ID(); ?> -->

        <?php endwhile;?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
