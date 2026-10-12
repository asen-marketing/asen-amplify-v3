<?php
/**
 * @file Menu functions
 */

function asen_theme_menus() {
    register_nav_menus([
        'primary-menu' => 'Primary Menu',
        'off-canvas-menu' => 'Off Canvas Menu',
        'off-canvas-bottom-menu' => 'Off Canvas Bottom Menu',
        'footer-menu' => 'Footer Menu',
        'footer-menu-2' => 'Footer Menu Column 2',
        'footer-menu-3' => 'Footer Menu Column 3'
    ]);
}
add_action( 'after_setup_theme', 'asen_theme_menus' );

function asen_auto_nav_title_attribute( $atts, $item, $args ) {
    if ( empty($item->attr_title) ) {
        $atts['title'] = esc_attr( 'Navigate to ' . wp_strip_all_tags($item->title) );
		return $atts;
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'asen_auto_nav_title_attribute', 10, 3 );