<?php

/**
 * Block Name: Asen Link Wrapper
 *
 * Warp block content in an <a> tag with this block.
 */

// Create class attribute allowing for custom "className" and "align" values.
$className = '';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
$link_object = get_field('link_object');
$link_url = '';
$link_title = '';
$link_target = '';
if ($link_object) {
    $link_url = $link_object['url'];
    $link_title = $link_object['title'];
    $link_target = $link_object['target'] ? $link_object['target'] : '_self';
    if (get_field('link_anchor')) {
        $link_url = $link_url . '#' . get_field('link_anchor');
    }
}

?>
<?php if (is_admin()) : ?>
    <div class="asen-link-wrapper asen-link-wrapper-<?php echo $block['id']; echo $className; ?>">
        <span class="block-label">Asen Link Wrapper: <?php echo $link_url; ?></span>
<?php else : ?>
        <a 
            href="<?php echo esc_url($link_url); ?>" 
            class="asen-link-wrapper asen-link-wrapper-<?php echo $block['id']; echo $className; ?>" 
            title="Follow this content to: <?php echo esc_html($link_title); ?>" 
            target="<?php echo esc_attr($link_target); ?>"
        >
<?php endif; ?>
        <InnerBlocks />
<?php if (is_admin()) : ?>
    </div>
<?php else : ?>
    </a>
<?php endif; ?>