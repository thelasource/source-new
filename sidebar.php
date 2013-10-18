<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Expound
 */
?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php if( is_front_page() || is_tax('edition') ): 
		$special_posts = new_source_get_special_posts(); ?>
	<?php if( $special_posts->have_posts() ): ?>
		<div class="featured-special">
		<?php while ( $special_posts->have_posts() ) : $special_posts->the_post(); ?>
		
			<?php if( in_category( array( 'spencies-view', 'le-grain-de-sel' ) ) ): ?>
				
				<div class="article"> <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a> </div>
			
			<?php else: ?>
			
				<div class="article article-forum"><span class="special">Join the conversation</span> <a href="<?php the_permalink(); ?>"><span><?php the_title(); ?></span></a> </div>
			
			<?php endif; ?>
		
		<?php endwhile; ?>
			
		</div>
	<?php endif; ?>
		
		
		
		<?php endif; ?>
		
		
		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget">
				<h1 class="widget-title"><?php _e( 'Archives', 'expound' ); ?></h1>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="meta" class="widget">
				<h1 class="widget-title"><?php _e( 'Meta', 'expound' ); ?></h1>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->
