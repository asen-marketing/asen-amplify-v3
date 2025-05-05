<?php

require_once(get_template_directory() . '/includes/development.php');
require_once(get_template_directory() . '/includes/theme.php');
require_once(get_template_directory() . '/includes/helpers.php');
require_once(get_template_directory() . '/includes/head-mods.php');
require_once(get_template_directory() . '/includes/body-class-mods.php');
require_once(get_template_directory() . '/includes/backend-mods.php');
require_once(get_template_directory() . '/includes/custom-post-types.php');
require_once(get_template_directory() . '/includes/menus.php');
require_once(get_template_directory() . '/includes/acf-customizations.php');
require_once(get_template_directory() . '/includes/gutenberg.php');
require_once(get_template_directory() . '/includes/woocommerce.php');
require_once(get_template_directory() . '/includes/yoast.php');
require_once(get_template_directory() . '/includes/footer-mods.php');

// Fix for CSS auto-sizing issue caused by WP 6.7.1
function remove_auto_sizes_css_fix($add_auto_sizes) {return false;}
add_filter('wp_img_tag_add_auto_sizes', 'remove_auto_sizes_css_fix');

// disable the split layout in gutenberg since 6.8
function wp68_admin_editor_fix_styles() {
    echo '<style>
        .editor-visual-editor {
            overflow: visible;
        }

        .interface-navigable-region.components-resizable-box__container.edit-post-meta-boxes-main.is-resizable {
            max-height: none !important;
            height: auto !important;
        }
    </style>';
}
add_action('admin_head', 'wp68_admin_editor_fix_styles');