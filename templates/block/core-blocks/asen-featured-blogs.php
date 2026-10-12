<?php
/**
 * Block Name: Asen - Featured Blogs
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$handpicked      = array_filter( (array) get_field( 'handpicked_posts' ) );
$show_cta        = ! get_field( 'hide_cta_tile' ); // Inverted so blocks saved before this field existed keep the tile.
$container_width = get_field( '__container_width' ) ?: 'xxl';
$heading_size    = get_field( '__heading_size' ) ?: 'h6';

// Hand-picked falls back to recent when nothing is selected.
$posts = 'handpicked' === get_field( 'post_source' ) && $handpicked
    ? array_slice( $handpicked, 0, 3 )
    : get_posts( array( 'post_type' => 'post', 'numberposts' => 3 ) );

$classes = array( 'asen-featured-blogs', 'block-width-' . $container_width, 'has-item-heading-' . $heading_size );
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) ); ?>>
    <div class="inside">
        <?php get_template_part( 'templates/block/partials/collection', null, array(
            'items'         => $posts,
            'item_template' => 'templates/block/partials/post-item',
            'columns'       => $show_cta ? 4 : 3,
            'lead'          => $show_cta ? array(
                'template' => 'templates/block/partials/blog-cta-item',
                'args'     => array(
                    'heading'  => get_field( 'blog_archive_cta_heading' ),
                    'image_id' => get_post_thumbnail_id( $post_id ?? get_the_ID() ),
                ),
            ) : null,
        ) ); ?>
    </div>
</section>
