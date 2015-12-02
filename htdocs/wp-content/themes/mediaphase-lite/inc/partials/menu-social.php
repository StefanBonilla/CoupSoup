<?php
/**
 * Social Media Menu
 * @package mediaphase
 */
global $wp_customize;
if ( !empty( $wp_customize ) && $wp_customize->is_preview() && !get_theme_mod( 'mediaphase_content_set', false ) ) {
?>
	<div id="menu-social" class="menu">
		<ul id="menu-social-items" class="menu-items">
			<li id="menu-item-11" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-11"><a href="http://twitter.com/"><span class="screen-reader-text">Twitter</span></a></li>
			<li id="menu-item-12" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-12"><a href="http://wordpress.com"><span class="screen-reader-text">WordPress</span></a></li>
			<li id="menu-item-13" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-13"><a href="http://facebook.com/"><span class="screen-reader-text">Facebook</span></a></li>
			<li id="menu-item-14" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-14"><a href="http://dribbble.com/"><span class="screen-reader-text">Dribbble</span></a></li>
			<li id="menu-item-15" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-15"><a href="http://plus.google.com/"><span class="screen-reader-text">Google+</span></a></li>
		</ul>
	</div>
<?php
} else {
	wp_nav_menu(
		array(
			'theme_location'  => 'social',
			'container'       => 'div',
			'container_id'    => 'menu-social',
			'container_class' => 'menu',
			'menu_id'         => 'menu-social-items',
			'menu_class'      => 'menu-items',
			'depth'           => 1,
			'link_before'     => '<span class="screen-reader-text">',
			'link_after'      => '</span>',
			'fallback_cb'     => '',
		)
	);
}