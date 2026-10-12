<?php if ( get_field('gets_scroll_down_cta', get_the_ID()) ) : ?>

<div class="scroll-down-cta-container">
    <button type="button">
        <span>Scroll down</span>
        <?php echo get_template_part('templates/svg/general-arrow-right'); ?>
    </button>
</div>

<script>
    (function($) {
        "use strict";
        var windowObject = $(window),
            htmlObject = $('html'),
            container = $('.scroll-down-cta-container'),
            button = container.find('button'),
            currentPageHeight = windowObject.height(),
            scrollTop = htmlObject[0].scrollTop;

        windowObject.ready( function() {
            checkScroll();
        }); // End window loaded.

        var resizeTimer;
        windowObject.scroll(function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                checkScroll();
            }, 100);
        });

        button.click( function(event) {
            event.preventDefault();
            container.removeClass('is-active');
            window.scroll( 0, windowObject.height() );
        });

        function checkScroll() {
            scrollTop = htmlObject[0].scrollTop;
            let scrollLimit = currentPageHeight * 0.1;
            if ( scrollTop > scrollLimit && container.hasClass('is-active') ) {
                container.removeClass('is-active');
            } else if ( scrollTop <= scrollLimit && container.hasClass('is-active') === false ) {
                container.addClass('is-active');
            }
        }
    })(jQuery);
</script>

<?php endif; ?>