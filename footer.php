<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Expound
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php if ( dynamic_sidebar('footer-1') ) : else : endif; ?>
			<?php if ( dynamic_sidebar('footer-2') ) : else : endif; ?>
			<?php if ( dynamic_sidebar('footer-3') ) : else : endif; ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>