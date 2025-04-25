<?php

function asen_background_image_inline( $wp_thumb = null, $post_id = null ) {
    if ($wp_thumb == null) {
		$wp_thumb = 'full';
	}
    if ($post_id == null) {
		$post_id = get_the_ID();
	}
    $featured_image_src = get_the_post_thumbnail_url($post_id, $wp_thumb);
    if (isset($featured_image_src)) {
		$result = 'style="background-image: url(\'';
		$result .= $featured_image_src;
		$result .= '\');"';
	}
    return ! empty( $result ) ? $result : false;
}

// GET ACF IMAGE
// Gets image URL through ACF on the current page
// ACF must provide attachment ID
function asen_acf_image_url($acf_image, $wp_thumb, $inline_style = false, $post_id = null) {
	if ($post_id == null) {
		$post_id = get_the_ID();
	}

	// Could be normal field or sub_field
	if (get_sub_field($acf_image, $post_id)) {
		$acf_field = get_sub_field($acf_image, $post_id);
	} elseif (get_field($acf_image, $post_id)) {
		$acf_field = get_field($acf_image, $post_id);
	}
	if (isset($acf_field)) {
		$image = wp_get_attachment_image_src($acf_field['ID'], $wp_thumb);
		if ($inline_style) {
			$result = 'style="background-image: url(\'';
			$result .= $image[0];
			$result .= '\');"';
		} else {
			$result = $image[0];
		}
	}
	return ! empty( $result ) ? $result : false;
}

// Remove dumb phone number stuff to return just the part we want for <a href="tel:...
function asen_clean_phone_number( $number ) {
	$typical_phone_junk = array(' ', '-', '.', '(', ')');
	return str_replace($typical_phone_junk, '', $number);
}

// Some hold overs from the old site related to Blog Categories.
function asen_get_primary_category_meta( $post_id = null ) {
    if ($post_id == null) {
        $post_id = get_the_ID();
    }
	// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
	$category = get_the_category( $post_id );
	$primary_category = array();
	// If post has a category assigned.
	if ( $category ) {
        $category_id = 0;
		$category_display = '';
		$category_slug = '';
		$category_link = '';
        $category_image = false;
		if ( class_exists('WPSEO_Primary_Term') )
		{
			// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
			$wpseo_primary_term = new WPSEO_Primary_Term( 'category', $post_id );
			$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
			$term = get_term( $wpseo_primary_term );
			if (is_wp_error($term)) {
				// Default to first category (not Yoast) if an error is returned
                $category_id = $category[0]->term_id;
				$category_display = $category[0]->name;
				$category_slug = $category[0]->slug;
				$category_link = get_category_link( $category[0]->term_id );
                $category_image = get_field( 'icon', 'category_' . $category[0]->term_id );
			} else {
				// Yoast Primary category
                $category_id = $term->term_id;
				$category_display = $term->name;
				$category_slug = $term->slug;
				$category_link = get_category_link( $term->term_id );
                $category_image = get_field( 'icon', 'category_' . $term->term_id );
			}
		}
		else {
			// Default, display the first category in WP's list of assigned categories
            $category_id = $category[0]->term_id;
			$category_display = $category[0]->name;
			$category_slug = $category[0]->slug;
			$category_link = get_category_link( $category[0]->term_id );
            $category_image = get_field( 'icon', 'category_' . $category[0]->term_id );
		}
        $primary_category['id'] = $category_id;
		$primary_category['url'] = $category_link;
		$primary_category['slug'] = $category_slug;
		$primary_category['title'] = $category_display;
        $primary_category['icon'] = wp_get_attachment_image($category_image, 'thumbnail');
	}
	return $primary_category;
}

function asen_get_primary_category( $post_id = null, $linked = true ) {
    if ($post_id == null) {
        $post_id = get_the_ID();
    }
	$primary_category = asen_get_primary_category_meta( $post_id );
    if ($linked) {
        $result = '<a href="' . $primary_category['url'] . '" class="primary-category" title="See all ' . $primary_category['title'] . ' blog posts">';
        // TODO: Control with params later.
        // $result .= $primary_category['icon'];
        $result .= $primary_category['title'] . '</a>';
    } else {
        $result = '<h4 class="blog-primary-category">' . $primary_category['title'] . '</h4>';
    }

	return !empty($result) ? $result : '';
}

/**
 * Get unique ID.
 *
 * This is a PHP implementation of Underscore's uniqueId method. A static variable
 * contains an integer that is incremented with each call. This number is returned
 * with the optional prefix. As such the returned value is not universally unique,
 * but it is unique across the life of the PHP process.
 *
 * @see wp_unique_id() Themes requiring WordPress 5.0.3 and greater should use this instead.
 *
 * @staticvar int $id_counter
 *
 * @param string $prefix Prefix for the returned ID.
 * @return string Unique ID.
 */
function twentytwenty_unique_id( $prefix = '' ) {
	static $id_counter = 0;
	if ( function_exists( 'wp_unique_id' ) ) {
		return wp_unique_id( $prefix );
	}
	return $prefix . (string) ++$id_counter;
}