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
    <?php wp_body_open(); ?>
    <div class="site-container">
        <?php if ( class_exists( 'ACF' ) && ! is_page_template( 'custom-blank.php' ) ) {
            get_template_part( 'templates/header/header' );
        } ?>
        <div id="top" class="main-content">
            <?php // Banners are located in the page.php or custom templates for proper HTML layout.
