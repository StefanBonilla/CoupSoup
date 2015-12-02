<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package mediaphase
 */
?>

<div class="singlepost">
	<?php the_post_thumbnail( 'mediaphase-blog-large', array( 'class' => 'singlepostimage' ) ); ?>
	<p class="newscategory">
		<?php
		$mediaphase_categories = get_the_category();
		if ( !empty( $mediaphase_categories ) ) {
			foreach ( $mediaphase_categories as $index => $category ) {
				echo '<a href="' . esc_url( home_url() . '/?cat=' . $category->term_id ) . '">' . $category->name . '</a>' . ( $index !== count( $mediaphase_categories ) - 1 ? ', ' : '' );
			}
		}
		?>
	</p>

	<h1 class="singleposttitle"><?php the_title(); ?></h1>

	<p class="newsauthor"><?php _e( 'Posted By', 'mediaphase-lite' ); ?> <a
			href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"
			class="authorname"><?php the_author(); ?></a></p>

	<div class="content">
		<?php
		the_content();
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'mediaphase-lite' ),
			'after'  => '</div>',
		) );
		mediaphase_the_post_navigation();
		edit_post_link( __( 'Edit', 'mediaphase-lite' ), '<span class="edit-link">', '</span>' );
		?>
	</div>
	<ul class="newsmeta">
		<li class="newscomments"><i
				class="fa fa-comments-o"></i> <?php if ( !post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<?php comments_popup_link( __( 'Leave a comment', 'mediaphase-lite' ), __( '1 Comment', 'mediaphase-lite' ), __( '% Comments', 'mediaphase-lite' ) ); ?>
			<?php endif; ?></li>
		<li class="newstime"><i
				class="fa fa-clock-o"></i> <?php mediaphase_posted_ago( get_the_date( 'c' ), get_permalink() ); ?></li>
	</ul>
</div>
