<?php
/**
 * Expound functions and definitions
 *
 * @package Expound
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 700; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'expound_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function expound_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );
	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/widgets.php' );
	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Customized dropdown menu
	 */
	require( get_template_directory() . '/inc/class.new_source_Walker_CategoryDropdown.php' );

	/**
	 * Customized shortcodes for shortlinks
	 */
	require( get_template_directory() . '/inc/shortcodes.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Mag, use a find and replace
	 * to change 'expound' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'expound', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Editor styles for the win
	 */
	add_editor_style();

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 220, 126, true );
	add_image_size( 'expound-featured', 460, 260, true );
	add_image_size( 'expound-mini', 50, 50, true );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'expound' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	 * Enable support for Custom Background
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'f2f2f2',
	) );

	/**
	 * Custom Header support
	 */
	add_theme_support( 'custom-header', array(
		'default-text-color'     => '3a3a3a',
		'width'                  => 274,
        'height'                 => 120,
        'flex-height'            => true,
        'wp-head-callback'       => 'expound_header_style',
        'admin-head-callback'    => 'expound_admin_header_style',
	) );
	
	
	add_action( 'wp_head','new_souce_prefetch_link' );
}
endif; // expound_setup
add_action( 'after_setup_theme', 'expound_setup' );

if ( ! function_exists( 'expound_admin_header_style' ) ) :
function expound_admin_header_style() {
	?>
	<style type="text/css">
	#headimg h1 {
		margin-top: 50px;
		margin-left: 40px;
		margin-bottom: 0;
		margin-right: 40px;
		font-size: 34px;
		line-height: 34px;
		font-family: Georgia, "Times New Roman", serif;
		font-weight: 300;
	}
	#headimg h1 a {
		text-decoration: none;
		color: #3a3a3a;
		display: block;
	}
	#headimg h1 a:hover {
		color: #117bb8;
	}
	#headimg #desc {
		font: 13px/20px "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-weight: 300;
		color: #878787;
		margin-left: 40px;
	}
	</style>
	<?php
}
endif;

if ( ! function_exists( 'expound_header_style' ) ) :
function expound_header_style() {
	$color = get_header_textcolor();
	$default_color = get_theme_support( 'custom-header', 'default-text-color' );

	if ( $color == $default_color )
		return;
	?>
	<style type="text/css">
	<?php if ( 'blank' == $color ) : ?>
		.site-title,
        .site-description {
            position: absolute !important;
            clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
            clip: rect(1px, 1px, 1px, 1px);
        }

        <?php if ( ! get_header_image() ) : // blank *and* no header image ?>
			.site-header .site-branding {
				min-height: 0;
				height: 0;
				height: 0;
			}
        <?php endif; ?>

	<?php else : // not blank ?>
        .site-title a,
        .site-title a:hover,
        .site-description {
			color: #<?php echo $color; ?>;
        }
	<?php endif; ?>
	</style>
	<?php
}
endif;

/**
 * Register widgetized area and update sidebar with default widgets
 */
function expound_widgets_init() {

// Area located before the header, use for ad.
	register_sidebar( array(
		'name' => __( 'Header Ad Place' ),
		'id' => 'header-widget-area',
		'description' => __( 'An ad place, max width 728px' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<span class="no-title">',
		'after_title' => '</span>',
	) );

// Featured widget area, use for ad.
	register_sidebar( array(
		'name' => __( 'Featured Ad Place' ),
		'id' => 'featured-widget-area',
		'description' => __( 'An ad place, width 300px and height 250px' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<span class="no-title">',
		'after_title' => '</span>',
	) );

// Sidebar from Theme 
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'expound' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

// Footer1 from Theme 
	register_sidebar( array(
		'name'          => __( 'Footer1' ),
		'id'            => 'footer-1',
		'description' => __( 'footer1 widget area' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

// Footer2 from Theme 
	register_sidebar( array(
		'name'          => __( 'Footer2' ),
		'id'            => 'footer-2',
		'description' => __( 'footer2 widget area' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

// Footer3 from Theme 
	register_sidebar( array(
		'name'          => __( 'Footer3' ),
		'id'            => 'footer-3',
		'description' => __( 'footer3 widget area' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

}
add_action( 'widgets_init', 'expound_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function expound_scripts() {
	wp_enqueue_style( 'expound-style', get_stylesheet_uri(), array(), 2 );
	wp_enqueue_style( 'expound-less', get_template_directory_uri() . '/expound.css', array( 'expound-style' ), 3 );

	wp_enqueue_script( 'new-source-combine', get_template_directory_uri() . '/js/combine.js', array('jquery'), '20120206', true );

	// wp_enqueue_script( 'expound-navigation', get_template_directory_uri() . '/js/combine.js', array(), '20120206', true );

	// wp_enqueue_script( 'expound-skip-link-focus-fix', get_template_directory_uri() . '/js/combine.js', array(), '20130115', true );

	// wp_enqueue_script( 'expand-archive', get_template_directory_uri() . '/js/combine.js', array('jquery'));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'expound-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'expound_scripts' );

/**
 * Additional helper post classes
 */
function expound_post_class( $classes ) {
	if ( has_post_thumbnail() )
		$classes[] = 'has-post-thumbnail';
	return $classes;
}
add_filter('post_class', 'expound_post_class' );

/**
 * Ignore and exclude featured posts on the home page.
 */
function expound_pre_get_posts( $query ) {
	if ( ! $query->is_main_query() || is_admin() )
		return;

	if ( $query->is_home() ) { // condition should be (almost) the same as in index.php
		$query->set( 'ignore_sticky_posts', true );

		$exclude_ids = array();
		$featured_posts = expound_get_featured_posts();

		if ( $featured_posts->have_posts() )
			foreach ( $featured_posts->posts as $post )
				$exclude_ids[] = $post->ID;

		$query->set( 'post__not_in', $exclude_ids );
	}
}

/**
 * new_source_pre_get_posts function.
 * 
 * @access public
 * @param mixed $query
 * @return void
 */
function new_source_pre_get_posts( $query ){
	if ( ! $query->is_main_query() || is_admin() )
		return;
	
	if ( $query->is_home() || $query->is_tax('edition') ){
		
		$exclude_ids = array();
		$featured_posts = new_source_get_featured_posts();

		if ( $featured_posts->have_posts() )
			foreach ( $featured_posts->posts as $post )
				$exclude_ids[] = $post->ID;
		
		$special_posts = new_source_get_special_posts();

		if ( $special_posts->have_posts() )
			foreach ( $special_posts->posts as $post )
				$exclude_ids[] = $post->ID;
		
		$query->set( 'post__not_in', $exclude_ids );
		
		if ( $query->is_home() ):
		
			$query->set( 'tax_query', array( array(
					'taxonomy' => 'edition',
					'field' => 'id',
					'terms' => get_theme_mod('home_edition')
				))
		 	);
		endif;
	
		
	
	}
}

function new_source_get_special_posts(){
	
	$edition = new_source_get_edition_id();
	
	$args = array(
		'posts_per_page' => -1,
		'tax_query' => array(
		array(
			'taxonomy' => 'edition',
			'field' => 'id',
			'terms' => new_source_get_edition_id()
		),
		array(
			'taxonomy' => 'category',
			'field' => 'slug',
			'terms' => array( 'spencies-view', 'forum', 'le-grain-de-sel' )
			)
		)
	);
		
	return new WP_Query( $args );
}

add_action( 'pre_get_posts', 'new_source_pre_get_posts' );


/**
 * new_source_remove_selected function.
 * 
 * @access public
 * @param mixed $categories
 * @return void
 */
function new_source_remove_selected( $categories ) {
	
	$exclude_categories = array('selected', 'selection');
	foreach($categories as $cat ):
		if(!in_array( $cat->slug, $exclude_categories ) )
			$return_categories[] = $cat;
	endforeach;
	
	return $return_categories;
}
add_filter( 'get_the_categories' , 'new_source_remove_selected');

/**
 * Returns a new WP_Query with featured posts.
 */
function expound_get_featured_posts() {
	global $wp_query;

	// Jetpack Featured Content support
	$sticky = apply_filters( 'expound_get_featured_posts', array() );
	if ( ! empty( $sticky ) )
		$sticky = wp_list_pluck( $sticky, 'ID' );

	if ( empty( $sticky ) )
		$sticky = (array) get_option( 'sticky_posts', array() );

	if ( empty( $sticky ) ) {
		return new WP_Query( array(
			'posts_per_page' => 5,
			'ignore_sticky_posts' => true,
		) );
	}

	$args = array(
		'posts_per_page' => 5,
		'post__in' => $sticky,
		'ignore_sticky_posts' => true,
	);

	return new WP_Query( $args );
}


/**
 * Returns a new WP_Query with featured posts.
 */
function new_source_get_featured_posts() {
	
	$edition = new_source_get_edition_id();
	
	$args = array(
		'posts_per_page' => -1,
		'tax_query' => array(
		array(
			'taxonomy' => 'edition',
			'field' => 'id',
			'terms' => new_source_get_edition_id()
		),
		array(
			'taxonomy' => 'category',
			'field' => 'slug',
			'terms' => array( 'cover-story', 'selected', 'a-la-une', 'selection' )
			)
		)
	);
		
	return new WP_Query( $args );
}

/**
 * new_source_get_edition_id function.
 * 
 * @access public
 * @return void
 */
function new_source_get_edition_id(){
	
	if( is_home() ):
		return get_theme_mod( 'home_edition' );
	elseif(  is_tax( 'edition' ) ) :
		return get_queried_object_id();
	elseif( is_page()):
		return get_theme_mod( 'home_edition' );
	elseif( is_single() ):
		global $post;
		$terms =  get_the_terms( $post->ID, 'edition' );
		
		if( !$terms )
			return get_theme_mod( 'home_edition' );
			
		$ids = array_keys( $terms );
		
		return $ids[0];
	endif;
}

function new_source_get_edition_name(){


	$term_id = new_source_get_edition_id();
	
	$edition = get_term_by( 'id', $term_id, 'edition' );
	
	$volume  = get_term_by( 'id', $edition->parent, 'edition' );
	$edition_link = get_term_link( $edition );

	return ( is_object($volume) ? $volume->name.", ".$edition->name." - ".$edition->description : $edition->name." - ".$edition->description );

}
/**
 * Returns a new WP_Query with related posts.
 */
function expound_get_related_posts() {
	$post = get_post();

	$args = array(
		'posts_per_page' => 3,
		'ignore_sticky_posts' => true,
		'post__not_in' => array( $post->ID ),
	);

	// Get posts from the same category.
	$categories = get_the_category();
	if ( ! empty( $categories ) ) {
		$category = array_shift( $categories );
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => $category->term_id,
			),
		);
	}

	return new WP_Query( $args );
}

/**
 * Footer credits.
 */
function expound_display_credits() {
	$text = '<a href="http://wordpress.org/" rel="generator">' . sprintf( __( 'Proudly powered by %s', 'expound' ), 'WordPress' ) . '</a>';
	$text .= '<span class="sep"> | </span>';
	$text .= sprintf( __( 'Theme: %1$s by %2$s', 'expound' ), 'expound', '<a href="http://kovshenin.com/" rel="designer">Konstantin Kovshenin</a>' );
	echo apply_filters( 'expound_credits_text', $text );
}
add_action( 'expound_credits', 'expound_display_credits' );

/**
 * Decrease caption width for non-full-width images. Pixelus perfectus!
 */
function expound_shortcode_atts_caption( $attr ) {
	global $content_width;

	if ( isset( $attr['width'] ) && $attr['width'] < $content_width )
		$attr['width'] -= 4;

	return $attr;
}
add_filter( 'shortcode_atts_caption', 'expound_shortcode_atts_caption' );


/**
 * new_source_customize_register function.
 * 
 * @access public
 * @param mixed $wp_customize
 * @return void
 */
function new_source_customize_register( $wp_customize ) {

	require_once( 'inc/class-taxonomy_dropdown_custom_control.php' );
	
	$wp_customize->add_section(
		'my_theme_blog_home_edition', array(
			'title' => 'Home Edition',
			'priority' => 36,
			'args' => array(), // arguments for wp_dropdown_categories function..., optional
		)
	);
	
	$wp_customize->add_setting(
		'home_edition', array(
			'default' => get_option( 'home_edition', '' ),
		)
	);
	
	$wp_customize->add_control(
		new Taxonomy_Dropdown_Custom_Control(
			$wp_customize, 'home_edition', array(
				'label' => __( 'Current Edition', 'textdomain' ),
				'section' => 'my_theme_blog_home_edition',
				'settings' => 'home_edition',
			)
		)
	);
	
	return $wp_customize;
}

add_action( 'customize_register', 'new_source_customize_register' );

if ( ! function_exists('new_source_register_edition') ) {
	// Register Custom Taxonomy
	function new_source_register_edition()  {
	
		$labels = array(
			'name'                       => _x( 'editions', 'Taxonomy General Name', 'new-source' ),
			'singular_name'              => _x( 'edition', 'Taxonomy Singular Name', 'new-source' ),
			'menu_name'                  => __( 'Edition', 'new-source' ),
			'all_items'                  => __( 'All Editions', 'new-source' ),
			'parent_item'                => __( 'Parent Edition', 'new-source' ),
			'parent_item_colon'          => __( 'Parent Edition:', 'new-source' ),
			'new_item_name'              => __( 'New Edition Name', 'new-source' ),
			'add_new_item'               => __( 'Add New Edition', 'new-source' ),
			'edit_item'                  => __( 'Edit Edition', 'new-source' ),
			'update_item'                => __( 'Update Edition', 'new-source' ),
			'separate_items_with_commas' => __( 'Separate editions with commas', 'new-source' ),
			'search_items'               => __( 'Search edition', 'new-source' ),
			'add_or_remove_items'        => __( 'Add or remove edition', 'new-source' ),
			'choose_from_most_used'      => __( 'Choose from the most used edition', 'new-source' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
		);
		register_taxonomy( 'edition', 'post', $args );
	
	}
	// Hook into the 'init' action
	add_action( 'init', 'new_source_register_edition', 0 );
}

/**
 * new_source_display_edition function.
 * 
 * @access public
 * @param mixed $edition
 * @return void
 */
function new_source_display_edition($edition) {
	
	
}

/**
 * new_souce_prefetch_link function.
 * 
 * @access public
 * @return void
 */
function new_souce_prefetch_link(){
	global $paged;
	
	if (is_archive() && ($paged > 1) && ( $paged < $wp_query->max_num_pages)) { ?>
	<link rel="prefetch" href="<?php echo get_next_posts_page_link(); ?>">
	<link rel="prerender" href="<?php echo get_next_posts_page_link(); ?>">
	<?php } elseif (is_singular()) { ?>
	<?php if( is_single() ) { 
		$post_previous = get_adjacent_post( false, '', true );
		$post_next = get_adjacent_post( false, '', false );
		
	?>
	
	<link rel="prefetch" href="<?php echo get_permalink( $post_previous ); ?>" />
	<link rel="prerender" href="<?php echo get_permalink( $post_previous ); ?>" />
	
	<link rel="prefetch" href="<?php echo get_permalink( $post_next ); ?>" />
	<link rel="prerender" href="<?php echo get_permalink( $post_next ); ?>" />
	
	<?php } ?>
	<link rel="prefetch" href="<?php bloginfo('home'); ?>">
	<link rel="prerender" href="<?php bloginfo('home'); ?>">
	<?php 
	} else if( is_home() || is_front_page() ){
	
		$featured_posts = new_source_get_featured_posts(); 
		if ( $featured_posts->have_posts() ) : $featured_posts->the_post();
			?>
			<link rel="prefetch" href="<?php echo get_permalink(); ?>">
			<link rel="prerender" href="<?php echo get_permalink(); ?>" />
			<?php
		endif;
	
	}
	
}
/*===================================================================================
 * Add Author Links
 * =================================================================================*/

/**
 * add_to_author_profile function.
 * 
 * @access public
 * @param mixed $contactmethods
 * @return void
 */
function add_to_author_profile( $contactmethods ) {
	
	$contactmethods['public_email'] = 'Public Email';
	$contactmethods['rss_url'] = 'RSS URL';
	$contactmethods['google_profile'] = 'Google Profile URL';
	$contactmethods['twitter_profile'] = 'Twitter Profile URL';
	$contactmethods['facebook_profile'] = 'Facebook Profile URL';
	$contactmethods['linkedin_profile'] = 'Linkedin Profile URL';
	
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'add_to_author_profile', 10, 1);
