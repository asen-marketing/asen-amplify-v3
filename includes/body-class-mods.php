<?php

function asen_body_class_mods( $classes ) {
    if (
        class_exists( 'woocommerce' ) &&
        is_shop()
    ) {
        $classes[] = 'asen-is-woo-archive';
    }
    return $classes;
}
add_filter( 'body_class', 'asen_body_class_mods' );