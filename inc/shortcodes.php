<?php 

add_shortcode('shortlinks', 'source_shortlinks');
add_shortcode('generate_QRcodes', 'source_QRcodes');

/**
 * source_shortlinks function.
 * 
 * @access public
 * @param mixed $atts
 * @return void
 */
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

/**
 * source_QRcodes function.
 * 
 * @access public
 * @return void
 */
function source_QRcodes(){
	
	
		// Generate form to create QR codes
		$html  = "<form action='".get_permalink()."' method='GET'>";
		$html .= "<input type='hidden' name='p' value='".esc_attr(get_the_ID())."'>";
		
		$html .= "Volume <input type='text' name='_vol' value='".esc_attr($_GET['_vol'])."'><br />";
		$html .= "Edition <input type='text' name='_ed' value='".esc_attr($_GET['_ed'])."'><br />";
		$html .= "Num. articles <input type='text' name='_size' value='".esc_attr($_GET['_size'])."'><br />";
		$html .= "<input type='submit' value='generate'>";
		$html .= "</form>";
		

		if($_GET['_size']){
			$url = site_url()."?_volume=".$_GET['_vol']."&_edition=".$_GET['_ed'];
			$html .= "<div style=''><img src=https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=".urlencode($url)."&choe=UTF-8 />";
			$html .= "QR code for volume ".$_GET['_vol'].", edition ".$_GET['_ed'].":<br/>".$url."</div>";
			for($i = 1; $i<=(int)$_GET['_size']; $i++){
				$url = site_url()."?_volume=".$_GET['_vol']."&_edition=".$_GET['_ed']."&_article=".$i;	
				$html .= "<div style=''><img src=https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=".urlencode($url)."&choe=UTF-8 />";
				$html .= "QR code for volume ".$_GET['_vol'].", edition ".$_GET['_ed'].", article ".$i.":<br/>".$url."</div>";
			}
			
		}
		return $html;
}
