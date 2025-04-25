<?php
    get_header(); 
    $primary_category = asen_get_primary_category_meta( get_the_ID() );
?>

<main role="main">
    <header class="blog-banner">
        <div class="banner-image">
            <?php if (get_field('banner_image')) : ?>
                <?php 
                $image = get_field('banner_image');
                $size = 'full'; // (thumbnail, medium, large, full or custom size)
                if( $image ) {
                    echo wp_get_attachment_image( $image, $size );
                } ?>
            <?php else : ?>
                Add banner image to post!
            <?php endif; ?>

        </div>
    </header>
    <div class="inside">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>

            <?php if ( function_exists('yoast_breadcrumb') ) : ?>
                <div class="asen-blog-breadcrumbs">
                    <?php yoast_breadcrumb( '<p id="breadcrumbs">','</p>' ); ?> <?php echo get_the_date(); ?>
                </div>
            <?php endif; ?>

            <article class="blog-post" id="post-<?php the_ID(); ?>">
                <div class="inside">
                    <h1 class="title">
                        <?php the_title(); ?>
                    </h1>

                    <?php the_content(); ?>

                    <div class="share-container">
                        <div class="divider-line"></div>
                        <div class="content">
                            <p>Share this post:</p>
                            <?php get_template_part('templates/social/share'); ?>
                        </div>
                    </div>
                </div>
            </article><!-- #post-<?php the_ID(); ?> -->
            
        <?php endwhile;?>
    <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>