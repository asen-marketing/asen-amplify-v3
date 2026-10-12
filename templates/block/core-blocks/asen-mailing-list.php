<?php
/**
 * Block Name: Asen - Mailing List
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$icon             = get_field( 'icon_code' );
$heading          = get_field( 'heading' );
$subheading       = get_field( 'subheading' );
$button_alignment = get_field( 'button_alignment' ) ?: 'stacked';
$background       = get_field( 'background_options' ) ?: 'none';
$background_image = get_field( 'background_image' );
$form_id          = get_field( 'mailing_list_form' ) ?: get_field( 'site_footer_mailing_list_form', 'option' );
$container_width  = get_field( '__container_width' ) ?: 'md';

$classes = array( 'asen-mailing-list', 'block-width-' . $container_width, 'background-' . $background );
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) ); ?>>
    <div class="inside">
        <?php if ( $icon || $heading || $subheading ) : ?>
        <div class="heading-container">
            <?php if ( $icon ) { echo $icon; } ?>
            <?php if ( $heading ) : ?>
            <h2><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>
            <?php if ( $subheading ) : ?>
            <p class="subheading"><?php echo esc_html( $subheading ); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="form-container <?php echo esc_attr( $button_alignment ); ?>">
            <?php if ( $form_id ) {
                echo do_shortcode( '[gravityform id="' . intval( $form_id ) . '" title="false" description="false" ajax="true"]' );
            } elseif ( is_admin() ) {
                echo '<p>Pick a form, or set the mailing list form in Footer Options.</p>';
            } ?>
        </div>
    </div>
    <?php if ( $background_image && in_array( $background, array( 'image', 'pattern' ), true ) ) : ?>
    <div class="background-container"<?php echo 'pattern' === $background ? ' style="background-image: url(' . esc_url( wp_get_attachment_image_url( $background_image, 'full' ) ) . ');"' : ''; ?>>
        <?php if ( 'image' === $background ) { echo wp_get_attachment_image( $background_image, 'full' ); } ?>
    </div>
    <?php endif; ?>
</section>
