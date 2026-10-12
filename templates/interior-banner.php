<?php 

if ( class_exists('ACF') === false ) return; 

if ( get_field('banner_disable') != true ) :

$eyebrow_classes = '';
$title_classes = '';
$subtitle_classes = '';
if (get_field('alignment_options')) {
    if ( get_field('alignment_options') === 'left' ) {
        $button_alignment = 'flex-start';
    } elseif ( get_field('alignment_options') === 'right' ) {
        $button_alignment = 'flex-end';
    } elseif ( get_field('alignment_options') === 'center' ) {
        $button_alignment = 'center';
    } // end elseif
} else if (get_field('page_banner_text_align', 'option')) {
    if ( get_field('page_banner_text_align', 'option') === 'left' ) {
        $button_alignment = 'flex-start';
    } elseif ( get_field('page_banner_text_align', 'option') === 'right' ) {
        $button_alignment = 'flex-end';
    } elseif ( get_field('page_banner_text_align', 'option') === 'center' ) {
        $button_alignment = 'center';
    } // end elseif
} else {
    $button_alignment = 'center';
}

if ( get_field('page_banner_eyebrow_size', 'option') ) {
    $eyebrow_classes .= ' ' . get_field('page_banner_eyebrow_size', 'option');
}
if ( get_field('page_banner_title_size', 'option') ) {
    $title_classes .= ' ' . get_field('page_banner_title_size', 'option');
}
if ( get_field('page_banner_subtitle_size', 'option') ) {
    $subtitle_classes .= ' ' . get_field('page_banner_subtitle_size', 'option');
}


$eyebrow_text = '';
$title_text = '';
$subtitle_text = '';

if ( is_archive() ) {
    $post_type = get_post_type_object( get_post_type() );
    $archive_title = $post_type->label;
    $slug = $post_type->name;
    $singular_title = $post_type->labels->singular_name;

    if ( get_field($slug . '_archive_custom_title', 'option') ) {
        $title_text = get_field($slug . '_archive_custom_title', 'option');
    } else {
        $title_text = $archive_title;
    }
    if ( get_field( $slug . '_archive_custom_subtitle', 'option' ) ) {
        $subtitle_text = get_field($slug . '_archive_custom_subtitle', 'option');
    }
} elseif ( is_page() ) {
    if ( get_field('banner_eyebrow') ) {
        $eyebrow_text = get_field('banner_eyebrow');
    }
    if ( get_field('banner_title') ) {
        $title_text = get_field('banner_title');
    } else {
        $title_text = get_the_title();
    }
    if ( get_field('banner_subtitle') ) {
        $subtitle_text = get_field('banner_subtitle');
    }
}

?>

<header class="asen-page-banner <?php echo $post->post_name; ?>">
    <?php if ( get_field('banner_background_image') && get_field('background_options') === 'image') : ?>
    <div class=" background-image">
        <?php echo wp_get_attachment_image( get_field('banner_background_image'), 'asen-banner-general' ); ?>
    </div>
    <?php endif; ?>
    <?php if (get_field('banner_background_video') && get_field('background_options') === 'video') : ?>
    <div class="background-video">
        <video src="<?php the_field('banner_background_video'); ?>" autoplay loop muted></video>
    </div>
    <?php endif; ?>
    <div class=" background-overlay">
    </div>
    <div class="inside">
        <div class="copy" style="align-items: <?php if (isset($button_alignment)) echo $button_alignment; ?>;">
            <?php if ( $eyebrow_text ) : ?>
            <p class="eyebrow <?php echo $eyebrow_classes ; ?>">
                <?php echo $eyebrow_text; ?>
            </p>
            <?php endif; ?>
            <h1 class="<?php echo $title_classes ; ?>">
                <?php echo $title_text; ?>
            </h1>
            <?php if ( $subtitle_text ) : ?>
            <p class="subtitle <?php echo $subtitle_classes ; ?>">
                <?php echo $subtitle_text; ?>
            </p>
            <?php endif; ?>
        </div>

        <?php
            $button_1 = get_field('button_1');
            $button_2 = get_field('button_2');

            if ($button_1) : 
            ?>
        <div class="button-container"
            style="justify-content: <?php if (isset($button_alignment)) echo $button_alignment; ?>;">
            <a class="button" href="<?php echo $button_1['url']; ?>" title="<?php echo $button_1['title']; ?>"
                target="<?php echo $button_1['target']; ?>">
                <?php echo $button_1['title']; ?>
            </a>
            <?php if ($button_2) : ?>
            <a class="button" href="<?php echo $button_2['url']; ?>" title="<?php echo $button_2['title']; ?>"
                target="<?php echo $button_2['target']; ?>">
                <?php echo $button_2['title']; ?>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</header>
<?php endif; ?>

<style>
.asen-page-banner {
    <?php if (get_field('background_options') !=='default'|| get_field('background_options') !=='color'): ?> background-color: transparent;
    <?php endif;

    ?><?php if (get_field('background_options')==='color') echo 'background-color: '. get_field('background_color') . ';';

    ?>.inside {
        .button-container .button {
            background-color: <?php the_field('banner_button_background_color', 'option');
            ?>;
            color: <?php the_field('banner_button_text_color', 'option');
            ?>;
        }

        .button-container .button:hover {
            background-color: <?php the_field('banner_button_background_hover_color', 'option');
            ?>;
            color: <?php the_field('banner_button_text_hover_color', 'option');
            ?>;
        }
    }
}

.asen-page-banner.<?php echo $post->post_name;

?> {
    .inside {
        <?php if (get_field('padding_top')) echo 'padding-top: '. get_field('padding_top') . '%;';
        ?><?php if (get_field('padding_right')) echo 'padding-right: '. get_field('padding_right') . '%;';
        ?><?php if (get_field('padding_bottom')) echo 'padding-bottom: '. get_field('padding_bottom') . '%;';
        ?><?php if (get_field('padding_left')) echo 'padding-left: '. get_field('padding_left') . '%;';
        ?>
    }

    h1 {
        max-width: <?php if (get_field('content_max_width')) echo get_field('content_max_width') . 'px;';
        ?>
    }

    p.subtitle {
        max-width: <?php if (get_field('content_max_width')) echo get_field('content_max_width') . 'px;';
        ?>
    }

    <?php if (get_field('alignment_options')) : ?>p.eyebrow {
        text-align: <?php echo get_field('alignment_options');
        ?>
    }

    h1 {
        text-align: <?php echo get_field('alignment_options');
        ?>
    }

    p.subtitle {
        text-align: <?php echo get_field('alignment_options');
        ?>
    }

    <?php endif;

    ?><?php if (get_field('background_overlay')) : ?>.background-overlay {
        background-color: <?php the_field('background_overlay');
        ?>;
        opacity: <?php if (get_field('background_overlay_opacity')) echo get_field('background_overlay_opacity');
        ?>;
    }

    <?php endif;

    ?>
}
</style>