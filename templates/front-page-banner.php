<?php

if ( class_exists('ACF') === false ) return; 

$container_classes = '';

if ( get_field('full_screen') ) {
    $container_classes .= ' is-full-screen';
}

$styles = '';
$background_image_styles = '';
$background_overlay_classes = '';
$background_overlay_styles = '';
$title_styles = '';
$title_classes = '';
$subtitle_styles = '';
$subtitle_classes = '';
$blurb_styles = '';
$button_styles = '';
$thumb_size = 'asen-banner-general';

$slider = get_field('enable_slider');
$slides = get_field('hero_slides');

if ($slides) {
    $total_slides = count($slides);
}

if (!$slider || !$total_slides) {
    if ( get_field('background_gradient') && get_field('background_gradient') != 'none' ) {
        $container_classes .= ' ' . get_field( 'background_gradient' );
    }
    if ( get_field('background_color') ) {
        $styles .= 'background-color: ' . get_field('background_color') . ';';
    }
    if ( get_field('background_blend_mode') && get_field('background_blend_mode') != 'normal' ) {
        $background_image_styles .= 'mix-blend-mode: ' . get_field('background_blend_mode') . ';';
    }
}
if ( get_field('background_overlay_color') ) {
    $background_overlay_styles .= 'background-color: ' . get_field('background_overlay_color') . ';';
}
if ( get_field('padding_top') ) {
    $styles .= 'padding-top: ' . get_field('padding_top') . get_field('padding_top_unit_type') . ';';
}
if ( get_field('padding_bottom') ) {
    $styles .= 'padding-bottom: ' . get_field('padding_bottom') . get_field('padding_bottom_unit_type') . ';';
}
if ( get_field('margin_top') ) {
    $styles .= 'margin-top: ' . get_field('margin_top') . get_field('margin_top_unit_type') . ';';
}
if ( get_field('margin_bottom') ) {
    $styles .= 'margin-bottom: ' . get_field('margin_bottom') . get_field('margin_bottom_unit_type') . ';';
}
if ( get_field('title_color') ) {
    $title_styles .= 'color: ' . get_field('title_color') . ';';
}
if ( get_field('title_size') ) {
    $title_classes .= ' ' . get_field('title_size');
}
if ( get_field('title_transform') ) {
    $title_styles .= 'text-transform: ' . get_field('title_transform') . ';';
}
if ( get_field('subtitle_color') ) {
    $subtitle_styles .= 'color: ' . get_field('subtitle_color') . ';';
}
if ( get_field('subtitle_size') ) {
    $subtitle_classes .= ' ' . get_field('subtitle_size');
}
if ( get_field('blurb_color') ) {
    $blurb_styles .= 'color: ' . get_field('blurb_color') . ';';
}
if (get_field('blurb_size')) {
    $blurb_styles .= 'font-size: ' . get_field('blurb_size') . 'px;';
}
if ( get_field('text_align') ) {
    $title_styles .= 'text-align: ' . get_field('text_align') . ';';
    $subtitle_styles .= 'text-align: ' . get_field('text_align') . ';';
    $blurb_styles .= 'text-align: ' . get_field('text_align') . ';';
    $button_styles .= 'text-align: ' . get_field('text_align') . ';';
}
?>

<header class="asen-front-page-banner <?php echo $container_classes; ?>"
    <?php echo ($styles != '' ? 'style="' . $styles . '"' : ''); ?>>
    <?php if ($slider && $total_slides > 0) : ?>
    <div class="slider<?php if (get_field('slider_options') === 'text') echo ' has-text'; ?>">
        <?php foreach ($slides as $index => $slide_row) : 
            $image = $slide_row['image'];
            $title = $slide_row['title'];
            $subtitle = $slide_row['subtitle'];
            $blurb = $slide_row['blurb'];
            ?>
        <div class="slide<?php if ($index === 0) echo ' active'; ?>" data-id="<?php echo $index; ?>">
            <?php echo wp_get_attachment_image($image, 'full'); ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if ( get_field('background_image') && !$slider ) : ?>
    <div class=" image"
        <?php echo ($background_image_styles != '' ? 'style="' . $background_image_styles . '"' : ''); ?>>
        <?php echo wp_get_attachment_image( get_field('background_image'), $thumb_size ); ?>
    </div>
    <?php endif; ?>
    <?php if (
        (get_field('background_desktop_video') ||
        get_field('background_desktop_video_webm') ||
        get_field('background_mobile_video') ||
        get_field('background_mobile_video_webm')) && !get_field('enable_slider')
    ) : ?>
    <div class="background-video">
        <video autoplay muted loop playsinline></video>
    </div>
    <?php endif; ?>
    <?php if ( get_field('background_overlay_color') ) : ?>
    <div class="background-overlay"
        <?php echo ($background_overlay_styles != '' ? 'style="' . $background_overlay_styles . '"' : ''); ?>></div>
    <?php endif; ?>
    <div class="inside">
        <div class="copy">
            <?php if ( get_field('title') ) : ?>
            <h1 class="<?php echo $title_classes ; ?>"
                <?php echo ($title_styles != '' ? 'style="' . $title_styles . '"' : ''); ?>>
                <?php the_field('title'); ?>
            </h1>
            <?php endif; ?>
            <?php if (get_field('subtitle')) : ?>
            <h2 class="<?php echo $subtitle_classes; ?>"
                <?php echo ($subtitle_styles != '' ? 'style="' . $subtitle_styles . '"' : ''); ?>>
                <?php the_field('subtitle'); ?>
            </h2>
            <?php endif; ?>
            <?php if ( get_field('blurb') ) : ?>
            <p <?php echo ($blurb_styles != '' ? 'style="' . $blurb_styles . '"' : ''); ?>>
                <?php the_field('blurb'); ?>
            </p>
            <?php endif; ?>
        </div>
        <?php if (
            get_field('button_1_wp_link') && get_field('button_1_text') || get_field('button_1_text_link') && get_field('button_1_text') ||
            get_field('button_2_wp_link') && get_field('button_2_text') || get_field('button_2_text_link') && get_field('button_2_text')
        ) : ?>
        <div class="buttons" <?php echo ($button_styles != '' ? 'style="' . $button_styles . '"' : ''); ?>>
            <?php if (get_field('button_1_wp_link') && get_field('button_1_text') || get_field('button_1_text_link') && get_field('button_1_text')) : ?>
            <?php
                        $button_1_link = (get_field('button_1_link_type') == true ? get_field('button_1_text_link') : get_field('button_1_wp_link'));
                    ?>
            <a class="button button-1" href="<?php echo $button_1_link; ?>" title="<?php the_field('button_1_text'); ?>"
                <?php echo (get_field('button_1_target') == '_blank' ? 'target="_blank"' : ''); ?>>
                <?php the_field('button_1_text'); ?>
            </a>
            <?php endif; ?>
            <?php if (get_field('button_2_wp_link') && get_field('button_2_text') || get_field('button_2_text_link') && get_field('button_2_text')) : ?>
            <?php
                        $button_2_link = (get_field('button_2_link_type') == true ? get_field('button_2_text_link') : get_field('button_2_wp_link'));
                    ?>
            <a class="button button-2" href="<?php echo $button_2_link; ?>" title="<?php the_field('button_2_text'); ?>"
                <?php echo (get_field('button_2_target') == '_blank' ? 'target="_blank"' : ''); ?>>
                <?php the_field('button_2_text'); ?>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</header>
<?php if ((
    get_field('background_desktop_video') ||
    get_field('background_desktop_video_webm') ||
    get_field('background_mobile_video') ||
    get_field('background_mobile_video_webm')) && !$slider
) :
    $video_desktop_mp4 = get_field('background_desktop_video');
    $video_desktop_webm = get_field('background_desktop_video_webm');
    $video_mobile_mp4 = get_field('background_mobile_video');
    $video_mobile_webm = get_field('background_mobile_video_webm');

    $video_desktop_mp4_meta = wp_get_attachment_metadata( $video_desktop_mp4 );
    $video_desktop_webm_meta = wp_get_attachment_metadata( $video_desktop_webm );
    $video_mobile_mp4_meta = wp_get_attachment_metadata( $video_mobile_mp4 );
    $video_mobile_webm_meta = wp_get_attachment_metadata( $video_mobile_webm );
?>
<script defer>
(function($) {
    "use strict";
    var windowObject = $(window),
        documentObject = $(document),
        container = $('.asen-front-page-banner'),
        videoObject = container.find('video'),
        videoDesktop = '',
        videoMobile = '',
        videoDesktopMP4 = {
            src: '<?php echo wp_get_attachment_url( $video_desktop_mp4 ); ?>',
            type: '<?php echo $video_desktop_mp4_meta['mime_type']; ?>'
        },
        videoDesktopWebM = {
            src: '<?php echo wp_get_attachment_url( $video_desktop_webm ); ?>',
            type: '<?php echo $video_desktop_webm_meta['mime_type']; ?>'
        },
        videoMobileMP4 = {
            <?php if ( get_field('background_mobile_video') ) : ?>
            src: '<?php echo wp_get_attachment_url( $video_mobile_mp4 ); ?>',
            type: '<?php echo $video_mobile_mp4_meta['mime_type']; ?>'
            <?php endif; ?>
        },
        videoMobileWebM = {
            <?php if ( get_field('background_mobile_video_webm') ) : ?>
            src: '<?php echo wp_get_attachment_url( $video_mobile_webm ); ?>',
            type: '<?php echo $video_mobile_webm_meta['mime_type']; ?>'
            <?php endif; ?>
        };

    documentObject.on("ready", function() {
        <?php if ( get_field('background_mobile_video') || get_field('background_mobile_video_webm') ) : ?>if
            (windowObject.width() > 800) {
                <?php endif; ?>
                <?php if ( get_field('background_desktop_video_webm') ) : ?>
                videoObject.append("<source type='video/webm' src='" + videoDesktopWebM.src + "' />");
                <?php endif; ?>
                <?php if ( get_field('background_desktop_video') ) : ?>
                videoObject.append("<source type='video/mp4' src='" + videoDesktopMP4.src + "' />");
                <?php endif; ?>
                <?php if ( get_field('background_mobile_video') || get_field('background_mobile_video_webm') ) : ?>
            } else {
                <?php if ( get_field('background_mobile_video_webm') ) : ?>
                videoObject.append("<source type='video/webm' src='" + videoMobileWebM.src + "' />");
                <?php endif; ?>
                <?php if ( get_field('background_mobile_video') ) : ?>
                videoObject.append("<source type='video/mp4' src='" + videoMobileMP4.src + "' />");
                <?php endif; ?>
            }
        <?php endif; ?>
    });

    videoObject[0].addEventListener('loadeddata', function() {
        videoObject.addClass('is-active');
    });
})(jQuery);
</script>
<?php endif; ?>


<?php if ($slider && $total_slides > 1) : ?>
<script defer>
(function($) {
    var slides = $('.slide'),
        currentSlide = 0,
        prevSlide = slides.length - 1
    timer = null

    timer = setInterval(function() {
        slides.removeClass('active')
        prevSlide = currentSlide
        currentSlide++
        if (currentSlide === slides.length) {
            currentSlide = 0
            prevSlide = slides.length - 1
        }
        slides.eq(prevSlide).addClass('previous')
        slides.eq(currentSlide).addClass('active')

        setTimeout(function() {
            slides.removeClass('previous')
        }, 500)
    }, 4000)
})(jQuery)
</script>
<?php endif; ?>