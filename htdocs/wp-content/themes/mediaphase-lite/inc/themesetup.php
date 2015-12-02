<?php

function mediaphase_load_theme_fonts()
{
	$heading = get_theme_mod( 'mediaphase_google_fonts_heading_font' );
	$body = get_theme_mod( 'mediaphase_google_fonts_body_font' );
	if ( ( !empty( $heading ) && $heading != 'none' ) || ( !empty( $body ) && $body != 'none' ) ) {
		echo '<style type="text/css">';
		$styles = array();
		if ( !empty( $heading ) && $heading != 'none' ) {
			$styles[] = 'h1, h2, h3, h4, h5, h6 { font-family: "' . esc_attr( $heading ) . '" !important }';
		}
		if ( !empty( $body ) && $body != 'none' ) {
			$styles[] = 'body { font-family: "' . esc_attr( $body ) . '" !important }';
		}

		echo implode( "\r\n", $styles );
		echo '</style>';

	}
}

add_action( 'wp_head', 'mediaphase_load_theme_fonts' );

function mediaphase_load_theme_styles()
{
	$top_ribbon_bg = get_theme_mod( 'mediaphase_top_ribbon_bg_image' );
	$hero_image_bg = get_theme_mod( 'mediaphase_hero_bg_image' );
	$middle_ribbon_bg = get_theme_mod( 'mediaphase_middle_ribbon_bg_image' );
	$bottom_ribbon_bg = get_theme_mod( 'mediaphase_bottom_ribbon_bg_image' );


	echo '<style>';
	echo '.topribbon { background-image: ' . ( $top_ribbon_bg ? 'url(' . $top_ribbon_bg . ')' : 'none' ) . '}';
	echo '.midribbon { background-image: ' . ( $middle_ribbon_bg ? 'url(' . $middle_ribbon_bg . ')' : 'none' ) . '}';
	echo '.botribbon { background-image: ' . ( $bottom_ribbon_bg ? 'url(' . $bottom_ribbon_bg . ')' : 'none' ) . '}';
	echo '#hero { background-image: ' . ( $hero_image_bg ? 'url(' . $hero_image_bg . ')' : 'none' ) . '}';

	echo '</style>';
}

add_action( 'wp_head', 'mediaphase_load_theme_styles' );