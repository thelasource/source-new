<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Expound
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php 

global $edition, $edition_link;

if( is_tax( 'edition' ) ):
	// $term_idz = get_queried_object_id();
else:
	$term_idz = get_theme_mod('home_edition');
endif;

	$edition = get_term_by( 'id', $term_idz, 'edition' );
	$volume  = get_term_by( 'id', $edition->parent, 'edition' );
	$edition_link = get_term_link( $edition );
	$edition_name = ( is_object($volume) ? $volume->name.", ".$edition->name." - ".$edition->description : $edition->name." - ".$edition->description ); 



// $edition->name
// $edition->description
// $edition->slug
// $edition->term_id		
		?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php wp_title( '|', true, 'right' ); echo " | ".$edition_name; ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!--Top Bar -->
<div id="top-bar" class="topbar">
	<div id="topbar-content">
	<div id="topbar-left" class="topbar-left">
	<img src="/wp-content/uploads/2013/08/source_icon_white.png"/>
	<span class="topbar-language"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ENGLISH</a></span> &middot; <span class="topbar-edition"><a class='expand-archive'><?php echo $edition_name; ?></a></span>
<form method="post" class='archive'>
            	Select an issue: 
            	<?php
            	
            	class Walker_SlugValueCategoryDropdown extends Walker_CategoryDropdown {
            		function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
						$pad = str_repeat('&nbsp;', $depth * 3);

						$cat_name = apply_filters('list_cats', $category->name, $category);
						$output .= "\t<option class=\"level-$depth\" value=\"".$category->slug."\"";
					
						if ( $category->term_id == $args['selected'] )
							$output .= ' selected="selected"';
					
						$output .= '>';
						$output .= $pad.$cat_name;
						if ( $args['show_count'] )
							$output .= '&nbsp;&nbsp;('. $category->count .')';
						$output .= "</option>\n";
					}
				}


            	$volume_args = array(
            		'name'=>'ed',
            		'taxonomy'=>'edition',
            		'hierarchical'=>true,
            		'walker'=>new Walker_SlugValueCategoryDropdown);

            	wp_dropdown_categories($volume_args);
            	?>
            	<script type="text/javascript"><!--
    				var dropdown = document.getElementById("ed");
    				function onEditionChange() {
						if ( dropdown.options[dropdown.selectedIndex].value) {
							location.href =  "<?php echo get_option('home');?>/?edition="+dropdown.options[dropdown.selectedIndex].value;
						}
    				}
    				dropdown.onchange = onEditionChange;
			--></script>
        	</form>
</div>
	<div id="topbar-right" class="topbar-right">retrouvez-nous:
		<a href="http://www.facebook.com/thelasource" target="_blank"><i class="icon-facebook-rect"></i></a> 
		<a href="http://twitter.com/thelasource" target="_blank"><i class="icon-twitter-rect"></i></a>
		<a href="mailto:info@thelasource.com" target="_blank"><i class="icon-mail-alt"></i>
		<a href="/feed/rss2/" target="_blank"><i class="icon-rss"></i></a>
	</div>
	</div>
</div>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<div class="site-title-group">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div>

			<?php $header_image = get_header_image(); ?>
			<?php if ( ! empty( $header_image ) ) : ?>
				<a class="expound-custom-header" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
				</a>
			<?php endif; ?>
            <!-- Header Ad Place -->
 <?php if ( is_active_sidebar( 'header-widget-area' ) ) : ?>
			<div id="header-ad" class="header-adplace">
                        <?php if ( !dynamic_sidebar( 'header-widget-area' ) )?>
           </div>
<?php endif; ?>
		</div>
		

		<nav id="site-navigation" class="navigation-main" role="navigation">
			<h1 class="menu-toggle"><?php _e( 'Menu', 'expound' ); ?></h1>
			<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'expound' ); ?>"><?php _e( 'Skip to content', 'expound' ); ?></a></div>

			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'depth' => 3 ) ); ?>
			<?php do_action( 'expound_navigation_after' ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
	<div id="main" class="site-main">
