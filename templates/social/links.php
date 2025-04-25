<?php if ( have_rows('site_social_media_selection', 'option') ) : ?>
    <ul class="site-social links">
        <?php while ( have_rows('site_social_media_selection', 'option') ) : the_row();
            $value = get_sub_field('social_media_network')['value'];
            $label = get_sub_field('social_media_network')['label'];
            $icon_name = 'fa-' . $value;
            if ( $value  == 'linkedin' ) {
                $icon_name = $icon_name . '-in';
            } else if ( $value == 'facebook' ) {
                $icon_name = $icon_name . '-f';
            }
        ?>
            <li>
                <a 
                    href="<?php the_sub_field('url'); ?>" 
                    title="Follow us on <?php echo $label; ?>" 
                    target="_blank"
                    rel="noreferrer noopener"
                >
                    <i class="fa-brands <?php echo $icon_name; ?>"></i>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
<?php endif; ?>