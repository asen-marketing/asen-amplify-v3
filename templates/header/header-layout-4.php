<?php $cta_button = get_field('site_header_cta_link', 'option'); ?>
<header class="site-header layout-4">
    <div class="inside">
        <div class="logo">
            <a href="<?php echo site_url( '/', 'https' ); ?>" title="<?php echo get_bloginfo('name', 'display'); ?>">
                <?php if (get_field('site_header_logo_image', 'option') ) : ?>
                <?php echo wp_get_attachment_image( get_field('site_header_logo_image', 'option'), 'large' ); ?>
                <?php else : ?>
                Add header logo!
                <?php endif; ?>
            </a>
        </div>
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
                <?php if ($cta_button && get_field('site_header_4_cta', 'option') === 'button') : ?>
                <a class="button header-cta" href="<?php echo $cta_button['link']; ?>"
                    title="<?php echo $cta_button['title']; ?>" target="<?php echo $cta_button['target']; ?>">
                    <?php echo $cta_button['title']; ?>
                </a>
                <?php endif; ?>
                <?php get_template_part('templates/menu/hamburger'); ?>
            </nav>
            <?php else : ?>
            <p>Create a menu called " Primary Menu"!</p>
            <?php endif; ?>
            <?php get_template_part('templates/custom-cta-options'); ?>
        </div>
    </div>
</header>