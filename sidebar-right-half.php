<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sidebar Right Half Template
 *
 *
 * @file           sidebar-right-half.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2015 - 2016 WiserSites
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/impactshirts/sidebar-right-half.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 * @since          available since Release 1.0
 */
?>
<?php impactshirts_widgets_before(); // above widgets container hook ?>
	<div id="widgets" class="grid col-460 fit">
		<?php impactshirts_widgets(); // above widgets hook ?>

		<?php if ( !dynamic_sidebar( 'right-sidebar-half' ) ) : ?>
			<div class="widget-wrapper">

				<div class="widget-title"><h3><?php _e( 'In Archive', 'impactshirts' ); ?></h3></div>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>

			</div><!-- end of .widget-wrapper -->
		<?php endif; //end of sidebar-right-half ?>

		<?php impactshirts_widgets_end(); // after widgets hook ?>
	</div><!-- end of #widgets -->
<?php impactshirts_widgets_after(); // after widgets container hook ?>