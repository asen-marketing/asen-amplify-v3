<?php
/**
 * Block Name: Asen - Products Showcase
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$layout          = get_field( 'use_carousel' ) ? 'carousel' : ( get_field( 'alternating_grid' ) ? 'alternating' : 'grid' );
$heading         = get_field( 'block_heading' );
$subheading      = get_field( 'block_subheading' );
$container_width = get_field( '__container_width' ) ?: 'xl';
$heading_size    = get_field( '__heading_size' ) ?: 'h6';

$classes = array( 'asen-products-showcase', 'block-width-' . $container_width, 'has-item-heading-' . $heading_size );
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
            'items'         => get_field( 'products' ),
            'item_template' => 'templates/block/partials/product-item',
            'layout'        => $layout,
            'columns'       => get_field( 'number_of_columns' ) ?: 3,
            'label'         => $heading ?: 'Products',
        ) ); ?>
    </div>
</section>
