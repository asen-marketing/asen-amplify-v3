<?php
/**
 * Block Name: Asen - Intro Block
 *
 * Reference implementation: padding, margin, and colors are native block supports (theme.json presets)
 * output by get_block_wrapper_attributes(); the ACF token selects cover what core has no preset for.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

// Fields
$icon         = get_field( 'icon' );
$heading      = get_field( 'heading' );
$subheading   = get_field( 'subheading' );
$blurb        = get_field( 'blurb' );
$align_center = get_field( 'align_center' );
$cta_options  = get_field( 'cta_options' );
$cta_links    = get_field( 'cta_links' );

$cta_class_map = array( 'buttons' => 'button button-small', 'text' => 'text-link', 'icon' => 'text-icon-link' );
$cta_classes   = $cta_options && isset( $cta_class_map[ $cta_options ] ) ? $cta_class_map[ $cta_options ] : '';
$cta_link_1    = $cta_links[0]['link_1'] ?? null;
$cta_link_2    = $cta_links[0]['link_2'] ?? null;
$link_icon     = $cta_links[0]['link_icon'] ?? null;

// Tokens
$container_width = get_field( '__container_width' );
$text_spacing    = get_field( 'text_spacing' )['__gap'] ?? null;
$text_size       = get_field( '__font_size' );

$classes = array_filter( array(
    'asen-intro-block',
    $align_center ? 'align-center' : '',
    $container_width ? 'block-width-' . $container_width : '',
    $text_spacing ? 'asen-intro-block--text-spacing-' . $text_spacing : '',
    $text_size ? 'asen-intro-block--text-' . $text_size : '',
) );
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) ); ?>>
    <div class="inside">
        <?php if ( $icon ) : ?>
        <div class="icon-container">
            <?php echo $icon; ?>
        </div>
        <?php endif; ?>

        <?php if ( $heading ) : ?>
        <h2 class="heading"><?php echo esc_html( $heading ); ?></h2>
        <?php endif; ?>

        <?php if ( $subheading ) : ?>
        <p class="subheading"><?php echo esc_html( $subheading ); ?></p>
        <?php endif; ?>

        <?php if ( $blurb ) : ?>
        <div class="blurb-container">
            <p class="blurb"><?php echo esc_html( $blurb ); ?></p>
        </div>
        <?php endif; ?>

        <?php if ( $cta_link_1 || $cta_link_2 ) : ?>
        <div class="link-container">
            <?php foreach ( array( $cta_link_1, $cta_link_2 ) as $i => $link ) : if ( ! $link ) { continue; } ?>
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
