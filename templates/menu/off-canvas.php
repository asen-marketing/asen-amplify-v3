<?php $site_name = get_bloginfo('name', 'display'); ?>

<div class="off-canvas-menu-backing-overlay"></div>
<div class="off-canvas-menu-container header-layout-<?php the_field('site_header_layout', 'option'); ?>">
    <div class="close-container">
        <div class="off-canvas-menu-hamburger header-layout-<?php the_field('site_header_layout', 'option'); ?>">
            <button class="hamburger hamburger--<?php the_field('site_hamburger_menu_animation', 'option'); ?>"
                type="button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                    <path
                        d="M345 137c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-119 119L73 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l119 119L39 375c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l119-119L311 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-119-119L345 137z">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <div class="inside">
        <?php if ( has_nav_menu('off-canvas-menu') ) : ?>
        <nav class="off-canvas-menu">
            <?php wp_nav_menu(array(
                    'menu' => 'Off Canvas Menu',
                    'container' => '',
                    'menu_class' => 'off-canvas-menu',
                    'theme_location' => 'off-canvas-menu',
                    'depth' => 2,
                    'after' => '<i class="fa-solid fa-angle-right"></i>'
                )); ?>
        </nav>
        <?php else : ?>
        <p>Create a menu called "Off Canvas Menu"!</p>
        <?php endif; ?>
        <?php get_template_part('templates/custom-cta-options'); ?>
        <?php if ( has_nav_menu('off-canvas-bottom-menu') ) : ?>
        <nav class="off-canvas-menu off-canvas-bottom-menu">
            <?php wp_nav_menu(array(
                    'menu' => 'Off Canvas Bottom Menu',
                    'container' => '',
                    'menu_class' => 'off-canvas-bottom-menu',
                    'theme_location' => 'off-canvas-bottom-menu',
                    'depth' => 2
                )); ?>
        </nav>
        <?php endif; ?>
        <?php if ( has_nav_menu('logged-in-woo-menu') && is_user_logged_in() ) : ?>
        <nav class="off-canvas-menu woo-off-canvas-menu woo-logged-in-menu">
            <?php wp_nav_menu(array(
                    'menu' => 'Woo Menu (Logged In)',
                    'container' => '',
                    'menu_class' => '',
                    'theme_location' => 'logged-in-woo-menu',
                    'depth' => 1
                )); ?>
        </nav>
        <?php elseif ( has_nav_menu('logged-out-woo-menu') ): ?>
        <nav class="off-canvas-menu woo-off-canvas-menu woo-logged-out-menu">
            <?php wp_nav_menu(array(
                    'menu' => 'Woo Menu (Logged Out)',
                    'container' => '',
                    'menu_class' => '',
                    'theme_location' => 'logged-out-woo-menu',
                    'depth' => 1
                )); ?>
        </nav>
        <?php endif; ?>
    </div>
</div>

<script defer>
(function($) {
    var hasChildren = $(".off-canvas-menu > .menu-item-has-children")
    var parentLinks = hasChildren.find("> a")
    var subMenu = hasChildren.find("> ul.sub-menu")

    parentLinks.removeAttr('href')

    parentLinks.each(function(idx) {
        $(this).on("click", function() {
            hasChildren.each(function(i) {
                if (i !== idx) {
                    $(this).removeClass("active")
                }
            })
            subMenu.each(function(i) {
                if (i !== idx) {
                    $(this).slideUp(500)
                }
            })
            hasChildren.eq(idx).toggleClass("active")
            subMenu.eq(idx).slideToggle(500)
        })
    })
})(jQuery)
</script>