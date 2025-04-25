<?php
/**
 * Block Name: Asen Buttons Group
 *
 * Buttons grouped in a container for control.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if ( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
$styles = '';

?>
<?php if ( !have_rows('buttons') && is_admin() ) : ?>
    <p>Add buttons!</p>
<?php endif; ?>
<?php if ( !is_admin() ) : ?>
<section
    class="asen-buttons-group buttons-group-<?php echo $block['id']; echo $className; ?>"
    <?php echo ($styles != '' ? 'style="' . $styles . '"' : ''); ?>
>
<?php endif; ?>
    <?php while ( have_rows('buttons') ) : the_row();
        $button_link = (get_sub_field('use_custom_url') == true ? get_sub_field('text_link') : get_the_permalink(get_sub_field('wp_link')));
    ?>
        <a class="button asen-button <?php the_sub_field('custom_classes'); ?>"
            href="<?php echo $button_link; ?>"
            title="<?php the_sub_field('text'); ?>"
            <?php echo (get_sub_field('target') == '_blank' ? 'target="_blank"' : ''); ?>
        >
            <?php if ( get_sub_field('text') ) : the_sub_field('text'); else : echo 'ADD BUTTON TEXT'; endif; ?>
        </a>
    <?php endwhile; ?>
<?php if ( !is_admin() ) : ?>
</section>
<?php endif; ?>