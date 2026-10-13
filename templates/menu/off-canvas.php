<?php $site_name = get_bloginfo('name', 'display'); ?>

<div class="off-canvas-menu-backing-overlay"></div>
<div class="off-canvas-menu-container" id="off-canvas-menu" inert>
    <div class="close-container">
        <div class="off-canvas-menu-hamburger">
            <button class="hamburger hamburger--<?php the_field('site_hamburger_menu_animation', 'option'); ?>"
                type="button" aria-label="Close menu" aria-controls="off-canvas-menu" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" aria-hidden="true" focusable="false">
                    <path
                        d="M345 137c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-119 119L73 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l119 119L39 375c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l119-119L311 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-119-119L345 137z">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <div class="inside<?php if (get_field('off_canvas_footer', 'option')) echo ' has-footer'; ?>">
        <div class="column-container<?php if (get_field('off_canvas_two_column', 'option')) echo ' two-column'; ?>">
            <?php if (has_nav_menu('off-canvas-menu')) : ?>
                <nav class="off-canvas-menu off-canvas-menu-large">
                    <?php wp_nav_menu(array(
                        'container' => '',
                        'menu_class' => 'off-canvas-menu',
                        'theme_location' => 'off-canvas-menu',
                        'depth' => 2,
                    )); ?>
                </nav>
            <?php else : ?>
                <p>Create a menu called "Off Canvas Menu"!</p>
            <?php endif; ?>
            <?php if (has_nav_menu('off-canvas-bottom-menu')) : ?>
                <nav class="off-canvas-menu off-canvas-menu-small">
                    <?php wp_nav_menu(array(
                        'container' => '',
                        'menu_class' => 'off-canvas-bottom-menu',
                        'theme_location' => 'off-canvas-bottom-menu',
                        'depth' => 2
                    )); ?>
                </nav>
            <?php endif; ?>
        </div>

        <?php if (get_field('off_canvas_footer', 'option')) : ?>
            <div class="off-canvas-footer">
                <?php
                $show_button = get_field('off_canvas_show_cta_button', 'option');
                $show_social = get_field('off_canvas_show_social_links', 'option');
                $show_copyright = get_field('off_canvas_show_copyright', 'option');
                $logo = get_field('off_canvas_logo_image', 'option');

                $cta_button = get_field('site_header_cta_link', 'option');
                ?>

                <?php if ($show_button && $cta_button) : ?>
                    <a class="button button-small" href="<?php echo $cta_button['url']; ?>"
                        title="<?php echo $cta_button['title']; ?>" target="<?php echo $cta_button['target']; ?>">
                        <?php echo $cta_button['title']; ?>
                    </a>
                <?php endif; ?>

                <?php if ($logo) : ?>
                    <?php echo wp_get_attachment_image($logo, 'full'); ?>
                <?php endif; ?>

                <?php if ($show_social) : ?>
                    <?php get_template_part(('templates/social/links')); ?>
                <?php endif; ?>

                <?php if ($show_copyright) : ?>
                    <p class="copyright">Copright © <?php echo date('Y'); ?> <?php echo get_bloginfo('name', 'display'); ?></p>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <?php if (has_nav_menu('logged-in-woo-menu') && is_user_logged_in()) : ?>
            <nav class="off-canvas-menu woo-off-canvas-menu woo-logged-in-menu">
                <?php wp_nav_menu(array(
                    'menu' => 'Woo Menu (Logged In)',
                    'container' => '',
                    'menu_class' => '',
                    'theme_location' => 'logged-in-woo-menu',
                    'depth' => 1
                )); ?>
            </nav>
        <?php elseif (has_nav_menu('logged-out-woo-menu')): ?>
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
