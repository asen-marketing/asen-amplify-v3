<?php
/**
 * Blog post card for Featured Blogs (templates/block/partials/collection.php).
 */

$post     = $args['post'];
$category = asen_get_primary_category_meta( $post->ID );
?>
<a class="post-item" href="<?php echo esc_url( get_permalink( $post ) ); ?>">
    <?php if ( has_post_thumbnail( $post ) ) : ?>
    <div class="item-media"><?php echo get_the_post_thumbnail( $post, 'large' ); ?></div>
    <?php endif; ?>
    <div class="item-copy">
        <p class="item-meta">
            <?php if ( ! empty( $category['title'] ) ) : ?><span class="category"><?php echo esc_html( $category['title'] ); ?></span> <span class="separator" aria-hidden="true">|</span> <?php endif; ?>
            <time datetime="<?php echo esc_attr( get_the_date( 'c', $post ) ); ?>"><?php echo esc_html( get_the_date( '', $post ) ); ?></time>
        </p>
        <h3 class="item-title"><?php echo esc_html( get_the_title( $post ) ); ?></h3>
    </div>
</a>
