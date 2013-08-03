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

$edition = get_term_by( 'id', get_theme_mod('home_edition'),'edition');
$volume  = get_term_by( 'id', $edition->parent, 'edition');

$edition_link = get_term_link( $edition );
$edition_name = ( is_object($volume) ? $volume->name.", ".$edition->name." - ".$edition->description : $edition->name." - ".$edition->description) ; 
// $edition->name
// $edition->description
// $edition->slug		
			?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php wp_title( '|', true, 'right' ); echo " | ".$edition_name; ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
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
		</div>

		<nav id="site-navigation" class="navigation-main" role="navigation">
			<h1 class="menu-toggle"><?php _e( 'Menu', 'expound' ); ?></h1>
			<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'expound' ); ?>"><?php _e( 'Skip to content', 'expound' ); ?></a></div>

			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'depth' => 3 ) ); ?>
			<?php do_action( 'expound_navigation_after' ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="main" class="site-main">
