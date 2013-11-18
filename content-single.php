<?php
/**
 * @package Expound
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
    
		<h1 class="entry-title"><?php the_title(); ?></h1>
       
       
		<div class="entry-meta">
        <div class="alignright content-social">
            Share: <a href="http://facebook.com/share.php?u=<?php the_permalink() ?>&amp;t=<?php echo urlencode(the_title('','', false)) ?>" target="new" title="Share on Facebook"><i class="icon-facebook-squared"></i></a>
            <a href="http://twitter.com/home?status=<?php the_title(); ?> <?php echo get_permalink($post->ID); ?>" target="new" title="Spread the word on Twitter"><i class="icon-twitter"></i></a>
            <a href="https://plus.google.com/share?url=<?php the_permalink() ?>" target="new"title="Add to Google+"><i class="icon-gplus-squared"></i></a>
        </div>
		<!--Author-->
		<?php expound_posted_on(); ?> 
		<!--Category-->
		<?php expound_posted_in(); ?> //
		<!--Issue-->
		<?php $edition_name = new_source_get_edition_name(); echo $edition_name; ?>

		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
        
        <div class="entry-meta content-social">
       		 Link to this article: <a href="<?php the_permalink() ?>" target="_blank" title="Link to this article"><?php the_permalink() ?></a> |
            Share: <a href="http://facebook.com/share.php?u=<?php the_permalink() ?>&amp;t=<?php echo urlencode(the_title('','', false)) ?>" target="new" title="Share on Facebook"><i class="icon-facebook-squared"></i></a>
            <a href="http://twitter.com/home?status=<?php the_title(); ?> <?php echo get_permalink($post->ID); ?>" target="new" title="Spread the word on Twitter"><i class="icon-twitter"></i></a>
            <a href="https://plus.google.com/share?url=<?php the_permalink() ?>" target="new"title="Add to Google+"><i class="icon-gplus-squared"></i></a>
        </div>
     
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'expound' ),
				'after'  => '</div>',
			) );
		?>
        
	</div><!-- .entry-content -->

	<footer class="entry-meta">
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->