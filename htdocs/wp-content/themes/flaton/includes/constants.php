<?php
	/* Defining directory PATH Constants */
	define( 'FLATON_PARENT_DIR', get_template_directory() );
	define( 'FLATON_CHILD_DIR', get_stylesheet_directory() );
	define( 'FLATON_INCLUDES_DIR', FLATON_PARENT_DIR. '/includes' );

	/** Defining URL Constants */
	define( 'FLATON_PARENT_URL', get_template_directory_uri() );
	define( 'FLATON_CHILD_URL', get_stylesheet_directory_uri() );
	define( 'FLATON_INCLUDES_URL', FLATON_PARENT_URL . '/includes' );

	/* 
	Check for language directory setup in Child Theme
	If not present, use parent theme's languages dir
	*/
	if ( ! defined( 'FLATON_LANGUAGES_URL' ) ) /** So we can predefine to child theme */
		define( 'FLATON_LANGUAGES_URL', FLATON_INCLUDES_URL . '/languages' );

	if ( ! defined( 'FLATON_LANGUAGES_DIR' ) ) /** So we can predefine to child theme */
		define( 'FLATON_LANGUAGES_DIR', FLATON_INCLUDES_DIR . '/languages' );