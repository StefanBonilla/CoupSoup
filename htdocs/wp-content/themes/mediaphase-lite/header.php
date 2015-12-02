<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package mediaphase
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
<div class="container">

	<div id="header" class="clearfix">
		<div class="wrap">
			<div id="site-branding">
				<div class="site-title">
					<a href="<?php echo esc_url( home_url() ); ?>" rel="home">
						<?php
						$mediaphase_display_header_logo = get_theme_mod( 'mediaphase_header_logo_show', 'text' );
						if ( $mediaphase_display_header_logo === 'logo' ) {
							echo '<img src="' . esc_url( get_theme_mod( 'mediaphase_header_logo_image' ) ) . '" />';
							echo '<h1 style="display: none;">' . esc_html( get_theme_mod( 'mediaphase_header_logo_text' ) ) . '</h1>';
						} else {
							echo '<img style="display: none;" src="' . esc_url( get_theme_mod( 'mediaphase_header_logo_image' ) ) . '" />';
							echo '<h1>' . esc_html( get_theme_mod( 'mediaphase_header_logo_text', get_bloginfo( 'name' ) ) ) . '</h1>';
						}
						?>
					</a>
				</div>
				<div class="site-description"><span><?php bloginfo( 'description' ); ?></span></div>

				<div id="cssmenu">
					<?php
					global $wp_customize;
					if ( !empty( $wp_customize ) && $wp_customize->is_preview() && !get_theme_mod( 'mediaphase_content_set', false ) ) {
						?>
						<ul>
							<li id="menu-item-16"
								class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-16">
								<a href="#">Home</a></li>
							<li id="menu-item-17"
								class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home current-menu-ancestor current-menu-parent menu-item-has-children menu-item-17 has-sub">
								<span class="submenu-button"></span><a href="#">Products</a>
								<ul class="sub-menu">
									<li id="menu-item-18"
										class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-18">
										<a href="#">Product 1</a></li>
									<li id="menu-item-19"
										class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-19">
										<a href="#">Product 2</a></li>
									<li id="menu-item-20"
										class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20">
										<a href="#">Product 3</a></li>
								</ul>
							</li>
							<li id="menu-item-21"
								class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-21">
								<a href="#">About</a></li>
							<li id="menu-item-22"
								class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-22">
								<a href="#">Contact</a></li>
						</ul>
					<?php
					} else {
						wp_nav_menu( array(
								'theme_location' => 'primary',
								'container'      => false,
								'items_wrap'     => '<ul>%3$s</ul>',
								'depth'          => 0,
								'fallback_cb'    => 'mediaphase_fallback_menu',
							)
						);
					}
					?>
				</div>
				<!-- End #CSSMenu -->
			</div>
		</div>
	</div>
	<!-- End #header -->

	<div id="subheader" class="clearfix">
		<div class="wrap">
			<?php
			$mediaphase_show_contacts = get_theme_mod( 'mediaphase_header_contacts_show', 'yes' );
			if ( $mediaphase_show_contacts === 'yes' ) : ?>
				<div class="contactdetails">
					<?php
					$mediaphase_contact_phone = get_theme_mod( 'mediaphase_header_contacts_phone' );
					if ( !empty( $mediaphase_contact_phone ) ) {
						echo '<span class="contact-phone"><i class="fa fa-phone-square"></i> ' . esc_html( $mediaphase_contact_phone ) . ' </span>';
					}
					$mediaphase_contact_email = get_theme_mod( 'mediaphase_header_contacts_email' );
					if ( !empty( $mediaphase_contact_email ) ) {
						echo '<span class="contact-email"><i class="fa fa-envelope"></i> ' . esc_html( $mediaphase_contact_email ) . ' </span>';
					}
					?>
				</div>
			<?php endif; ?>
			<div class="topsearch">
				<form><span class="fa fa-search"></span><input type="text" class="search-field" value="" name="s"/>
					<input type="submit" class="search-submit" value="Go"/></form>
			</div>

			<!-- #menu-social -->
			<?php get_template_part( 'inc/partials/menu', 'social' ); ?>
			<!-- End #menu-social -->

		</div>
	</div>
