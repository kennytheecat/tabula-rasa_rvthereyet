<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>		
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h2>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</h2>
			<span class="author">Posted by <?php the_author_posts_link(); ?></span>
			<span class="categories">Categories: <?php the_category(', '); ?></span>
			<?php if ( is_single() ) { ?>
				<div class="orig_source">
					<a  href="<?php the_syndication_permalink(); ?>" target="_blank">View original source of this article</a>
				</div>
			<?php } ?>
			<?php if ( is_single() ) { ?>
				<div class="entry-meta">
				<?php edit_post_link( __( 'Edit', 'tabula-rasa' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .entry-meta -->
			<?php } ?>
		</header><!-- .entry-header -->
		<?php if ( is_single() && has_post_thumbnail() ) { ?>
		<?php } ?>
		
		<?php if ( !is_single() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<div class="entry-thumbnail">
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'blog-thumb' );
				} else {  
					echo '<img src="' . content_url() . '/uploads/default.jpg" alt="RVThereYet Blog Network" title="RVThereYet Blog Network" />';
				}
				?>
			</div>		
			<div class="entry">
				<?php 
				$excerpt_length = 280;
				$excerpt = get_the_excerpt();
				$excerpt = strip_tags($excerpt);
				if (strlen($excerpt) > $excerpt_length) {
					$excerpt = substr( $excerpt, 0, $excerpt_length - 3 ).'...';
				}
				echo $excerpt;
				?>
			</div>
			<a href="<?php the_permalink() ?>" class="read-more">Full Story &raquo;</a>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
					<div class="float_share <?php if ( is_admin_bar_showing() ) {echo 'float_share_admin'; } ?>">
				<?php if ( function_exists( 'floating_social_bar' ) ) floating_social_bar( array( 'facebook' => true, 'google' => true, 'twitter' => true, 'pinterest' => true ) ); ?>
				</div>
				<div class="blog_ad">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- RV Blog Single Header -->
					<ins class="adsbygoogle"
							 style="display:inline-block;width:468px;height:60px"
							 data-ad-client="ca-pub-7445595777186624"
							 data-ad-slot="6968175600"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>				
				</div>
				<?php 
				$excerpt_length = 4000;
				$content = get_the_content();
				if (strlen($content) > $excerpt_length) {
					$content = substr( $content, 0, $excerpt_length - 3 ).'...';
				}
				$content = apply_filters('the_content', $content);
				echo $content;
				?>		
		</div><!-- .entry-content -->

		<?php endif; ?>

		<footer class="entry-meta">
		<?php if ( is_single() ) { ?>
			<div class="orig_source">
				<a href="<?php the_syndication_permalink(); ?>" target="_blank">Continue reading the rest of this article...</a>
			</div>
		<?php } ?>
		<?php if ( ! is_single() ) { ?>
				<!--<a href="<?php the_permalink() ?>" class="read-more">Full Story &raquo;</a> -->
			<?php } else { ?>
			<?php //the_tags('Tags: ', ', ', '<br />'); ?> <!--Posted in <?php //the_category(', ') ?> | -->
			<?php //tr_entry_meta(); ?>
			<?php //edit_post_link( __( 'Edit', 'tabula-rasa' ), '<span class="edit-link">', '</span>' ); ?>
			<?php } ?>
			<?php if ( comments_open() && ! is_single() ) : ?>
			<?php endif; // comments_open() ?>			
			<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
				<?php get_template_part( 'author-bio' ); ?>
			<?php endif; ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->	
