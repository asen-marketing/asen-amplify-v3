<header class="site-header layout-2">
    <div class="inside">
        <div class="navigation">
            <?php if ( has_nav_menu('primary-menu') ) : ?>
            <nav class="header-menu">
                <?php wp_nav_menu(array(
                        'menu' => 'Primary Menu',
                        'container' => '',
                        'menu_class' => 'primary-menu',
                        'theme_location' => 'primary-menu',
                        'depth' => 1
                    )); ?>
            </nav>
            <?php else : ?>
            <p>Create a menu called "Primary Menu"!</p>
            <?php endif; ?>
        </div>
        <?php get_template_part('templates/menu/hamburger'); ?>
    </div>
</header>

<script defer>
(function($) {
    $(document).ready(function() {
        menuItems = $('.primary-menu .menu-item')
        centerItem = menuItems.eq(Math.floor(menuItems.length / 2 - 1))
        logo =
            '<?php echo wp_get_attachment_image( get_field('site_header_logo_image', 'option'), 'large' ); ?>'

        centerItem.after(
            '<a href="<?php echo site_url( '/', 'https' ); ?>" title="<?php echo get_bloginfo('name', 'display'); ?>"><li class="layout-2-logo">' +
            logo + '</li></a>')
    });
})(jQuery);
</script>