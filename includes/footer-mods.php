<?php function asen_custom_css_footer() { 
    $icon_size = get_field('footer_font_size', 'option') ? get_field('footer_font_size', 'option') * 0.75 . 'px' : '';
    
    ?>

<style>
footer.site-footer {
    .top {

        background-color: <?php the_field('footer_background_color', 'option');
        ?>;

        li,
        a {
            font-size: <?php echo get_field('footer_font_size', 'option') . 'px';
            ?>;
            color: <?php the_field('footer_text_color', 'option');
            ?>;
        }

        .footer-mailing-list-container {

            p,
            h5 {
                color: <?php the_field('footer_text_color', 'option');
                ?>;
            }
        }

        a:hover {
            color: <?php the_field('footer_text_hover_color', 'option');
            ?>;
        }

        li.phone i {
            font-size: <?php echo $icon_size;
            ?>;
        }
    }

    .bottom {
        background-color: <?php the_field('footer_bottom_background_color', 'option');
        ?>;

        p,
        a,
        p.copyright,
        p.copright a {
            font-size: <?php echo get_field('footer_bottom_font_size', 'option') . 'px';
            ?>;
            color: <?php the_field('footer_bottom_text_color', 'option');
            ?>;
        }

        a:hover {
            color: <?php the_field('footer_bottom_text_hover_color', 'option');
            ?>;
        }

        .site-social.links a {
            font-size: <?php echo get_field('footer_social_links_size', 'option') . 'px';
            ?>;
        }
    }

    .footer-mailing-list-container {
        h5 {
            color: <?php the_field('footer_mailing_list_title_color', 'option');
            ?>;
            font-size: <?php echo get_field('footer_mailing_list_title_size', 'option') . 'px';
            ?>;
        }

        p {
            color: <?php the_field('footer_mailing_list_subtitle_color', 'option');
            ?>;
            font-size: <?php echo get_field('footer_mailing_list_subtitle_size', 'option') . 'px';
            ?>;
        }
    }

    img {
        height: <?php echo get_field('footer_logo_height', 'option') . 'px';
        ?>;
    }
}
</style>

<?php
}
add_action('wp_footer', 'asen_custom_css_footer', 100);
?>