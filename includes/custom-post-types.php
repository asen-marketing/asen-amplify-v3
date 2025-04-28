<?php

// CPTs moved into ACF dashboard

// function asen_amplify_cptui_register_cpts() {

// 	if ( class_exists('ACF') ) {

// 		/**
// 		 * Post Type: Services.
// 		 */

// 		$labels = [
// 			"name" => __( "Services", "amplify2020" ),
// 			"singular_name" => __( "Service", "amplify2020" ),
// 		];

// 		$args = [
// 			"label" => __( "Services", "amplify2020" ),
// 			"labels" => $labels,
// 			"description" => "Services offered clients.",
// 			"public" => true,
// 			"publicly_queryable" => true,
// 			"show_ui" => true,
// 			"show_in_rest" => true,
// 			"rest_base" => "",
// 			"rest_controller_class" => "WP_REST_Posts_Controller",
// 			"has_archive" => true,
// 			"show_in_menu" => true,
// 			"show_in_nav_menus" => true,
// 			"delete_with_user" => false,
// 			"exclude_from_search" => false,
// 			"capability_type" => "page",
// 			"map_meta_cap" => true,
// 			"hierarchical" => false,
// 			"rewrite" => [ "slug" => "services", "with_front" => false ],
// 			"query_var" => true,
// 			"menu_icon" => "dashicons-hammer",
// 			"supports" => [ "title", "editor", "thumbnail", "revisions" ],
// 		];

// 		if ( get_field('site_services_enabled', 'option') ) {
// 			register_post_type( "services", $args );
// 		}

// 		/**
// 		 * Post Type: Products.
// 		 */

// 		$labels = [
// 			"name" => __( "Products", "amplify2020" ),
// 			"singular_name" => __( "Product", "amplify2020" ),
// 		];

// 		$args = [
// 			"label" => __( "Products", "amplify2020" ),
// 			"labels" => $labels,
// 			"description" => "Products available for purchase.",
// 			"public" => true,
// 			"publicly_queryable" => true,
// 			"show_ui" => true,
// 			"show_in_rest" => true,
// 			"rest_base" => "",
// 			"rest_controller_class" => "WP_REST_Posts_Controller",
// 			"has_archive" => true,
// 			"show_in_menu" => true,
// 			"show_in_nav_menus" => true,
// 			"delete_with_user" => false,
// 			"exclude_from_search" => false,
// 			"capability_type" => "page",
// 			"map_meta_cap" => true,
// 			"hierarchical" => false,
// 			"rewrite" => [ "slug" => "products", "with_front" => false ],
// 			"query_var" => true,
// 			"menu_icon" => "dashicons-cart",
// 			"supports" => [ "title", "thumbnail", "revisions" ],
// 		];

// 		if ( get_field('site_products_enabled', 'option') ) {
// 			register_post_type( "products", $args );
// 		}

// 		/**
// 		 * Post Type: Team Members.
// 		 */

// 		$labels = [
// 			"name" => __( "Team", "amplify2020" ),
// 			"singular_name" => __( "Team Member", "amplify2020" ),
// 		];

// 		$args = [
// 			"label" => __( "Team Members", "amplify2020" ),
// 			"labels" => $labels,
// 			"description" => "",
// 			"public" => true,
// 			"publicly_queryable" => true,
// 			"show_ui" => true,
// 			"show_in_rest" => true,
// 			"rest_base" => "",
// 			"rest_controller_class" => "WP_REST_Posts_Controller",
// 			"has_archive" => true,
// 			"show_in_menu" => true,
// 			"show_in_nav_menus" => true,
// 			"delete_with_user" => false,
// 			"exclude_from_search" => false,
// 			"capability_type" => "page",
// 			"map_meta_cap" => true,
// 			"hierarchical" => false,
// 			"rewrite" => [ "slug" => "team", "with_front" => false ],
// 			"query_var" => true,
// 			"menu_icon" => "dashicons-groups",
// 			"supports" => [ "title", "thumbnail", "revisions" ],
// 		];

// 		if ( get_field('site_team_members_enabled', 'option') ) {
// 			register_post_type( "team", $args );
// 		}

// 	}
// }

// add_action( 'init', 'asen_amplify_cptui_register_cpts' );