<?php

function asen_backend_scripts_enqueue() {
	// Custom backend styles
    wp_enqueue_style( 'backend-styles', get_template_directory_uri() . '/includes/css/backend-styles.css', __FILE__ );
}
add_action( 'admin_enqueue_scripts', 'asen_backend_scripts_enqueue' );

function asen_curate_menu_list() {
    $current_user = wp_get_current_user();
    $current_user_email_domain = explode('@', $current_user->user_email);
    $current_user_roles = $current_user->roles;
    if (
        $current_user_email_domain[1] != 'asenmarketing.com' || 
        in_array( 'administrator', $current_user_roles ) == false
    ) {
        remove_menu_page( 'kadence-blocks' );
    }
}
add_action( 'admin_init', 'asen_curate_menu_list' );

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
