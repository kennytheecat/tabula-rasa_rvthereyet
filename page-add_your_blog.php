<?php
/*
Template Name: Add Your Blog
*/
get_header(); ?>
<div class="add_your_blog">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			
				<?php while ( have_posts() ) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
							<div class="entry-thumbnail">
								<?php the_post_thumbnail(); ?>
							</div>
							<?php endif; ?>

							<h1 class="entry-title"><?php the_title(); ?></h1>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<?php the_content(); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'tabula-rasa' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
						</div><!-- .entry-content -->
						
				<?php endwhile; // end of the loop. ?>
		</div><!-- #content -->
	</div><!-- #primary -->
	<div id="secondary" class="widget-area aside1" role="complementary">
		<div class="badges">
			<h2><?php _e( 'RVThereYet Blog Network Badges', 'tabula_rasa' ); ?></h1>
			<img src="<?php echo home_url(); ?>/blog_badge_100.png">
			<p>Copy and paste this code on your blog:<br />
				<span>
					&lt;a href=&quot;http://www.rvthereyetdirectory.com&quot;&gt;&lt;img src=&quot;<?php echo home_url(); ?>/blog_badge_100.png&quot; /&gt;&lt;/a&gt;
				</span>
			</p>
			<img src="<?php echo home_url(); ?>/blog_badge_150.png">
			<p>Copy and paste this code on your blog:<br />
				<span>
					&lt;a href=&quot;http://www.rvthereyetdirectory.com&quot;&gt;&lt;img src=&quot;<?php echo home_url(); ?>/blog_badge_150.png&quot; /&gt;&lt;/a&gt;
				</span>
			</p>
			<img src="<?php echo home_url(); ?>/blog_badge_200.png">
			<p>Copy and paste this code on your blog:<br />
				<span>
					&lt;a href=&quot;http://www.rvthereyetdirectory.com&quot;&gt;&lt;img src=&quot;<?php echo home_url(); ?>/blog_badge_200.png&quot; /&gt;&lt;/a&gt;
				</span>
			</p>
			<!--
			<img src="<?php echo home_url(); ?>/blog_badge_250.png">
			<p>Copy and paste this code on your blog:<br />
				<span>
					&lt;a href=&quot;http://www.rvthereyetdirectory.com&quot;&gt;&lt;img src=&quot;<?php echo home_url(); ?>/blog_badge_250.png&quot; /&gt;&lt;/a&gt;
				</span>
			</p>
			<img src="<?php echo home_url(); ?>/blog_badge_300.png">
			<p>Copy and paste this code on your blog:<br />
				<span>
					&lt;a href=&quot;http://www.rvthereyetdirectory.com&quot;&gt;&lt;img src=&quot;<?php echo home_url(); ?>/blog_badge_300.png&quot; /&gt;&lt;/a&gt;
				</span>
			</p>	-->		
		</div>
	</div>
<?php //get_sidebar(); ?>
</div>
<?php get_footer(); ?>