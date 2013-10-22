<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Expound
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>
            
<!--BEGIN .author-bio-->
<div class="author-bio">
			<h3 class="author-title"><?php the_author_link(); ?></h3>
			<?php echo get_avatar( get_the_author_meta('email'), '90' ); ?>
            <div class="author-info">
	<?php 
		
		$facebook_profile = get_the_author_meta( 'facebook_profile' );
		if ( $facebook_profile && $facebook_profile != '' ) {
			echo '<a href="' . esc_url($facebook_profile) . '"><i class="icon-facebook-squared"></i></a>';
		}
		
		$twitter_profile = get_the_author_meta( 'twitter_profile' );
		if ( $twitter_profile && $twitter_profile != '' ) {
			echo '<a href="' . esc_url($twitter_profile) . '"><i class="icon-twitter"></i></a>';
		}
		
		$google_profile = get_the_author_meta( 'google_profile' );
		if ( $google_profile && $google_profile != '' ) {
			echo '<a href="' . esc_url($google_profile) . '" rel="author"><i class="icon-gplus-squared"></i></a>';
		}
						
		$linkedin_profile = get_the_author_meta( 'linkedin_profile' );
		if ( $linkedin_profile && $linkedin_profile != '' ) {
		       echo '<a href="' . esc_url($linkedin_profile) . '"><i class="icon-link"></i></a>';
		}
	
		$author_email = get_the_author_meta('public_email');
		if ( $author_email && $author_email != '' ) {
			echo '<a href="mailto:' . $author_email . '"><i class="icon-mail"></i></a>';
		}
		
		$rss_url = get_the_author_meta( 'rss_url' );
		if ( $rss_url && $rss_url != '' ) {
			echo '<a href="' . esc_url($rss_url) . '"><i class="icon-rss"></i></a>';
		}
		
	?>
<p class="author-description"><?php the_author_meta('description'); ?></p>
			</div>
<!--END .author-bio-->
</div>
            
			<?php get_template_part( 'related-content' ); ?>

			<?php expound_content_nav( 'nav-below' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>