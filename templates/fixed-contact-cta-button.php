<?php
// Floating contact button (Site Options → Enable Floating CTA). Colors are CSS variables; js/floating-cta.js hides it over the footer.
$text = get_field( 'cta_link_text', 'option' );
$icon = get_field( 'cta_icon', 'option' );
?>
<a class="fixed-contact-cta-button" title="<?php echo esc_attr( wp_strip_all_tags( $text ) ); ?>" href="<?php echo esc_url( get_field( 'cta_link_url', 'option' ) ); ?>">
    <span class="hover-intent-layer"><?php echo wp_kses_post( $text ); ?></span>
    <span class="icon-container"><?php echo $icon ? $icon : '<i class="fa-solid fa-square-plus"></i>'; ?></span>
</a>
