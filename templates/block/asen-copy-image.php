<?php
/**
 * Block Name: Asen Copy + Image
 *
 * Split block with copy on one side and image on the other.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$rows = get_field('copy_image_rows');
$cta_options = get_field('cta_options');
$cta = get_field('cta_link');
$cta_styles = get_field('cta_styles');

if (is_array($cta_styles)) {
    if (isset($cta_styles[0]['background_color'])) {
        $cta_bg = $cta_styles[0]['background_color'];
    }
    if (isset($cta_styles[0]['background_hover_color'])) {
        $cta_bg_hover = $cta_styles[0]['background_hover_color'];
    }
    if (isset($cta_styles[0]['text_color'])) {
        $cta_text_color = $cta_styles[0]['text_color'];
    }
    if (isset($cta_styles[0]['text_hover_color'])) {
        $cta_text_hover_color = $cta_styles[0]['text_hover_color'];
    }
    if (isset($cta_styles[0]['icon'])) {
        $cta_icon = $cta_styles[0]['icon'];
    }
}
?>


<section class="asen-copy-image asen-copy-image-<?php echo $block['id']; echo $className; ?>">
    <div class="inside" style="<?php echo 'max-width: ' . get_field('block_max_width') . 'px;'; ?>">
        <?php if ($rows) : ?>
        <?php foreach( $rows as $row ) : ?>
        <div class="item">
            <div class="image-container">
                <?php echo wp_get_attachment_image($row['image'], 'full'); ?>
            </div>
            <div class="copy-container">
                <h2
                    class="<?php if (get_field('heading_text_transform')) echo get_field('heading_text_transform'); echo ' ' . get_field('heading_font_style') ?>">
                    <?php echo $row['heading']; ?></h2>
                <p class="<?php echo get_field('copy_font_style'); ?>"><?php echo $row['copy']; ?></p>
                <?php if ($cta_options) : ?>
                <a class="<?php if ($cta_options === 'button') echo 'button button-small'; ?>"
                    href="<?php echo $cta['url']; ?>" title="<?php echo $cta['title']; ?>"
                    target="<?php echo $cta['target']; ?>">
                    <?php echo $cta['title']; ?>
                    <?php if ($cta_options === 'icon') : ?>
                    <?php if (isset($cta_icon)) : ?>
                    <?php echo $cta_icon; ?>
                    <?php else : ?>
                    <i class="fa-regular fa-circle-plus"></i>
                    <?php endif; ?>
                    <?php endif; ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php
$heading_size = get_field('heading_size');
$copy_size = get_field('copy_size');
?>

<style>
.asen-copy-image-<?php echo $block['id'];

?> {
    .inside .item {

        <?php if (get_field('gap_size')): ?> gap: <?php echo get_field('gap_size') . 'rem';
        ?>;

        @media (max-width: 1200px) {
            gap: <?php echo get_field('gap_size') * 0.75 . 'rem';
            ?>;
        }

        @media (max-width: 768px) {
            gap: <?php echo get_field('gap_size') * 0.5 . 'rem';
            ?>;
        }

        <?php endif;

        ?>.image-container {
            max-width: <?php if (get_field('image_width')) echo get_field('image_width') . '%';
            ?>;

            @media (max-width: 768px) {
                max-width: 100%;
            }
        }


        .copy-container {
            width: <?php if (get_field('image_width')) echo 100 - get_field('image_width') . '%';
            ?>;

            h2 {
                font-size: <?php if (isset($heading_size)) echo $heading_size . 'px';
                ?>;
                color: <?php echo get_field('heading_color');
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

            p {
                font-size: <?php if (isset($copy_size)) echo $copy_size . 'px';
                ?>;
                color: <?php echo get_field('copy_color');
                ?>;

                <?php if (isset($copy_size) && $copy_size > 25) {
                    $copy_size=round($copy_size * 0.85);
                }

                ?>@media (max-width: 1024px) {
                    font-size: <?php if (isset($copy_size)) echo $copy_size . 'px';
                    ?>;
                }

                <?php if (isset($copy_size) && $copy_size > 25) {
                    $copy_size=round($copy_size * 0.85);
                }

                ?>@media (max-width: 640px) {
                    font-size: <?php if (isset($copy_size)) echo $copy_size . 'px';
                    ?>;
                }
            }

            a {
                color: <?php if (isset($cta_text_color)) echo $cta_text_color;
                ?>
            }

            a:hover {
                color: <?php if (isset($cta_text_hover_color)) echo $cta_text_hover_color;
                ?>
            }

            a.button {
                background-color: <?php if (isset($cta_bg)) echo $cta_bg;
                ?>
            }

            a.button:hover {
                background-color: <?php if (isset($cta_bg_hover)) echo $cta_bg_hover;
                ?>
            }

            @media (max-width: 768px) {
                width: 100%;
            }
        }
    }
}
</style>