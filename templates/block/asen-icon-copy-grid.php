<?php
/**
 * Block Name: Asen Icon + Copy Grid
 *
 * A CTA grid made up of icons with headings and copy.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$link_type = get_field('link_type_options');
$link_styles = get_field('link_styles');
$link_color = $link_styles[0]['link_color'];
$link_hover_color = $link_styles[0]['link_hover_color'];
$background_color = $link_styles[0]['button_background_color'];
$background_hover_color = $link_styles[0]['button_background_hover_color'];
$link_icon = $link_styles[0]['link_icon'];
$heading_size = get_field('heading_size');

?>
<?php if ( have_rows('copy_text_blocks') ) : ?>
<section
    class="asen-icon-copy-grid asen-icon-copy-grid-<?php echo $block['id']; echo $className; ?><?php echo ' link-' . $link_type; ?><?php echo ' bg-style-' . get_field('background_options'); ?><?php if (get_field('rounded_corners')) echo ' rounded'; ?><?php if (get_field('alignment_options')) echo ' align-center'; ?>"
    id="<?php echo $block['anchor']; ?>">
    <div class="inside" style="<?php echo 'max-width: ' . get_field('block_max_width') . 'px;'; ?>">
        <div class="items">
            <?php while ( have_rows('copy_text_blocks') ) : the_row(); ?>
            <?php 
                    $link = get_sub_field('link');
                    if( $link &&  $link_type === 'invisible-link' ) : 
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                        ?>
            <a class="
    item<?php if(get_field('rounded_corners')) echo ' rounded'; ?><?php if(get_field('alignment_options')) echo ' align-center'; ?>"
                href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
                title="<?php echo esc_attr( $link_title ); ?>">
                <?php else : ?>
                <div
                    class="item<?php if(get_field('rounded_corners')) echo ' rounded'; ?><?php if(get_field('alignment_options')) echo ' align-center'; ?>">
                    <?php endif; ?>
                    <div class="top">
                        <?php if (get_sub_field('icon')) the_sub_field('icon'); ?>
                        <div class="copy">
                            <h4 class="<?php echo $heading_size; ?>"><?php the_sub_field('heading'); ?></h4>
                            <p><?php the_sub_field('copy'); ?></p>
                        </div>
                    </div>
                    <?php 
                        if( $link &&  $link_type !== 'invisible-link' && $link_type !== 'no-link' ) : 
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self';
                            ?>
                    <a class="<?php echo $link_type === 'button-link' ? 'button button-small' : 'asen-text-link'; ?>"
                        href="<?php echo esc_url( $link_url ); ?>"
                        target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?><?php if ($link_type === 'text-link') echo $link_icon; ?></a>
                    <?php endif; ?>
                    <?php 
                        if( $link &&  $link_type === 'invisible-link' ) : ?>
            </a>
            <?php else : ?>
        </div>
        <?php endif; ?>
        <?php endwhile; ?>
    </div>
    </div>
</section>
<?php endif; ?>

<style>
.asen-icon-copy-grid-<?php echo $block['id'];

?> {
    <?php $top_padding=get_field('top_padding');
    $bottom_padding=get_field('bottom_padding');
    $top_margin=get_field('top_margin');
    $bottom_margin=get_field('bottom_margin');


    if ($top_padding || $top_padding==0) {
        echo 'padding-top: '. $top_padding . 'px;';
        echo '@media (max-width: 1440px) {padding-top: '. $top_padding * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {padding-top: '. $top_padding * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {padding-top: '. $top_padding * 0.55 . 'px;}';
    }

    if ($bottom_padding || $bottom_padding==0) {
        echo 'padding-bottom: '. $bottom_padding . 'px;';
        echo '@media (max-width: 1440px) {padding-bottom: '. $bottom_padding * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {padding-bottom: '. $bottom_padding * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {padding-bottom: '. $bottom_padding * 0.55 . 'px;}';
    }

    if ($top_margin || $top_margin==0) {
        echo 'margin-top: '. $top_margin . 'px;';
        echo '@media (max-width: 1440px) {margin-top: '. $top_margin * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {margin-top: '. $top_margin * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {margin-top: '. $top_margin * 0.55 . 'px;}';
    }

    if ($bottom_margin || $bottom_margin==0) {
        echo 'margin-bottom: '. $bottom_margin . 'px;';
        echo '@media (max-width: 1440px) {margin-bottom: '. $bottom_margin * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {margin-bottom: '. $bottom_margin * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {margin-bottom: '. $bottom_margin * 0.55 . 'px;}';
    }

    ?>.inside {
        .items {

            .item.rounded {
                border-radius: <?php echo get_field('border_radius') . 'px';
                ?>;
            }

            .item {
                <?php if (get_field('background_options')==='color') {
                    echo 'background-color: '. get_field('background_color') . ';';
                }

                if (get_field('background_options')==='border') {
                    echo 'border: 3px solid'. get_field('border_color') . ';';
                }

                ?>h4,
                p {
                    color: <?php the_field('text_color');
                    ?>;
                }
            }

            i {
                color: <?php the_field('icon_color');
                ?>;
            }

            a.asen-text-link,
            a.button {
                color: <?php echo $link_color;
                ?>;

            }

            a.asen-text-link:hover,
            a.button:hover {
                color: <?php echo $link_hover_color;
                ?>;
            }

            a.button {
                background-color: <?php echo $background_color;
                ?>;
            }

            a.button:hover {
                background-color: <?php echo $background_hover_color;
                ?>;
            }
        }
    }
}
</style>