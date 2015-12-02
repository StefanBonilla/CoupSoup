<?php
/**
 * The template part for displaying blog post in grid blog template.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mediaphase
 */
?>

<div class="newspost">
	<a href="<?php the_permalink(); ?>">
		<div class="newsoverlay">
			<?php if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'mediaphase-frontpage-news', array( 'class' => 'newsimage' ) );
			} else {
				?>
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.gif"
					 alt="<?php the_title(); ?>"/>
			<?php } ?>
			<div class="newsimagebody">
				<i class="fa fa-chevron-right"></i>
			</div>
		</div>
	</a>

	<p class="newscategory">
		<?php
		$mediaphase_categories = get_the_category();
		if ( !empty( $mediaphase_categories ) ) {
			foreach ( $mediaphase_categories as $index => $category ) {
				echo '<a href="' . esc_url( home_url() . '/?cat=' . $category->term_id ) . '">' . $category->name . '</a>' . ( $index !== count( $mediaphase_categories ) - 1 ? ' ' : '' );
			}
		}
		?>
	</p>

	<h1 class="newstitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

	<p class="newsauthor"><?php _e( 'Posted By', 'mediaphase-lite' ); ?> <a
			href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"
			class="authorname"><?php the_author(); ?></a></p>

	<div class="newstext">
		<?php
		the_excerpt();
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'mediaphase-lite' ),
			'after'  => '</div>',
		) );
		?>
	</div>
	<ul class="newsmeta">
		<li class="newscomments"><i class="fa fa-comments-o"></i>
			<?php comments_popup_link( __( '0 Comments', 'mediaphase-lite' ), __( '1 Comment', 'mediaphase-lite' ), __( '% Comments', 'mediaphase-lite' ) ); ?>
		</li>
		<li class="newstime"><i
				class="fa fa-clock-o"></i> <?php mediaphase_posted_ago( get_the_date( 'c' ), get_permalink() ); ?></li>
	</ul>

</div>
