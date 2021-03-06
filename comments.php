<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to tr_comment() which is
 * located in the functions.php file.
 */
$post_type = get_post_type();
if ( 'rvdumps' == $post_type ) {
	$post_type_name = 'RV Dump';
}
if ( 'rvboons' == $post_type ) {
	$post_type_name = 'RV Boondock';
}
if ( 'rvparks' == $post_type ) {
	$post_type_name = 'RV Parks';
}
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

		<p class="comments-title">
			<?php
				if ( get_comments_number() == 0 ) {
					printf ( _( 'There are no comments for this ' . $post_type_name . ' yet') );
				} else {				
				printf( _n( 'One comment for this ' . $post_type_name . '', '%1$s comments for this ' . $post_type_name . '', get_comments_number(), 'tabula-rasa' ),
					number_format_i18n( get_comments_number() ) );
				}
			?>
		</p>
		<?php 
		$url = home_url();
		$comments_args = array(
			// change the title of send button 
			'title_reply'=>'',
			// remove "Text or HTML to be displayed after the set of comment fields"
			'comment_field' => '<p class="comment-form-comment">' .
			'<label for="comment">' . __( 'Leave a comment for this ' . $post_type_name . '' ) . '</label>' .
			'<textarea id="comment" name="comment" style="width: 400px;" cols="45" rows="25" aria-required="true"></textarea>' .
			'</p><!-- #form-section-comment .form-section -->',
			'comment_notes_after' => '
			<div class="review_policy">
				Comments are moderated according to our <a href="' . $url . '/review-policy/">comment policy</a>.
			</div>',
			'label_submit'=> __( 'Submit ' . $post_type_name . ' Comment' ),
		);
		comment_form($comments_args); ?>
	<?php if ( have_comments() ) : ?>		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="navigation-comment" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'tabula-rasa' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'tabula-rasa' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'tabula-rasa' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>		

		<ol class="commentlist">
			<?php 
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use tr_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define tr_comment() and that will be used instead.
				 * See tr_comment() in inc/template-tags.php for more.
				 */
				 wp_list_comments( array( 'callback' => 'tr_comment', 'style' => 'ol' ) ); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation-comment" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'tabula-rasa' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'tabula-rasa' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'tabula-rasa' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'tabula-rasa' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>


</div><!-- #comments .comments-area -->