<?php
/**
 * Block Name: Asen CTA
 *
 * A CTA paragraph row that can be used anywhere.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
$styles = '';
$copyClassName = '';
$copyStyles = '';
if ( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if ( get_field('background_style') && get_field('background_style') != 'custom' ) {
    $className .= ' ' . get_field('background_style');
}
if ( get_field('custom_background_color') && get_field('background_style') == 'custom' ) {
    $styles .= 'background-color:' . get_field('custom_background_color') . ';';
}
if ( get_field('copy_style') && get_field('copy_style') != 'custom'  ) {
    $copyClassName .= ' ' . get_field('copy_style');
}
if ( get_field('custom_copy_style') && get_field('copy_style') == 'custom' ) {
    $copyStyles .= 'color:' . get_field('custom_copy_style') . ';';
}

?>
<?php if ( !is_admin() ) : ?>
<section
    class="asen-cta asen-cta-<?php echo $block['id']; echo $className; ?>"
    <?php echo ($styles != '' ? 'style="' . $styles . '"' : ''); ?>
>
    <div class="inside">
<?php endif; ?>
        <div 
            class="copy <?php echo $copyClassName; ?> text-enlarge" 
            <?php echo ($copyStyles != '' ? 'style="' . $copyStyles . '"' : ''); ?>
        >
            <?php echo apply_filters( 'the_content', get_field('copy') ); ?>
        </div>
        <?php if ( have_rows('buttons') ) : ?>
            <div class="buttons">
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
            </div>
        <?php endif; ?>

        <?php if ( get_field('form_code') ) : ?>
        <div class="form-container knockout-white-form">
            <?php echo apply_filters( 'the_content', get_field('form_code') ); ?>
        </div>
        <?php endif; ?>

<?php if ( !is_admin() ) : ?>
    </div>
</section>
<?php endif; ?>