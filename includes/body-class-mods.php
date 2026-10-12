<?php

function asen_body_class_mods( $classes ) {
    if (
        class_exists( 'woocommerce' ) &&
        is_shop()
    ) {
        $classes[] = 'asen-is-woo-archive';
    }

    // Site Options toggles the SCSS keys off; has-page-banner lets content start flush under the banner (values are CSS variables; see asen_option_css()).
    if ( class_exists( 'ACF' ) ) {
        $page_id = is_singular() ? get_queried_object_id() : 0;

        if ( 'static' === get_field( 'site_header_position', 'option' ) ) {
            $classes[] = 'has-static-header';
        }
        if ( get_field( 'overlapping_header', 'option' ) && ! get_field( 'disable_overlapping_header', $page_id ) ) {
            $classes[] = 'has-overlapping-header';
        }
        if ( get_field( 'sticky_hamburger', 'option' ) ) {
            $classes[] = 'has-sticky-hamburger';
        }
        if ( get_field( 'off_canvas_close_position', 'option' ) ) {
            $classes[] = 'off-canvas-close-right';
        }
        if ( ( $page_id && has_block( 'acf/asen-banner', $page_id ) ) || is_page_template( 'custom-contact.php' ) ) {
            $classes[] = 'has-page-banner';
        }
    }

    return $classes;
}
add_filter( 'body_class', 'asen_body_class_mods' );
