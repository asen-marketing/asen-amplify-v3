<?php
/**
 * @file Menu functions
 */

function asen_theme_menus() {
    register_nav_menus([
        'primary-menu' => 'Primary Menu',
        'off-canvas-menu' => 'Off Canvas Menu',
        'off-canvas-bottom-menu' => 'Off Canvas Bottom Menu',
        'footer-menu' => 'Footer Menu'
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

// Manipulate menu objects
function asen_modify_menu_items( $sorted_menu_items, $args ) {
    $menu_location = $args->theme_location;

    // Provide Home menu item a logo for split menus.
    // This is preferable to automatic placement in case an offset is intended.
    if ( $menu_location === 'primary-menu' && get_field('site_header_layout', 'option') == 2 ) {
        foreach ( $sorted_menu_items as $index => $item ) {
            if ( $item->title === 'Home' ) {
                ob_start();
                if (get_field('site_header_logo_image', 'option') ) {
                    echo wp_get_attachment_image(
                        get_field('site_header_logo_image', 'option'), 'large'
                    );
                } else {
                    echo "Add header logo!";
                }
                $item->title = ob_get_clean();
                if ( empty($item->attr_title) ) {
                    $item->attr_title = esc_attr( 'Navigate to ' . get_bloginfo('name', 'display') . ' home page' );
                }
                $item->classes[] = 'layout-2-logo';
            }
        }
    }

    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'asen_modify_menu_items', 10, 2 );