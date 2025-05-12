<a class="fixed-contact-cta-button" title="<?php echo strip_tags(get_field('cta_link_text', 'option')); ?>"
    href="<?php the_field('cta_link_url', 'option'); ?>">
    <span class="hover-intent-layer">
        <?php the_field('cta_link_text', 'option'); ?>
    </span>
    <span class="icon-container">
        <?php echo get_field('cta_icon', 'option') ? get_field('cta_icon', 'option') : '<i class="fa-solid fa-square-plus"></i>'; ?>
    </span>
</a>

<?php
$style_row = get_field('cta_styling', 'option');
$text_color = $style_row[0]['text_color'];
$background_color = $style_row[0]['background_color'];
?>

<style>
.fixed-contact-cta-button {
    background-color: <?php echo $background_color;
    ?>;

    .hover-intent-layer {
        color: <?php echo $background_color;
        ?>;
    }

    .icon-container {
        color: <?php echo $text_color;
        ?>;
    }
}

.fixed-contact-cta-button:hover {
    background-color: <?php echo $text_color;
    ?>;
    color: <?php echo $background_color;
    ?>;

    .hover-intent-layer {
        color: <?php echo $background_color;
        ?>;
    }

    .icon-container {
        color: <?php echo $background_color;
        ?>;
    }
}

@media (hover: none) {
    .fixed-contact-cta-button {
        background-color: <?php echo $text_color;
        ?>;

        .hover-intent-layer {
            color: <?php echo $background_color;
            ?>;
        }

        .icon-container {
            color: <?php echo $background_color;
            ?>;
        }
    }
}
</style>

<script defer>
(function($) {
    "use strict";
    var windowObject = $(window);
    var ctaButtonsContainer = $('.fixed-contact-cta-button');
    var didScroll = false;
    var lastScrollTop = 0;
    var triggerDepth = 150;
    var timer;
    var checkingScroll = false;
    var bodyObject = $('body');
    var bodyHeight = 0;
    var footerObject = $('footer.site-footer');
    var footerHeight = 0;
    var distanceFromFooter = 0;
    var resizeTimeout;

    windowObject.ready(function() {
        resizeTask();
        checkScroll();
    }); // End window loaded.

    windowObject.scroll(function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            checkScroll();
        }, 10);
    });

    windowObject.on("resize", function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            resizeTask();
        }, 100);
    });

    function resizeTask() {
        bodyHeight = bodyObject.outerHeight();
        footerHeight = footerObject.outerHeight();
        distanceFromFooter = bodyHeight - windowObject.height() - footerHeight;
    }

    function checkScroll() {
        let currentScrollTop = windowObject.scrollTop();
        let currentDistanceFromFooter = distanceFromFooter - currentScrollTop;

        if (
            currentDistanceFromFooter > 0
        ) {
            if (ctaButtonsContainer.hasClass('is-hidden')) {
                ctaButtonsContainer.removeClass('is-hidden');
            }
        } else if (
            currentDistanceFromFooter <= 0
        ) {
            if (ctaButtonsContainer.hasClass('is-hidden') == false) {
                ctaButtonsContainer.addClass('is-hidden');
            }
        }
    }
})(jQuery);
</script>