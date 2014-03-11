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
        	
            <?php _e('Share', 'new-source'); ?>: <a href="http://facebook.com/share.php?u=<?php the_permalink() ?>&amp;t=<?php echo urlencode(the_title('','', false)) ?>" target="new" title="<?php esc_attr_e('Share on Facebook', 'new-source'); ?>"><i class="icon-facebook-squared"></i></a>
            <a href="http://twitter.com/home?status=<?php the_title(); ?> <?php echo get_permalink($post->ID); ?>" target="new" title="<?php esc_attr_e('Spread the word on Twitter', 'new-source'); ?>"><i class="icon-twitter"></i></a>
            <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="new" title="<?php esc_attr_e('Add to Google+', 'new-source'); ?>"><i class="icon-gplus-squared"></i></a>
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
        
        <div class="entry-meta link-to-article">
       		 <?php _e('Link to this article', 'new-source'); ?>: <a href="<?php echo home_url('?p=' . get_the_ID() ); ?>" target="_blank" title="<?php esc_attr_e('Link to this article', 'new-source' );?>"><?php echo home_url('?p=' . get_the_ID() ); ?></a></div>
     
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'new-source' ),
				'after'  => '</div>',
			) );
		?>
        
	</div><!-- .entry-content -->

	<footer class="entry-meta">
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->