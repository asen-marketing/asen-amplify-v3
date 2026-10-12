<?php
/**
 * Block Name: Asen Tabbed Content
 *
 * Tabbed content selector
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if ( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$selector_type = get_field('tab_selector_options');

?>
<section class="asen-tabbed-content asen-tabbed-content-<?php echo $block['id']; ?> <?php echo $className;?>"
    id="<?php echo array_key_exists('anchor', $block) ? $block['anchor'] : ''; ?>">
    <div class="inside" style="max-width: <?php the_field('block_max_width'); ?>px;">
        <div class="tab-container">
            <?php if( have_rows('tabs') ): ?>

            <?php if ($selector_type == 'buttons') : ?>
            <div class="tab-buttons">
                <?php while( have_rows('tabs') ): the_row(); ?>

                <?php 
                    $tab_name_param = get_sub_field('tab_name');
                    $tab_name_param = str_replace(' ', '-', strtolower($tab_name_param));
                    ?>

                <button class="button tab" data-id="<?php echo get_row_index(); ?>"
                    data-name="<?php echo $tab_name_param; ?>">
                    <?php the_sub_field('tab_name'); ?>
                </button>

                <div class="single-tab mobile <?php the_sub_field('special_classes'); ?>"
                    data-id="<?php echo get_row_index(); ?>" data-name="<?php echo $tab_name_param; ?>">
                    <?php the_sub_field('tab_content'); ?>

                    <script src="<?php the_sub_field('form_script_code'); ?>"></script>
                </div>

                <?php endwhile; ?>
            </div>
            <?php endif; ?>

            <?php if ($selector_type == 'dropdown') : ?>
            <div class="tab-dropdown">
                <div class="select-wrapper">
                    <select class="tab-selector" aria-label="Select a tab" name="tab-selector">
                        <?php while( have_rows('tabs') ): the_row(); ?>
                        <?php 
                        $tab_name_param = get_sub_field('tab_name');
                        $tab_name_param = str_replace(' ', '-', strtolower($tab_name_param));
                        ?>
                        <option class="tab-option" data-id="<?php echo get_row_index(); ?>"
                            data-name="<?php echo $tab_name_param; ?>">
                            <?php the_sub_field('tab_name'); ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>

            <div class="tab-content">
                <div class="content-tabs">
                    <?php while( have_rows('tabs') ): the_row(); ?>

                    <?php                
                        $tab_name_param = get_sub_field('tab_name');
                        $tab_name_param = str_replace(' ', '-', strtolower($tab_name_param));
                        ?>

                    <div class="single-tab <?php the_sub_field('special_classes'); ?>"
                        data-id="<?php echo get_row_index(); ?>" data-name="<?php echo $tab_name_param; ?>">
                        <?php the_sub_field('tab_content'); ?>

                        <script src="<?php the_sub_field('form_script_code'); ?>"></script>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <?php endif; ?>
        </div>
    </div>
</section>

<style>
.asen-tabbed-content-<?php echo $block['id'];

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
        .button.tab {
            background-color: <?php the_field('tab_button_background');
            ?>;
            color: <?php the_field('tab_button_text_color');
            ?>;
        }

        .button.tab:hover,
        .button.tab.active {
            background-color: <?php the_field('tab_button_active_background');
            ?>;
            color: <?php the_field('tab_button_active_text_color');
            ?>;
        }

        .tab-dropdown {
            .tab-selector {
                background-color: <?php the_field('dropdown_background_color');
                ?>;
                color: <?php the_field('dropdown_text_color');
                ?>;
            }
        }

        .tab-content {
            background-color: <?php the_field('tab_content_background');
            ?>;
            color: <?php the_field('tab_content_text_color');
            ?>;
        }
    }
}
</style>

<script defer>
(function($) {
        var tabButtons = $('.tab-buttons .tab'),
            tabPanels = $('.tab-content .single-tab'),
            active = 1,
            mobileTabPanels = $('.single-tab.mobile'),
            isMobile = $(window).width() <= 639,
            tabLink = new URLSearchParams(window.location.search).get('tab'),
            dropdown = $('.tab-dropdown select');

        tabPanels.filter('[data-id="1"]').addClass('active');

        // If URL param exists, set active tab, else default to first tab
        if (tabLink) {
            tabButtons.removeClass('active');
            tabPanels.removeClass('active');
            tabPanels.filter('[data-name="' + tabLink + '"]').addClass('active');
            tabButtons.filter('[data-name="' + tabLink + '"]').addClass('active');
            $('option[data-name="' + tabLink + '"]', dropdown).prop('selected', true);

            if (isMobile) {
                mobileTabPanels.filter('[data-name="' + tabLink + '"]').addClass('active');
            }
        } else {
            tabPanels.filter('[data-id="1"]').addClass('active');
            tabButtons.filter('[data-id="1"]').addClass('active');

            if (isMobile) {
                tabButtons.removeClass('active');
                //     mobileTabPanels.filter('[data-id="1"]').addClass('active').slideDown();
            }
        }

        tabButtons.on('click', function() {
            // Set URL param to tab name
            var url = window.location.href.split('?')[0];
            window.history.pushState({}, "", `${url}?tab=${$(this).data('name')}`);

            var id = $(this).data('id');
            active = id

            if ($(window).width() > 639) {
                tabButtons.removeClass('active');
                tabPanels.removeClass('active');
                tabPanels.filter('[data-id="' + id + '"]').addClass('active');
                $(this).addClass('active');
            } else {
                mobileTabPanels.each(function() {
                    if ($(this).data('id') !== id) {
                        $(this).slideUp();
                    } else {
                        $(this).slideToggle();
                    }
                });

                tabButtons.each(function() {
                    if ($(this).data('id') !== id) {
                        $(this).removeClass('active');
                    } else {
                        $(this).toggleClass('active');
                    }
                });
            }
        });

        dropdown.on('change', function() {
            var url = window.location.href.split('?')[0];
            window.history.pushState({}, "", `${url}?tab=${$(this).val().toLowerCase().replace(' ', '-')}`);

            var id = $(this).find('option:selected').data('id');
            active = id

            tabPanels.removeClass('active');
            tabPanels.filter('[data-id="' + id + '"]').addClass('active');
        })

        $(window).on('resize', function() {
            if ($(window).width() > 639) {
                if (isMobile === true) {
                    isMobile = false;
                    mobileTabPanels.hide()
                }
            } else {
                if (isMobile === false) {
                    isMobile = true;
                    tabButtons.removeClass('active');
                }

                tabPanels.removeClass('active');
                tabPanels.filter('[data-id="' + active + '"]').addClass('active');
            }
        });

    }

)(jQuery);
</script>