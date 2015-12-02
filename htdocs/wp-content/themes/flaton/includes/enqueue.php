<?php
/**
 * Enqueue scripts and styles.
 */
function flaton_fontawesome() {
    wp_deregister_style( 'redux-elusive-icon' );
    wp_deregister_style( 'redux-elusive-icon-ie7' );
	wp_enqueue_style( 'flaton-fontawesome', FLATON_PARENT_URL . '/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'flaton_fontawesome' );
add_action( 'redux/page/flaton/enqueue', 'flaton_fontawesome' );

function flaton_scripts() {
	wp_enqueue_style( 'flaton-bitter', '//fonts.googleapis.com/css?family=Bitter:400,700' );
	wp_enqueue_style( 'flaton-source-sans-pro', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic,700italic' );
	wp_enqueue_style( 'flaton-flexslider', FLATON_PARENT_URL . '/css/flexslider.css' );
	global $flaton;
	if( isset( $flaton['color'] ) ) {
		switch ($flaton['color']) {
			case '2':
				wp_enqueue_style( 'flaton-green', FLATON_PARENT_URL . '/green.css');
				break;
			default:
				wp_enqueue_style( 'flaton-style', get_stylesheet_uri() );
				break;
		}		
	} else {
		wp_enqueue_style( 'flaton-style', get_stylesheet_uri() );
	}

	wp_enqueue_script( 'flaton-navigation', FLATON_PARENT_URL . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'flaton-skip-link-focus-fix', FLATON_PARENT_URL . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script( 'flaton-flexsliderjs', FLATON_PARENT_URL . '/js/jquery.flexslider-min.js', array('jquery'), '2.2.2', true );
	wp_enqueue_script( 'jquery-ui-tabs', false, array('jquery'));
	wp_enqueue_script( 'flaton-custom', FLATON_PARENT_URL . '/js/custom.js', array('jquery'), '1.0', true );	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'flaton_scripts' );

function flaton_admin_style() {
	wp_enqueue_style( 'flaton-admin', FLATON_PARENT_URL . '/css/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'flaton_admin_style' );