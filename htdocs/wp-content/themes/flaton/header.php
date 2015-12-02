<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package flaton
 */
global $flaton;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function flaton_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'flaton_render_title' );
endif;
?>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'flaton' ); ?></a>
	
	<?php do_action('flaton_before_header'); ?>
	<header id="masthead" class="site-header" role="banner">
	<?php if( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" style="position: absolute;" />
	<?php endif; ?>
		<div class="container">
			<div class="sixteen columns">
					<div class="logo site-branding">
						<?php if( isset( $flaton['site-title'] ) && isset( $flaton['custom-logo'] ) && $flaton['site-title'] ) : ?>
							<img src="<?php echo esc_url( $flaton['custom-logo']['url'] ); ?>" alt="logo" >
						<?php else : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php if( isset( $flaton['site-description'] ) && $flaton['site-description'] != 0 ) : ?>
								<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
							<?php endif; ?>
						<?php endif; ?>
						<?php if( ! isset( $flaton['site-description'] ) ) : ?>
							<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						<?php endif; ?>
					</div>
				</div>
		</div>
		
		<?php do_action('flaton_before_navigation'); ?>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="container">
				<div class="sixteen columns">
					<button class="menu-toggle"><?php _e( 'Primary Menu', 'flaton' ); ?></button>
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				</div>
			</div>
		</nav><!-- #site-navigation -->
		<?php do_action('flaton_after_navigation'); ?>

	</header><!-- #masthead -->
	<?php do_action('flaton_after_header'); ?>

<?php	if ( ! is_front_page() ) : ?>
	<div id="content" class="site-content container">
<?php endif; ?>
