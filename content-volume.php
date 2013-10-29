<article class="entry">

<?php $tax = get_queried_object_id();
	$args = array(
	    'orderby'       => 'slug', 
	    'order'         => 'ASC',
	    'fields'        => 'all', 
	    'parent'         => $tax,
	    'hierarchical'  => true, 
	);
	$editions = get_terms( "edition", $args );
	
	
	foreach( $editions as $edition):
		// var_dump($edition);
		$term_link = get_term_link( $edition,  "edition" );
		echo '<a class="edition-image" href="'.$term_link.'"><img src="/img/'.$edition->slug.'.gif" class="alignleft" alt="'.$edition->name.' Cover Image" /></a>';
		echo '<h1 class="edition-title"><a href="'.$term_link.'">'.$edition->name.'</a> <small>'.$edition->description.'</small></h1>';
		
	endforeach;
	?>
</article>