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
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<style>
.asen-copy-image-<?php echo $block['id'];

?> {
    .inside .item {

        .image-container {
            max-width: <?php echo get_field('image_width') . '%';
            ?>;

            @media (max-width: 768px) {
                max-width: 100%;
            }
        }

        .copy-container {
            width: <?php echo 100 - get_field('image_width') . '%';
            ?>;

            h2 {
                font-size: <?php echo get_field('heading_size') . 'px';
                ?>;
                color: <?php echo get_field('heading_color');
                ?>;
            }

            p {
                font-size: <?php echo get_field('copy_size') . 'px';
                ?>;
                color: <?php echo get_field('copy_color');
                ?>;
            }

            @media (max-width: 768px) {
                width: 100%;
            }
        }
    }
}
</style>