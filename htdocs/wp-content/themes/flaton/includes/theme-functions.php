<?php
/**
 * Theme Functions
 *
 * Various functions to use through out site such as breadcrumb, pagination, etc
 *
 * @package FLATON
 *
 * @since 1.0
 *
 */

	// cleaning up excerpt
	add_filter('excerpt_more', 'flaton_excerpt_more');

	// This removes the annoying […] to a Read More link
	function flaton_excerpt_more($excerpt) {
		global $post;
		// edit here if you like
		return '<p class="readmore"><a href="'. get_permalink($post->ID) . '" title="Read '.get_the_title($post->ID).'">Read more &raquo;</a></p>';
	}

	function flaton_excerpt_length( $length ) {
		return 20;
	}
	add_filter( 'excerpt_length', 'flaton_excerpt_length', 999 );

	add_action( 'wp_head', 'flaton_custom_css' );

	function flaton_custom_css() {
		global $flaton;
		if( isset( $flaton['custom-css'] ) ) {
			$custom_css = '<style type="text/css">' . $flaton['custom-css'] . '</style>';
			echo $custom_css;
		}
	}