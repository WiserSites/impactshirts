<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Widget Template
 *
 *
 * @file           sidebar-left.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2015 - 2016 WiserSites
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/impactshirts/sidebar-left.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 * @since          available since Release 1.0
 */
?>
<?php impactshirts_widgets_before(); // above widgets container hook ?>
	<div id="widgets" class="grid-right col-300 rtl-fit">
		<?php impactshirts_widgets(); // above widgets hook ?>

		<?php if ( !dynamic_sidebar( 'left-sidebar' ) ) : ?>
			<div class="widget-wrapper">

				<div class="widget-title"><h3><?php _e( 'In Archive', 'impactshirts' ); ?></h3></div>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>

			</div><!-- end of .widget-wrapper -->
		<?php endif; //end of right-left ?>

		<?php impactshirts_widgets_end(); // after widgets hook ?>
	</div><!-- end of #widgets -->
<?php impactshirts_widgets_after(); // after widgets container hook ?>