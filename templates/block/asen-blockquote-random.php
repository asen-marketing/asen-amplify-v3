<?php
/**
 * Block Name: Asen Blockquote Random Row
 *
 * A random blockquote that looks great with Asen 2020.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
?>
<?php if ( is_admin() && get_field('quotes_pool') ) : ?>
    <?php foreach( get_field('quotes_pool') as $item ): ?>
        <p><strong><?php echo $item['quote'] ?></strong> <?php echo $item['attribution']; ?></p>
    <?php endforeach; ?>
<?php elseif ( get_field('quotes_pool') ) : ?>
    <div class="asen-blockquote asen-blockquote-<?php echo $block['id']; echo $className; ?>">
        <div class="inside"></div>
    </div>
    <?php
        $quotes_pool = array();
        foreach ( get_field('quotes_pool') as $item ) {
            $result = new stdClass;
            $result->quote = $item['quote'];
            $result->attribution = $item['attribution'];
            array_push($quotes_pool, $result);
        }
    ?>
    <script defer>
        (function($) {
            "use strict";
            var windowObject = $(window),
                randomQuote = $('.asen-blockquote-<?php echo $block['id']; ?>'),
                randomQuoteContainer = randomQuote.find('.inside'),
                randomQuotesList = <?php echo json_encode( $quotes_pool ); ?>,
                randomQuotesListRandom = getRandom(randomQuotesList, 1);

            windowObject.on("load", function() {
                let cite = randomQuotesListRandom.attribution.length > 0 ? `<cite>&#8213; ${randomQuotesListRandom.attribution}</cite>` : '',
                    className = randomQuotesListRandom.text_size != undefined ? randomQuotesListRandom.text_size : '';
                randomQuoteContainer.append(`
                    <blockquote class="${className}">
                        <p>&ldquo;${randomQuotesListRandom.quote}&rdquo;</p>
                        ${cite}
                    </blockquote>
                `);
            }); // End window loaded.

            // https://stackoverflow.com/a/19270021
            function getRandom(arr, n) {
                var result = new Array(n),
                    len = arr.length,
                    taken = new Array(len);
                if (n > len)
                    throw new RangeError("getRandom: more elements taken than available");
                while (n--) {
                    var x = Math.floor(Math.random() * len);
                    result[n] = arr[x in taken ? taken[x] : x];
                    taken[x] = --len in taken ? taken[len] : len;
                }
                return result[0];
            }
        })(jQuery);
    </script>
<?php else : ?>
    <p>Add some quotes!</p>
<?php endif; ?>
