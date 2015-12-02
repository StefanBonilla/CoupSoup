<?php
/**
 * @package flaton
 */
global $flaton;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php flaton_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if( isset($flaton['featured-image'] ) && $flaton['featured-image'] ) : ?>
			<div class="thumb">
				<?php 
					if( has_post_thumbnail() && ! post_password_required() ) : 
						the_post_thumbnail(); 
					else :
						echo '<img src="' . FLATON_CHILD_URL . '/images/thumbnail-default.png" />';
					endif;
				?>
			</div>
		<?php endif; ?>
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'flaton' ), 
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>

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
