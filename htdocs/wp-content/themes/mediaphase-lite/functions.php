<?php
/**
 * mediaphase functions and definitions
 *
 * @package mediaphase
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( !isset( $content_width ) ) {
	$content_width = 700; /* pixels */
}

if ( !function_exists( 'mediaphase_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mediaphase_setup()
	{

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on mediaphase, use a find and replace
		 * to change 'mediaphase-lite' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'mediaphase-lite', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
		) );

		// enable featured images
		add_theme_support( 'post-thumbnails' );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'mediaphase_custom_background_args', array(
			'default-color' => 'e2e2e2',
			'default-image' => '',
			'panel'         => 'mediaphase_colors',
		) ) );

		add_image_size( 'mediaphase-frontpage-news', 300, 220, true );
		add_image_size( 'mediaphase-blog-large', 700, 313, true );
	}
endif; // mediaphase_setup
add_action( 'after_setup_theme', 'mediaphase_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function mediaphase_widgets_init()
{
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'mediaphase-lite' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<div class="sidebarwidget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="sidebartitle"><i class="fa fa-chevron-circle-right"></i>',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Main Features Left', 'mediaphase-lite' ),
		'id'            => 'mediaphase-main-features-left',
		'before_widget' => '<div class="featurewidget hideme">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="featurewidgettitle">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Main Features Right', 'mediaphase-lite' ),
		'id'            => 'mediaphase-main-features-right',
		'before_widget' => '<div class="featurewidget hideme">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="featurewidgettitle">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sub Features', 'mediaphase-lite' ),
		'id'            => 'mediaphase-sub-features',
		'before_widget' => '<div class="featurewidget hideme">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="featurewidgettitle">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer', 'mediaphase-lite' ),
		'id'            => 'mediaphase-footer',
		'before_widget' => '<div class="footerwidget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="footerwidgettitle">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Team', 'mediaphase-lite' ),
		'id'            => 'mediaphase-team',
		'before_widget' => '<div class="member hideme">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="membertitle">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'mediaphase_widgets_init' );

// Load Roboto Font
function mediaphase_fonts_url()
{
	$fonts_url = '';
	$font_families = array();

	// default font - Roboto
	$roboto = _x( 'on', 'Roboto font: on or off', 'mediaphase-lite' );
	$heading_font_family = get_theme_mod( 'mediaphase_google_fonts_heading_font', null );
	$body_font_family = get_theme_mod( 'mediaphase_google_fonts_body_font', null );

	if ( 'off' !== $roboto ) {
		$font_families[] = 'Roboto:300,400,700,300italic,400italic,700italic';
	}

	if ( !empty( $heading_font_family ) && $heading_font_family !== 'none' ) {
		$heading_font = _x( 'on', $heading_font_family . ' font: on or off', 'mediaphase-lite' );
		if ( 'off' !== $heading_font ) {
			$font_families[] = $heading_font_family;
		}
	}

	if ( !empty( $body_font_family ) && $body_font_family !== 'none' && $body_font_family !== $heading_font_family ) {
		$body_font = _x( 'on', $body_font_family . ' font: on or off', 'mediaphase-lite' );
		if ( 'off' !== $body_font ) {
			$font_families[] = $body_font_family;
		}
	}

	// if both body and heading fonts are set in customizer,
	// don't include default Roboto font
	if ( count( $font_families ) === 3 ) {
		array_shift( $font_families );
	}

	if ( !empty( $font_families ) ) {
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles.
 */
function mediaphase_scripts()
{
	wp_enqueue_style( 'mediaphase-style', get_stylesheet_uri() );
	wp_enqueue_style( 'mediaphase-font-awesome', get_template_directory_uri() . '/inc/css/font-awesome-4.3.0.min.css' );
	wp_enqueue_style( 'mediaphase-fonts', mediaphase_fonts_url(), array(), null );
	wp_enqueue_script( 'mediaphase-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'mediaphase-fade', get_template_directory_uri() . '/inc/js/fade.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'mediaphase-menu', get_template_directory_uri() . '/inc/js/script.js', array( 'jquery' ), '20120206', true );

	wp_enqueue_script( 'mediaphase-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'mediaphase_scripts' );

function mediaphase_set_sample_content()
{
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'mediaphase-lite' ),
		'social'  => __( 'Social', 'mediaphase-lite' ),
	) );

	// Add default items to primary menu
	$primary_menu_items = wp_get_nav_menu_items( 'primary' );
	if ( empty( $primary_menu_items ) ) {
		$name = 'primary';
		$menu_id = wp_create_nav_menu( $name );
		$menu = get_term_by( 'name', $name, 'nav_menu' );

		wp_update_nav_menu_item( $menu->term_id, 0, array(
				'menu-item-title'  => __( 'Home', 'mediaphase-lite' ),
				'menu-item-url'    => home_url( '/' ),
				'menu-item-status' => 'publish' )
		);

		$product_id = wp_update_nav_menu_item( $menu->term_id, 0, array(
				'menu-item-title'  => __( 'Products', 'mediaphase-lite' ),
				'menu-item-url'    => home_url( '/' ),
				'menu-item-status' => 'publish' )
		);

		wp_update_nav_menu_item( $menu->term_id, 0, array(
			'menu-item-title'     => __( 'Product 1', 'mediaphase-lite' ),
			'menu-item-url'       => home_url( '/' ),
			'menu-item-status'    => 'publish',
			'menu-item-parent-id' => $product_id,
		) );

		wp_update_nav_menu_item( $menu->term_id, 0, array(
			'menu-item-title'     => __( 'Product 2', 'mediaphase-lite' ),
			'menu-item-url'       => home_url( '/' ),
			'menu-item-status'    => 'publish',
			'menu-item-parent-id' => $product_id,
		) );

		wp_update_nav_menu_item( $menu->term_id, 0, array(
			'menu-item-title'     => __( 'Product 3', 'mediaphase-lite' ),
			'menu-item-url'       => home_url( '/' ),
			'menu-item-status'    => 'publish',
			'menu-item-parent-id' => $product_id,
		) );

		wp_update_nav_menu_item( $menu->term_id, 0, array(
				'menu-item-title'  => __( 'About', 'mediaphase-lite' ),
				'menu-item-url'    => home_url( '/' ),
				'menu-item-status' => 'publish' )
		);

		wp_update_nav_menu_item( $menu->term_id, 0, array(
				'menu-item-title'  => __( 'Contact', 'mediaphase-lite' ),
				'menu-item-url'    => home_url( '/' ),
				'menu-item-status' => 'publish' )
		);

		$locations = get_theme_mod( 'nav_menu_locations' );
		$locations['primary'] = $menu->term_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	// Add default items to social menu
	$social_menu_items = wp_get_nav_menu_items( 'social' );
	if ( empty( $social_menu_items ) ) {
		$name = 'social';
		$menu_id = wp_create_nav_menu( $name );
		$menu = get_term_by( 'name', $name, 'nav_menu' );

		wp_update_nav_menu_item( $menu->term_id, 0, array(
				'menu-item-title'  => __( 'Twitter', 'mediaphase-lite' ),
				'menu-item-url'    => 'http://twitter.com/',
				'menu-item-status' => 'publish' )
		);

		wp_update_nav_menu_item( $menu->term_id, 0, array(
				'menu-item-title'  => __( 'WordPress', 'mediaphase-lite' ),
				'menu-item-url'    => 'http://wordpress.com',
				'menu-item-status' => 'publish' )
		);

		wp_update_nav_menu_item( $menu->term_id, 0, array(
				'menu-item-title'  => __( 'Facebook', 'mediaphase-lite' ),
				'menu-item-url'    => 'http://facebook.com/',
				'menu-item-status' => 'publish' )
		);

		wp_update_nav_menu_item( $menu->term_id, 0, array(
				'menu-item-title'  => __( 'Dribbble', 'mediaphase-lite' ),
				'menu-item-url'    => 'http://dribbble.com/',
				'menu-item-status' => 'publish' )
		);

		wp_update_nav_menu_item( $menu->term_id, 0, array(
				'menu-item-title'  => __( 'Google+', 'mediaphase-lite' ),
				'menu-item-url'    => 'http://plus.google.com/',
				'menu-item-status' => 'publish' )
		);

		$locations = get_theme_mod( 'nav_menu_locations' );
		$locations['social'] = $menu->term_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	// set sample content - text, images, titles, team members
	if ( !get_theme_mod( 'mediaphase_content_set', false ) ) {
		// set up default widgets
		$active_sidebars = get_option( 'sidebars_widgets' );
		$search_widget = get_option( 'widget_search' );
		$search_widget[1] = array( 'title' => __( 'Search', 'mediaphase-lite' ) );

		$categories_widget = get_option( 'widget_categories' );
		$categories_widget[1] = array( 'title' => __( 'Categories', 'mediaphase-lite' ), 'count' => 1 );

		$recent_posts_widget = get_option( 'widget_recent-posts' );
		$recent_posts_widget[1] = array( 'title' => __( 'Recent Posts', 'mediaphase-lite' ), 'show_date' => 1, 'number' => 5 );
		$recent_posts_widget[2] = array( 'title' => __( 'Recent Posts', 'mediaphase-lite' ), 'show_date' => 1, 'number' => 5 );

		$recent_comments_widget = get_option( 'widget_recent-comments' );
		$recent_comments_widget[1] = array( 'title' => __( 'Recent Comments', 'mediaphase-lite' ) );

		$meta_widget = get_option( 'widget_meta' );
		$meta_widget[1] = array( 'title' => __( 'Meta', 'mediaphase-lite' ) );

		$text_widget = get_option( 'widget_text' );
		$text_widget[1] = array( 'title' => __( 'Text Widget', 'mediaphase-lite' ), 'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean dapibus erat eget rhoncus facilisis. Duis et lacus ut tellus fermentum ultricies quis sit amet mauris. Nullam molestie, mauris ac ultrices tincidunt, sapien turpis rhoncus tellus, sed sagittis dui felis molestie risus.' );

		$navigation_widget = get_option( 'widget_nav_menu' );
		$navigation_widget[1] = array( 'title' => __( 'Browse Site', 'mediaphase-lite' ), 'nav_menu' => 'primary.' );

		$team_member_widget = get_option( 'widget_mediaphase-team-member-widget' );
		$team_member_widget[1] = array( 'title' => __( 'Member 1', 'mediaphase-lite' ), 'textbox' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque', 'social_twitter' => 'http://twitter.com', 'social_facebook' => 'http://facebook.com', 'social_dribbble' => 'http://dribbble.com', 'social_linkedin' => 'http://linkedin.com', 'social_gplus' => 'http://plus.google.com', 'image_url' => get_template_directory_uri() . '/img/staff1.jpg' );
		$team_member_widget[2] = array( 'title' => __( 'Member 2', 'mediaphase-lite' ), 'textbox' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque', 'social_twitter' => 'http://twitter.com', 'social_facebook' => 'http://facebook.com', 'social_dribbble' => 'http://dribbble.com', 'social_linkedin' => 'http://linkedin.com', 'social_gplus' => 'http://plus.google.com', 'image_url' => get_template_directory_uri() . '/img/staff1.jpg' );
		$team_member_widget[3] = array( 'title' => __( 'Member 3', 'mediaphase-lite' ), 'textbox' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque', 'social_twitter' => 'http://twitter.com', 'social_facebook' => 'http://facebook.com', 'social_dribbble' => 'http://dribbble.com', 'social_linkedin' => 'http://linkedin.com', 'social_gplus' => 'http://plus.google.com', 'image_url' => get_template_directory_uri() . '/img/staff1.jpg' );

		$main_features_widget = get_option( 'widget_mediaphase-feature-widget' );
		$main_features_widget[1] = array( 'title' => 'Feature 1', 'textbox' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p>', 'url' => home_url( '/' ), 'icon' => 'fa-camera' );
		$main_features_widget[2] = array( 'title' => 'Feature 2', 'textbox' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p>', 'url' => home_url( '/' ), 'icon' => 'fa-check' );
		$main_features_widget[3] = array( 'title' => 'Feature 3', 'textbox' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p>', 'url' => home_url( '/' ), 'icon' => 'fa-eye' );
		$main_features_widget[4] = array( 'title' => 'Feature 4', 'textbox' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p>', 'url' => home_url( '/' ), 'icon' => 'fa-info' );
		$main_features_widget[5] = array( 'title' => 'Sub Feature 1', 'textbox' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p><a class="button red">Read More <i class="fa fa-chevron-circle-right"></i></a>', 'url' => home_url( '/' ), 'icon' => 'fa-camera' );
		$main_features_widget[6] = array( 'title' => 'Sub Feature 2', 'textbox' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p><a class="button red">Read More <i class="fa fa-chevron-circle-right"></i></a>', 'url' => home_url( '/' ), 'icon' => 'fa-check' );
		$main_features_widget[7] = array( 'title' => 'Sub Feature 3', 'textbox' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p><a class="button red">Read More <i class="fa fa-chevron-circle-right"></i></a>', 'url' => home_url( '/' ), 'icon' => 'fa-eye' );

		$active_sidebars['mediaphase-footer'] = array( 'recent-posts-1', 'recent-comments-1', 'meta-1' );
		update_option( 'widget_recent-posts', $recent_posts_widget );
		update_option( 'widget_recent-comments', $recent_comments_widget );
		update_option( 'widget_meta', $meta_widget );
		update_option( 'sidebars_widgets', $active_sidebars );

		$active_sidebars['sidebar-1'] = array( 'recent-posts-2', 'text-1', 'search-1', 'nav_menu-1', 'categories-1' );
		update_option( 'widget_search', $search_widget );
		update_option( 'widget_categories', $categories_widget );
		update_option( 'widget_text', $text_widget );
		update_option( 'widget_nav_menu', $navigation_widget );
		update_option( 'sidebars_widgets', $active_sidebars );

		$active_sidebars['mediaphase-team'] = array( 'mediaphase-team-member-widget-1', 'mediaphase-team-member-widget-2', 'mediaphase-team-member-widget-3' );
		update_option( 'widget_mediaphase-team-member-widget', $team_member_widget );
		update_option( 'sidebars_widgets', $active_sidebars );

		$active_sidebars['mediaphase-main-features-left'] = array( 'mediaphase-feature-widget-1', 'mediaphase-feature-widget-2' );
		update_option( 'widget_mediaphase-feature-widget', $main_features_widget );
		update_option( 'sidebars_widgets', $active_sidebars );

		$active_sidebars['mediaphase-main-features-right'] = array( 'mediaphase-feature-widget-3', 'mediaphase-feature-widget-4' );
		$active_sidebars['mediaphase-sub-features'] = array( 'mediaphase-feature-widget-5', 'mediaphase-feature-widget-6', 'mediaphase-feature-widget-7' );
		update_option( 'widget_mediaphase-feature-widget', $main_features_widget );
		update_option( 'sidebars_widgets', $active_sidebars );

		// set customizer options
		set_theme_mod( 'mediaphase_header_logo_image', get_template_directory_uri() . '/img/logo.png' );
		set_theme_mod( 'mediaphase_header_logo_text', get_bloginfo( 'name' ) );
		set_theme_mod( 'mediaphase_header_contacts_phone', '0800 123 4567' );
		set_theme_mod( 'mediaphase_header_contacts_email', 'contact@yourdomain.com' );
		set_theme_mod( 'mediaphase_hero_bg_image', get_template_directory_uri() . '/img/hero.jpg' );
		set_theme_mod( 'mediaphase_hero_title', 'MediaPhase is a Sweet MultiPurpose Theme' );
		set_theme_mod( 'mediaphase_hero_text', '<p>Lorem ipsum dolor sit amet, <a href="#">consectetur adipiscing</a> elit. Praesent vel interdum diam, in ultricies diam. Proin vehicula sagittis lorem, nec.</p>
<a href="#" class="herobutton red">Read More <i class="fa fa-chevron-circle-right"></i></a>
<a href="#" class="herobutton clear">Join Now <i class="fa fa-chevron-circle-right"></i></a>' );
		set_theme_mod( 'mediaphase_top_ribbon_bg_image', get_template_directory_uri() . '/img/ribbon1.png' );
		set_theme_mod( 'mediaphase_top_ribbon_text', 'Download it free from the WordPress Repository <i class="fa fa-cloud-download"></i>' );
		set_theme_mod( 'mediaphase_main_features_title', 'MediaPhase is a Sweet MultiPurpose Theme' );
		set_theme_mod( 'mediaphase_main_features_bg_image', get_template_directory_uri() . '/img/iphones.png' );
		set_theme_mod( 'mediaphase_about_us_title', 'About Us' );
		set_theme_mod( 'mediaphase_about_us_text', 'Here is a special area where you can write about yourself or your company, use it to write a short intro or a welcome message. Use it to tell the world how great your are and draw attention to some of your businesses sucess stories.This text is editable via the customizer, if you wish you can also hide this block from view completely.' );
		set_theme_mod( 'mediaphase_middle_ribbon_bg_image', get_template_directory_uri() . '/img/ribbon2.png' );
		set_theme_mod( 'mediaphase_middle_ribbon_text', '<p>Download it free from the WordPress Repository <i class="fa fa-cloud-download"></i></p><a class="button herobutton clear">Join Now <i class="fa fa-chevron-circle-right"></i></a>' );
		set_theme_mod( 'mediaphase_meet_the_team_title', 'Meet The Team' );
		set_theme_mod( 'mediaphase_meet_the_team_text', 'We have built some custom widgets so you can show off your staff members here along with their social media profile links. You can edit this text in the customizer.' );
		set_theme_mod( 'mediaphase_latest_news_title', 'Latest News' );
		set_theme_mod( 'mediaphase_latest_news_text', 'This is where you can display your latest blog posts, you can choose how many items to show or hide this block completely - this text is editable in the customizer.' );
		set_theme_mod( 'mediaphase_bottom_ribbon_bg_image', get_template_directory_uri() . '/img/ribbon3.png' );
		set_theme_mod( 'mediaphase_bottom_ribbon_text', '<p>Download it free from the WordPress Repository <i class="fa fa-cloud-download"></i></p><a class="button herobutton clear">Join Now <i class="fa fa-chevron-circle-right"></i></a>' );
		set_theme_mod( 'mediaphase_logos_image', get_template_directory_uri() . '/img/logos.png' );
		set_theme_mod( 'mediaphase_footer_logo_image', get_template_directory_uri() . '/img/logo.png' );

		set_theme_mod( 'mediaphase_content_set', true );
	}
}

add_action( 'after_switch_theme', 'mediaphase_set_sample_content', 100 );

function mediaphase_pagination($wp_query_object = null)
{
	global $wp_query;
	$query_object = !empty( $wp_query_object ) ? $wp_query_object : $wp_query;
	if ( !is_page() && $query_object->max_num_pages < 2 ) {
		return;
	}
	$big = 999999999; // need an unlikely integer
	echo '<div class="pagination">';
	echo paginate_links( array(
		'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format'  => '?paged=%#%',
		'current' => max( 1, get_query_var( 'paged' ) ),
		'total'   => $query_object->max_num_pages
	) );
	echo '</div>';
}


/**
 * Custom Breadcrumbs
 */
function mediaphase_breadcrumb()
{
	if ( !is_home() ) {
		echo '<a href="';
		echo esc_url( home_url() );
		echo '">';
		bloginfo( 'name' );
		echo "</a> <i class='fa fa-chevron-right'></i> ";
		if ( is_category() || is_single() ) {
			the_category( ', ' );
			if ( is_single() ) {
				echo " <i class='fa fa-chevron-right'></i> ";
				the_title();
			}
		} elseif ( is_page() ) {
			echo the_title();
		}
	}
}

function mediaphase_esc_html( $text ) {
	return strip_tags( $text, '<p><a><i><br><strong><b><em><ul><li><ol><span><h1><h2><h3><h4>' );
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis) and sets character length to 35
 */
function mediaphase_excerpt( $text )
{
	if ( $text == '' ) {
		$text = get_the_content( '' );
		$text = strip_shortcodes( $text );
		$text = apply_filters( 'the_content', $text );
		$text = str_replace( ']]>', ']]>', $text );
		$text = strip_tags( $text );
		$text = nl2br( $text );
		$excerpt_length = apply_filters( 'excerpt_length', 45 );
		$words = explode( ' ', $text, $excerpt_length + 1 );
		if ( count( $words ) > $excerpt_length ) {
			array_pop( $words );
			array_push( $words, '' );
			$text = implode( ' ', $words );
		}
	}

	return $text;
}

remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
add_filter( 'get_the_excerpt', 'mediaphase_excerpt' );

/* This code filters the Categories archive widget to include the post count inside the link */
function mediaphase_cat_count_span( $links )
{
	$links = str_replace( '</a> (', ' (', $links );
	$links = str_replace( ')', ')</a>', $links );

	return $links;
}

add_filter( 'wp_list_categories', 'mediaphase_cat_count_span' );

/* This code filters the Archive widget to include the post count inside the link */
function mediaphase_archive_count_span( $links )
{
	$links = str_replace( '</a>&nbsp;(', ' (', $links );
	$links = str_replace( ')', ')</a>', $links );

	return $links;
}

add_filter( 'get_archives_link', 'mediaphase_archive_count_span' );


// Style the Tag Cloud
function mediaphase_custom_tag_cloud_widget( $args )
{
	$args['largest'] = 12; //largest tag
	$args['smallest'] = 12; //smallest tag
	$args['unit'] = 'px'; //tag font unit
	$args['number'] = '8'; //number of tags
	return $args;
}

add_filter( 'widget_tag_cloud_args', 'mediaphase_custom_tag_cloud_widget' );


/**
 * Declare WooCommerce Compatibility
 */
function mediaphase_woocommerce_support()
{
	add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'mediaphase_woocommerce_support' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer styles, fonts
 */
require get_template_directory() . '/inc/themesetup.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Mediaphase Custom Widgets
 */

require get_template_directory() . '/inc/widgets/feature-widget.php';
require get_template_directory() . '/inc/widgets/team-member-widget.php';

/**
 * Load "time ago" library
 */
if ( !function_exists( 'mediaphase_time_ago_in_words' ) ) {
	require get_template_directory() . '/inc/timeago.inc.php';
}