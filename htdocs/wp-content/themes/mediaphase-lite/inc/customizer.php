<?php
/**
 * mediaphase Theme Customizer
 *
 * @package mediaphase
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mediaphase_customize_register( $wp_customize )
{
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	function mediaphase_sanitize_textarea( $text )
	{
		return strip_tags( $text, '<p><a><i><br><strong><b><em><ul><li><ol><span><h1><h2><h3><h4>' );
	}

	function mediaphase_sanitize_integer( $text )
	{
		return ( int )$text;
	}
}

add_action( 'customize_register', 'mediaphase_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mediaphase_customize_preview_js()
{
	wp_enqueue_script( 'mediaphase_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130513', true );
}

add_action( 'customize_preview_init', 'mediaphase_customize_preview_js' );

function mediaphase_sanitize_color_hex( $value )
{
	if ( !preg_match( '/\#[a-fA-F0-9]{6}/', $value ) ) {
		$value = '#ffffff';
	}

	return $value;
}

function mediaphase_customizer( $wp_customize )
{

	$wp_customize->add_panel( 'mediaphase_homepage', array(
		'title'    => __( 'Homepage Setup', 'mediaphase-lite' ),
		'priority' => 10,
	) );

	// header logo
	$wp_customize->add_section( 'mediaphase_header_logo', array(
		'title'    => __( 'Header logo', 'mediaphase-lite' ),
		'priority' => 50,
	) );

	$wp_customize->add_setting( 'mediaphase_header_logo_show', array(
		'default'           => 'text',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_header_logo_show', array(
		'label'    => __( 'Show header logo or text', 'mediaphase-lite' ),
		'section'  => 'mediaphase_header_logo',
		'settings' => 'mediaphase_header_logo_show',
		'type'     => 'select',
		'choices'  => array( 'logo' => __( 'Logo', 'mediaphase-lite' ), 'text' => __( 'Text', 'mediaphase-lite' ) ),
	) );

	$wp_customize->add_setting( 'mediaphase_header_logo_image', array(
		'default'           => get_template_directory_uri() . '/img/logo.png',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mediaphase_header_logo_image', array(
		'label'    => __( 'Logo image', 'mediaphase-lite' ),
		'section'  => 'mediaphase_header_logo',
		'settings' => 'mediaphase_header_logo_image',
	) ) );

	$wp_customize->add_setting( 'mediaphase_header_logo_text', array(
		'default'			=> get_bloginfo( 'name' ),
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_header_logo_text', array(
		'label'   => __( 'Text', 'mediaphase-lite' ),
		'section' => 'mediaphase_header_logo',
	) );
	// end header logo

	// contacts
	$wp_customize->add_section( 'mediaphase_header_contacts', array(
		'title'    => __( 'Header contacts', 'mediaphase-lite' ),
		'priority' => 50,
	) );

	$wp_customize->add_setting( 'mediaphase_header_contacts_show', array(
		'default'           => 'yes',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_header_contacts_show', array(
		'label'    => __( 'Show header contacts', 'mediaphase-lite' ),
		'section'  => 'mediaphase_header_contacts',
		'settings' => 'mediaphase_header_contacts_show',
		'type'     => 'select',
		'choices'  => array( 'yes' => __( 'Yes', 'mediaphase-lite' ), 'no' => __( 'No', 'mediaphase-lite' ) ),
	) );

	$wp_customize->add_setting( 'mediaphase_header_contacts_phone', array(
		'default'			=> '0800 123 4567',
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_header_contacts_phone', array(
		'label'   => __( 'Phone', 'mediaphase-lite' ),
		'section' => 'mediaphase_header_contacts',
	) );

	$wp_customize->add_setting( 'mediaphase_header_contacts_email', array(
		'default'			=> 'contact@yourdomain.com',
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_header_contacts_email', array(
		'label'   => __( 'Email', 'mediaphase-lite' ),
		'section' => 'mediaphase_header_contacts',
	) );
	// end contacts

	// hero banner
	$wp_customize->add_section( 'mediaphase_hero', array(
		'title'       => __( 'Hero Banner', 'mediaphase-lite' ),
		'priority'    => 50,
		'description' => __( 'Big banner section on the front page - background image, title and text', 'mediaphase-lite' ),
		'panel'       => 'mediaphase_homepage',
	) );

	$wp_customize->add_setting( 'mediaphase_hero_show', array(
		'default'           => 'yes',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_hero_show', array(
		'label'    => __( 'Show hero banner in the front page', 'mediaphase-lite' ),
		'section'  => 'mediaphase_hero',
		'settings' => 'mediaphase_hero_show',
		'type'     => 'select',
		'choices'  => array( 'yes' => __( 'Yes', 'mediaphase-lite' ), 'no' => __( 'No', 'mediaphase-lite' ) ),
	) );

	$wp_customize->add_setting( 'mediaphase_hero_bg_image', array(
		'default'           => get_template_directory_uri() . '/img/hero2.jpg',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mediaphase_hero_bg_image', array(
		'label'    => __( 'Background image', 'mediaphase-lite' ),
		'section'  => 'mediaphase_hero',
		'settings' => 'mediaphase_hero_bg_image',
	) ) );

	$wp_customize->add_setting( 'mediaphase_hero_title', array(
		'default'			=> 'MediaPhase is a Sweet MultiPurpose Theme',
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_hero_title', array(
		'label'   => __( 'Title', 'mediaphase-lite' ),
		'section' => 'mediaphase_hero',
	) );

	$wp_customize->add_setting( 'mediaphase_hero_text', array(
		'default' 			=> '<p>Lorem ipsum dolor sit amet, <a href="#">consectetur adipiscing</a> elit. Praesent vel interdum diam, in ultricies diam. Proin vehicula sagittis lorem, nec.</p>
<a href="#" class="herobutton red">Read More <i class="fa fa-chevron-circle-right"></i></a>
<a href="#" class="herobutton clear">Join Now <i class="fa fa-chevron-circle-right"></i></a>',
		'sanitize_callback' => 'mediaphase_sanitize_textarea',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'mediaphase_hero_text', array(
		'label'    => __( 'Main text', 'mediaphase-lite' ),
		'section'  => 'mediaphase_hero',
		'settings' => 'mediaphase_hero_text',
		'type'     => 'textarea',
	) );
	// end hero banner

	// top ribbon
	$wp_customize->add_panel( 'mediaphase_ribbons', array(
		'title'    => __( 'Ribbons', 'mediaphase-lite' ),
		'priority' => 10,
	) );
	$wp_customize->add_section( 'mediaphase_top_ribbon', array(
		'title'       => __( 'Top Ribbon', 'mediaphase-lite' ),
		'priority'    => 50,
		'description' => __( 'Top ribbon section on the front page - background image and text', 'mediaphase-lite' ),
		'panel'       => 'mediaphase_ribbons',
	) );

	$wp_customize->add_setting( 'mediaphase_top_ribbon_show', array(
		'default'           => 'yes',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_top_ribbon_show', array(
		'label'    => __( 'Show top ribbon on the front page', 'mediaphase-lite' ),
		'section'  => 'mediaphase_top_ribbon',
		'settings' => 'mediaphase_top_ribbon_show',
		'type'     => 'select',
		'choices'  => array( 'yes' => __( 'Yes', 'mediaphase-lite' ), 'no' => __( 'No', 'mediaphase-lite' ) ),
	) );

	$wp_customize->add_setting( 'mediaphase_top_ribbon_bg_image', array(
		'default'           => get_template_directory_uri() . '/img/ribbon1.png',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mediaphase_top_ribbon_bg_image', array(
		'label'    => __( 'Background image', 'mediaphase-lite' ),
		'section'  => 'mediaphase_top_ribbon',
		'settings' => 'mediaphase_top_ribbon_bg_image',
	) ) );

	$wp_customize->add_setting( 'mediaphase_top_ribbon_text', array(
		'default'			=> 'Download it free from the WordPress Repository <i class="fa fa-cloud-download"></i>',
		'sanitize_callback' => 'mediaphase_sanitize_textarea',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_top_ribbon_text', array(
		'label'   => __( 'Text', 'mediaphase-lite' ),
		'section' => 'mediaphase_top_ribbon',
	) );
	// end top ribbon

	// main features
	$wp_customize->add_section( 'mediaphase_main_features', array(
		'title'       => __( 'Main Features', 'mediaphase-lite' ),
		'priority'    => 50,
		'description' => __( 'Main features section (front page, widgetized area)', 'mediaphase-lite' ),
		'panel'       => 'mediaphase_homepage',
	) );

	$wp_customize->add_setting( 'mediaphase_main_features_show', array(
		'default'           => 'yes',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_main_features_show', array(
		'label'    => __( 'Show main features on the front page', 'mediaphase-lite' ),
		'section'  => 'mediaphase_main_features',
		'settings' => 'mediaphase_main_features_show',
		'type'     => 'select',
		'choices'  => array( 'yes' => __( 'Yes', 'mediaphase-lite' ), 'no' => __( 'No', 'mediaphase-lite' ) ),
	) );

	$wp_customize->add_setting( 'mediaphase_main_features_bg_image', array(
		'default'           => get_template_directory_uri() . '/img/iphones.png',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mediaphase_main_features_bg_image', array(
		'label'    => __( 'Background image', 'mediaphase-lite' ),
		'section'  => 'mediaphase_main_features',
		'settings' => 'mediaphase_main_features_bg_image',
	) ) );

	$wp_customize->add_setting( 'mediaphase_main_features_title', array(
		'default'			=> 'MediaPhase is a Sweet MultiPurpose Theme',
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_main_features_title', array(
		'label'   => __( 'Text', 'mediaphase-lite' ),
		'section' => 'mediaphase_main_features',
	) );
	// end main features

	// sub features
	$wp_customize->add_section( 'mediaphase_sub_features', array(
		'title'       => __( 'Sub Features', 'mediaphase-lite' ),
		'priority'    => 50,
		'description' => __( 'Sub features section (front page, widgetized area)', 'mediaphase-lite' ),
		'panel'       => 'mediaphase_homepage',
	) );

	$wp_customize->add_setting( 'mediaphase_sub_features_show', array(
		'default'           => 'yes',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_sub_features_show', array(
		'label'    => __( 'Show sub features on the front page', 'mediaphase-lite' ),
		'section'  => 'mediaphase_sub_features',
		'settings' => 'mediaphase_sub_features_show',
		'type'     => 'select',
		'choices'  => array( 'yes' => __( 'Yes', 'mediaphase-lite' ), 'no' => __( 'No', 'mediaphase-lite' ) ),
	) );
	// end sub features

	// about us
	$wp_customize->add_section( 'mediaphase_about_us', array(
		'title'       => __( 'About us', 'mediaphase-lite' ),
		'priority'    => 50,
		'description' => __( 'About us section (front page)', 'mediaphase-lite' ),
		'panel'       => 'mediaphase_homepage',
	) );

	$wp_customize->add_setting( 'mediaphase_about_us_show', array(
		'default'           => 'yes',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_about_us_show', array(
		'label'    => __( 'Show about us section on the front page', 'mediaphase-lite' ),
		'section'  => 'mediaphase_about_us',
		'settings' => 'mediaphase_about_us_show',
		'type'     => 'select',
		'choices'  => array( 'yes' => __( 'Yes', 'mediaphase-lite' ), 'no' => __( 'No', 'mediaphase-lite' ) ),
	) );

	$wp_customize->add_setting( 'mediaphase_about_us_title', array(
		'default'			=> 'About us',
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_about_us_title', array(
		'label'   => __( 'Title', 'mediaphase-lite' ),
		'section' => 'mediaphase_about_us',
	) );

	$wp_customize->add_setting( 'mediaphase_about_us_text', array(
		'default'			=> 'Here is a special area where you can write about yourself or your company, use it to write a short intro or a welcome message. Use it to tell the world how great your are and draw attention to some of your businesses sucess stories.This text is editable via the customizer, if you wish you can also hide this block from view completely.',
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_about_us_text', array(
		'label'   => __( 'Text', 'mediaphase-lite' ),
		'section' => 'mediaphase_about_us',
	) );
	// end about us

	// middle ribbon
	$wp_customize->add_section( 'mediaphase_middle_ribbon', array(
		'title'       => __( 'Middle Ribbon', 'mediaphase-lite' ),
		'priority'    => 50,
		'description' => __( 'Middle ribbon section on the front page - background image and text', 'mediaphase-lite' ),
		'panel'       => 'mediaphase_ribbons',
	) );

	$wp_customize->add_setting( 'mediaphase_middle_ribbon_show', array(
		'default'           => 'yes',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_middle_ribbon_show', array(
		'label'    => __( 'Show middle ribbon on the front page', 'mediaphase-lite' ),
		'section'  => 'mediaphase_middle_ribbon',
		'settings' => 'mediaphase_middle_ribbon_show',
		'type'     => 'select',
		'choices'  => array( 'yes' => __( 'Yes', 'mediaphase-lite' ), 'no' => __( 'No', 'mediaphase-lite' ) ),
	) );

	$wp_customize->add_setting( 'mediaphase_middle_ribbon_bg_image', array(
		'default'           => get_template_directory_uri() . '/img/ribbon2.png',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mediaphase_middle_ribbon_bg_image', array(
		'label'    => __( 'Background image', 'mediaphase-lite' ),
		'section'  => 'mediaphase_middle_ribbon',
		'settings' => 'mediaphase_middle_ribbon_bg_image',
	) ) );

	$wp_customize->add_setting( 'mediaphase_middle_ribbon_text', array(
		'default'			=> '<p>Download it free from the WordPress Repository <i class="fa fa-cloud-download"></i></p><a class="button herobutton clear">Join Now <i class="fa fa-chevron-circle-right"></i></a>',
		'sanitize_callback' => 'mediaphase_sanitize_textarea',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_middle_ribbon_text', array(
		'label'   => __( 'Text', 'mediaphase-lite' ),
		'section' => 'mediaphase_middle_ribbon',
	) );
	// end middle ribbon

	// meet the team
	$wp_customize->add_section( 'mediaphase_meet_the_team', array(
		'title'       => __( 'Meet the team', 'mediaphase-lite' ),
		'priority'    => 50,
		'description' => __( 'Meet the team section (front page)', 'mediaphase-lite' ),
		'panel'       => 'mediaphase_homepage',
	) );

	$wp_customize->add_setting( 'mediaphase_meet_the_team_show', array(
		'default'           => 'yes',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_meet_the_team_show', array(
		'label'    => __( 'Show meet the team section on the front page', 'mediaphase-lite' ),
		'section'  => 'mediaphase_meet_the_team',
		'settings' => 'mediaphase_meet_the_team_show',
		'type'     => 'select',
		'choices'  => array( 'yes' => __( 'Yes', 'mediaphase-lite' ), 'no' => __( 'No', 'mediaphase-lite' ) ),
	) );

	$wp_customize->add_setting( 'mediaphase_meet_the_team_title', array(
		'default'			=> 'Meet The Team',
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_meet_the_team_title', array(
		'label'   => __( 'Title', 'mediaphase-lite' ),
		'section' => 'mediaphase_meet_the_team',
	) );

	$wp_customize->add_setting( 'mediaphase_meet_the_team_text', array(
		'default'			=> 'We have built some custom widgets so you can show off your staff members here along with their social media profile links. You can edit this text in the customizer.',
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_meet_the_team_text', array(
		'label'   => __( 'Text', 'mediaphase-lite' ),
		'section' => 'mediaphase_meet_the_team',
	) );
	// end meet the team

	// latest news
	$wp_customize->add_section( 'mediaphase_latest_news', array(
		'title'       => __( 'Latest news', 'mediaphase-lite' ),
		'priority'    => 50,
		'description' => __( 'Latest news section (front page)', 'mediaphase-lite' ),
		'panel'       => 'mediaphase_homepage',
	) );

	$wp_customize->add_setting( 'mediaphase_latest_news_show', array(
		'default'           => 'yes',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_latest_news_show', array(
		'label'    => __( 'Show latest news section on the front page', 'mediaphase-lite' ),
		'section'  => 'mediaphase_latest_news',
		'settings' => 'mediaphase_latest_news_show',
		'type'     => 'select',
		'choices'  => array( 'yes' => __( 'Yes', 'mediaphase-lite' ), 'no' => __( 'No', 'mediaphase-lite' ) ),
	) );

	$wp_customize->add_setting( 'mediaphase_latest_news_title', array(
		'default'			=> 'Latest News',
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_latest_news_title', array(
		'label'   => __( 'Title', 'mediaphase-lite' ),
		'section' => 'mediaphase_latest_news',
	) );

	$wp_customize->add_setting( 'mediaphase_latest_news_text', array(
		'default'			=> 'This is where you can display your latest blog posts, you can choose how many items to show or hide this block completely - this text is editable in the customizer.',
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_latest_news_text', array(
		'label'   => __( 'Text', 'mediaphase-lite' ),
		'section' => 'mediaphase_latest_news',
	) );

	$wp_customize->add_setting( 'mediaphase_latest_news_item_limit', array(
		'sanitize_callback' => 'mediaphase_sanitize_integer',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'default'           => 3,
	) );
	$wp_customize->add_control( 'mediaphase_latest_news_item_limit', array(
		'label'   => __( 'Number of news items to show', 'mediaphase-lite' ),
		'section' => 'mediaphase_latest_news',
	) );
	// end latest news

	// bottom ribbon
	$wp_customize->add_section( 'mediaphase_bottom_ribbon', array(
		'title'       => __( 'Bottom Ribbon', 'mediaphase-lite' ),
		'priority'    => 50,
		'description' => __( 'Bottom ribbon section on the front page - background image and text', 'mediaphase-lite' ),
		'panel'       => 'mediaphase_ribbons',
	) );

	$wp_customize->add_setting( 'mediaphase_bottom_ribbon_show', array(
		'default'           => 'yes',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_bottom_ribbon_show', array(
		'label'    => __( 'Show bottom ribbon on the front page', 'mediaphase-lite' ),
		'section'  => 'mediaphase_bottom_ribbon',
		'settings' => 'mediaphase_bottom_ribbon_show',
		'type'     => 'select',
		'choices'  => array( 'yes' => __( 'Yes', 'mediaphase-lite' ), 'no' => __( 'No', 'mediaphase-lite' ) ),
	) );

	$wp_customize->add_setting( 'mediaphase_bottom_ribbon_bg_image', array(
		'default'           => get_template_directory_uri() . '/img/ribbon3.png',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mediaphase_bottom_ribbon_bg_image', array(
		'label'    => __( 'Background image', 'mediaphase-lite' ),
		'section'  => 'mediaphase_bottom_ribbon',
		'settings' => 'mediaphase_bottom_ribbon_bg_image',
	) ) );

	$wp_customize->add_setting( 'mediaphase_bottom_ribbon_text', array(
		'default'			=> '<p>Download it free from the WordPress Repository <i class="fa fa-cloud-download"></i></p><a class="button herobutton clear">Join Now <i class="fa fa-chevron-circle-right"></i></a>',
		'sanitize_callback' => 'mediaphase_sanitize_textarea',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mediaphase_bottom_ribbon_text', array(
		'label'   => __( 'Text', 'mediaphase-lite' ),
		'section' => 'mediaphase_bottom_ribbon',
	) );
	// end bottom ribbon

	// logos
	$wp_customize->add_section( 'mediaphase_logos', array(
		'title'       => __( 'Customer Logos', 'mediaphase-lite' ),
		'priority'    => 50,
		'description' => __( 'Logos section on the front page', 'mediaphase-lite' ),
		'panel'       => 'mediaphase_homepage',
	) );

	$wp_customize->add_setting( 'mediaphase_logos_show', array(
		'default'           => 'yes',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_logos_show', array(
		'label'    => __( 'Show logos on the front page', 'mediaphase-lite' ),
		'section'  => 'mediaphase_logos',
		'settings' => 'mediaphase_logos_show',
		'type'     => 'select',
		'choices'  => array( 'yes' => __( 'Yes', 'mediaphase-lite' ), 'no' => __( 'No', 'mediaphase-lite' ) ),
	) );

	$wp_customize->add_setting( 'mediaphase_logos_image', array(
		'default'           => get_template_directory_uri() . '/img/logos.png',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mediaphase_logos_image', array(
		'label'    => __( 'Logos image', 'mediaphase-lite' ),
		'section'  => 'mediaphase_logos',
		'settings' => 'mediaphase_logos_image',
	) ) );
	// end logos

	// footer logo
	$wp_customize->add_section( 'mediaphase_footer_logo', array(
		'title'    => __( 'Footer logo', 'mediaphase-lite' ),
		'priority' => 50,
	) );

	$wp_customize->add_setting( 'mediaphase_footer_logo_show', array(
		'default'           => 'no',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_footer_logo_show', array(
		'label'    => __( 'Show footer logo', 'mediaphase-lite' ),
		'section'  => 'mediaphase_footer_logo',
		'settings' => 'mediaphase_footer_logo_show',
		'type'     => 'select',
		'choices'  => array( 'yes' => __( 'Yes', 'mediaphase-lite' ), 'no' => __( 'No', 'mediaphase-lite' ) ),
	) );

	$wp_customize->add_setting( 'mediaphase_footer_logo_image', array(
		'default'           => get_template_directory_uri() . '/img/logo.png',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mediaphase_footer_logo_image', array(
		'label'    => __( 'Logo image', 'mediaphase-lite' ),
		'section'  => 'mediaphase_footer_logo',
		'settings' => 'mediaphase_footer_logo_image',
	) ) );
	// end footer logo

	// fullwidth page
	$wp_customize->add_section( 'mediaphase_page_fullwidth', array(
		'title'    => __( 'Full width page', 'mediaphase-lite' ),
		'priority' => 50,
	) );

	$wp_customize->add_setting( 'mediaphase_page_fullwidth', array(
		'default'           => 'no',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_page_fullwidth', array(
		'label'    => __( 'Make the pages full width', 'mediaphase-lite' ),
		'section'  => 'mediaphase_page_fullwidth',
		'settings' => 'mediaphase_page_fullwidth',
		'type'     => 'select',
		'choices'  => array( 'no' => __( 'No', 'mediaphase-lite' ), 'yes' => __( 'Yes', 'mediaphase-lite' ) ),
	) );
	// end full width page

	// google fonts
	require_once( dirname( __FILE__ ) . '/google-fonts/fonts.php' );


	$wp_customize->add_section( 'mediaphase_google_fonts', array(
		'title'    => __( 'Fonts', 'mediaphase-lite' ),
		'priority' => 50,
	) );

	$wp_customize->add_setting( 'mediaphase_google_fonts_heading_font', array(
		'default'           => 'none',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_google_fonts_heading_font', array(
		'label'    => __( 'Header Font', 'mediaphase-lite' ),
		'section'  => 'mediaphase_google_fonts',
		'settings' => 'mediaphase_google_fonts_heading_font',
		'type'     => 'select',
		'choices'  => $font_choices,
	) );

	$wp_customize->add_setting( 'mediaphase_google_fonts_body_font', array(
		'default'           => 'none',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'mediaphase_google_fonts_body_font', array(
		'label'    => __( 'Body Font', 'mediaphase-lite' ),
		'section'  => 'mediaphase_google_fonts',
		'settings' => 'mediaphase_google_fonts_body_font',
		'type'     => 'select',
		'choices'  => $font_choices,
	) );
	// end google fonts

	// colors
	$wp_customize->add_panel( 'mediaphase_colors', array(
		'title'    => __( 'Colors', 'mediaphase-lite' ),
		'priority' => 10,
	) );

	$wp_customize->add_section( 'colors', array(
			'title'       => __( 'Customize theme colors', 'mediaphase-lite' ),
			'description' => sprintf( __( '%1$s %2$s.', 'mediaphase-lite' ), '<a href="//themefurnace.com/">Upgrade</a>', 'to a paid plan for more customization options, access to 17 more themes and support' ),
			'priority'    => 35,
			'panel'       => 'mediaphase_colors',
		)
	);

	// end colors

}

add_action( 'customize_register', 'mediaphase_customizer', 11 );