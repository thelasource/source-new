<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Expound
 */
?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php 
		if( new_source_is_volume() ):
			new_source_volume_sidebar();
		elseif( is_front_page() || is_tax('edition')  ): 
			$special_posts = new_source_get_special_posts(); ?>
			<?php if( $special_posts->have_posts() ): ?>
				
					<?php while ( $special_posts->have_posts() ) : $special_posts->the_post(); ?>
					
						<?php if( !in_category( array( 'spencies-view', 'le-grain-de-sel' ) ) ): ?>
                        
                        
						<div class="featured-special">
							<div class="article article-forum"><span class="special"><?php _e( 'Join the conversation', 'new-source');?></span> <a href="<?php the_permalink(); ?>"><span><?php the_title(); ?></span></a> </div>
                        </div>
						<?php else: ?>
						<div class="featured-comic">
                        <?php if ( get_the_category() ) : ?>
						<span class="home-comic-category"><?php the_category( ' // ' ); ?></span>
						<?php endif; // get_the_category() ?>
							
							<div class="article"> <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a> </div>
						</div>
						<?php endif; ?>
					
					<?php endwhile; ?>
				
		    <?php endif; ?>
		<?php endif; ?>
		
		<?php do_action( 'before_sidebar' ); ?>
		
			<?php if( is_home() || is_front_page() ):
				  if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget">
				<h1 class="widget-title"><?php _e( 'Archives', 'new-source' ); ?></h1>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="meta" class="widget">
				<h1 class="widget-title"><?php _e( 'Meta', 'new-source' ); ?></h1>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
		<?php else: ?>
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		<?php endif; ?>
	</div><!-- #secondary -->
