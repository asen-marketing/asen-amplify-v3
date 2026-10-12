<?php
/**
 * Block Name: Asen Case Study Web Video
 * Description: Looping video teaser with popup YouTube player.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

if ( class_exists('ACF') === false ) return; 

$className = '';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if( get_field('has_gray_background') === true ) {
    $className = ' has-background';
}

?>

<?php if (is_admin()) : ?>

<pre><?php print_r(get_fields()); ?></pre>

<?php else : ?>
<section
    class="asen-video-teaser-popup asen-video-teaser-popup-<?php echo $block['id']; echo $className; echo " " . $block['className']; ?>">
    <div class="inside">
        <div class="play-button">
            <svg viewBox="0 0 576 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg" role="img">
                <title>Play</title>
                <path
                    d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z">
                </path>
            </svg>
        </div>

        <div class="teaser">
            <?php if (get_field('teaser_options') == 'image' && get_field('teaser_image')) : ?>
            <?php echo wp_get_attachment_image(get_field('teaser_image'), 'full'); ?>
            <?php elseif (get_field('teaser_options') == 'video' && get_field('teaser_video')) : ?>
            <video src="<?php echo get_field('teaser_video'); ?>" muted autoplay loop></video>
            <?php endif; ?>
        </div>

        <div class="modal homepage asen-video-modal youtube-video-modal">
            <a href="#" class="close-modal close-modal-<?php echo $index; ?>">Close window</a>
            <div class="video-wrapper">
                <div class="video"></div>
            </div>
        </div>

    </div>
</section>

<script defer>
(function($) {
    // Load video after document is ready
    $(document).ready(function() {

        var openVideoModalButton = $('.asen-video-teaser-popup div.play-button'),
            videoModal = $(
                '.asen-video-modal.homepage'
            ),
            videoModalCloseButton = videoModal.find('a.close-modal'),
            activeVideoModal,
            activeVideoID = '',
            youTubePlayer,
            loopingVideo = $('.asen-video-teaser-popup .teaser video');

        openVideoModalButton.on("click", function(event) {

            if (loopingVideo.length) {
                loopingVideo[0].pause();
            }

            activeVideoID = '';
            let clickedButton = $(this),
                clickedVideoID =
                '<?php echo get_field('youtube_video_id'); ?>';

            console.log('Clicked Video ID:', clickedVideoID);
            if (clickedVideoID == '') {
                console.error('Video ID is not available.');
                alert(
                    "We're sorry. Video is unable to play. Please, contact us for help!"
                );
                return;
            }
            activeVideoID = clickedVideoID;
            videoModal.modal({
                showClose: false, // We're using our own.
                escapeClose: true,
                clickClose: true
            });
        });

        videoModalCloseButton.on("click", function(event) {
            event.preventDefault();
            $.modal.close();
        });

        videoModal.on($.modal.BEFORE_OPEN, function(event, modal) {
            activeVideoModal = videoModal.find(".video");
        });

        videoModal.on($.modal.OPEN, function(event, modal) {
            loadPlayer();
        });

        videoModal.on($.modal.BEFORE_CLOSE, function(event, modal) {
            youTubePlayer.destroy();

            if (loopingVideo.length) {
                loopingVideo[0].play();
            }
        });

        function loadPlayer() {
            youTubePlayer = new YT.Player(activeVideoModal[0], {
                height: '506',
                width: '900',
                videoId: activeVideoID,
                events: {
                    'onReady': onPlayerReady
                },
                rel: 0
            });
        }

        function onPlayerReady(event) {
            event.target.playVideo();
        }

    }); // End $( document ).ready

})(jQuery)
</script>

<?php endif; ?>