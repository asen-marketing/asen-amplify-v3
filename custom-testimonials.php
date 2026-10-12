<?php /* Template Name: Testimonials Page */
get_header();

?>

<main role="main">
    <div class="asen-blockquote-page">
        <?php if ( get_field('quotes') ) : ?>
            <div class="inside">
                <?php while ( have_rows('quotes') ) : the_row(); ?>
                    <blockquote class="<?php the_sub_field('text_size'); ?>">
                        <p>&ldquo;<?php the_sub_field('quote'); ?>&rdquo;</p>
                        <?php if ( get_sub_field('attribution') ) : ?>
                            <cite>&#8213; <?php the_sub_field('attribution'); ?></cite>
                        <?php endif; ?>
                    </blockquote>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p>Add some testimonials under Pages -> Testimonials!</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
