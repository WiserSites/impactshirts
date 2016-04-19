<?php
/**
 * Impactshirts  Theme Customizer
 *
 * @package impactshirts
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function impactshirts_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';


/*--------------------------------------------------------------
	// Theme Elements
--------------------------------------------------------------*/

	$wp_customize->add_section( 'theme_elements', array(
		'title'                 => __( 'Theme Elements', 'impactshirts' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'impactshirts_theme_options[breadcrumb]', array( 'sanitize_callback' => 'impactshirts_sanitize_checkbox', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_breadcrumb', array(
		'label'                 => __( 'Disable breadcrumb list?', 'impactshirts' ),
		'section'               => 'theme_elements',
		'settings'              => 'impactshirts_theme_options[breadcrumb]',
		'type'                  => 'checkbox'
	) );
	$wp_customize->add_setting( 'impactshirts_theme_options[cta_button]', array( 'sanitize_callback' => 'impactshirts_sanitize_checkbox', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_cta_button', array(
		'label'                 => __( 'Disable Call to Action Button?', 'impactshirts' ),
		'section'               => 'theme_elements',
		'settings'              => 'impactshirts_theme_options[cta_button]',
		'type'                  => 'checkbox'
	) );
	$wp_customize->add_setting( 'impactshirts_theme_options[minified_css]', array( 'sanitize_callback' => 'impactshirts_sanitize_checkbox', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_minified_css', array(
		'label'                 => __( 'Enable minified css?', 'impactshirts' ),
		'section'               => 'theme_elements',
		'settings'              => 'impactshirts_theme_options[minified_css]',
		'type'                  => 'checkbox'
	) );
	$wp_customize->add_setting( 'impactshirts_theme_options[blog_post_title_toggle]', array( 'sanitize_callback' => 'impactshirts_sanitize_checkbox', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_blog_post_title_toggle', array(
		'label'                 => __( 'Enable Blog Title', 'impactshirts' ),
		'section'               => 'theme_elements',
		'settings'              => 'impactshirts_theme_options[blog_post_title_toggle]',
		'type'                  => 'checkbox'
	) );

	$wp_customize->add_setting( 'impactshirts_theme_options[blog_post_title_text]', array( 'sanitize_callback' => 'sanitize_text_field', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_blog_post_title_text', array(
		'label'                 => __( 'Title Text', 'impactshirts' ),
		'section'               => 'theme_elements',
		'settings'              => 'impactshirts_theme_options[blog_post_title_text]',
		'type'                  => 'text'
	) );


/*--------------------------------------------------------------
	// Home Page
--------------------------------------------------------------*/

	$wp_customize->add_section( 'home_page', array(
		'title'                 => __( 'Home Page', 'impactshirts' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'impactshirts_theme_options[front_page]', array( 'sanitize_callback' => 'impactshirts_sanitize_checkbox', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_front_page', array(
		'label'                 => __( 'Enable Custom Front Page', 'impactshirts' ),
		'section'               => 'home_page',
		'settings'              => 'impactshirts_theme_options[front_page]',
		'type'                  => 'checkbox',
		'description'           => __( 'Overrides the WordPress front page option', 'impactshirts' )
	) );
	$wp_customize->add_setting( 'impactshirts_theme_options[home_headline]', array( 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage','default' => __( 'Hello, World!', 'impactshirts' ), 'type' => 'option' ));
	$wp_customize->add_control( 'res_home_headline', array(
		'label'                 => __( 'Headline', 'impactshirts' ),
		'section'               => 'home_page',
		'settings'              => 'impactshirts_theme_options[home_headline]',
		'type'                  => 'text'
	) );
	$wp_customize->add_setting( 'impactshirts_theme_options[home_subheadline]', array( 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage','default' => __( 'Your H2 subheadline here', 'impactshirts' ), 'type' => 'option' ));
	$wp_customize->add_control( 'res_home_subheadline', array(
		'label'                 => __( 'Subheadline', 'impactshirts' ),
		'section'               => 'home_page',
		'settings'              => 'impactshirts_theme_options[home_subheadline]',
		'type'                  => 'text'
	) );
	$wp_customize->add_setting( 'impactshirts_theme_options[home_content_area]',array( 'sanitize_callback' => 'impactshirts_sanitize_textarea', 'default' => __( 'Your title, subtitle and this very content is editable from Theme Option. Call to Action button and its destination link as well. Image on your right can be an image or even YouTube video if you like.', 'impactshirts' ), 'transport' => 'postMessage', 'type' => 'option') );
	$wp_customize->add_control( 'res_home_content_area', array(
		'label'                 => __( 'Content Area', 'impactshirts' ),
		'section'               => 'home_page',
		'settings'              => 'impactshirts_theme_options[home_content_area]',
		'type'                  => 'textarea'
	) );	
	$wp_customize->add_setting( 'impactshirts_theme_options[cta_url]', array( 'sanitize_callback' => 'esc_url_raw','default' => '#nogo','transport' => 'postMessage', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_cta_url', array(
		'label'                 => __( 'Call to Action (URL)', 'impactshirts' ),
		'section'               => 'home_page',
		'settings'              => 'impactshirts_theme_options[cta_url]',
		'type'                  => 'text'
	) );

	$wp_customize->add_setting( 'impactshirts_theme_options[cta_text]', array( 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Call to Action','transport' => 'postMessage', 'type' => 'option') );
	$wp_customize->add_control( 'res_cta_text', array(
		'label'                 => __( 'Call to Action (Text)', 'impactshirts' ),
		'section'               => 'home_page',
		'settings'              => 'impactshirts_theme_options[cta_text]',
		'type'                  => 'text'
	) );

	$wp_customize->add_setting( 'impactshirts_theme_options[featured_content]', array( 'sanitize_callback' => 'impactshirts_sanitize_textarea', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_featured_content', array(
		'label'                 => __( 'Featured Content', 'impactshirts' ),
		'section'               => 'home_page',
		'settings'              => 'impactshirts_theme_options[featured_content]',
		'type'                  => 'textarea',
		'description'           => __( 'Paste your shortcode, video or image source', 'impactshirts' )
	) );


/*--------------------------------------------------------------
	// Default Layouts
--------------------------------------------------------------*/

	$wp_customize->add_section( 'default_layouts', array(
		'title'                 => __( 'Default Layouts', 'impactshirts' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'impactshirts_theme_options[static_page_layout_default]', array( 'sanitize_callback' => 'impactshirts_sanitize_default_layouts', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_static_page_layout_default', array(
		'label'                 => __( 'Default Static Page Layout', 'impactshirts' ),
		'section'               => 'default_layouts',
		'settings'              => 'impactshirts_theme_options[static_page_layout_default]',
		'type'                  => 'select',
		'choices'               => Impactshirts_Options::valid_layouts()
	) );
	$wp_customize->add_setting( 'impactshirts_theme_options[single_post_layout_default]', array( 'sanitize_callback' => 'impactshirts_sanitize_default_layouts', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_single_post_layout_default', array(
		'label'                 => __( 'Default Single Blog Post Layout', 'impactshirts' ),
		'section'               => 'default_layouts',
		'settings'              => 'impactshirts_theme_options[single_post_layout_default]',
		'type'                  => 'select',
		'choices'               => Impactshirts_Options::valid_layouts()
	) );
	$wp_customize->add_setting( 'impactshirts_theme_options[blog_posts_index_layout_default]', array( 'sanitize_callback' => 'impactshirts_sanitize_default_layouts', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_hblog_posts_index_layout_default', array(
		'label'                 => __( 'Default Blog Posts Index Layout', 'impactshirts' ),
		'section'               => 'default_layouts',
		'settings'              => 'impactshirts_theme_options[blog_posts_index_layout_default]',
		'type'                  => 'select',
		'choices'               => Impactshirts_Options::valid_layouts()
	) );

/*--------------------------------------------------------------
	// SOCIAL MEDIA SECTION
--------------------------------------------------------------*/

	$wp_customize->add_section( 'impactshirts_social_media', array(
		'title'             => __( 'Social Icons', 'impactshirts' ),
		'priority'          => 40,
		'description'       => __( 'Enter the URL to your account for each service for the icon to appear in the header.', 'impactshirts' ),
	) );

	// Add Twitter Setting

	$wp_customize->add_setting( 'impactshirts_theme_options[twitter_uid]', array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_twitter', array(
		'label'             => __( 'Twitter', 'impactshirts' ),
		'section'           => 'impactshirts_social_media',
		'settings'          => 'impactshirts_theme_options[twitter_uid]'
	) ) );

	// Add Facebook Setting

	$wp_customize->add_setting( 'impactshirts_theme_options[facebook_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_facebook', array(
		'label'             => __( 'Facebook', 'impactshirts' ),
		'section'           => 'impactshirts_social_media',
		'settings'          => 'impactshirts_theme_options[facebook_uid]'
	) ) );

	// Add LinkedIn Setting

	$wp_customize->add_setting( 'impactshirts_theme_options[linkedin_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_linkedin', array(
		'label'             => __( 'LinkedIn', 'impactshirts' ),
		'section'           => 'impactshirts_social_media',
		'settings'          => 'impactshirts_theme_options[linkedin_uid]'
	) ) );

	// Add Youtube Setting

	$wp_customize->add_setting( 'impactshirts_theme_options[youtube_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_youtube', array(
		'label'             => __( 'Tumblr', 'impactshirts' ),
		'section'           => 'impactshirts_social_media',
		'settings'          => 'impactshirts_theme_options[youtube_uid]'
	) ) );

	// Add Google+ Setting

	$wp_customize->add_setting( 'impactshirts_theme_options[googleplus_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_googleplus', array(
		'label'             => __( 'Google+', 'impactshirts' ),
		'section'           => 'impactshirts_social_media',
		'settings'          => 'impactshirts_theme_options[googleplus_uid]'
	) ) );

	// Add RSS Setting

	$wp_customize->add_setting( 'impactshirts_theme_options[rss_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_rss', array(
		'label'             => __( 'RSS Feed', 'impactshirts' ),
		'section'           => 'impactshirts_social_media',
		'settings'          => 'impactshirts_theme_options[rss_uid]'
	) ) );

	// Add Instagram Setting

	$wp_customize->add_setting( 'impactshirts_theme_options[instagram_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_instagram', array(
		'label'             => __( 'Instagram', 'impactshirts' ),
		'section'           => 'impactshirts_social_media',
		'settings'          => 'impactshirts_theme_options[instagram_uid]'
	) ) );

	// Add Pinterest Setting

	$wp_customize->add_setting( 'impactshirts_theme_options[pinterest_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_pinterest', array(
		'label'             => __( 'Pinterest', 'impactshirts' ),
		'section'           => 'impactshirts_social_media',
		'settings'          => 'impactshirts_theme_options[pinterest_uid]'
	) ) );

	// Add StumbleUpon Setting

	$wp_customize->add_setting( 'impactshirts_theme_options[stumbleupon_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_stumble', array(
		'label'             => __( 'StumbleUpon', 'impactshirts' ),
		'section'           => 'impactshirts_social_media',
		'settings'          => 'impactshirts_theme_options[stumbleupon_uid]'
	) ) );	

	// Add Vimeo Setting

	$wp_customize->add_setting( 'impactshirts_theme_options[vimeo_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_vimeo', array(
		'label'             => __( 'Vimeo', 'impactshirts' ),
		'section'           => 'impactshirts_social_media',
		'settings'          => 'impactshirts_theme_options[vimeo_uid]'
	) ) );

	// Add SoundCloud Setting

	$wp_customize->add_setting( 'impactshirts_theme_options[yelp_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_yelp', array(
		'label'             => __( 'Yelp', 'impactshirts' ),
		'section'           => 'impactshirts_social_media',
		'settings'          => 'impactshirts_theme_options[yelp_uid]'
	) ) );

	// Add Foursquare Setting

	$wp_customize->add_setting( 'impactshirts_theme_options[foursquare_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_foursquare', array(
		'label'             => __( 'Foursquare', 'impactshirts' ),
		'section'           => 'impactshirts_social_media',
		'settings'          => 'impactshirts_theme_options[foursquare_uid]'
	) ) );

/*--------------------------------------------------------------
	// CSS Styles
--------------------------------------------------------------*/

	$wp_customize->add_section( 'css_styles', array(
		'title'                 => __( 'CSS Styles', 'impactshirts' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'impactshirts_theme_options[impactshirts_inline_css]' ,array( 'sanitize_callback' => 'wp_filter_nohtml_kses', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_impactshirts_inline_css', array(
		'label'                 => __( 'Custom CSS Styles', 'impactshirts' ),
		'section'               => 'css_styles',
		'settings'              => 'impactshirts_theme_options[impactshirts_inline_css]',
		'type'                  => 'textarea'
	) );
	
/*--------------------------------------------------------------
	// Scripts
--------------------------------------------------------------*/

	$wp_customize->add_section( 'scripts', array(
		'title'                 => __( 'Scripts', 'impactshirts' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'impactshirts_theme_options[impactshirts_inline_js_head]',array( 'sanitize_callback' => 'wp_filter_nohtml_kses', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_impactshirts_inline_js_head', array(
		'label'                 => __( 'Embeds to header.php', 'impactshirts' ),
		'section'               => 'scripts',
		'settings'              => 'impactshirts_theme_options[impactshirts_inline_js_head]',
		'type'                  => 'textarea'
	) );

	$wp_customize->add_setting( 'impactshirts_theme_options[impactshirts_inline_js_footer]',array( 'sanitize_callback' => 'wp_filter_nohtml_kses', 'type' => 'option' ));
	$wp_customize->add_control( 'res_impactshirts_inline_js_footer', array(
		'label'                 => __( 'Embeds to footer.php', 'impactshirts' ),
		'section'               => 'scripts',
		'settings'              => 'impactshirts_theme_options[impactshirts_inline_js_footer]',
		'type'                  => 'textarea'
	) );


}
add_action( 'customize_register', 'impactshirts_customize_register' );

function impactshirts_sanitize_checkbox( $input ) {
		if ( $input ) {				
		$output = '1';	
	} else {				
		$output = false;	
	}	
	return $output;
}

function impactshirts_sanitize_textarea( $input ) {
	global $allowedposttags;	
	$output = wp_kses( $input, $allowedposttags);	
	return $output;
}

function impactshirts_sanitize_default_layouts( $input ) {
	$output = '';	
	$option = Impactshirts_Options::valid_layouts();
	if ( array_key_exists( $input, $option ) ) {	
		$output = $input;	
	}	
	return $output;
}


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function impactshirts_customize_preview_js() {
	wp_enqueue_script( 'impactshirts_customizer', get_template_directory_uri() . '/core/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'impactshirts_customize_preview_js' );
