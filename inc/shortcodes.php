<?php 

add_shortcode('shortlinks', 'source_shortlinks');

function source_shortlinks($atts){
	// Query the current edition
	$term_id = get_theme_mod( 'home_edition' );
	$edition = get_term_by( 'id', $term_id, 'edition' );
	$args = array(
		'post_type' => 'post',
		'edition' => $edition->slug,
		'posts_per_page' => -1
	);

	$the_query = new WP_Query( $args );
	$html = '<ul>';
	// The Loop
	while ( $the_query->have_posts() ) :
    	$the_query->the_post();
    	$html.= '<p><strong>' . get_the_title() .'</strong>  <br /> '.home_url().'/?p='.get_the_ID().'<p>';
	endwhile;

	// Restore original Query & Post Data
	wp_reset_query();
	wp_reset_postdata();

	return $html;
}