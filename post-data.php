<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post Data Template-Part File
 *
 * @file           post-data.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2015 - 2016 WiserSites
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/impactshirts/post-data.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
?>

<?php if ( !is_page() && !is_search() ) { ?>

	<div class="post-data">
		<?php printf( __( 'Posted in %s', 'impactshirts' ), get_the_category_list( ', ' ) ); ?>
		<?php the_tags( __( 'Tagged with:', 'impactshirts' ) . ' ', ', ', '<br />' ); ?>
	</div><!-- end of .post-data -->

<?php } ?>

<div class="post-edit"><?php edit_post_link( __( 'Edit', 'impactshirts' ) ); ?></div>