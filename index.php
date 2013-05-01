<?php

get_header(); ?>


<div id="content">

	<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<strong><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong>
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			<?php endwhile; ?>

		<?php else : ?>

			<div id="post-0" class="post no-results not-found">
				<div class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
				</div><!-- .entry-header -->

				<div class="entry-content">
					<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</div><!-- #post-0 -->

		<?php endif; ?>


</div>


<?php get_sidebar(); ?>
<?php get_footer(); ?>