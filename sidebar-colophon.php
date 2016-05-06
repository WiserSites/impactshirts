<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Colophon Widget Template
 *
 *
 * @file           sidebar-colophon.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2015 - 2016 WiserSites
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/impactshirts/sidebar-colophon.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 * @since          available since Release 1.1
 */
?>
<?php
if ( !is_active_sidebar( 'colophon-widget' )
) {
	return;
}
?>
<?php impactshirts_widgets_before(); // above widgets container hook ?>
	<div id="colophon-widget" class="grid col-940">
		<?php impactshirts_widgets(); // above widgets hook ?>

		<?php if ( is_active_sidebar( 'colophon-widget' ) ) : ?>

			<?php dynamic_sidebar( 'colophon-widget' ); ?>

		<?php endif; //end of colophon-widget ?>

		<?php impactshirts_widgets_end(); // after widgets hook ?>
	</div><!-- end of #colophon-widget -->
<?php impactshirts_widgets_after(); // after widgets container hook ?>