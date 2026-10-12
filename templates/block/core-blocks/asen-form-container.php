<?php
/**
 * Block Name: Asen - Form Container
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$heading          = get_field( 'heading' );
$subheading       = get_field( 'subheading' );
$shortcode        = get_field( 'gravity_forms_shortcode' );
$button_alignment = get_field( 'button_alignment' ) ?: 'center';
$container_width  = get_field( '__container_width' ) ?: 'md';

$classes = array( 'asen-form-container', 'block-width-' . $container_width, 'button-align-' . $button_alignment );
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
        <div class="form-container">
            <?php if ( $shortcode ) {
                echo do_shortcode( $shortcode );
            } elseif ( is_admin() ) {
                echo '<p>Add a Gravity Forms shortcode.</p>';
            } ?>
        </div>
    </div>
</section>
