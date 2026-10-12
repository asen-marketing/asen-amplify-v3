<?php
    /* Block Name: Asen Intro Block */

    if (is_admin()) {
    echo '<h3 class="asen-block-heading">Asen Intro Block</h3>';
    }

    // Fields
    $icon         = get_field('icon');
    $heading      = get_field('heading');
    $subheading   = get_field('subheading');
    $blurb        = get_field('blurb');
    $align_center = get_field('align_center');
    $cta_options  = get_field('cta_options');
    $cta_links    = get_field('cta_links');
    $has_cta      = false;

    $cta_classes = '';

    if ('buttons' === $cta_options) {
    $cta_classes = 'button button-small';
    } elseif ('text' === $cta_options) {
    $cta_classes = 'text-link';
    } elseif ('icon' === $cta_options) {
    $cta_classes = 'text-icon-link';
    }

    $cta_link_1 = null;
    $cta_link_2 = null;
    $link_icon  = null;

    if (is_array($cta_links) && ! empty($cta_links[0])) {
    $cta_link_1 = $cta_links[0]['link_1'] ?? null;
    $cta_link_2 = $cta_links[0]['link_2'] ?? null;
    $link_icon  = $cta_links[0]['link_icon'] ?? null;
    }

    $has_cta = $cta_link_1 || $cta_link_2;

    // Tokens
    $container_width = get_field('__container_width');
    $top_padding     = get_field('top_padding')['__spacing'] ?? null;
    $bottom_padding  = get_field('bottom_padding')['__spacing'] ?? null;
    $text_spacing    = get_field('text_spacing')['__gap'] ?? null;
    $text_size       = get_field('__font_size');

    $classes = [
    'asen-intro-block',
    'asen-intro-block-' . $block['id'],
    $align_center ? 'align-center' : '',
    $container_width ? 'block-width-' . $container_width : '',
    $top_padding ? 'spacing-top-' . $top_padding : '',
    $bottom_padding ? 'spacing-bottom-' . $bottom_padding : '',
    $text_spacing ? 'asen-intro-block--text-spacing-' . $text_spacing : '',
    $text_size ? 'asen-intro-block--text-' . $text_size : '',
    ];

    if (! empty($block['className'])) {
    $classes[] = $block['className'];
    }
?>

<section class="<?php echo implode(' ', array_filter($classes)); ?>"
    id="<?php echo esc_attr($block['anchor'] ?? ''); ?>">
    <div class="inside">
        <?php if ($icon): ?>
        <div class="icon-container">
            <?php echo $icon; ?>
        </div>
        <?php endif; ?>

        <?php if ($heading): ?>
        <h2 class="heading">
            <?php echo $heading; ?>
        </h2>
        <?php endif; ?>

        <?php if ($subheading): ?>
        <p class="subheading">
            <?php echo $subheading; ?>
        </p>
        <?php endif; ?>

        <?php if ($blurb): ?>
        <div class="blurb-container">
            <p class="blurb">
                <?php echo $blurb; ?>
            </p>
        </div>
        <?php endif; ?>

        <?php if ($has_cta): ?>
        <div class="link-container">
            <?php if ($cta_link_1): ?>
            <a href="<?php echo $cta_link_1['url']; ?>" class="<?php echo $cta_classes; ?>"
                target="<?php echo $cta_link_1['target'] ?? '_self'; ?>" title="<?php echo $cta_link_1['title']; ?>">
                <?php echo $cta_link_1['title']; ?>

                <?php if (isset($link_icon) && 'icon' === $cta_options) {echo $link_icon;} ?>
            </a>
            <?php endif; ?>

            <?php if ($cta_link_2): ?>
            <a href="<?php echo $cta_link_2['url']; ?>" class="<?php echo $cta_classes; ?>"
                target="<?php echo $cta_link_2['target'] ?? '_self'; ?>" title="<?php echo $cta_link_2['title']; ?>">
                <?php echo $cta_link_2['title']; ?>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>