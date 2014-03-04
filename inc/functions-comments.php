<?php
/*
inc/functions-comments.php
	- COMMENT LAYOUT
		- tr_comment( $comment, $args, $depth )	
	- THE COMMENT FORM
		- save_comment_meta_data( $comment_id )
		- save_park_vote_fields($comment_id)
	- COMMENTS IN THE ADMIN SECTION
		- extend_comment_add_meta_box()
		- extend_comment_meta_box ( $comment )
		- extend_comment_edit_metafields( $comment_id )
		- delete_park_votes( $comment_id )
		- trash_park_votes( $comment_id )
		- approve_park_votes( $comment_id )
		- set_comment_columns( $columns )
		- myplugin_comment_column( $column, $comment_ID )
*/

/**************************************************
COMMENT LAYOUT - Not the form
**************************************************/
if ( ! function_exists( 'tr_comment' ) ) :

function tr_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	global $post;
	global $name;
	$wpid = $post->ID;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'tabula_rasa' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'tabula_rasa' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		$post_type = get_post_type();
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
			<div itemprop="review" itemscope itemtype="http://data-vocabulary.org/Review">
				<meta itemprop="itemreviewed" content="<?php the_title(); ?>">
				<div class="comment_wrap">
					<header class="comment-meta comment-author vcard">
						<div class="comment_col1">
							<?php 
							if ($comment->comment_parent == 0) {
								echo get_avatar($comment,$size='60',$default='', $alt='Facebook Avatar' ); 
							}
							?>
							<span itemprop="reviewer">
								<?php 
								if ($comment->comment_parent != 0) { ?>
									<h2><?php echo the_title(); ?> Response: </h2>
								<?php 
								} else { 
								?>
								<?php printf( get_comment_author_link()); ?>
								<?php edit_comment_link(__('(Edit)'),' ',''); ?>
								<?php 
								} ?>
							</span>								
							<?php if ($comment->comment_parent == 0) { echo "<br />"; } ?>
							<?php comment_date(); ?>
							<br />
							<?php if ($comment->comment_parent == 0) { ?>
							<div class="comment_star">
								<?php 
								if ( $post_type == 'rvparks' ) {
									if ($comment->comment_parent == 0) {
										$rating = get_comment_meta( $comment->comment_ID, 'rvp_vote', true );
										echo get_star_rating($rating, 'small');
										echo '<meta itemprop="rating" content="' . $rating . '">';
									}
								}
								?>
							</div> 	
							<?php } ?>
						</div>
						<?php 
						if ($comment->comment_parent == 0) { 
							 ?>
								<div class="comment_col2">
									<?php
									if ( $post_type == 'rvparks' ) {
										//link to post facebook feed.
										if ($rating == 1) {$vote = '&#9733;&#10032;&#10032;&#10032;&#10032;';}
										if ($rating == 2) {$vote = '&#9733;&#9733;&#10032;&#10032;&#10032;';}
										if ($rating == 3) {$vote = '&#9733;&#9733;&#9733;&#10032;&#10032;';}
										if ($rating == 4) {$vote = '&#9733;&#9733;&#9733;&#9733;&#10032;';}
										if ($rating == 5) {$vote = '&#9733;&#9733;&#9733;&#9733;&#9733;';}		
										$wp_park_link = get_permalink( $wpid );
										
										$args = array(
											'numberposts' => 1,
											'order'=> 'ASC',
											'orderby'=> 'menu_order',
											'post_mime_type' => 'image',
											'post_parent' => $wpid,
											'post_status' => null,
											'post_type' => 'attachment'
										);	
										$attachments = get_children( $args );
										if ($attachments) {
											foreach($attachments as $attachment) {
												$fb_photo = wp_get_attachment_url( $attachment->ID, 'gallery-thumb' );
											}
										} else { 
											$fb_photo = get_bloginfo("template_directory") . '/images/logo.png';
										}										
										$feed_text = get_comment_text();
										echo '<div class="comment_fb"><a href="https://www.facebook.com/dialog/feed?
										app_id=107256345975330&
										link=' . $wp_park_link . '&
										picture=' . $fb_photo . '&
										name=' . $name . '&
										caption=' . $vote . '&
										description=' . $feed_text . '&
										redirect_uri=' . $wp_park_link . '" >Post this review to Facebook</a></div>';
									}?>
								</div>	
							<?php
						} ?>		
					</header><!-- .comment-meta -->
					<div class="comment_text_wrap">
						<?php 
						if ($comment->comment_approved == '0') { ?>
							<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'tabula_rasa' ); ?></p>
						<?php 
						} else {
							echo '<span itemprop="description">';
							echo get_comment_text();
							echo '</span>';
						} ?>
					</div>
				</div>
				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'tabula_rasa' ), 'after' => ' ', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
			</div><!-- Shema stuff -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;
?>
<?php
/**************************************************
The Comment Form
**************************************************/

//Source: http://wp.smashingmagazine.com/2012/05/08/adding-custom-fields-in-wordpress-comment-form/
// Add fields after default fields above the comment box, always visible
//add_action( 'comment_form_logged_in_after', 'additional_fields' );
//add_action( 'comment_form_after', 'additional_fields' );
/*
function additional_fields () {
	echo '<div id="rating_box"><label for="rating">'. __('Choose a Rating') . '<span class="required">*</span></label>
	<span class="commentratingbox">';

	//Current rating scale is 1 to 5. If you want the scale to be 1 to 10, then set the value of $i to 10.
	for( $i=1; $i <= 5; $i++ )
	echo '<span class="commentrating"><input type="radio" id="rating" name="rating" value="'. $i .'"/>'. get_star_rating($i, 'small') .'</span><br />';
	echo'</span></div>';
}
*/			
// Save the comment meta data along with comment
function save_comment_meta_data( $comment_id ) {
	if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '') )
	$rating = wp_filter_nohtml_kses($_POST['rating']);
	add_comment_meta( $comment_id, 'rvp_vote', $rating );
	
	save_park_vote_fields( $comment_id );
}
add_action( 'comment_post', 'save_comment_meta_data' );

//Retreive past ratings to calculate # of ratings and average ratings
function save_park_vote_fields($comment_id) {
	$comment_id_fetch = get_comment( $comment_id  ); 
	$rvparks_id = $comment_id_fetch->comment_post_ID;
	$args = array(
		'parent' => 0,
		'status' => 'approve',
		'post_id' => $rvparks_id, // use post_id, not post_ID
	);
	$comments = get_comments($args);
	if ($comments != NULL) {	
		foreach($comments as $comment) {
			$comment_id = $comment->comment_ID; 
			$ratings_array[] = get_comment_meta( $comment_id, 'rvp_vote', true );
		}
		$vote_tally = count($ratings_array);
		$vote_sum = array_sum($ratings_array);
		$vote_avg = round($vote_sum / $vote_tally);
		$vote_fields = array( $vote_tally, $vote_avg );
		update_post_meta( $rvparks_id, 'park_vote_fields', $vote_fields );
	} else {
		delete_post_meta( $rvparks_id, 'park_vote_fields', $vote_fields );
	} 
}
	
// Add the filter to check whether the comment meta data has been filled
if ( 'rvparks' == get_post_type() ) {
	add_filter( 'preprocess_comment', 'verify_comment_meta_data' );
	function verify_comment_meta_data( $commentdata ) {
		if ( ! isset( $_POST['rating'] ) )
		wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.' ) );
		return $commentdata;
	}
}

/**************************************************
Comments in the Admin Section
**************************************************/
// Add an edit option to comment editing screen  
function extend_comment_add_meta_box() {
	add_meta_box( 'title', __( 'Rating' ), 'extend_comment_meta_box', 'comment', 'normal' );
}
add_action( 'admin_menu', 'extend_comment_add_meta_box' );

function extend_comment_meta_box ( $comment ) {
	$rating = get_comment_meta( $comment->comment_ID, 'rvp_vote', true );
	wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
	?>
	<p>
		<label for="rating"><?php _e( 'Rating: ' ); ?></label>
		<span class="commentratingbox">
			<?php 
				for( $i=1; $i <= 5; $i++ ) {
				echo '<span class="commentrating"><input type="radio" name="rating" id="rating" value="'. $i .'"';
				if ( $rating == $i ) echo ' checked="checked"';
				echo ' />'. $i .' </span>';
				}
			$comment_id_fetch = get_comment( $comment_id );
			?>
		</span>
	</p>
	<?php
}

// Update comment meta data from comment editing screen 
function extend_comment_edit_metafields( $comment_id ) {
	if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;

	if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '') ):
	$rating = wp_filter_nohtml_kses($_POST['rating']);
	update_comment_meta( $comment_id, 'rvp_vote', $rating );
	save_park_vote_fields( $comment_id );
	else :
	delete_comment_meta( $comment_id, 'rvp_vote');
	save_park_vote_fields( $comment_id );
	endif;
}
add_action( 'edit_comment', 'extend_comment_edit_metafields' );

// If a comment is deleted, delete the rating as well
function delete_park_votes( $comment_id ) {
	save_park_vote_fields( $comment_id );
}
add_action( 'delete_comment', 'delete_park_votes' );

function trash_park_votes( $comment_id ) {
	save_park_vote_fields( $comment_id );
}
add_action( 'trashed_comment', 'trash_park_votes' );

function approve_park_votes( $comment_id ) {
	save_park_vote_fields( $comment_id );
}
add_action( 'wp_set_comment_status', 'approve_park_votes' );

// Add custom column - Rating
// Source: http://stv.whtly.com/2011/07/27/adding-custom-columns-to-the-wordpress-comments-admin-page/
function set_comment_columns( $columns ) {
    return array(
        'cb' => '<input type="checkbox" />',
        'author' => __('Author'),
        'rating_column' => __('Rating'),
        'comment' => __('Comment'),
        'response' =>__( 'In Response To')
    );
}
add_filter('manage_edit-comments_columns' , 'set_comment_columns');

function myplugin_comment_column( $column, $comment_ID ) {
	if ( 'rating_column' == $column ) {
		$images_path = get_bloginfo ( 'template_url' ) . '/images/';
		if( $commentrating = get_comment_meta( get_comment_ID(), 'rvp_vote', true ) ) {
			for( $i=1; $i <= $commentrating; $i++ ) {
				$star_ratings .= '<img src="'. $images_path . 'small_single_star_green.png"/>';
			}
			echo$commentrating = '<p class="comment-rating">' . $star_ratings . '</p>';
		}		
	}
}
add_filter( 'manage_comments_custom_column', 'myplugin_comment_column', 10, 2 );
?>