<?php
/**
 * Block Name: Asen Dynamic Color SVG
 *
 * Dynamic color SVG block
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if ( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$image = get_field('svg_image');
$color = get_field('svg_color');
$max_width = get_field('svg_max_width');
?>

<?php if ( !$image ) :
    echo '<p>Please select an SVG image in the block settings.</p>';
    else : ?>

<object class="asen-dynamic-color-svg asen-dynamic-color-svg-<?php echo $block['id']; echo $className; ?>"
    id="<?php echo $block['anchor']; ?>" type="image/svg+xml" data="<?php echo $image; ?>"
    data-color="<?php echo $color; ?>" style="max-width: <?php echo $max_width; ?>px;"></object>


<script defer>
(function($) {
    var svgObject = $("object.asen-dynamic-color-svg-<?php echo $block['id']; ?>");

    if (svgObject.length) {
        svgObject.on("load", function() {
            const color = this.getAttribute("data-color");
            const svgDoc = this.contentDocument;
            const svg = svgDoc.querySelector("svg");

            if (!svg) return;

            svg.querySelectorAll("path").forEach(el => {
                el.removeAttribute("fill");
                el.style.setProperty("fill", color, "important");
            });

            svg.style.setProperty("fill", color, "important");
        });
    }
})(jQuery);
</script>
<?php endif; ?>