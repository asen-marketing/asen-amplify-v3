<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
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