<?php
    /**
 * Block Name: Asen Special Copy Blurb
 *
 * Blurb with styled copy and icon.
 */

    if (is_admin()) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
    }

    $className = '';

    if (! empty($block['className'])) {
    $className .= ' ' . $block['className'];
    }

    $icon            = get_field('icon');
    $icon_size       = get_field('icon_size');
    $icon_color      = get_field('icon_color');
    $blurb           = get_field('blurb');
    $blurb_size      = get_field('blurb_font_size');
    $blurb_color     = get_field('blurb_text_color');
    $blurb_weight    = get_field('blurb_font_weight');
    $blurb_transform = get_field('blurb_text_transform');
    $blurb_style     = get_field('blurb_text_style');

    $link_options = get_field('cta_options');
    $links        = get_field('cta_links');

    if (! empty($links) && is_array($links) && isset($links[0]) && is_array($links[0])) {
    $link_1    = $links[0]['link_1'] ?? null;
    $link_2    = $links[0]['link_2'] ?? null;
    $link_icon = $links[0]['link_icon'] ?? null;
    }

    $align_center = get_field('align_center');
    $link_colors  = get_field('link_colors');

    if (! empty($link_colors) && is_array($link_colors) && isset($link_colors[0]) && is_array($link_colors[0])) {
    $text_color             = $link_colors[0]['text_color'] ?? '';
    $text_hover_color       = $link_colors[0]['text_hover_color'] ?? '';
    $background_color       = $link_colors[0]['button_background_color'] ?? '';
    $background_hover_color = $link_colors[0]['button_background_hover_color'] ?? '';
    }

?>
<section class="asen-special-copy-blurb asen-special-copy-blurb-<?php echo $block['id'];
                                                                echo $className; ?><?php echo get_field('full_width') ? ' full-width' : ' fixed-width'; ?><?php
      if ($align_center) {
          echo ' align-center';
      }

  ?>" id="<?php echo $block['anchor']; ?>">
    <div class="inside" style="<?php echo 'max-width: ' . get_field('block_max_width') . 'px;'; ?>">
        <?php
        if ($icon): ?>
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
        <?php
        if ($link_options): ?>
        <div class="link-container">
            <?php
            if (isset($link_1)): ?>
            <a href="<?php echo $link_1['url']; ?>" class="<?php
             if ('buttons' === $link_options) {
                 echo 'button button-small';
             }

             if ('text' === $link_options) {
                 echo 'text-link';
             }

             if ('icon' === $link_options) {
                 echo 'text-icon-link';
             }

         ?>">
                <?php echo $link_1['title']; ?><?php
      if (isset($link_icon) && 'icon' === $link_options) {
          echo $link_icon;
      }

  ?>
            </a>
            <?php endif; ?>
            <?php
            if (isset($link_2)): ?>
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
    <?php $top_padding=get_field('top_padding');
    $bottom_padding=get_field('bottom_padding');
    $top_margin=get_field('top_margin');
    $bottom_margin=get_field('bottom_margin');

    if ($top_padding || 0==$top_padding) {
        echo 'padding-top: '. $top_padding . 'px;';
        echo '@media (max-width: 1440px) {padding-top: '. $top_padding * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {padding-top: '. $top_padding * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {padding-top: '. $top_padding * 0.55 . 'px;}';
    }

    if ($bottom_padding || 0==$bottom_padding) {
        echo 'padding-bottom: '. $bottom_padding . 'px;';
        echo '@media (max-width: 1440px) {padding-bottom: '. $bottom_padding * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {padding-bottom: '. $bottom_padding * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {padding-bottom: '. $bottom_padding * 0.55 . 'px;}';
    }

    if ($top_margin || 0==$top_margin) {
        echo 'margin-top: '. $top_margin . 'px;';
        echo '@media (max-width: 1440px) {margin-top: '. $top_margin * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {margin-top: '. $top_margin * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {margin-top: '. $top_margin * 0.55 . 'px;}';
    }

    if ($bottom_margin || 0==$bottom_margin) {
        echo 'margin-bottom: '. $bottom_margin . 'px;';
        echo '@media (max-width: 1440px) {margin-bottom: '. $bottom_margin * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {margin-bottom: '. $bottom_margin * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {margin-bottom: '. $bottom_margin * 0.55 . 'px;}';
    }

    ?>p.blurb {
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