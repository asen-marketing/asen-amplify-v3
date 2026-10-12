<?php

function asen_register_woocommerce_sidebar() {
	if ( class_exists( 'woocommerce' ) ) {
		register_sidebar(
			array(
				'name' => __( 'Woo Sidebar', 'amplify' ),
				'id' => 'woo-sidebar',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
        		'after_widget'  => "</div>\n",
			)
		);
	}
}
add_action( 'widgets_init', 'asen_register_woocommerce_sidebar' );

function asen_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'asen_add_woocommerce_support' );

function asen_disable_woo_commerce_sidebar() {
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10); 
}
add_action('init', 'asen_disable_woo_commerce_sidebar');

function asen_disable_woo_archive_buttons() {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
}
add_action( 'woocommerce_after_shop_loop_item', 'asen_disable_woo_archive_buttons', 1);

function asen_wc_custom_price_string( $subscription_string ) {
	global $product;
	if ( get_field('asen_custom_price_copy', $product->id) ) {
		$new_string = get_field('asen_custom_price_copy', $product->id);
	} else {
		$new_string = $subscription_string;
	}
    return $new_string;
}
add_filter( 'woocommerce_get_price_html', 'asen_wc_custom_price_string' );
add_filter( 'woocommerce_subscriptions_product_price_string', 'asen_wc_custom_price_string' );
add_filter( 'woocommerce_subscription_price_string', 'asen_wc_custom_price_string' );

function asen_wc_remove_cancel_button( $actions, $subscription_id ) {
	unset( $actions['cancel'] );
	return $actions;
}
add_filter( 'wcs_view_subscription_actions', 'asen_wc_remove_cancel_button', 100, 2);