<?php
/**
 * Block Name: Asen Mailing List
 *
 * Displays mailing list form with heading and background.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$icon = get_field('icon_code');
$heading = get_field('heading');
$subheading = get_field('subheading');
$button_alignment = get_field('button_alignment');

$icon_color = get_field('icon_color');
$icon_size = get_field('icon_size');
$heading_color = get_field('heading_color');
$heading_size = get_field('heading_size');
$subheading_color = get_field('subheading_color');
$subheading_size = get_field('subheading_size');

$button_colors = get_field('button_colors');
$button_bg = $button_colors[0]['background_color'];
$button_bg_hover = $button_colors[0]['background_hover_color'];
$button_text_color = $button_colors[0]['text_color'];
$button_text_hover_color = $button_colors[0]['text_hover_color'];

$background_options = get_field('background_options');
$background_color = get_field('background_color');
$background_image = get_field('background_image');
?>

<section
    class="asen-mailing-list asen-mailing-list-<?php echo $block['id']; echo $className; ?><?php echo ' background-' . $background_options; ?>"
    id="<?php echo $block['anchor']; ?>">
    <div class="inside" style="<?php echo 'max-width: ' . get_field('block_max_width') . 'px;'; ?>">
        <div class="heading-container">
            <?php if ($icon) echo $icon; ?>
            <?php if ($heading) : ?>
            <h2 class="<?php if (get_field('heading_text_transform')) echo get_field('heading_text_transform'); ?>">
                <?php echo $heading; ?></h2>
            <?php endif; ?>
            <?php if ($subheading) : ?>
            <p
                class="subheading <?php if (get_field('subheading_text_transform')) echo get_field('subheading_text_transform'); ?>">
                <?php echo $subheading; ?></p>
            <?php endif; ?>
        </div>
        <div class="form-container <?php echo $button_alignment; ?>">
            <?php echo do_shortcode('[gravityform id="1" title="false"]'); ?>
        </div>
    </div>
    <?php if ($background_options === 'image' || $background_options === 'pattern') : ?>
    <div class="background-container <?php echo $background_options; ?>"
        style="<?php if ($background_options === 'pattern') echo 'background-image: url(' . wp_get_attachment_image_url($background_image, 'full') . ');'; ?>">
        <?php if ($background_options === 'image') echo wp_get_attachment_image($background_image, 'full'); ?>
    </div>
    <?php endif; ?>
</section>

<style>
.asen-mailing-list-<?php echo $block['id'];

?> {
    <?php $top_padding=get_field('top_padding');
    $bottom_padding=get_field('bottom_padding');
    $top_margin=get_field('top_margin');
    $bottom_margin=get_field('bottom_margin');

    if ($top_padding) {
        echo 'padding-top: '. $top_padding . 'px;';
        echo '@media (max-width: 1440px) {padding-top: '. $top_padding * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {padding-top: '. $top_padding * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {padding-top: '. $top_padding * 0.55 . 'px;}';
    }

    if ($bottom_padding) {
        echo 'padding-bottom: '. $bottom_padding . 'px;';
        echo '@media (max-width: 1440px) {padding-bottom: '. $bottom_padding * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {padding-bottom: '. $bottom_padding * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {padding-bottom: '. $bottom_padding * 0.55 . 'px;}';
    }

    if ($top_margin) {
        echo 'margin-top: '. $top_margin . 'px;';
        echo '@media (max-width: 1440px) {margin-top: '. $top_margin * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {margin-top: '. $top_margin * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {margin-top: '. $top_margin * 0.55 . 'px;}';
    }

    if ($bottom_margin) {
        echo 'margin-bottom: '. $bottom_margin . 'px;';
        echo '@media (max-width: 1440px) {margin-bottom: '. $bottom_margin * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {margin-bottom: '. $bottom_margin * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {margin-bottom: '. $bottom_margin * 0.55 . 'px;}';
    }

    ?>.heading-container {
        i {
            color: <?php echo $icon_color;
            ?>;
            font-size: <?php echo $icon_size . 'px';
            ?>;

            <?php if ($icon_size && $icon_size > 25) {
                $icon_size=round($icon_size * 0.85);
            }

            ?>@media (max-width: 640px) {
                font-size: <?php echo $icon_size . 'px';
                ?>;
            }
        }

        h2 {
            color: <?php echo $heading_color;
            ?>;
            font-size: <?php echo $heading_size . 'px';
            ?>;

            <?php if (isset($heading_size) && $heading_size > 40) {
                $heading_size=round($heading_size * 0.85);
            }

            ?>@media (max-width: 1024px) {
                font-size: <?php if (isset($heading_size)) echo $heading_size . 'px';
                ?>;
            }

            <?php if (isset($heading_size) && $heading_size > 40) {
                $heading_size=round($heading_size * 0.8);
            }

            ?>@media (max-width: 640px) {
                font-size: <?php if (isset($heading_size)) echo $heading_size . 'px';
                ?>;
            }
        }

        p.subheading {
            color: <?php echo $subheading_color;
            ?>;
            font-size: <?php echo $subheading_size . 'px';
            ?>;

            <?php if (isset($subheading_size) && $subheading_size > 25) {
                $subheading_size=round($subheading_size * 0.85);
            }

            ?>@media (max-width: 1024px) {
                font-size: <?php if (isset($subheading_size)) echo $subheading_size . 'px';
                ?>;
            }

            <?php if (isset($subheading_size) && $subheading_size > 25) {
                $subheading_size=round($subheading_size * 0.85);
            }

            ?>@media (max-width: 640px) {
                font-size: <?php if (isset($subheading_size)) echo $subheading_size . 'px';
                ?>;
            }
        }
    }

    .gform_wrapper .gform_footer input[type="submit"] {
        background-color: <?php echo $button_bg;
        ?>;
        color: <?php echo $button_text_color;
        ?>;
    }

    .gform_wrapper .gform_footer input[type="submit"]:hover {
        background-color: <?php echo $button_bg_hover;
        ?>;
        color: <?php echo $button_text_hover_color;
        ?>;
    }
}

.asen-mailing-list-<?php echo $block['id'];

?>.background-color,
.asen-mailing-list-<?php echo $block['id'];

?>.background-pattern {
    background-color: <?php echo $background_color;
    ?>;
}
</style>