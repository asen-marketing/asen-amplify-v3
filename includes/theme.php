<?php
/**
 * @file Theme functions.
 */

function site_enqueue_theme_scripts() {
	$cache_buster_css = date( "YmdHi", filemtime(get_template_directory() . '/css/index.css') );
	$cache_buster_js = date( "YmdHi", filemtime(get_template_directory() . '/js/main.js') );
	wp_enqueue_style('main', get_template_directory_uri() . '/css/index.css', [], $cache_buster_css);
    wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', [ 'jquery' ], $cache_buster_js, true);
	wp_enqueue_script( 'jquery-modal', get_template_directory_uri() . '/js/vendor/jquery.modal.min.js', null, '0.9.2', true );

}
add_action('wp_enqueue_scripts', 'site_enqueue_theme_scripts');

// Enable native WordPress Featured Image
// Typically shouldn't be enabled unless importing old posts with Featured Images (ACF better option)
add_theme_support( 'post-thumbnails' );

// Add default posts and comments RSS feed links to head.
// add_theme_support( 'automatic-feed-links' );

// Let WordPress manage the document title.
// By adding theme support, we declare that this theme does not use a
// hard-coded <title> tag in the document head, and expect WordPress to
// provide it for us.
add_theme_support( 'title-tag' );

// Switch default core markup for search form, comment form, and comments
// to output valid HTML5.
add_theme_support(
	'html5',
	array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	)
);

function site_widgets_init() {
	register_sidebar( array(
		'name'          => 'Blog Sidebar',
		'id'            => 'blog_sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'site_widgets_init' );

function site_remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'site_remove_admin_login_header');

function asen_enqueue_glide_js() {
	// 3.4.1 was buggy. A performance with redraw issue of some sort.
	// 3.3.0 was known to work well.
	wp_enqueue_script( 'glide-js', get_template_directory_uri() . '/js/vendor/glide.min.js', null, '3.3.0', true );
}

// Custom Image Sizes
add_image_size( 'asen-fullscreen', 1920, 1920, false );
add_image_size( 'asen-banner-general', 1920, 0, false );

add_filter('jpeg_quality', function() {
	return 75;
});

if ( !isset($content_width) ) {
	$content_width = 1480;
}

function site_init() {
	// Disable for security.
	add_filter('xmlrpc_enabled', '__return_false');
	// Enable infinite scrolling because it's our party.
	add_filter('media_library_infinite_scrolling', '__return_true');
	// Disable new sitemap feature.
	add_filter('wp_sitemaps_enabled', '__return_false');
	// Disable WordPress' automatic image scaling feature.
	add_filter('big_image_size_threshold', '__return_false');
}
add_action('init', 'site_init');