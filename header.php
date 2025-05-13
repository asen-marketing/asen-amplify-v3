<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php if ( function_exists('wp_body_open') ) :
            wp_body_open();
        endif; ?>
    <div class="site-container">
        <?php 
                if ( class_exists('ACF') ) :
                    if (
                        is_page_template('custom-blank.php') == false && 
                        get_field('site_header_layout', 'option')
                    ) : 
                        get_template_part(
                            'templates/header/header-layout',
                            get_field('site_header_layout', 'option')
                        );
                    endif;
                endif;
            ?>
        <div id="top" class="main-content">
            <?php // Banners are located in the page.php or custom templates for proper HTML layout.