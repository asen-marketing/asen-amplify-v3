<header class="site-header layout-3">
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
    </div>
</header>