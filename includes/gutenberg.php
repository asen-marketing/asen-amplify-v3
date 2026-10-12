<?php

function asen_include_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'asen-blocks',
				'title' => 'Asen Blocks',
			),
		)
	);
}
add_filter( 'block_categories_all', 'asen_include_block_category', 10, 2 );

function site_acf_init() {
	
	// Check for ACF function before continuing.
	if ( function_exists('acf_register_block') ) {

		// Asen Split Fancy Copy
		acf_register_block(array(
			'name'				=> 'asen-split-fancy-copy',
			'title'				=> __('Asen Split Fancy Copy'),
			'description'		=> __('A two column block with fancy block, background, and layout.'),
			'mode'              => 'auto',
			'render_callback'	=> 'site_acf_block_callback',
			'category'			=> 'asen-blocks',
			'icon'				=> 'heart',
			'keywords'			=> array( 'fancy', 'asen', 'split' ),
			'supports'          => array( 'align' => false ),
		));

		// Asen WYSIWYG
		acf_register_block(array(
			'name'				=> 'asen-wysiwyg',
			'title'				=> __('Asen WYSIWYG'),
			'description'		=> __('A traditional WYSIWYG block.'),
			'mode'              => 'auto',
			'render_callback'	=> 'site_acf_block_callback',
			'category'			=> 'asen-blocks',
			'icon'				=> 'heart',
			'keywords'			=> array( 'wysiwyg', 'asen' ),
			'supports'          => array( 'align' => false ),
		));

		// Asen CTA
		acf_register_block(array(
			'name'				=> 'asen-cta',
			'title'				=> __('Asen CTA'),
			'description'		=> __('A CTA with rich text and buttons.'),
			'mode'              => 'auto',
			'render_callback'	=> 'site_acf_block_callback',
			'category'			=> 'asen-blocks',
			'icon'				=> 'carrot',
			'keywords'			=> array( 'button', 'asen' ),
			'supports'          => array( 'align' => false ),
		));

		// Asen Anchor
		acf_register_block(array(
			'name'				=> 'asen-anchor',
			'title'				=> __('Asen Anchor'),
			'description'		=> __('A block to add an anchor to anything.'),
			'mode'              => 'auto',
			'render_callback'	=> 'site_acf_block_callback',
			'category'			=> 'asen-blocks',
			'icon'				=> 'admin-links',
			'keywords'			=> array( 'anchor', 'asen' ),
			'supports'          => array( 'align' => false ),
		));

		// Asen Button
		acf_register_block(array(
			'name'				=> 'asen-button',
			'title'				=> __('Asen Button'),
			'description'		=> __('A basic button with no container. Because.'),
			'mode'              => 'auto',
			'render_callback'	=> 'site_acf_block_callback',
			'category'			=> 'asen-blocks',
			'icon'				=> 'button',
			'keywords'			=> array( 'button', 'asen' ),
			'supports'          => array( 'align' => false ),
		));

		// Asen Buttons Group
		acf_register_block(array(
			'name'				=> 'asen-buttons-group',
			'title'				=> __('Asen Buttons Group'),
			'description'		=> __('Buttons grouped in a container for control.'),
			'mode'              => 'auto',
			'render_callback'	=> 'site_acf_block_callback',
			'category'			=> 'asen-blocks',
			'icon'				=> 'button',
			'keywords'			=> array( 'button', 'asen' ),
			'supports'          => array( 'align' => false ),
		));

		// Asen Link Wrapper
		acf_register_block(array(
			'name'				=> 'asen-link-wrapper',
			'title'				=> __('Asen Link Wrapper'),
			'description'		=> __('Warp block content in an <a> tag with this block.'),
			'mode'              => 'preview',
			'render_callback'	=> 'site_acf_block_callback',
			'category'			=> 'asen-blocks',
			'icon'				=> 'admin-links',
			'keywords'			=> array( 'link', 'asen', 'wrap', 'container' ),
			'supports'          => array( 'align' => false, 'mode' => false, 'jsx' => true ),
		));

		// Asen Product and Service Tiers
		acf_register_block(array(
			'name'				=> 'asen-product-service-tiers',
			'title'				=> __('Asen Product and Service Tiers'),
			'description'		=> __('Every brochure site needs a product and/or services tier row.'),
			'mode'              => 'auto',
			'render_callback'	=> 'site_acf_block_callback',
			'category'			=> 'asen-blocks',
			'icon'				=> 'list',
			'keywords'			=> array( 'pricing', 'asen', 'tier', 'product', 'service' ),
			'supports'          => array( 'align' => false ),
		));

		// Asen 2 Featured Blogs + CTA Row
		acf_register_block(array(
			'name'				=> 'asen-featured-blogs',
			'title'				=> __('Asen Featured Blogs'),
			'mode'              => 'edit',
			'render_callback'	=> 'site_acf_block_callback',
			'category'			=> 'asen-blocks',
			'icon'				=> '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M192 32c0 17.7 14.3 32 32 32c123.7 0 224 100.3 224 224c0 17.7 14.3 32 32 32s32-14.3 32-32C512 128.9 383.1 0 224 0c-17.7 0-32 14.3-32 32zm0 96c0 17.7 14.3 32 32 32c70.7 0 128 57.3 128 128c0 17.7 14.3 32 32 32s32-14.3 32-32c0-106-86-192-192-192c-17.7 0-32 14.3-32 32zM96 144c0-26.5-21.5-48-48-48S0 117.5 0 144V368c0 79.5 64.5 144 144 144s144-64.5 144-144s-64.5-144-144-144H128v96h16c26.5 0 48 21.5 48 48s-21.5 48-48 48s-48-21.5-48-48V144z"/></svg>',
			'keywords'			=> array( 'blog', 'grid' ),
			'supports'          => array( 'align' => false, 'anchor' => true ),
		));

		// Asen Dynamic Color SVG
		acf_register_block(array(
			'name'				=> 'asen-dynamic-color-svg',
			'title'				=> __('Asen Dynamic Color SVG'),
			'description'		=> __('Dynamic SVG with color options'),
			'mode'              => 'edit',
			'render_callback'	=> 'site_acf_block_callback',
			'category'			=> 'asen-blocks',
			'icon'				=> 'format-image',
			'keywords'			=> array( 'asen', 'dynamic', 'color', 'svg' ),
			'supports'          => array( 'align' => false, 'anchor' => true ),
		));

		// Asen Dropdown Links
		acf_register_block(array(
			'name'				=> 'asen-dropdown-links',
			'title'				=> __('Asen Dropdown Links'),
			'description'		=> __('Links displayed in a dropdown selector.'),
			'mode'              => 'auto',
			'render_callback'	=> 'site_acf_block_callback',
			'category'			=> 'asen-blocks',
			'icon'				=> 'arrow-down-alt2',
			'keywords'			=> array( 'select', 'links', 'dropdown', 'asen' ),
			'supports'          => array( 'align' => false, 'anchor' => true ),
		));

		// Asen Video Popup
		acf_register_block(array(
			'name'				=> 'asen-video-popup',
			'title'				=> __('Asen Video Popup'),
			'description'		=> __('Looping video teaser with popup YouTube player.'),
			'mode'              => 'edit',
			'render_callback'	=> 'site_acf_block_callback',
			'category'			=> 'asen-blocks',
			'icon'				=> 'video-alt3',
			'keywords'			=> array( 'video', 'player', 'youtube', 'asen' ),
			'supports'          => array( 'align' => false, 'anchor' => true ),
		));

	}
}
add_action('acf/init', 'site_acf_init');

function site_acf_block_callback( $block ) {
	
	// Convert block name ("acf/example") into path friendly slug ("example").
	$slug = str_replace('acf/', '', $block['name']);
	
	// Include a template part from within the "template/block" folder.
	if( file_exists( get_theme_file_path("/templates/block/{$slug}.php") ) ) {
		include( get_theme_file_path("/templates/block/{$slug}.php") );
	}
}