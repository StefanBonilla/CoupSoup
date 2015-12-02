<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package flaton
 */

if ( ! function_exists( 'flaton_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function flaton_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'flaton' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'flaton' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'flaton' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'flaton_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function flaton_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'flaton' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'flaton' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'flaton' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'flaton_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function flaton_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'flaton' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'flaton' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<span class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) { echo get_avatar( $comment, $args['avatar_size'] ); } ?>
					<?php printf( __( '%s', 'flaton' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</span><!-- .comment-author -->

				<span class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '- %1$s at %2$s', '1: date, 2: time', 'flaton' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit', 'flaton' ), '<span class="edit-link">', '</span>' ); ?>
				</span><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'flaton' ); ?></p>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>',
				) ) );
			?>
		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for flaton_comment()

if ( ! function_exists( 'flaton_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function flaton_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( '%s', 'post date', 'flaton' ),
		'<i class="fa fa-clock-o"></i> <a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( '%s', 'post author', 'flaton' ),
		'<span class="author vcard"><i class="fa fa-user"></i> <a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
	edit_post_link( __( 'Edit', 'flaton' ), '<span class="edit-link"><i class="fa fa-edit"></i> ', '</span>' );

}
endif;

if ( ! function_exists( 'flaton_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function flaton_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'flaton' ) );
		if ( $categories_list && flaton_categorized_blog() ) {
			printf( '<span class="cat-links"><i class="fa fa-list-alt"></i>' . __( '%1$s', 'flaton' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'flaton' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><i class="fa fa-tags"></i> ' . __( '%1$s', 'flaton' ) . '</span>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'flaton' ), __( '1 Comment', 'flaton' ), __( '% Comments', 'flaton' ) );
		echo '</span>';
	}

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function flaton_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'flaton_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'flaton_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so flaton_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so flaton_categorized_blog should return false.
		return false;
	}
}

// Recent Posts with featured Images to be displayed on home page
if( ! function_exists('flaton_recent_posts') ) {
	function flaton_recent_posts() {
		$output = '';
		// WP_Query arguments
		$args = array (
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'posts_per_page'         => get_option('posts_per_page'),
			'ignore_sticky_posts'    => true,
			'order'                  => 'DESC',
		);

		// The Query
		$query = new WP_Query( $args );

		// The Loop
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$output .= '<div class="recent-work">';
				$output .= '<div class="rk-thumb">';
				if ( has_post_thumbnail() ) {
					$output .= get_the_post_thumbnail();
				}
				else {
					$output .= '<img src="' . get_stylesheet_directory_uri() . '/images/thumbnail-default.png" alt="" >';
				}
				$output .= '</div><!-- .rk-thumb -->';
				$output .= '<div class="rk-content">';
				$output .= '<h3><a href="'. get_permalink() . '">' . get_the_title() . '</a></h3>';
				$output .= '<p>' . get_the_excerpt() . '</p>';
				$output .= '</div><!-- .rk-content -->';
				$output .= '</div>';
			}
		} 

		// Restore original Post Data
		wp_reset_postdata();
		echo $output;
	}
}

/**
 * Flush out the transients used in flaton_categorized_blog.
 */
function flaton_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'flaton_categories' );
}
add_action( 'edit_category', 'flaton_category_transient_flusher' );
add_action( 'save_post',     'flaton_category_transient_flusher' );


