<?php

// All Asen blocks register from includes/core-blocks/{slug}/block.json (see asen_register_acf_blocks() in theme.php).
function asen_include_block_category( $categories ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'asen-blocks',
				'title' => 'Asen Blocks',
			),
		)
	);
}
add_filter( 'block_categories_all', 'asen_include_block_category' );

// The link wrapper's inner blocks go straight inside its <a>, without ACF's extra container div.
add_filter( 'acf/blocks/wrap_frontend_innerblocks', function ( $wrap, $name ) {
	return 'acf/asen-link-wrapper' === $name ? false : $wrap;
}, 10, 2 );
