<?php get_header();

$banner_classes = '';
$banner_styles = '';

?>

<main role="main">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article class="product-post" id="post-<?php the_ID(); ?>">
                <div class="inside">
                    <div class="left">
                        <?php echo wp_get_attachment_image( get_field('product_image'), 'large' ); ?>
                        
                    </div>
                    <div class="right">
                        <header>
                            <h1><?php the_title(); ?></h1>
                            <p><?php the_field('product_price'); ?></p>
                        </header>
                        <section>
                            <?php the_field('product_description'); ?>
                            <div class="text-small">
                                <?php the_field('product_notes'); ?>
                            </div>
                            <?php if ( get_field('pdf_download') && get_field('pdf_download_text') ) : ?>
                                <a 
                                    class="button"
                                    href="<?php the_field('pdf_download'); ?>"
                                    title="<?php the_field('pdf_download_text'); ?>"
                                    target="_blank"
                                >
                                    <?php the_field('pdf_download_text'); ?>
                                </a>
                            <?php endif; ?>
                        </section>
                    </div>
                </div>
            </article><!-- #post-<?php the_ID(); ?> -->
            <?php get_template_part('templates/bottom-form'); ?>
        <?php endwhile;?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
