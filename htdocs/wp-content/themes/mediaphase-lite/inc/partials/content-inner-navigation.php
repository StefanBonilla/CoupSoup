<?php
/**
 * The template part for displaying breadcrumbs in blog template.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mediaphase
 */
?>

<div id="innernav">
	<div class="wrap">
		<h2 class="innerheading"><?php the_title(); ?></h2>

		<div class="innerbreadcrumbs"><?php mediaphase_breadcrumb(); ?></div>
	</div>
</div>