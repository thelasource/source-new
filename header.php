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

 $term_id = new_source_get_edition_id();
 $edition_name = new_source_get_edition_name();
	
	?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php wp_title( '|', true, 'right' ); echo " | ".$edition_name; ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<!--[if IE 8]>
<link href="<?php echo get_template_directory_uri(); ?>/css/ie8.css" rel="stylesheet" type="text/css">
<![endif]-->
<!--[if lte IE 7]>
<link href="<?php echo get_template_directory_uri(); ?>/css/ie7.css" rel="stylesheet" type="text/css">
<![endif]-->
<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!--Top Bar -->
<div id="top-bar" class="topbar">
	<div id="topbar-content">
	<div id="topbar-left" class="topbar-left">
		<a href="<?php site_url();?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/brand/source_icon_white.png"/></a>
		<span class="topbar-language"><a href="/<?php _e('fr','new-source'); ?>"><?php _e( 'Français','new-source');?></a></span> &middot; <span class="topbar-edition"><a class='expand-archive'><?php echo $edition_name; ?></a> &middot; <a class="pdf-download" href=<?php echo new_source_get_pdf( __( 'English_lowres', 'new-source' )  ) ?> ><i class="icon-download"></i> <?php _e('Download PDF','new-source');?> </a></span>
			
			<form method="post" class='archive'>
            	Select an issue: 
            	<?php
            	$volume_args = array(
            		'name'=>'ed',
            		'taxonomy'=>'edition',
            		'hierarchical'=>true,
            		'selected'=>$term_id,
            		'walker'=>new new_source_Walker_CategoryDropdown);

            	wp_dropdown_categories( $volume_args );
            	?>
        	</form>
</div>
		
		<div id="topbar-right" class="topbar-right"><?php _e('Find us','new-source');?>:
			<a href="http://www.facebook.com/thelasource" target="_blank"><i class="icon-facebook-squared"></i></a> 
			<a href="http://twitter.com/thelasource" target="_blank"><i class="icon-twitter"></i></a>
			<a href="mailto:info@thelasource.com" target="_blank"><i class="icon-mail"></i></a>
			<a href="<?php bloginfo('rss_url'); ?> " target="_blank"><i class="icon-rss"></i></a>
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
			<h1 class="menu-toggle"><?php _e( 'Menu', 'new-source' ); ?></h1>
			<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'new-source' ); ?>"><?php _e( 'Skip to content', 'new-source' ); ?></a></div>
			<div class="nav-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'depth' => 3 ) ); ?>
				<?php do_action( 'expound_navigation_after' ); ?>
				<div id="search" class="menu-search">
					<?php get_search_form(); ?>
				</div><!-- #search-form -->
			</div>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
	<div id="main" class="site-main">