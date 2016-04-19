<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header Template
 *
 *
 * @file           header.php
 * @package        Impact Shirts
 * @author         Jason Wiser
 * @copyright      2014 Webinatin Station
 * @license        license.txt
 * @version        Release: 1.3
 * @link           http://codex.wordpress.org/Theme_Development#Document_Head_.28header.php.29
 * @since          available since Release 1.0
 */
?>
	<!doctype html>
	<!--[if !IE]>
	<html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 7 ]>
	<html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 8 ]>
	<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 9 ]>
	<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
	<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?php wp_title( '&#124;', true, 'right' ); ?></title>

		<link rel="profile" href="http://gmpg.org/xfn/11"/>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:700italic,400,800,700,600' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Francois+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
		<?php wp_head(); ?>
	</head>

<body <?php body_class(); ?>>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=179660798774296&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php impactshirts_container(); // before container hook ?>
<div id="container" class="hfeed">

<?php impactshirts_header(); // before header hook ?>
	<div id="fixedHeaderWrapper">
	<div class="skip-container cf">
		<a class="skip-link screen-reader-text focusable" href="#main"><?php _e( '&darr; Skip to Main Content', 'impactshirts' ); ?></a>
	</div><!-- .skip-container -->
	<div id="header-wrapper">
		<div id="header">

			<?php impactshirts_header_top(); // before header content hook ?> 

			<?php impactshirts_in_header(); // header hook ?>
			<?php $data = get_option('impact-options'); ?>
			<?php if( $data['site-logo']['src'] != '' ) : ?>

				<div id="logo">
					<a href="<?php echo home_url( '/' ); ?>"><img src="<?php echo $data['site-logo']['src']; ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
				</div><!-- end of #logo -->

			<?php endif; // header image was removed ?>

			<?php if( !get_header_image() ) : ?>

				<!-- <div id="logo">
					<span class="site-name"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
					<span class="site-description"><?php bloginfo( 'description' ); ?></span>
				</div><!-- end of #logo -->
			<?php endif; // header image was removed (again) ?>

			<?php get_sidebar( 'top' ); $data = get_option('impact-options'); ?>

			<?php impactshirts_header_bottom(); // after header content hook ?>
				<div class="churchShirts">
					<h2><?php echo $data['headerText']; ?></h2>
					<p><?php echo $data['headerSubText']; ?></p>
				</div> 
		</div><!-- end of #header -->
	</div><!-- end of #header-wrapper -->
    
    <?php $header_nav_search = get_field('header_nav_search', 'option');?>
    
	<div id="nav-wrapper">
    	<div class="nav-sub-wrapper">
        	<?php if($header_nav_search == true) : ?>
        	<div class="grid col-700">
                    <img src="<?php echo get_stylesheet_directory_uri()?>/images/spyglass3.png">
            <?php else: ?>
            <div class="grid col-940">
            <?php endif; ?>
					<?php wp_nav_menu( array(
								   'container'       => 'div',
								   'container_class' => 'main-nav',
								   'fallback_cb'     => 'impactshirts_fallback_menu',
								   'theme_location'  => 'header-menu'
							   )
			);
			?>

			<?php if( has_nav_menu( 'sub-header-menu', 'impactshirts' ) ) { ?>
				<?php wp_nav_menu( array(
									   'container'      => '',
									   'menu_class'     => 'sub-header-menu',
									   'theme_location' => 'sub-header-menu'
								   )
				);
				?>
			<?php } ?>
            </div>
            <?php if($header_nav_search == true): ?>
            <div class="col-220 grid fit search-foot"><div class="widget-wrapper"><?php get_search_form(); ?></div></div>
            <?php endif; ?>
            <div class="clearfix"></div>
    	</div>
	</div>
	</div>
	
<?php impactshirts_header_end(); // after header container hook ?>

<?php impactshirts_wrapper(); // before wrapper container hook ?>
<?php 
	if (is_front_page()) :
		if(get_current_blog_id() == '1'):
			echo '<div class="home-slider">'.do_shortcode( '[metaslider id='.$data['homeSliderID'].']' ).'</div>';
		//elseif(get_current_blog_id() == '6'):
		//	echo '<div class="home-slider" style="position:relative;">';
		//	echo do_shortcode( '[metaslider id='.$data['homeSliderID'].']' );
		//	echo '<iframe class="featuredHeaderVideo" width="500" height="281" src="https://www.youtube.com/embed/HIQzAL7mbo8?showinfo=0" frameborder="0" allowfullscreen></iframe>';
		//	echo '</div>';
		endif;
	endif; 
?>
<?php if(!is_search() && !is_404()): ?>
	<div id="wrapper" class="clearfix">
<?php endif; ?>
<?php impactshirts_wrapper_top(); // before wrapper content hook ?>
<?php impactshirts_in_wrapper(); // wrapper hook ?>
<div class="clearfix"></div>