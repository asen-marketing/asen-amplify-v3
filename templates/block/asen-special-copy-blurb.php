<?php
/**
 * Block Name: Asen Special Copy Blurb
 *
 * Blurb with styled copy and icon. 
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$icon = get_field('icon');
$icon_size = get_field('icon_size');
$icon_color = get_field('icon_color');
$blurb = get_field('blurb');
$blurb_size = get_field('blurb_font_size');
$blurb_color = get_field('blurb_text_color');
$blurb_weight = get_field('blurb_font_weight');
$blurb_transform = get_field('blurb_text_transform');
$blurb_style = get_field('blurb_text_style');

$link_options = get_field('cta_options');
$links = get_field('cta_links');
$link_1 = $links[0]['link_1'];
$link_2 = $links[0]['link_2'];
$link_icon = $links[0]['link_icon'];

$align_center = get_field('align_center');
$link_colors = get_field('link_colors');
$text_color = $link_colors[0]['text_color'];
$text_hover_color = $link_colors[0]['text_hover_color'];
$background_color = $link_colors[0]['button_background_color'];
$background_hover_color = $link_colors[0]['button_background_hover_color'];
?>
<section
    class="asen-special-copy-blurb asen-special-copy-blurb-<?php echo $block['id']; echo $className; ?><?php echo get_field('full_width') ? ' full-width' : ' fixed-width'; ?><?php if ($align_center) echo ' align-center'; ?>">
    <div class="inside" style="<?php echo 'max-width: ' . get_field('block_max_width') . 'px;'; ?>">
        <?php if( $icon ) : ?>
        <div class="icon-container">
            <?php echo $icon; ?>
        </div>
        <?php endif; ?>
        <div class="blurb-container">
            <p class="blurb"
                style="color: <?php echo $blurb_color; ?>; font-weight: <?php echo $blurb_weight; ?>; text-transform: <?php echo $blurb_transform; ?>; font-style: <?php echo $blurb_style; ?>;">
                <?php echo $blurb; ?>
            </p>
        </div>
        <?php if( $link_options ) : ?>
        <div class="link-container">
            <?php if( $link_1 ) : ?>
            <a href="<?php echo $link_1['url']; ?>"
                class="<?php if ($link_options === 'buttons') echo 'button button-small'; if ($link_options === 'text') echo 'text-link'; if ($link_options === 'icon') echo 'text-icon-link'; ?>">
                <?php echo $link_1['title']; ?><?php if ($link_icon && $link_options === 'icon') echo $link_icon; ?>
            </a>
            <?php endif; ?>
            <?php if( $link_2 ) : ?>
            <a href="<?php echo $link_2['url']; ?>" class="button button-small">
                <?php echo $link_2['title']; ?>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
</section>

<style>
.asen-special-copy-blurb-<?php echo $block['id'];

?> {

    p.blurb {
        font-size: <?php echo $blurb_size . 'px';
        ?>;

        <?php if ($blurb_size && $blurb_size > 25) {
            $blurb_size=round($blurb_size * 0.85);
        }

        ?>@media (max-width: 1024px) {
            font-size: <?php echo $blurb_size . 'px';
            ?>;
        }

        <?php if ($blurb_size && $blurb_size > 25) {
            $blurb_size=round($blurb_size * 0.85);
        }

        ?>@media (max-width: 640px) {
            font-size: <?php echo $blurb_size . 'px';
            ?>;
        }

    }

    .icon-container i {
        font-size: <?php echo $icon_size . 'px';
        ?>;
        color: <?php echo $icon_color;
        ?>;

        <?php if ($icon_size && $icon_size > 25) {
            $icon_size=round($icon_size * 0.85);
        }

        ?>@media (max-width: 640px) {
            font-size: <?php echo $icon_size . 'px';
            ?>;
        }
    }

    .link-container a {
        color: <?php echo $text_color;
        ?>;
    }

    .link-container a:hover {
        color: <?php echo $text_hover_color;
        ?>;
    }

    .link-container a.button {
        background-color: <?php echo $background_color;
        ?>;
    }

    .link-container a.button:hover {
        background-color: <?php echo $background_hover_color;
        ?>;
    }
}
</style>