<?php
/**
 * The template part for displaying breadcrumbs in search template.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mediaphase
 */
?>

<div id="innernav">
	<div class="wrap">
		<h2 class="innerheading"><?php printf( __( 'Search Results for: %s', 'mediaphase-lite' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
	</div>
</div>