<?php
/**
 * Service card for the Services Hub (templates/block/partials/collection.php).
 */

$post       = $args['post'];
$display    = $args['display'] ?? 'image';
$link_style = $args['link_style'] ?? 'none';
$image      = get_field( 'service_image', $post->ID );
$icon       = get_field( 'icon_code', $post->ID );
$blurb      = get_field( 'service_blurb', $post->ID );
?>
<article class="service-item">
    <?php if ( 'image' === $display && $image ) : ?>
    <div class="item-media"><?php echo wp_get_attachment_image( $image, 'large' ); ?></div>
    <?php elseif ( 'icon' === $display && $icon ) : ?>
    <div class="item-media is-icon"><?php echo $icon; ?></div>
    <?php endif; ?>
    <div class="item-copy">
        <h3 class="item-title"><?php echo esc_html( get_the_title( $post ) ); ?></h3>
        <?php if ( $blurb ) : ?>
        <p><?php echo wp_kses_post( $blurb ); ?></p>
        <?php endif; ?>
    </div>
    <?php if ( 'none' !== $link_style ) : ?>
    <a class="item-link<?php echo 'button' === $link_style ? ' button button-small' : ''; ?>" href="<?php echo esc_url( get_permalink( $post ) ); ?>">
        <?php echo esc_html( $args['link_text'] ?? 'View Service' ); ?><?php if ( 'icon' === $link_style && ! empty( $args['link_icon'] ) ) { echo $args['link_icon']; } ?>
    </a>
    <?php endif; ?>
</article>
