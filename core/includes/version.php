<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Version Control
 *
 *
 * @file           version.php
 * @package        WordPress
 * @subpackage     Impactshirts
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.2
 * @filesource     wp-content/themes/impactshirts/includes/version.php
 * @link           N/A
 * @since          available since Release 1.0
 */
?>
<?php
function impactshirts_template_data() {
	echo '<!-- We need this for debugging -->' . "\n";
	echo '<!-- ' . get_impactshirts_template_name() . ' ' . get_impactshirts_template_version() . ' -->' . "\n";
}

add_action( 'wp_head', 'impactshirts_template_data' );

function impactshirts_theme_data() {
	if ( is_child_theme() ) {
		echo '<!-- ' . get_impactshirts_theme_name() . ' ' . get_impactshirts_theme_version() . ' -->' . "\n";
	}
}

add_action( 'wp_head', 'impactshirts_theme_data' );

function get_impactshirts_theme_name() {
	$theme = wp_get_theme();

	return $theme->Name;
}

function get_impactshirts_theme_version() {
	$theme = wp_get_theme();

	return $theme->Version;
}

function get_impactshirts_template_name() {
	$theme  = wp_get_theme();
	$parent = $theme->parent();
	if ( $parent ) {
		$theme = $parent;
	}

	return $theme->Name;
}

function get_impactshirts_template_version() {
	$theme  = wp_get_theme();
	$parent = $theme->parent();
	if ( $parent ) {
		$theme = $parent;
	}

	return $theme->Version;
}