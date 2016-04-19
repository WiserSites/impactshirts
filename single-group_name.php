<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Single Group Name
 */
//echo get_the_permalink( 8697 ); exit;
wp_redirect( get_permalink( 8697 )  ); //site_url('group_name')
exit;
?>