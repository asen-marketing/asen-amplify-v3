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