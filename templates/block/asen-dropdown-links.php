<?php
/**
 * Block Name: Asen Dropdown Links
 *
 * Links displayed in a dropdown selector.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
} else {
    $className = '';
    if ( !empty($block['className']) ) {
        $className .= ' ' . $block['className'];
    }

    $links = get_field('links');
    ?>

<div class="asen-dropdown-links <?php echo $className;?>"
    id="<?php if (array_key_exists('anchor_name', $block)) { echo esc_attr($block['anchor_name']); } ?>">

    <div class="custom-select">
        <div class="selected"><?php the_field('default_display_option'); ?></div>
        <ul class="options">
            <?php if( $links ): ?>
            <?php foreach( $links as $link_element ): 
                    $link = $link_element['link'];
                ?>
            <li data-value="<?php echo esc_url($link['url']); ?>">
                <?php echo esc_html($link['title']); ?>
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>

</div>


<script defer>
(function($) {
    $(document).ready(function() {
        const $select = $('.asen-dropdown-links .custom-select');
        const $selected = $select.find('.selected');
        const $options = $select.find('.options li');

        // Toggle dropdown
        $selected.on('click', function() {
            $select.toggleClass('open');
        });

        // Select option
        $options.on('click', function() {
            const value = $(this).data('value');
            const text = $(this).text();
            $selected.text(text);
            $select.removeClass('open');

            if (value) {
                window.open(value, '_blank');
            }
        });

        // Close dropdown on click outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.custom-select').length) {
                $select.removeClass('open');
            }
        });
    });
})(jQuery);
</script>


<?php
}
?>