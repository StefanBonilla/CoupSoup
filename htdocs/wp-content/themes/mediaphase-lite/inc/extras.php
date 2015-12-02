<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package mediaphase
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function mediaphase_body_classes( $classes )
{
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$fullwidth = get_theme_mod( 'mediaphase_page_fullwidth', null );

	if ( $fullwidth === 'yes' ) {
		$classes[] = 'fullwidth';
	}

	return $classes;
}

add_filter( 'body_class', 'mediaphase_body_classes' );

function mediaphase_fallback_menu()
{
	wp_nav_menu( array(
			'menu'       => 'primary',
			'container'  => false,
			'items_wrap' => '<ul>%3$s</ul>',
			'depth'      => 0,
		)
	);
}
