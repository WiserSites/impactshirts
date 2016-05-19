<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme Options
 *
 *
 * @file           theme-options.php
 * @package        Impactshirts
 * @author         WiserSites
 * @copyright      2003 - 2014 WiserSites
 * @license        license.txt
 * @version        Release: 1.9.6
 * @filesource     wp-content/themes/impactshirts/includes/theme-options.php
 * @link           http://themeshaper.com/2010/06/03/sample-theme-options/
 * @since          available since Release 1.0
 */

/**
 * Call the options class
 */
require( get_template_directory() . '/core/includes/classes/Impactshirts_Options.php' ); //str_replace( 'responsive', 'impactshirts', get_template_directory())
//require( str_replace( 'responsive', 'impactshirts', get_template_directory()) . '/core/includes/classes/Impactshirts_Options.php' ); //str_replace( 'responsive', 'impactshirts', get_template_directory())

/**
 * A safe way of adding JavaScripts to a WordPress generated page.
 */
function impactshirts_admin_enqueue_scripts( $hook_suffix ) {
	$template_directory_uri = get_template_directory_uri();
	$suffix                 = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'impactshirts-theme-options', $template_directory_uri . '/core/includes/theme-options/theme-options' . $suffix . '.css', false, '1.0' );
	wp_enqueue_script( 'impactshirts-theme-options', $template_directory_uri . '/core/includes/theme-options/theme-options' . $suffix . '.js', array( 'jquery' ), '1.0' );
}

add_action( 'admin_print_styles-appearance_page_theme_options', 'impactshirts_admin_enqueue_scripts' );

/**
 * Init plugin options to white list our options
 */
function impactshirts_theme_options_init() {
	register_setting( 'impactshirts_options', 'impactshirts_theme_options', 'impactshirts_theme_options_validate' );
}

/**
 * Load up the menu page
 */
function impactshirts_theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'impactshirts' ), __( 'Theme Options', 'impactshirts' ), 'edit_theme_options', 'theme_options', 'impactshirts_theme_options_do_page' );
}

function impactshirts_inline_css() {
	global $impactshirts_options;
	if ( !empty( $impactshirts_options['impactshirts_inline_css'] ) ) {
		echo '<!-- Custom CSS Styles -->' . "\n";
		echo '<style type="text/css" media="screen">' . "\n";
		echo $impactshirts_options['impactshirts_inline_css'] . "\n";
		echo '</style>' . "\n";
	}
}

add_action( 'wp_head', 'impactshirts_inline_css', 110 );

function impactshirts_inline_js_head() {
	global $impactshirts_options;
	if ( !empty( $impactshirts_options['impactshirts_inline_js_head'] ) ) {
		echo '<!-- Custom Scripts -->' . "\n";
		echo $impactshirts_options['impactshirts_inline_js_head'];
		echo "\n";
	}
}

add_action( 'wp_head', 'impactshirts_inline_js_head' );

function impactshirts_inline_js_footer() {
	global $impactshirts_options;
	if ( !empty( $impactshirts_options['impactshirts_inline_js_footer'] ) ) {
		echo '<!-- Custom Scripts -->' . "\n";
		echo $impactshirts_options['impactshirts_inline_js_footer'];
		echo "\n";
	}
}

add_action( 'wp_footer', 'impactshirts_inline_js_footer' );

/**
 * Create the options page
 */
function impactshirts_theme_options_do_page() {

	if ( !isset( $_REQUEST['settings-updated'] ) ) {
		$_REQUEST['settings-updated'] = false;
	}

	// Set confirmaton text for restore default option as attributes of submit_button().
	$attributes['onclick'] = 'return confirm("' . __( 'Do you want to restore?', 'impactshirts' ) . '\n' . __( 'All theme settings will be lost!', 'impactshirts' ) . '\n' . __( 'Click OK to Restore.', 'impactshirts' ) . '")';
	?>

	<div class="wrap">
	<?php $theme_name = wp_get_theme() ?>
	<?php echo "<h2>" . $theme_name . " " . __( 'Theme Options', 'impactshirts' ) . "</h2>"; ?>


	<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options Saved', 'impactshirts' ); ?></strong></p></div>
	<?php endif; ?>

	<?php impactshirts_theme_options(); // Theme Options Hook ?>

	<?php

	/**
	 * Create array of option sections
	 *
	 * @Title The display title
	 * @id The id that the option array references so the options display in the correct section
	 */
	$sections = apply_filters( 'impactshirts_option_sections_filter', array(
																	  array(
																		  'title' => __( 'Theme Elements', 'impactshirts' ),
																		  'id'    => 'theme_elements'
																	  ),

																	  array(
																		  'title' => __( 'Logo Upload', 'impactshirts' ),
																		  'id'    => 'logo_upload'
																	  ),
																	  array(
																		  'title' => __( 'Home Page', 'impactshirts' ),
																		  'id'    => 'home_page'
																	  )
																  ,
																	  array(
																		  'title' => __( 'Default Layouts', 'impactshirts' ),
																		  'id'    => 'layouts'
																	  ),
																	  array(
																		  'title' => __( 'Social Icons', 'impactshirts' ),
																		  'id'    => 'social'
																	  ),
																	  array(
																		  'title' => __( 'CSS Styles', 'impactshirts' ),
																		  'id'    => 'css'
																	  ),
																	  array(
																		  'title' => __( 'Scripts', 'impactshirts' ),
																		  'id'    => 'scripts'
																	  )

																  )

	);

	/**
	 * Creates and array of options that get added to the relevant sections
	 *
	 * @key This must match the id of the section you want the options to appear in
	 *
	 * @title Title on the left hand side of the options
	 * @subtitle Displays underneath main title on left hand side
	 * @heading Right hand side above input
	 * @type The type of input e.g. text, textarea, checkbox
	 * @id The options id
	 * @description Instructions on what to enter in input
	 * @placeholder The placeholder for text and textarea
	 * @options array used by select dropdown lists
	 */
	$options = apply_filters( 'impactshirts_options_filter', array(
		'theme_elements' => array(
			array(
				'title'       => __( 'Disable breadcrumb list?', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'checkbox',
				'id'          => 'breadcrumb',
				'description' => __( 'check to disable', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Disable Call to Action Button?', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'checkbox',
				'id'          => 'cta_button',
				'description' => __( 'check to disable', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Enable minified css?', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'checkbox',
				'id'          => 'minified_css',
				'description' => __( 'check to enable', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Enable Blog Title', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'checkbox',
				'id'          => 'blog_post_title_toggle',
				'description' => __( 'check to enable', 'impactshirts' ),
			),
			array(
				'title'       => __( 'Title Text', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'blog_post_title_text',
				'description' => '',
				'placeholder' => __( 'Blog', 'impactshirts' )
			)
		),
		'logo_upload' => array(
			array(
				'title'       => __( 'Custom Header', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'description',
				'id'          => '',
				'description' => __( 'Need to replace or remove default logo?', 'impactshirts' ) . sprintf( ' <a href="%s">' . __( 'Click here', 'impactshirts' ) . '</a>.',
				 admin_url( 'themes.php?page=custom-header' ) ),
				'placeholder' => ''
			)
		),
		'home_page' => array(
			array(
				'title'       => __( 'Enable Custom Front Page', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'checkbox',
				'id'          => 'front_page',
				'description' => sprintf( __( 'Overrides the WordPress %1sfront page option%2s', 'impactshirts' ), '<a href="options-reading.php">', '</a>' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Headline', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'home_headline',
				'description' => __( 'Enter your headline', 'impactshirts' ),
				'placeholder' => __( 'Hello, World!', 'impactshirts' )
			),
			array(
				'title'       => __( 'Subheadline', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'home_subheadline',
				'description' => __( 'Enter your subheadline', 'impactshirts' ),
				'placeholder' => __( 'Your H2 subheadline here', 'impactshirts' )
			),
			array(
				'title'       => __( 'Content Area', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'editor',
				'id'          => 'home_content_area',
				'description' => __( 'Enter your content', 'impactshirts' ),
				'placeholder' => __( 'Your title, subtitle and this very content is editable from Theme Option. Call to Action button and its destination link as well. Image on your right can be an image or even YouTube video if you like.', 'impactshirts' )
			),
			array(
				'title'       => __( 'Call to Action (URL)', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'cta_url',
				'description' => __( 'Enter your call to action URL', 'impactshirts' ),
				'placeholder' => '#nogo'
			),
			array(
				'title'       => __( 'Call to Action (Text)', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'cta_text',
				'description' => __( 'Enter your call to action text', 'impactshirts' ),
				'placeholder' => __( 'Call to Action', 'impactshirts' )
			),
			array(
				'title'       => __( 'Featured Content', 'impactshirts' ),
				'subtitle'    => '<a class="help-links" href="' . esc_url( 'http://wisersites.com/guide/impactshirts/' ) . '" title="' . esc_attr__( 'See Docs', 'impactshirts' ) . '" target="_blank">' .
				 __( 'See Docs', 'impactshirts' ) . '</a>',
				'heading'     => '',
				'type'        => 'editor',
				'id'          => 'featured_content',
				'description' => __( 'Paste your shortcode, video or image source', 'impactshirts' ),
				'placeholder' => "<img class='aligncenter' src='" . get_template_directory_uri() . "'/core/images/featured-image.png' width='440' height='300' alt='' />"
			)

		),
		'layouts' => array(
			array(
				'title'       => __( 'Default Static Page Layout', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'select',
				'id'          => 'static_page_layout_default',
				'description' => '',
				'placeholder' => '',
				'options'     => Impactshirts_Options::valid_layouts()
			),
			array(
				'title'       => __( 'Default Single Blog Post Layout', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'select',
				'id'          => 'single_post_layout_default',
				'description' => '',
				'placeholder' => '',
				'options'     => Impactshirts_Options::valid_layouts()
			),
			array(
				'title'       => __( 'Default Blog Posts Index Layout', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'select',
				'id'          => 'blog_posts_index_layout_default',
				'description' => '',
				'placeholder' => '',
				'options'     => Impactshirts_Options::valid_layouts()
			)

		),
		'social' => array(
			array(
				'title'       => __( 'Twitter', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'twitter_uid',
				'description' => __( 'Enter your Twitter URL', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Facebook', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'facebook_uid',
				'description' => __( 'Enter your Facebook URL', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'LinkedIn', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'linkedin_uid',
				'description' => __( 'Enter your LinkedIn URL', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'YouTube', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'youtube_uid',
				'description' => __( 'Enter your YouTube URL', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'StumbleUpon', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'stumble_uid',
				'description' => __( 'Enter your StumbleUpon URL', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'RSS Feed', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'rss_uid',
				'description' => __( 'Enter your RSS Feed URL', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Google+', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'google_plus_uid',
				'description' => __( 'Enter your Google+ URL', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Instagram', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'instagram_uid',
				'description' => __( 'Enter your Instagram URL', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Pinterest', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'pinterest_uid',
				'description' => __( 'Enter your Pinterest URL', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Yelp!', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'yelp_uid',
				'description' => __( 'Enter your Yelp! URL', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Vimeo', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'vimeo_uid',
				'description' => __( 'Enter your Vimeo URL', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'foursquare', 'impactshirts' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'foursquare_uid',
				'description' => __( 'Enter your foursquare URL', 'impactshirts' ),
				'placeholder' => ''
			)

		),
		'css' => array(
			array(
				'title'       => __( 'Custom CSS Styles', 'impactshirts' ),
				'subtitle'    => '<a class="help-links" href="https://developer.mozilla.org/en/CSS" title="CSS Tutorial" target="_blank">' . __( 'CSS Tutorial', 'impactshirts' ) . '</a>',
				'heading'     => '',
				'type'        => 'textarea',
				'id'          => 'impactshirts_inline_css',
				'description' => __( 'Enter your custom CSS styles.', 'impactshirts' ),
				'placeholder' => ''
			)
		),
		'scripts' => array(
			array(
				'title'       => __( 'Custom Scripts for Header and Footer', 'impactshirts' ),
				'subtitle'    => '<a class="help-links" href="http://codex.wordpress.org/Using_Javascript" title="Quick Tutorial" target="_blank">' . __( 'Quick Tutorial', 'impactshirts' ) . '</a>',
				'heading'     => __( 'Embeds to header.php &darr;', 'impactshirts' ),
				'type'        => 'textarea',
				'id'          => 'impactshirts_inline_js_head',
				'description' => __( 'Enter your custom header script.', 'impactshirts' ),
				'placeholder' => ''
			),
			array(
				'title'       => '',
				'subtitle'    => '',
				'heading'     => __( 'Embeds to footer.php &darr;', 'impactshirts' ),
				'type'        => 'textarea',
				'id'          => 'impactshirts_inline_js_footer',
				'description' => __( 'Enter your custom footer script.', 'impactshirts' ),
				'placeholder' => ''
			)
		)
	) );

	if ( class_exists( 'Impactshirts_Pro_Options' ) ) {
		$display = new Impactshirts_Pro_Options( $sections, $options );
	}
	else {
		$display = new Impactshirts_Options( $sections, $options );
	}

	?>
	<form method="post" action="options.php">
		<?php settings_fields( 'impactshirts_options' ); ?>
		<?php global $impactshirts_options; ?>

		<div id="rwd" class="grid col-940">
			<?php
			$display->render_display();
			?>
		</div>
		<!-- end of .grid col-940 -->
	</form>
	</div><!-- wrap -->
<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function impactshirts_theme_options_validate( $input ) {

	global $impactshirts_options;
	$defaults = impactshirts_get_option_defaults();

	if ( isset( $input['reset'] ) ) {

		$input = $defaults;

	}
	else {

		// checkbox value is either 0 or 1
		foreach( array(
					'breadcrumb',
					'cta_button',
					'front_page'
				) as $checkbox ) {
			if ( !isset( $input[$checkbox] ) ) {
				$input[$checkbox] = null;
			}
			$input[$checkbox] = ( $input[$checkbox] == 1 ? 1 : 0 );
		}
		foreach( array(
					'static_page_layout_default',
					'single_post_layout_default',
					'blog_posts_index_layout_default'
				) as $layout ) {
			$input[$layout] = ( isset( $input[$layout] ) && array_key_exists( $input[$layout], impactshirts_get_valid_layouts() ) ? $input[$layout] : $impactshirts_options[$layout] );
		}
		foreach( array(
					'home_headline',
					'home_subheadline',
					'home_content_area',
					'cta_text',
					'cta_url',
					'featured_content',
				) as $content ) {
			$input[$content] = ( in_array( $input[$content], array( $defaults[$content], '' ) ) ? $defaults[$content] : wp_kses_stripslashes( $input[$content] ) );
		}
		$input['google_site_verification']    = ( isset( $input['google_site_verification'] ) ) ? wp_filter_post_kses( $input['google_site_verification'] ) : null;
		$input['bing_site_verification']      = ( isset( $input['bing_site_verification'] ) ) ? wp_filter_post_kses( $input['bing_site_verification'] ) : null;
		$input['yahoo_site_verification']     = ( isset( $input['yahoo_site_verification'] ) ) ? wp_filter_post_kses( $input['yahoo_site_verification'] ) : null;
		$input['site_statistics_tracker']     = ( isset( $input['site_statistics_tracker'] ) ) ? wp_kses_stripslashes( $input['site_statistics_tracker'] ) : null;
		$input['twitter_uid']                 = esc_url_raw( $input['twitter_uid'] );
		$input['facebook_uid']                = esc_url_raw( $input['facebook_uid'] );
		$input['linkedin_uid']                = esc_url_raw( $input['linkedin_uid'] );
		$input['youtube_uid']                 = esc_url_raw( $input['youtube_uid'] );
		$input['stumble_uid']                 = esc_url_raw( $input['stumble_uid'] );
		$input['rss_uid']                     = esc_url_raw( $input['rss_uid'] );
		$input['google_plus_uid']             = esc_url_raw( $input['google_plus_uid'] );
		$input['instagram_uid']               = esc_url_raw( $input['instagram_uid'] );
		$input['pinterest_uid']               = esc_url_raw( $input['pinterest_uid'] );
		$input['yelp_uid']                    = esc_url_raw( $input['yelp_uid'] );
		$input['vimeo_uid']                   = esc_url_raw( $input['vimeo_uid'] );
		$input['foursquare_uid']              = esc_url_raw( $input['foursquare_uid'] );
		$input['impactshirts_inline_css']       = wp_kses_stripslashes( $input['impactshirts_inline_css'] );
		$input['impactshirts_inline_js_head']   = wp_kses_stripslashes( $input['impactshirts_inline_js_head'] );
		$input['impactshirts_inline_js_footer'] = wp_kses_stripslashes( $input['impactshirts_inline_js_footer'] );

		$input = apply_filters( 'impactshirts_options_validate', $input );
	}

	return $input;
}

