<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme's Action Hooks
 *
 *
 * @file           hooks.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/impactshirts/includes/hooks.php
 * @link           http://codex.wordpress.org/Plugin_API/Hooks
 * @since          available since Release 1.1
 */

/**
 * Just after opening <body> tag
 *
 * @see header.php
 */
function impactshirts_container() {
	do_action( 'impactshirts_container' );
}

/**
 * Just after closing </div><!-- end of #container -->
 *
 * @see footer.php
 */
function impactshirts_container_end() {
	do_action( 'impactshirts_container_end' );
	tha_footer_before();
}

/**
 * Just after opening <div id="container">
 *
 * @see header.php
 */
function impactshirts_header() {
	do_action( 'impactshirts_header' );
	tha_header_before();
}

/**
 * Just after opening <div id="header">
 *
 * @see header.php
 */
function impactshirts_header_top() {
	do_action( 'impactshirts_header_top' );
	tha_header_top();
}

/**
 * Just after opening <div id="header">
 *
 * @see header.php
 */
function impactshirts_in_header() {
	do_action( 'impactshirts_in_header' );
}

/**
 * Just after closing </div><!-- end of #header -->
 *
 * @see header.php
 */
function impactshirts_header_bottom() {
	do_action( 'impactshirts_header_bottom' );
	tha_header_bottom();
}

/**
 * Just after closing </div><!-- end of #header -->
 *
 * @see header.php
 */
function impactshirts_header_end() {
	do_action( 'impactshirts_header_end' );
	tha_header_after();
}

/**
 * Just before opening <div id="wrapper">
 *
 * @see header.php
 */
function impactshirts_wrapper() {
	do_action( 'impactshirts_wrapper' );
	tha_content_before();
}

/**
 * Just after opening <div id="wrapper">
 *
 * @see header.php
 */
function impactshirts_wrapper_top() {
	do_action( 'impactshirts_wrapper_top' );
	tha_content_top();
}

/**
 * Just after opening <div id="wrapper">
 *
 * @see header.php
 */
function impactshirts_in_wrapper() {
	do_action( 'impactshirts_in_wrapper' );
}

/**
 * Just before closing </div><!-- end of #wrapper -->
 *
 * @see header.php
 */
function impactshirts_wrapper_bottom() {
	do_action( 'impactshirts_wrapper_bottom' );
	tha_content_bottom();
}

/**
 * Just after closing </div><!-- end of #wrapper -->
 *
 * @see header.php
 */
function impactshirts_wrapper_end() {
	do_action( 'impactshirts_wrapper_end' );
	tha_content_after();
}

/** Just before <div id="post">
 *
 * @see index.php
 */
function impactshirts_entry_before() {
	do_action( 'impactshirts_entry_before' );
	tha_entry_before();
}

/** Just after <div id="post">
 *
 * @see index.php
 */
function impactshirts_entry_top() {
	do_action( 'impactshirts_entry_top' );
	tha_entry_top();
}

/** Just before </div> <!-- end of div#post -->
 *
 * @see index.php
 */
function impactshirts_entry_bottom() {
	do_action( 'impactshirts_entry_bottom' );
	tha_entry_bottom();
}

/** Just after </div> <!-- end of div#post -->
 *
 * @see index.php
 */
function impactshirts_entry_after() {
	do_action( 'impactshirts_entry_after' );
	tha_entry_after();
}

/** Just before comments_template()
 *
 * @see index.php
 */
function impactshirts_comments_before() {
	do_action( 'impactshirts_comments_before' );
	tha_comments_before();
}

/** Just after comments_template()
 *
 * @see index.php
 */
function impactshirts_comments_after() {
	do_action( 'impactshirts_comments_after' );
	tha_comments_after();
}

/**
 * Just before opening <div id="widgets">
 *
 * @see sidebar.php
 */
function impactshirts_widgets_before() {
	do_action( 'impactshirts_widgets_before' );
	tha_sidebars_before();
}

/**
 * Just after opening <div id="widgets">
 *
 * @see sidebar.php
 */
function impactshirts_widgets() {
	do_action( 'impactshirts_widgets' );
	tha_sidebar_top();
}

/**
 * Just before closing </div><!-- end of #widgets -->
 *
 * @see sidebar.php
 */
function impactshirts_widgets_end() {
	do_action( 'impactshirts_widgets_end' );
	tha_sidebar_bottom();
}

/**
 * Just after closing </div><!-- end of #widgets -->
 *
 * @see sidebar.php
 */
function impactshirts_widgets_after() {
	do_action( 'impactshirts_widgets_after' );
	tha_sidebars_after();
}

/**
 * Just after opening <div id="footer">
 *
 * @see footer.php
 */
function impactshirts_footer_top() {
	do_action( 'impactshirts_footer_top' );
	tha_footer_top();
}

/**
 * Just before closing </div><!-- end of #footer -->
 *
 * @see footer.php
 */
function impactshirts_footer_bottom() {
	do_action( 'impactshirts_footer_bottom' );
	tha_footer_bottom();
}

/**
 * Just after closing </div><!-- end of #footer -->
 *
 * @see footer.php
 */
function impactshirts_footer_after() {
	do_action( 'impactshirts_footer_after' );
	tha_footer_after();
}

/**
 * Theme Options
 *
 * @see theme-options.php
 */
function impactshirts_theme_options() {
	do_action( 'impactshirts_theme_options' );
}

/**
 * WooCommerce
 *
 * Unhook/Hook the WooCommerce Wrappers
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'impactshirts_woocommerce_wrapper', 10 );
add_action( 'woocommerce_after_main_content', 'impactshirts_woocommerce_wrapper_end', 10 );

function impactshirts_woocommerce_wrapper() {
	echo '<div id="content-woocommerce" class="grid col-620">';
}

function impactshirts_woocommerce_wrapper_end() {
	echo '</div><!-- end of #content-woocommerce -->';
}