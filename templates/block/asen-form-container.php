<?php
/**
 * Block Name: Asen Form Container
 * 
 * Container for displaying a GF form with heading.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$heading = get_field('heading');
$subheading = get_field('subheading');
$form = get_field('gravity_forms_shortcode');

$button_colors = get_field('button_colors');
$button_bg = $button_colors[0]['background_color'];
$button_text = $button_colors[0]['text_color'];
$button_hover_bg = $button_colors[0]['background_hover_color'];
$button_hover_text = $button_colors[0]['text_hover_color'];
?>

<section class="asen-form-container asen-form-container-<?php echo $block['id']; echo $className; ?>"
    id="<?php echo $block['anchor']; ?>">
    <div class="inside" style="<?php echo 'max-width: ' . get_field('block_max_width') . 'px;'; ?>">
        <div class="heading-container">
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
        <div class="form-container">
            <?php if ($form) {
                echo do_shortcode($form);
            } else {
                echo do_shortcode('[gravityform id="2" title="false"]'); 
            }
                ?>
        </div>
    </div>
</section>


<?php $heading_size = get_field('heading_size');
$subheading_size = get_field('subheading_size');
?>

<style>
.asen-form-container-<?php echo $block['id'];

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
        h2 {
            color: <?php echo get_field('heading_color');
            ?>;
            font-size: <?php echo get_field('heading_size') . 'px';

            ?><?php if (isset($heading_size) && $heading_size > 40) {
                $heading_size=round($heading_size * 0.85);
            }

            ?>;

            @media (max-width: 1024px) {
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
            color: <?php echo get_field('subheading_color');
            ?>;
            font-size: <?php echo get_field('subheading_size') . 'px';

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

    .gform_body {
        label {
            color: <?php echo get_field('label_color');
            ?>;
            font-size: <?php echo get_field('label_size') . 'px';
            ?> !important;

            <?php if (get_field('label_text_transform')) {
                echo 'text-transform: '. get_field('label_text_transform') . ';';
            }

            ?>
        }

        span.gfield_required {
            color: <?php echo get_field('required_indicator_color');
            ?>
        }
    }

    .gform_footer {
        .gform_button {
            color: <?php echo $button_text;
            ?>;
            background-color: <?php echo $button_bg;
            ?>;

            <?php if (get_field('button_alignment')==='center') {
                echo 'margin: auto;';
            }

            if (get_field('button_alignment')==='full') {
                echo 'width: 100%;';
            }

            ?>
        }

        .gform_button:hover {
            color: <?php echo $button_hover_text;
            ?>;
            background-color: <?php echo $button_hover_bg;
            ?>;
        }
    }
}
</style>