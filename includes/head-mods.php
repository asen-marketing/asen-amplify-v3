<?php

function asen_top_head() {
?>

<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?php if ( class_exists('ACF') ) :
    if ( get_field('site_font_snippets', 'option') ) :
        echo get_field('site_font_snippets', 'option');
    endif;
endif; ?>

<?php
}
add_action('wp_head', 'asen_top_head', 1);

function asen_head_code() {
    if ( class_exists('ACF') ) :
        if ( get_field('site_head_script_snippets', 'option') ) :
            echo get_field('site_head_script_snippets', 'option');
        endif;
    endif;
}
add_action('wp_head', 'asen_head_code');

function asen_body_open_code() {
    if ( class_exists('ACF') ) :
        if ( get_field('site_after_opening_body_tag_script_snippets', 'option') ) :
            echo get_field('site_after_opening_body_tag_script_snippets', 'option');
        endif;
    endif;
}
add_action('wp_body_open', 'asen_body_open_code');

function asen_body_close_code() {
    if ( class_exists('ACF') ) :
        if ( get_field('site_before_closing_body_tag_script_snippets', 'option') ) :
            echo get_field('site_before_closing_body_tag_script_snippets', 'option');
        endif;
    endif;
}
add_action('wp_footer', 'asen_body_close_code');

function asen_custom_css_head() {
    if ( class_exists('ACF') === false ) return; 
    $styles = '';
    if ( get_field('page_padding_top', get_the_ID()) || get_field('page_padding_top', get_the_ID()) != '' ) {
        $styles .= 'padding-top: ' . get_field('page_padding_top', get_the_ID() ) . get_field('page_padding_top_unit_type', get_the_ID() ) . ';';
    }
    if ( get_field('page_padding_bottom', get_the_ID()) || get_field('page_padding_bottom', get_the_ID()) != '' ) {
        $styles .= 'padding-bottom: ' . get_field('page_padding_bottom', get_the_ID() ) . get_field('page_padding_bottom_unit_type', get_the_ID() ) . ';';
    }
    $header_height = get_field('site_header_height', 'option');
    $header_height_pixels = get_field('site_header_height', 'option') . 'px';
    $header_width_px = get_field('header_max_width', 'option') ? (get_field('header_max_width', 'option') . 'px') : '1400px';
    $off_canvas_px = get_field('off_canvas_breakpoint', 'option') ? (get_field('off_canvas_breakpoint', 'option') . 'px') : '1024px';


    if (
        is_page() && get_field('banner_disable') != true ||
        get_post_type() == 'products' && get_field('products_archive_use_page_banner_styles', 'option') ||
        get_post_type() == 'services' && get_field('services_archive_use_page_banner_styles', 'option') ||
        get_post_type() == 'team' && get_field('team_archive_use_page_banner_styles', 'option')
    ) {
        $page_banner_styles = '';
        $page_banner_background_image_styles = '';
        $page_banner_background_overlay_styles = '';
        $page_banner_eyebrow_styles = '';
        $page_banner_title_styles = '';
        $page_banner_subtitle_styles = '';
        if ( get_field('page_banner_text_align', 'option') ) {
            $page_banner_eyebrow_styles .= 'text-align: ' . get_field('page_banner_text_align', 'option') . ';';
            $page_banner_title_styles .= 'text-align: ' . get_field('page_banner_text_align', 'option') . ';';
            $page_banner_subtitle_styles .= 'text-align: ' . get_field('page_banner_text_align', 'option') . ';';
        }
        if ( get_field('page_banner_eyebrow_color', 'option') ) {
            $page_banner_eyebrow_styles .= 'color: ' . get_field('page_banner_eyebrow_color', 'option') . ';';
        }
        if ( get_field('page_banner_eyebrow_transform', 'option') ) {
            $page_banner_eyebrow_styles .= 'text-transform: ' . get_field('page_banner_eyebrow_transform', 'option') . ';';
        }
        if ( get_field('page_banner_title_color', 'option') ) {
            $page_banner_title_styles .= 'color: ' . get_field('page_banner_title_color', 'option') . ';';
        }
        if ( get_field('page_banner_title_transform', 'option') ) {
            $page_banner_title_styles .= 'text-transform: ' . get_field('page_banner_title_transform', 'option') . ';';
        }
        if ( get_field('page_banner_subtitle_color', 'option') ) {
            $page_banner_subtitle_styles .= 'color: ' . get_field('page_banner_subtitle_color', 'option') . ';';
        }
        if ( get_field('page_banner_subtitle_transform', 'option') ) {
            $page_banner_subtitle_styles .= 'text-transform: ' . get_field('page_banner_subtitle_transform', 'option') . ';';
        }
        if ( get_field('page_banner_background_color', 'option') ) {
            $page_banner_styles .= 'background-color: ' . get_field('page_banner_background_color', 'option') . ';';
        }
        if ( get_field('page_banner_background_blend_mode', 'option') && get_field('page_banner_background_blend_mode', 'option') != 'normal' ) {
            $page_banner_background_image_styles .= 'mix-blend-mode: ' . get_field('page_banner_background_blend_mode', 'option') . ';';
        }
        if ( get_field('page_banner_background_overlay_color', 'option') ) {
            $page_banner_background_overlay_styles .= 'background-color: ' . get_field('page_banner_background_overlay_color', 'option') . ';';
        }
        if ( get_field('page_banner_background_overlay_opacity', 'option') ) {
            $page_banner_background_overlay_styles .= 'opacity: ' . get_field('page_banner_background_overlay_opacity', 'option') . ';';
        }
        if ( get_field('page_banner_padding_top', 'option') ) {
            $page_banner_styles .= 'padding-top: ' . get_field('page_banner_padding_top', 'option') . get_field('page_banner_padding_top_unit_type', 'option') . ';';
        }
        if ( get_field('page_banner_padding_right', 'option') ) {
            $page_banner_styles .= 'padding-right: ' . get_field('page_banner_padding_right', 'option') . get_field('page_banner_padding_right_unit_type', 'option') . ';';
        }
        if ( get_field('page_banner_padding_bottom', 'option') ) {
            $page_banner_styles .= 'padding-bottom: ' . get_field('page_banner_padding_bottom', 'option') . get_field('page_banner_padding_bottom_unit_type', 'option') . ';';
        }
        if ( get_field('page_banner_padding_left', 'option') ) {
            $page_banner_styles .= 'padding-left: ' . get_field('page_banner_padding_left', 'option') . get_field('page_banner_padding_left_unit_type', 'option') . ';';
        }
    }
?>

<style>
<?php echo ($styles !=''? 'body.page main {'. $styles . '}' : '');

?><?php if (get_field('site_header_position', 'option')=='static') : ?>header.site-header {
    position: static;
}

<?php endif;

?>body {
    <?php if (get_field('site_header_position', 'option')=='static'): ?> padding-top: 0;
    <?php else: ?> padding-top: <?php echo $header_height_pixels;
    ?>;
    <?php endif;
    ?>
}

body.admin-bar {
    <?php if (get_field('site_header_position', 'option')=='static'): ?> padding-top: 32px;
    <?php else: ?> padding-top: <?php echo 32 + $header_height . 'px';
    ?>;
    <?php endif;
    ?>
}

@media screen and (max-width: 782px) {
    body.admin-bar {
        <?php if (get_field('site_header_position', 'option')=='static'): ?> padding-top: 46px;
        <?php else: ?> padding-top: <?php echo 46 + $header_height . 'px';
        ?>;
        <?php endif;
        ?>
    }
}

.site-container {
    <?php if (get_field('site_header_position', 'option')=='static'): ?> min-height: 100vh;
    <?php else: ?> min-height: calc(100vh - <?php echo $header_height_pixels; ?>);
    <?php endif;
    ?>
}

body.admin-bar .site-container {
    <?php if (get_field('site_header_position', 'option')=='static'): ?> min-height: calc(100vh - 32px);
    <?php else: ?> min-height: calc(100vh - <?php echo 32 + $header_height . 'px'; ?>);
    <?php endif;
    ?>
}

@media screen and (max-width: 782px) {
    body.admin-bar .site-container {
        <?php if (get_field('site_header_position', 'option')=='static'): ?> min-height: calc(100vh - 46px);
        <?php else: ?> min-height: calc(100vh - <?php echo 46 + $header_height . 'px'; ?>);
        <?php endif;
        ?>
    }
}

header.site-header .inside {
    max-width: <?php echo get_field('full_width_header', 'option')==false ? $header_width_px: '100%';
    ?>;
}

header.site-header .inside,
.off-canvas-menu-hamburger {
    height: <?php echo $header_height_pixels;
    ?>;
}

header.site-header .button.header-cta {
    background-color: <?php the_field('site_header_cta_color', 'option');
    ?>;
    color: <?php the_field('site_header_cta_text_color', 'option');
    ?>;
}

header.site-header .button.header-cta:hover {
    background-color: <?php the_field('site_header_cta_text_color', 'option');
    ?>;
    color: <?php the_field('site_header_cta_color', 'option');
    ?>;
}

.off-canvas-menu ul li a {
    font-size: <?php echo get_field('off_canvas_font_size', 'option') . 'px';
    ?>;
    color: <?php get_field('off_canvas_custom_colors', 'option') ? the_field('off_canvas_text_color', 'option'): '#fff'; // TODO: change to primary/secondary color
    ?>;
}

.off-canvas-menu ul li a:hover {
    color: <?php get_field('off_canvas_custom_colors', 'option') ? the_field('off_canvas_hover_color', 'option'): '#fff'; // TODO: change to primary/secondary color
    ?>;
}

@media (max-width: 639px) {
    .off-canvas-menu ul li a {
        font-size: <?php echo get_field('off_canvas_mobile_font_size', 'option') . 'px';
        ?>;
    }
}

@media (max-width: <?php echo $off_canvas_px; ?>) {

    .off-canvas-menu-backing-overlay,
    .off-canvas-menu-container.header-layout-1,
    .off-canvas-menu-container.header-layout-2 {
        display: flex;
    }

    .off-canvas-menu-hamburger.header-layout-1,
    .off-canvas-menu-hamburger.header-layout-2 {
        display: block;
    }

    header.site-header.layout-1 .navigation,
    header.site-header.layout-1 nav.header-menu,
    header.site-header.layout-2 nav.header-menu li:not(.layout-2-logo),
    header.site-header.layout-3 nav.header-menu,
    header.site-header.layout-4 ul.primary-menu {
        display: none;
    }
}

header.site-header div.logo a,
nav.header-menu li.layout-2-logo img {
    height: <?php the_field('site_header_logo_height', 'option');
    ?>px;
}

.off-canvas-menu-container {
    padding-top: <?php echo $header_height_pixels;
    ?>;
}

.off-canvas-menu-container .inside {
    margin-top: <?php echo '-'. $header_height_pixels;
    ?>;
}

body.admin-bar .off-canvas-menu-container {
    padding-top: <?php echo 32 + $header_height . 'px';
    ?>;
}

@media (max-width: 782px) {
    body.admin-bar .off-canvas-menu-container {
        padding-top: <?php echo 46 + $header_height . 'px';
        ?>;
    }
}

.asen-front-page-banner.is-full-screen {
    min-height: calc(96vh);
}

@media (max-width: 782px) {
    .asen-front-page-banner.is-full-screen {
        min-height: calc(88vh);
    }
}

body.admin-bar .asen-front-page-banner.is-full-screen {
    min-height: calc(96vh - <?php echo 32 . 'px'; ?>);
}

@media (max-width: 782px) {
    body.admin-bar .asen-front-page-banner.is-full-screen {
        min-height: calc(88vh - <?php echo 46 . 'px'; ?>);
    }
}

<?php

/* Banner styling from Site Options fields */
?><?php if ((is_page() && get_field('banner_disable') !=true && get_field("enable_styling_options", 'options')==1) || get_post_type()=='products'&& get_field('products_archive_use_page_banner_styles', 'option') || get_post_type()=='services'&& get_field('services_archive_use_page_banner_styles', 'option') || get_post_type()=='team'&& get_field('team_archive_use_page_banner_styles', 'option')) : ?><?php if ($page_banner_styles !='') : ?>.asen-page-banner {
    <?php echo $page_banner_styles;
    ?>
}

<?php endif;

?><?php if ($page_banner_background_image_styles !='') : ?>.asen-page-banner .background-image {
    <?php echo $page_banner_background_image_styles;
    ?>
}

<?php endif;

?><?php if ($page_banner_background_overlay_styles !='') : ?>.asen-page-banner .background-overlay {
    <?php echo $page_banner_background_overlay_styles;
    ?>
}

<?php endif;

?><?php if ($page_banner_eyebrow_styles !='') : ?>.asen-page-banner p.eyebrow {
    <?php echo $page_banner_eyebrow_styles;
    ?>
}

<?php endif;

?><?php if ($page_banner_title_styles !='') : ?>.asen-page-banner h1 {
    <?php echo $page_banner_title_styles;
    ?>
}

<?php endif;

?><?php if ($page_banner_subtitle_styles !='') : ?>.asen-page-banner div.subtitle {
    <?php echo $page_banner_subtitle_styles;
    ?>
}

<?php endif;
?><?php endif;

?><?php if (get_field('banner_disable') !=true) : ?>body.page main {
    padding-top: 0;
}

<?php endif;
?>
</style>

<?php
}
add_action('wp_head', 'asen_custom_css_head', 100);