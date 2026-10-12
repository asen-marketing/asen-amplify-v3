<?php
/**
 * @file Theme functions.
 */

function site_enqueue_theme_scripts() {
    $cache_buster_css = date( "YmdHi", filemtime( get_template_directory() . '/css/index.css' ) );
    $cache_buster_js  = date( "YmdHi", filemtime( get_template_directory() . '/js/main.js' ) );
    wp_enqueue_style( 'main', get_template_directory_uri() . '/css/index.css', array(), $cache_buster_css );
    wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), $cache_buster_js, true );
    wp_enqueue_script( 'jquery-modal', get_template_directory_uri() . '/js/vendor/jquery.modal.min.js', null, '0.9.2', true );
}

add_action( 'wp_enqueue_scripts', 'site_enqueue_theme_scripts' );

// Libraries blocks depend on are registered, never enqueued globally: block viewScripts list them as dependencies,
// and the collection partial enqueues the carousel only when a block renders in carousel layout.
function asen_register_block_dependencies() {
    $uri = get_template_directory_uri();
    wp_register_style( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );
    wp_register_script( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );
    wp_register_style( 'splide', $uri . '/js/vendor/splide/splide.min.css', array(), '4.1.4' );
    wp_register_script( 'splide', $uri . '/js/vendor/splide/splide.min.js', array(), '4.1.4', true );
    wp_register_script( 'splide-auto-scroll', $uri . '/js/vendor/splide/splide-extension-auto-scroll.min.js', array( 'splide' ), '0.5.3', true );
    wp_register_script( 'asen-carousel', $uri . '/js/carousel.js', array( 'splide' ), filemtime( get_template_directory() . '/js/carousel.js' ), true );
}
add_action( 'init', 'asen_register_block_dependencies' );

// Subresource integrity for the CDN-loaded Leaflet assets.
add_filter( 'script_loader_tag', function ( $tag, $handle ) {
    return 'leaflet' === $handle ? str_replace( ' src=', ' integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="" src=', $tag ) : $tag;
}, 10, 2 );
add_filter( 'style_loader_tag', function ( $tag, $handle ) {
    return 'leaflet' === $handle ? str_replace( ' href=', ' integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" href=', $tag ) : $tag;
}, 10, 2 );

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
    remove_action( 'wp_head', '_admin_bar_bump_cb' );
}

add_action( 'get_header', 'site_remove_admin_login_header' );

// Splide plus the auto-scroll extension, for client blocks that build their own carousels (e.g. a logo marquee).
function asen_enqueue_splide() {
    wp_enqueue_style( 'splide' );
    wp_enqueue_script( 'splide-auto-scroll' );
}

// Custom Image Sizes
add_image_size( 'asen-fullscreen', 1920, 1920, false );
add_image_size( 'asen-banner-general', 1920, 0, false );

add_filter( 'jpeg_quality', function () {
    return 75;
} );

if ( ! isset( $content_width ) ) {
    $content_width = 1480;
}

function asen_register_acf_blocks() {
    // Get the path to your blocks directory
    $blocks_dir = get_template_directory() . "/includes/core-blocks";

// Loop through each folder in the blocks directory
    if ( is_dir( $blocks_dir ) ) {
        $block_folders = new DirectoryIterator( $blocks_dir );

        foreach ( $block_folders as $folder ) {
// Check if it's a directory and contains a block.json file
            if ( $folder->isDir() && ! $folder->isDot() ) {
                $block_json = $folder->getPathname() . '/block.json';

                if ( file_exists( $block_json ) ) {
                    // Register the block using the path to the folder
                    register_block_type( $folder->getPathname() );
                }
            }
        }
    }
}

function site_init() {
    // Disable for security.
    add_filter( 'xmlrpc_enabled', '__return_false' );
    // Enable infinite scrolling because it's our party.
    add_filter( 'media_library_infinite_scrolling', '__return_true' );
    // Disable new sitemap feature.
    add_filter( 'wp_sitemaps_enabled', '__return_false' );
    // Disable WordPress' automatic image scaling feature.
    add_filter( 'big_image_size_threshold', '__return_false' );
    asen_register_acf_blocks();
}

add_action( 'init', 'site_init' );