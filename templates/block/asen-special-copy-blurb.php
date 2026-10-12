<?php
/**
 * Block Name: Asen - Special Copy Blurb
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$icon         = get_field( 'icon' );
$blurb        = get_field( 'blurb' );
$cta_options  = get_field( 'cta_options' );
$cta_links    = get_field( 'cta_links' );

// Tokens
$container_width = get_field( '__container_width' ) ?: 'lg';
$text_size       = get_field( '__font_size' ) ?: 'xl';

$cta_class_map = array( 'buttons' => 'button button-small', 'text' => 'text-link', 'icon' => 'text-icon-link' );
$cta_classes   = $cta_options && isset( $cta_class_map[ $cta_options ] ) ? $cta_class_map[ $cta_options ] : '';
$link_1        = $cta_links[0]['link_1'] ?? null;
$link_2        = $cta_links[0]['link_2'] ?? null;
$link_icon     = $cta_links[0]['link_icon'] ?? null;

$classes = array_filter( array(
    'asen-special-copy-blurb',
    'block-width-' . $container_width,
    'asen-special-copy-blurb--text-' . $text_size,
) );
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) ); ?>>
    <div class="inside">
        <?php if ( $icon ) : ?>
        <div class="icon-container"><?php echo $icon; ?></div>
        <?php endif; ?>

        <?php if ( $blurb ) : ?>
        <p class="blurb"><?php echo wp_kses_post( $blurb ); ?></p>
        <?php endif; ?>

        <?php if ( $cta_classes && ( $link_1 || $link_2 ) ) : ?>
        <div class="link-container">
            <?php foreach ( array( $link_1, $link_2 ) as $i => $link ) : if ( ! $link ) { continue; } ?>
            <a href="<?php echo esc_url( $link['url'] ); ?>" class="<?php echo esc_attr( $cta_classes ); ?>"
                target="<?php echo esc_attr( $link['target'] ?: '_self' ); ?>" title="<?php echo esc_attr( $link['title'] ); ?>">
                <?php echo esc_html( $link['title'] ); ?>
                <?php if ( 0 === $i && $link_icon && 'icon' === $cta_options ) { echo $link_icon; } ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
