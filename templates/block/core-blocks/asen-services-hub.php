<?php
/**
 * Block Name: Asen - Services Hub
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$display         = get_field( 'display_options' ) ?: 'image';
$layout          = get_field( 'use_carousel' ) ? 'carousel' : ( get_field( 'alternating_grid' ) && 'image' === $display ? 'alternating' : 'grid' );
$heading         = get_field( 'services_heading' );
$subheading      = get_field( 'services_subheading' );
$container_width = get_field( '__container_width' ) ?: 'xl';
$heading_size    = get_field( '__heading_size' ) ?: 'h6';

// Links go to single service pages, which only exist on sites with upgraded features.
$link_style = get_field( 'tier_3', 'option' ) ? ( get_field( 'link_style' ) ?: 'none' ) : 'none';

$classes = array( 'asen-services-hub', 'block-width-' . $container_width, 'has-item-heading-' . $heading_size );
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) ); ?>>
    <div class="inside">
        <?php if ( $heading || $subheading ) : ?>
        <div class="heading-container">
            <?php if ( $heading ) : ?>
            <h2><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>
            <?php if ( $subheading ) : ?>
            <p class="subheading"><?php echo esc_html( $subheading ); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php get_template_part( 'templates/block/partials/collection', null, array(
            'items'         => get_field( 'services' ),
            'item_template' => 'templates/block/partials/service-item',
            'layout'        => $layout,
            'columns'       => get_field( 'number_of_columns' ) ?: 3,
            'label'         => $heading ?: 'Services',
            'item_args'     => array(
                'display'    => $display,
                'link_style' => $link_style,
                'link_text'  => get_field( 'link_text' ) ?: 'View Service',
                'link_icon'  => get_field( 'link_icon_code' ),
            ),
        ) ); ?>
    </div>
</section>
