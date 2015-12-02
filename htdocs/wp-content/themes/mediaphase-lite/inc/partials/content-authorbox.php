<?php
/**
 * Template part to display the content for single post
 *
 * @package mediaphase
 */
?>

<div id="authorbox">
	<?php echo get_avatar( get_the_author_meta( 'email' ), '120' ); ?>
	<div class="authorinfo">
		<h3 class="author-title">Written by <?php the_author_link(); ?></h3>

		<p class="author-description"><?php the_author_meta( 'description' ); ?></p>

		<p class="author-website"><i class="fa fa-external-link"></i> <a
				href="<?php esc_url( the_author_meta( 'user_url' ) ); ?>"><?php the_author_meta( 'user_url' ); ?></a></p>
	</div>
</div>