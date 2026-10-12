<?php
/**
 * Block Name: Asen - Testimonials
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$carousel        = get_field( 'use_carousel' );
$columns         = get_field( 'number_of_columns' ) ?: ( $carousel ? 1 : 3 );
$nav             = get_field( 'nav_options' ) ?: 'selectors';
$container_width = get_field( '__container_width' ) ?: 'lg';
$text_size       = get_field( '__font_size' ) ?: 'md';

// One testimonial at a time crossfades; several per view slide.
$splide = array(
    'arrows'     => in_array( $nav, array( 'arrows', 'both' ), true ),
    'pagination' => in_array( $nav, array( 'selectors', 'both' ), true ),
);
if ( 1 === (int) $columns ) {
    $splide += array( 'type' => 'fade', 'rewind' => true );
}

$classes = array( 'asen-testimonials', 'block-width-' . $container_width, 'asen-testimonials--text-' . $text_size );
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) ); ?>>
    <div class="inside">
        <?php get_template_part( 'templates/block/partials/collection', null, array(
            'items'         => get_field( 'testimonials' ),
            'item_template' => 'templates/block/partials/testimonial-item',
            'layout'        => $carousel ? 'carousel' : 'grid',
            'columns'       => $columns,
            'label'         => 'Testimonials',
            'splide'        => $splide,
        ) ); ?>
    </div>
</section>
