<?php
/**
 * @package flaton
 */
global $flaton;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php flaton_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if( isset( $flaton['single-featured-image'] ) && $flaton['single-featured-image'] ) : ?>
			<?php if( has_post_thumbnail() ) : ?>
				<div class="post-thumb">
					<?php the_post_thumbnail(); ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'flaton' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php flaton_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
