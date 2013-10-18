<?php $featured_posts = new_source_get_featured_posts(); ?>
<?php if ( $featured_posts->have_posts() ) : $featured_posts->the_post(); ?>
<div class="featured-content">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'expound-featured' ); ?></a>
		</div>
		<?php endif; ?>

<?php if ( is_active_sidebar( 'featured-widget-area' ) ) { ?><!-- If there is a featured content ad -->
		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'expound' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt(); ?>
			<p><a class="button-primary" href="<?php the_permalink(); ?>"><?php _e( 'Continue reading &rarr;', 'expound' ); ?></a></p>
		</div><!-- .entry-summary -->
			<div id="featured-ad" class="featured-adplace">
                        <?php if ( !dynamic_sidebar( 'featured-widget-area' ) )?>
           </div><!-- featured ad place -->
<?php } else { ?><!-- If there is no featured content ad -->
<header class="entry-header no-featured-ad">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'expound' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		</header><!-- .entry-header -->

		<div class="entry-summary no-featured-ad">
			<?php the_excerpt(); ?>
			<p><a class="button-primary" href="<?php the_permalink(); ?>"><?php _e( 'Continue reading &rarr;', 'expound' ); ?></a></p>
		</div><!-- .entry-summary -->
<?php }; ?>
	</article>

</div><!-- .featured-content -->


<?php

$total_posts = $featured_posts->post_count - 1;
if ( $featured_posts->have_posts() ) : // more than one? ?>
<div class="featured-content-secondary">
	<?php
	$count = 1;
	
	 while ( $featured_posts->have_posts() ) : $featured_posts->the_post(); ?>
	
		<article id="post-<?php the_ID(); ?>" <?php post_class( "post-count-".$total_posts ); ?>>

			<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry-thumbnail">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>

				<?php if ( get_the_category() ) : ?>
				<span class="entry-thumbnail-category"><?php the_category( ' // ' ); ?></span>
				<?php endif; // get_the_category() ?>
			</div>
			<?php endif; ?>

			<header class="entry-header">
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'expound' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			</header><!-- .entry-header -->

			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		</article>

	<?php 
	$count; 
	endwhile; ?>
</div><!-- .featured-content-secondary -->
<?php endif; // have_posts() inner ?>

<?php endif; // have_posts() ?>


<?php $special_posts = new_source_get_special_posts(); ?>
<?php if( $special_posts->have_posts() ): ?>
	<div class="featured-special">
	<?php while ( $special_posts->have_posts() ) : $special_posts->the_post(); ?>
	<?php if( in_category( array('spencies-view', 'le-grain-de-sel') ) ): ?>
		<div class="article"> <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a> </div>
	<?php else: ?>
		<div class="article article-forum"><span class="special">Join the conversation</span> <a href="<?php the_permalink(); ?>"><span><?php the_title(); ?></span></a> </div>
	<?php endif; ?>
	
	<?php endwhile; ?>
		
	</div>
<?php endif; ?>