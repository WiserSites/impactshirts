<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme's Functions and Definitions
 *
 *
 * @file           functions.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2015 - 2016 WiserSites
 * @license        license.txt
 * @version        Release: 1.2.1
 * @filesource     wp-content/themes/impactshirts/includes/functions.php
 * @link           http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          available since Release 1.0
 */
?>
<?php
/*
 * Globalize Theme options
 */
$impactshirts_options = impactshirts_get_options();

/**
 * Add plugin automation file
 */
require_once( dirname( __FILE__ ) . '/classes/class-tgm-plugin-activation.php' );

/*
 * Hook options
 */
add_action( 'admin_init', 'impactshirts_theme_options_init' );
add_action( 'admin_menu', 'impactshirts_theme_options_add_page' );

/**
 * Retrieve Theme option settings
 */
function impactshirts_get_options() {
	// Globalize the variable that holds the Theme options
	global $impactshirts_options;
	// Parse array of option defaults against user-configured Theme options
	$impactshirts_options = wp_parse_args( get_option( 'impactshirts_theme_options', array() ), impactshirts_get_option_defaults() );

	// Return parsed args array
	return $impactshirts_options;
}

/**
 * Impactshirts Theme option defaults
 */
function impactshirts_get_option_defaults() {
	$defaults = array(
		'breadcrumb'                      => false,
		'cta_button'                      => false,
		'minified_css'                    => false,
		'front_page'                      => 1,
		'home_headline'                   => null,
		'home_subheadline'                => null,
		'home_content_area'               => null,
		'cta_text'                        => null,
		'cta_url'                         => null,
		'featured_content'                => null,
		'google_site_verification'        => '',
		'bing_site_verification'          => '',
		'yahoo_site_verification'         => '',
		'site_statistics_tracker'         => '',
		'twitter_uid'                     => '',
		'facebook_uid'                    => '',
		'linkedin_uid'                    => '',
		'youtube_uid'                     => '',
		'stumble_uid'                     => '',
		'rss_uid'                         => '',
		'google_plus_uid'                 => '',
		'instagram_uid'                   => '',
		'pinterest_uid'                   => '',
		'yelp_uid'                        => '',
		'vimeo_uid'                       => '',
		'foursquare_uid'                  => '',
		'impactshirts_inline_css'           => '',
		'impactshirts_inline_js_head'       => '',
		'impactshirts_inline_css_js_footer' => '',
		'static_page_layout_default'      => 'default',
		'single_post_layout_default'      => 'default',
		'blog_posts_index_layout_default' => 'default',
	);

	return apply_filters( 'impactshirts_option_defaults', $defaults );
}

/**
 * Fire up the engines boys and girls let's start theme setup.
 */
add_action( 'after_setup_theme', 'impactshirts_setup' );

if ( !function_exists( 'impactshirts_setup' ) ):

	function impactshirts_setup() {

		global $content_width;

		$template_directory = get_template_directory();

		/**
		 * Global content width.
		 */
		if ( !isset( $content_width ) ) {
			$content_width = 605;
		}

		/**
		 * Impactshirts is now available for translations.
		 * The translation files are in the /languages/ directory.
		 * Translations are pulled from the WordPress default lanaguge folder
		 * then from the child theme and then lastly from the parent theme.
		 * @see http://codex.wordpress.org/Function_Reference/load_theme_textdomain
		 */

		$domain = 'impactshirts';

		load_theme_textdomain( $domain, WP_LANG_DIR . '/impactshirts/' );
		load_theme_textdomain( $domain, get_stylesheet_directory() . '/languages/' );
		load_theme_textdomain( $domain, get_template_directory() . '/languages/' );

		/**
		 * Add callback for custom TinyMCE editor stylesheets. (editor-style.css)
		 * @see http://codex.wordpress.org/Function_Reference/add_editor_style
		 */
		add_editor_style();

		/**
		 * This feature enables post and comment RSS feed links to head.
		 * @see http://codex.wordpress.org/Function_Reference/add_theme_support#Feed_Links
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * This feature enables post-thumbnail support for a theme.
		 * @see http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * This feature enables woocommerce support for a theme.
		 * @see http://www.woothemes.com/2013/02/last-call-for-testing-woocommerce-2-0-coming-march-4th/
		 */
		add_theme_support( 'woocommerce' );

		/**
		 * This feature enables custom-menus support for a theme.
		 * @see http://codex.wordpress.org/Function_Reference/register_nav_menus
		 */
		register_nav_menus( array(
			'top-menu'        => __( 'Top Menu', 'impactshirts' ),
			'header-menu'     => __( 'Header Menu', 'impactshirts' ),
			'sub-header-menu' => __( 'Sub-Header Menu', 'impactshirts' ),
			'footer-menu'     => __( 'Footer Menu', 'impactshirts' )
		) );

		add_theme_support( 'custom-background' );

		add_theme_support( 'custom-header', array(
			// Header text display default
			'header-text'         => false,
			// Header image flex width
			'flex-width'          => true,
			// Header image width (in pixels)
			'width'               => 300,
			// Header image flex height
			'flex-height'         => true,
			// Header image height (in pixels)
			'height'              => 100,
			// Admin header style callback
			'admin-head-callback' => 'impactshirts_admin_header_style'
		) );

		// gets included in the admin header
		function impactshirts_admin_header_style() {
			?>
			<style type="text/css">
				.appearance_page_custom-header #headimg {
					background-repeat: no-repeat;
					border: none;
				}
			</style><?php
		}

		// While upgrading set theme option front page toggle not to affect old setup.
		$impactshirts_options = get_option( 'impactshirts_theme_options' );
		if ( $impactshirts_options && isset( $_GET['activated'] ) ) {

			// If front_page is not in theme option previously then set it.
			if ( !isset( $impactshirts_options['front_page'] ) ) {

				// Get template of page which is set as static front page
				$template = get_post_meta( get_option( 'page_on_front' ), '_wp_page_template', true );

				// If static front page template is set to default then set front page toggle of theme option to 1
				if ( 'page' == get_option( 'show_on_front' ) && $template == 'default' ) {
					$impactshirts_options['front_page'] = 1;
				} else {
					$impactshirts_options['front_page'] = 0;
				}
				update_option( 'impactshirts_theme_options', $impactshirts_options );
			}
		}
	}

endif;

/**
 * Adjust content width in certain contexts.
 *
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 */
function impactshirts_content_width() {
	global $content_width;
	$full_width = is_page_template( 'full-width-page.php' ) || is_404() || 'full-width-page' == impactshirts_get_layout();
	if ( $full_width ) {
		$content_width = 918;
	}
	$half_width = is_page_template( 'sidebar-content-half-page.php' ) || is_page_template( 'content-sidebar-half-page.php' ) || 'sidebar-content-half-page' == impactshirts_get_layout() || 'content-sidebar-half-page' == impactshirts_get_layout();
	if ( $half_width ) {
		$content_width = 449;
	}
}
add_action( 'template_redirect', 'impactshirts_content_width' );

/**
 * Set a fallback menu that will show a home link.
 */
function impactshirts_fallback_menu() {
	$args    = array(
		'depth'       => 0,
		'sort_column' => 'menu_order, post_title',
		'menu_class'  => 'menu',
		'include'     => '',
		'exclude'     => '',
		'echo'        => false,
		'show_home'   => true,
		'link_before' => '',
		'link_after'  => ''
	);
	$pages   = wp_page_menu( $args );
	$prepend = '<div class="main-nav">';
	$append  = '</div>';
	$output  = $prepend . $pages . $append;
	echo $output;
}

/**
 * A safe way of adding stylesheets to a WordPress generated page.
 */
if ( !function_exists( 'impactshirts_css' ) ) {

	function impactshirts_css() {
		$theme      = wp_get_theme();
		$impactshirts = wp_get_theme( 'impactshirts' );
		$impactshirts_options = impactshirts_get_options();
		if ( 1 == $impactshirts_options['minified_css'] ) {
			wp_enqueue_style( 'impactshirts-style', get_template_directory_uri() . '/core/css/style.min.css', false, $impactshirts['Version'] );
		} else {
			wp_enqueue_style( 'impactshirts-style', get_template_directory_uri() . '/core/css/style.css', false, $impactshirts['Version'] );
			wp_enqueue_style( 'impactshirts-media-queries', get_template_directory_uri() . '/core/css/impactshirts.css', false, $impactshirts['Version'].'1' );
		}

		if ( is_rtl() ) {
			wp_enqueue_style( 'impactshirts-rtl-style', get_template_directory_uri() . '/rtl.css', false, $impactshirts['Version'] );
		}
		if ( is_child_theme() ) {
			wp_enqueue_style( 'impactshirts-child-style', get_stylesheet_uri(), false, $theme['Version'] );
		}
	}

}
add_action( 'wp_enqueue_scripts', 'impactshirts_css' );

/**
 * A safe way of adding JavaScripts to a WordPress generated page.
 */
if ( !function_exists( 'impactshirts_js' ) ) {

	function impactshirts_js() {
		$suffix                 = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		$directory              = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? 'js-dev' : 'js';
		$template_directory_uri = get_template_directory_uri();

		// JS at the bottom for fast page loading.
		// except for Modernizr which enables HTML5 elements & feature detects.
		wp_enqueue_script( 'modernizr', $template_directory_uri . '/core/' . $directory . '/impactshirts-modernizr' . $suffix . '.js', array( 'jquery' ), '2.6.2', false );
		wp_enqueue_script( 'impactshirts-scripts', $template_directory_uri . '/core/' . $directory . '/impactshirts-scripts' . $suffix . '.js', array( 'jquery' ), '1.2.7', true );
		if ( !wp_script_is( 'tribe-placeholder' ) ) {
			wp_enqueue_script( 'jquery-placeholder', $template_directory_uri . '/core/' . $directory . '/jquery.placeholder' . $suffix . '.js', array( 'jquery' ), '2.0.7', true );
		}
	}

}
add_action( 'wp_enqueue_scripts', 'impactshirts_js' );

/**
 * A comment reply.
 */
function impactshirts_enqueue_comment_reply() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'impactshirts_enqueue_comment_reply' );

/**
 * Front Page function starts here. The Front page overides WP's show_on_front option. So when show_on_front option changes it sets the themes front_page to 0 therefore displaying the new option
 */
function impactshirts_front_page_override( $new, $orig ) {
	global $impactshirts_options;

	if ( $orig !== $new ) {
		$impactshirts_options['front_page'] = 0;

		update_option( 'impactshirts_theme_options', $impactshirts_options );
	}

	return $new;
}

add_filter( 'pre_update_option_show_on_front', 'impactshirts_front_page_override', 10, 2 );

/**
 * Funtion to add CSS class to body
 */
function impactshirts_add_class( $classes ) {

	// Get Impactshirts theme option.
	global $impactshirts_options;
	if ( $impactshirts_options['front_page'] == 1 && is_front_page() ) {
		$classes[] = 'front-page';
	}

	return $classes;
}

add_filter( 'body_class', 'impactshirts_add_class' );


/**
 * This function prints post meta data.
 *
 * Ulrich Pogson Contribution
 *
 */
if ( !function_exists( 'impactshirts_post_meta_data' ) ) {

	function impactshirts_post_meta_data() {
		printf( __( '<span class="%1$s">Posted on </span>%2$s<span class="%3$s"> by </span>%4$s', 'impactshirts' ),
				'meta-prep meta-prep-author posted',
				sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="timestamp updated" datetime="%3$s">%4$s</time></a>',
						 esc_url( get_permalink() ),
						 esc_attr( get_the_title() ),
						 esc_html( get_the_date('c')),
						 esc_html( get_the_date() )
				),
				'byline',
				sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
						 get_author_posts_url( get_the_author_meta( 'ID' ) ),
						 sprintf( esc_attr__( 'View all posts by %s', 'impactshirts' ), get_the_author() ),
						 esc_attr( get_the_author() )
				)
		);
	}

}


/**
 * Added the footer copyright setting to the theme customizer - starts
 */
function impactshirts_footer_customizer( $wp_customize ) {
	$wp_customize->add_section(
		'footer_section',
		array(
		    'title' => __('Footer Settings','impactshirts'),
		    'priority' => 35,
		)
	    );

	  $wp_customize->add_setting(
	    'copyright_textbox',
	    array(
		'sanitize_callback' => 'sanitize_text_field',
		'default' => __('Default copyright text','impactshirts'),
	    )
	  );

	$wp_customize->add_setting(
	    'poweredby_link',
	    array(
		'sanitize_callback' => 'impactshirts_sanitize_checkbox',
		'default' => '',
	    )
	  );	

	$wp_customize->add_control(
	    'copyright_textbox',
	    array(
		'label' => __('Copyright text','impactshirts'),
		'section' => 'footer_section',
		 'type' => 'text',
	    )
		 
	);
	$wp_customize->add_control(
	    'poweredby_link',
	    array(
		'label' => __('Display Powered By WordPress Link','impactshirts'),
		'section' => 'footer_section',
		'type' => 'checkbox',
	    )
		 
	);
	if( !get_option('copyright_textbox') ) {
	set_theme_mod( 'copyright_textbox', 'Default copyright text' );
	}
}
add_action( 'customize_register', 'impactshirts_footer_customizer' );

function fetch_copyright(){
	?>
	<script>
		jQuery(document).ready(function(){
		var copyright_text = "<?php echo get_theme_mod('copyright_textbox'); ?>";
		var wisersites_link = "<?php echo get_theme_mod('poweredby_link'); ?>";
		var siteurl = "<?php echo site_url(); ?>"; 
		if(copyright_text == "")
		{
			jQuery(".copyright a").text(" "+"Default copyright text");
		}
		else{ 
			jQuery(".copyright a").text(" "+copyright_text);
		}
		jQuery(".copyright a").attr('href',siteurl);
		if(wisersites_link == 1)
		{
			jQuery(".powered").css("display","block");
		}
		else{
			jQuery(".powered").css("display","none");
		}
		});
	</script>
<?php
}
add_action('wp_head','fetch_copyright');

/**
 * Added the footer copyright setting to the theme customizer - ends
 */
