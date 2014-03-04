<?php
// RV Bloggers
function rv_blogger_widget() { 
	$display_admins = false;
	$order_by = 'display_name'; // 'nicename', 'email', 'url', 'registered', 'display_name', or 'post_count'
	$role = 'rvblogger'; // 'subscriber', 'contributor', 'editor', 'author' - leave blank for 'all'
	//$avatar_size = 32;
	$hide_empty = false; // hides authors with zero posts
	if(!empty($display_admins)) {
		$blogusers = get_users('orderby='.$order_by.'&role='.$role);
	} else {
		$admins = get_users('role=administrator');
		$exclude = array();
		foreach($admins as $ad) {
			$exclude[] = $ad->ID;
		}
		$exclude = implode(',', $exclude);
		$blogusers = get_users('exclude='.$exclude.'&orderby='.$order_by.'&role='.$role);
	}
	$authors = array();
	foreach ($blogusers as $bloguser) {
		$user = get_userdata($bloguser->ID);
		if(!empty($hide_empty)) {
			$numposts = count_user_posts($user->ID);
			if($numposts < 1) continue;
		}
		$authors[] = (array) $user;
	}
	echo '<aside class="bloggers widget"><h3 class="widget-title">RV Bloggers</h3>';
	echo '<ul class="contributors">';
	foreach($authors as $author) {
		$display_name = $author['data']->display_name;
		//$avatar = get_avatar($author['ID'], $avatar_size);
		$author_profile_url = get_author_posts_url($author['ID']);
		echo '<li><a href="', $author_profile_url, '" class="contributor-link">', $display_name, '</a></li>';
	}
	echo '</ul></aside>';
}

/* Facebook Box
*****************************************/
function facebook_box() { 
	echo '
	<div class="facebook_box widget">
		<h2><a href="http://www.facebook.com/RvThereYetDirectory">Like us on Facebook</a></h2>
		<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like-box href="http://www.facebook.com/RvThereYetDirectory" width="300" show_faces="true" border_color="#004040" stream="false" header="false"></fb:like-box>
	</div>
	';
}

/* Add Your Blog
*****************************************/
function add_your_blog() { 
	echo '
	<div class="add_your_blog widget">
		<h2>
			<a href="' .home_url() . '/add-your-blog">Add Your Blog</a>
		</h2>
		<p>To be part of the network your blog must meet certain guidleines.<br />
			<a href="' .home_url() . '/add-your-blog">View Details</a>
		</p>
	</div>
	';
}

function register_widgets() {
	register_sidebar_widget('RV Bloggers', 'rv_blogger_widget');
	register_sidebar_widget('State Dropdown - Blog', 'state_dropdown_blog');
	register_sidebar_widget('Facebook Box', 'facebook_box');
	register_sidebar_widget('Add Your Blog', 'add_your_blog');
}
add_action('widgets_init', 'register_widgets');
?>