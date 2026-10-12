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

// Styles panel options. Button styles map to the .button variants in _buttons.scss; Group styles are the section styles in _section-styles.scss.
function asen_register_block_styles() {
	foreach ( array( 'knockout' => 'Knockout', 'small' => 'Small', 'wide' => 'Wide' ) as $name => $label ) {
		register_block_style( 'core/button', array( 'name' => $name, 'label' => $label ) );
	}
	foreach ( array( 'section-light' => 'Light Section', 'section-dark' => 'Dark Section', 'section-brand' => 'Brand Section' ) as $name => $label ) {
		register_block_style( 'core/group', array( 'name' => $name, 'label' => $label ) );
	}
}
add_action( 'init', 'asen_register_block_styles' );
