<?php
/**
 * Testimonial for the Testimonials block (templates/block/partials/collection.php).
 */

$item    = $args['post'];
$quote   = get_field( 'testimonial_quote', $item->ID );
$author  = get_field( 'testimonial_author', $item->ID );
$company = get_field( 'testimonial_company', $item->ID );
$image   = get_field( 'testimonial_image', $item->ID );
?>
<figure class="testimonial-item">
    <?php if ( $image ) : ?>
    <div class="item-media"><?php echo wp_get_attachment_image( $image, 'medium' ); ?></div>
    <?php endif; ?>
    <?php if ( $quote ) : ?>
    <blockquote class="item-copy quote">
        <p><?php echo wp_kses_post( $quote ); ?></p>
    </blockquote>
    <?php endif; ?>
    <?php if ( $author || $company ) : ?>
    <figcaption class="item-meta">
        <?php if ( $author ) : ?><span class="name"><?php echo esc_html( $author ); ?></span><?php endif; ?><?php echo $author && $company ? ', ' : ''; ?><?php if ( $company ) : ?><span class="company"><?php echo esc_html( $company ); ?></span><?php endif; ?>
    </figcaption>
    <?php endif; ?>
</figure>
