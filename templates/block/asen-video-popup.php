<?php
/**
 * Block Name: Asen - Video Popup
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$hosting         = get_field( 'hosting_options' ) ?: 'youtube';
$youtube_id      = 'youtube' === $hosting ? asen_youtube_id( (string) get_field( 'youtube_video_id' ) ) : '';
$video_file      = 'internal' === $hosting ? get_field( 'video_file' ) : '';
$teaser          = get_field( 'teaser_options' ) ?: 'image';
$teaser_image    = get_field( 'teaser_image' );
$teaser_video    = get_field( 'teaser_video' );
$container_width = get_field( '__container_width' ) ?: 'xl';
$has_video       = $youtube_id || $video_file;
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => 'asen-video-popup block-width-' . $container_width ) ); ?>>
    <div class="inside">
        <div class="teaser">
            <?php if ( 'video' === $teaser && $teaser_video ) : ?>
            <video src="<?php echo esc_url( $teaser_video ); ?>" muted autoplay loop playsinline></video>
            <?php elseif ( $teaser_image ) : ?>
            <?php echo wp_get_attachment_image( $teaser_image, 'full' ); ?>
            <?php endif; ?>

            <?php if ( $has_video ) : ?>
            <button class="play-button" type="button" aria-label="Play video" aria-haspopup="dialog"
                <?php echo $youtube_id ? 'data-youtube="' . esc_attr( $youtube_id ) . '"' : 'data-src="' . esc_url( $video_file ) . '"'; ?>>
                <svg viewBox="0 0 576 512" aria-hidden="true" focusable="false"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/></svg>
            </button>
            <?php elseif ( is_admin() ) : ?>
            <p>Add a YouTube video or upload a video file.</p>
            <?php endif; ?>
        </div>

        <?php if ( $has_video ) : ?>
        <dialog class="video-dialog" aria-label="Video">
            <button class="close" type="button" aria-label="Close video">&times;</button>
            <div class="video-frame"></div>
        </dialog>
        <?php endif; ?>
    </div>
</section>
