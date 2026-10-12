<?php
/**
 * Block Name: Asen Button
 *
 * A basic button with no container. Because.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
$styles = '';
if ( get_field('margin_top') ) {
    $styles .= 'margin-top: ' . get_field('margin_top') . get_field('margin_top_unit_type') . ';';
}
if ( get_field('margin_right') ) {
    $styles .= 'margin-right: ' . get_field('margin_right') . get_field('margin_right_unit_type') . ';';
}
if ( get_field('margin_bottom') ) {
    $styles .= 'margin-bottom: ' . get_field('margin_bottom') . get_field('margin_bottom_unit_type') . ';';
}
if ( get_field('margin_left') ) {
    $styles .= 'margin-left: ' . get_field('margin_left') . get_field('margin_left_unit_type') . ';';
}
$button_link = get_field('link');
?>
<?php if ( is_admin() ) : ?><div style="width: 100%;"><?php endif; ?>
    <?php if (
    !is_admin() && isset($button_link) ||
    is_admin()
) : ?>
    <a class="button asen-button asen-button-<?php echo $block['id']; echo $className; ?>"
        <?php echo ($styles != '' ? 'style="' . $styles . '"' : ''); ?> href="<?php echo $button_link['url']; ?>"
        title="<?php $button_link['title']; ?>" target="<?php echo $button_link['target']; ?>">
        <?php if ( isset($button_link['title']) ) : echo $button_link['title']; else : echo 'ADD BUTTON TEXT'; endif; ?>
    </a>
    <?php endif; ?>
    <?php if ( is_admin() ) : ?>
</div><?php endif; ?>