<?php

function asen_backend_scripts_enqueue() {
	// Custom backend styles
    wp_enqueue_style( 'backend-styles', get_template_directory_uri() . '/includes/css/backend-styles.css', __FILE__ );}
add_action( 'admin_enqueue_scripts', 'asen_backend_scripts_enqueue' );

function asen_curate_menu_list() {
    $current_user = wp_get_current_user();
    $current_user_email_domain = explode('@', $current_user->user_email);
    $current_user_roles = $current_user->roles;
    remove_menu_page( 'edit-comments.php' );
    $acf = function_exists( 'get_field' );

    if ($acf && !get_field('site_blog_enabled', 'option')) {
        remove_menu_page( 'edit.php' );
    }
    if (
        $current_user_email_domain[1] != 'asenmarketing.com' || 
        in_array( 'administrator', $current_user_roles ) == false
    ) {
        remove_menu_page( 'kadence-blocks' );
    }
    if ($acf && !get_field('site_faqs_enabled', 'option')) {
        remove_menu_page( 'edit.php?post_type=faq' );
    }
        if ($acf && !get_field('site_products_enabled', 'option')) {
        remove_menu_page( 'edit.php?post_type=product' );
    }
    if ($acf && !get_field('site_services_enabled', 'option')) {
        remove_menu_page( 'edit.php?post_type=service' );
    }
        if ($acf && !get_field('site_team_members_enabled', 'option')) {
        remove_menu_page( 'edit.php?post_type=team' );
    }
        if ($acf && !get_field('site_testimonials_enabled', 'option')) {
        remove_menu_page( 'edit.php?post_type=testimonial' );
    }
}
add_action( 'admin_menu', 'asen_curate_menu_list' );

function asen_hide_editor()
{
    $post_id = 0;
    if (array_key_exists('post', $_GET)) {
        $post_id = $_GET['post'];
    } elseif (array_key_exists('post_ID', $_GET)) {
        $post_id = $_GET['post_ID'];
    } else {
        return;
    }
    $template_file = get_post_meta($post_id, '_wp_page_template', true);

    if (
        $template_file == 'custom-contact.php' ||
        $template_file == 'custom-testimonials.php'
    ) {
        remove_post_type_support('page', 'editor');
    }
}
add_action( 'admin_init', 'asen_hide_editor' );



// $global_tiers = get_field_object('site_tier', 'option');
// $condition_field = get_field_object('sub-menu_indicator_closed', 'option');

// function set_conditions() {
//         $condition_field['conditional_logic'] = array(
//             array(
//                 'field' => $global_tiers['key'],
//                 'operator' => '!=',
//                 'value' => '0'
//             )
//             );

//         // if ($global_tiers['value'] != 1) {
//         //     return false;
//         // }
//     return $condition_field;
// }

// apply_filters('acf/prepare_field/key=' . $condition_field['key'], 'set_conditions');