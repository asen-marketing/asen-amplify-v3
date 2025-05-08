<?php 

if ( class_exists('ACF') === false ) return; 

if ( get_field('banner_disable') != true ) :

$eyebrow_classes = '';
$title_classes = '';
$subtitle_classes = '';

if ( get_field('page_banner_eyebrow_size', 'option') ) {
    $eyebrow_classes .= ' ' . get_field('page_banner_eyebrow_size', 'option');
}
if ( get_field('page_banner_title_size', 'option') ) {
    $title_classes .= ' ' . get_field('page_banner_title_size', 'option');
}
if ( get_field('page_banner_subtitle_size', 'option') ) {
    $subtitle_classes .= ' ' . get_field('page_banner_subtitle_size', 'option');
}


$eyebrow_text = '';
$title_text = '';
$subtitle_text = '';

if ( is_archive() ) {
    $post_type = get_post_type_object( get_post_type() );
    $archive_title = $post_type->label;
    $slug = $post_type->name;
    $singular_title = $post_type->labels->singular_name;

    if ( get_field($slug . '_archive_custom_title', 'option') ) {
        $title_text = get_field($slug . '_archive_custom_title', 'option');
    } else {
        $title_text = $archive_title;
    }
    if ( get_field( $slug . '_archive_custom_subtitle', 'option' ) ) {
        $subtitle_text = get_field($slug . '_archive_custom_subtitle', 'option');
    }
} elseif ( is_page() ) {
    if ( get_field('banner_eyebrow') ) {
        $eyebrow_text = get_field('banner_eyebrow');
    }
    if ( get_field('banner_title') ) {
        $title_text = get_field('banner_title');
    } else {
        $title_text = get_the_title();
    }
    if ( get_field('banner_subtitle') ) {
        $subtitle_text = get_field('banner_subtitle');
    }
}

?>

<header class="asen-page-banner">
    <?php if ( get_field('banner_background_image') ) : ?>
    <div class="background-image">
        <?php echo wp_get_attachment_image( get_field('banner_background_image'), 'asen-banner-general' ); ?>
    </div>
    <?php endif; ?>
    <?php if (get_field('banner_background_video')) : ?>
    <div class="background-video">
        <video src="<?php the_field('banner_background_video'); ?>" autoplay loop muted></video>
    </div>
    <?php endif; ?>
    <div class=" background-overlay">
    </div>
    <div class="inside<?php if (get_field('align_center')) echo ' align-center'; ?>">
        <div class="copy">
            <?php if ( $eyebrow_text ) : ?>
            <p class="eyebrow <?php echo $eyebrow_classes ; ?>">
                <?php echo $eyebrow_text; ?>
            </p>
            <?php endif; ?>
            <h1 class="<?php echo $title_classes ; ?>">
                <?php echo $title_text; ?>
            </h1>
            <?php if ( $subtitle_text ) : ?>
            <p class="subtitle <?php echo $subtitle_classes ; ?>">
                <?php echo $subtitle_text; ?>
            </p>
            <?php endif; ?>
        </div>

        <?php
            $button_1 = get_field('button_1');
            $button_2 = get_field('button_2');

            if ($button_1) : 
            ?>
        <div class="button-container<?php if (get_field('align_center')) echo ' align-center'; ?>">
            <a class="button" href="<?php echo $button_1['url']; ?>" title="<?php echo $button_1['title']; ?>"
                target="<?php echo $button_1['target']; ?>">
                <?php echo $button_1['title']; ?>
            </a>
            <?php if ($button_2) : ?>
            <a class="button" href="<?php echo $button_2['url']; ?>" title="<?php echo $button_2['title']; ?>"
                target="<?php echo $button_2['target']; ?>">
                <?php echo $button_2['title']; ?>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</header>
<?php endif; ?>

<style>
.asen-page-banner {
    background-color: <?php the_field('banner_background_color');
    ?>;

    .inside {
        .copy {

            p,
            h1 {
                color: <?php the_field('banner_text_color');
                ?>;
            }
        }

        .button-container .button {
            background-color: <?php the_field('button_background_color');
            ?>;
            color: <?php the_field('button_text_color');
            ?>;
        }
    }
}
</style>