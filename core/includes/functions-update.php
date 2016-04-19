<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Update social icon options
 *
 * @since    1.9.4.9
 */
function impactshirts_update_social_icon_options() {
	$impactshirts_options = impactshirts_get_options();
	// If new option does not exist then copy the option
	if ( !isset( $impactshirts_options['googleplus_uid'] ) ) {
		$impactshirts_options['googleplus_uid'] = $impactshirts_options['google_plus_uid'];
	}
	if ( !isset( $impactshirts_options['stumbleupon_uid'] ) ) {
		$impactshirts_options['stumbleupon_uid'] = $impactshirts_options['stumble_uid'];
	}

	// Update entire array
	update_option( 'impactshirts_theme_options', $impactshirts_options );
}

add_action( 'after_setup_theme', 'impactshirts_update_social_icon_options' );

/*
 * Update page templete meta data
 *
 * E.g: Change from `page-templates/full-width-page.php` to `full-width-page.php`
 *
 * This function only needes to be run once but it does not mater when. after_setup_theme should be fine.
 *
 */
function impactshirts_update_page_template_meta(){
	$args = array(
		'post_type' => 'page',
		'meta_query' => array(
			array(
				'key' => '_wp_page_template',
				'value' => 'default',
				'compare' => '!='
			)
		)
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {

		while ( $query->have_posts() ) {
			$query->the_post();

			$meta_value = get_post_meta( get_the_ID(), '_wp_page_template', true );
			$page_templates_dir = 'page-templates/';
			$conatins = strpos( $meta_value, $page_templates_dir );

			if ( false !== $conatins ) {
				$meta_value = basename( $meta_value );
				update_post_meta( get_the_ID(), '_wp_page_template', $meta_value );
			}

		}
	}
}
add_action( 'after_switch_theme', 'impactshirts_update_page_template_meta' );

/**
 * Impactshirts 2.0 update check
 *
 * Queries WordPress.org API to get details on impactshirts theme where we can get the current version number
 *
 * @return bool
 */
function impactshirts_theme_query() {

	$themes = get_theme_updates();

	$new_version = false;

	foreach ( $themes as $stylesheet => $theme ) {
		if ( 'impactshirts' == $stylesheet ) {
			$new_version = $theme->update['new_version'];
		}
	}

	// Check if we had a response and compare the current version on wp.org to version 2. If it is version 2 or greater display a message
	if ( $new_version && version_compare( $new_version, '2', '>=' ) ) {
		return true;
	}

	return false;

}

/**
 * Impactshirts 2.0 update warning message
 *
 * Displays warning message in the update notice
 */
function impactshirts_admin_update_notice(){
	global $pagenow;
	// Add plugin notification only if the current user is admin and on theme.php
	if ( impactshirts_theme_query() && current_user_can( 'update_themes' ) && ( 'themes.php' == $pagenow || 'update-core.php' == $pagenow ) ) {
		$html = '<div class="error"><p>';
		$html .= sprintf(
				/* Translators: This is a big update. Please read the blog post before updating. */
				__( '<strong>WARNING:</strong> There is a big <strong>Impactshirts Theme</strong> update available. Please read the %1$s before updating.', 'impactshirts' ),
				'<a href="' . esc_url( 'http://content.cyberchimps.com/impactshirts-2-migration' ) . '">' . __( 'update page', 'impactshirts' ) . '</a>'
			);
		$html .= '</p></div>';
		echo $html;
	}
}
add_action( 'admin_notices', 'impactshirts_admin_update_notice' );
