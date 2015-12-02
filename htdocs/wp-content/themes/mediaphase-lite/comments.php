<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package mediaphase
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php // You can start editing here -- including this comment! ?>

<?php if ( have_comments() ) : ?>
	<div id="comments" class="comments-area">
		<h2 class="comments-title">
			<?php
			printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'mediaphase-lite' ),
				number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'mediaphase-lite' ); ?></h2>

				<div class="nav-links">

					<div
						class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'mediaphase-lite' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'mediaphase-lite' ) ); ?></div>

				</div>
				<!-- .nav-links -->
			</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
			) );
			?>
		</ol>
		<!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'mediaphase-lite' ); ?></h2>

				<div class="nav-links">

					<div
						class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'mediaphase-lite' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'mediaphase-lite' ) ); ?></div>

				</div>
				<!-- .nav-links -->
			</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>
	</div><!-- #comments -->
<?php endif; // have_comments() ?>

<?php if ( !comments_open() ) : ?>
	<div id="comments" class="comments-area">
		<p class="no-comments"><?php _e( 'Comments are closed.', 'mediaphase-lite' ); ?></p>
	</div>
<?php endif; ?>





<?php if ( comments_open() ) : ?>
	<div id="responder"><?php comment_form(); ?></div>
<?php endif;