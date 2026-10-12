<!doctype html>
<html <?php language_attributes(); ?>>

<head>
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
