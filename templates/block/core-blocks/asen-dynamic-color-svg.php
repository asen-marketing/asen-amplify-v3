<?php
/**
 * Block Name: Asen - Dynamic Color SVG
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$image     = get_field( 'svg_image' );
$max_width = (int) get_field( 'svg_max_width' );
$recolor   = ! empty( $block['textColor'] ) || ! empty( $block['style']['color']['text'] );
$svg       = $image ? asen_inline_svg( is_numeric( $image ) ? (int) $image : attachment_url_to_postid( (string) $image ), $recolor ) : '';
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'asen-dynamic-color-svg' ) ); ?>>
    <?php if ( $svg ) : ?>
    <span class="svg"<?php echo $max_width ? ' style="max-width: ' . $max_width . 'px;"' : ''; ?>><?php echo $svg; ?></span>
    <?php elseif ( is_admin() ) : ?>
    <p>Select an SVG file.</p>
    <?php endif; ?>
</div>
