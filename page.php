<?php get_header(); ?>

<main role="main">
    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>">
        <?php
                    if ( is_front_page() ) :
                        get_template_part('templates/front-page-banner');
                    else :
                        get_template_part('templates/interior-banner');
                    endif;
                ?>
        <?php the_content(); ?>
    </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile;?>
    <?php endif; ?>
</main>

<?php if (get_the_ID() === 1101) : ?>
<script defer>
(function($) {
    var checkbox = $('.check'),
        submit = $('input[type="submit"]')

    submit.on('click', function() {
        $(checkbox).addClass('checked');
    });
})(jQuery);
</script>
<?php endif; ?>

<?php get_footer(); ?>