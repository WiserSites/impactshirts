<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Home Widgets Template
 *
 *
 * @file           sidebar-home.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2015 - 2016 WiserSites
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/impactshirts/sidebar-home.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 * @since          available since Release 1.0
 */
?>
<?php impactshirts_widgets_before(); // above widgets container hook ?>
	<div id="widgets" class="home-widgets">
		<div id="home_widget_1" class="grid col-300">
			<?php impactshirts_widgets(); // above widgets hook ?>

			<?php if ( !dynamic_sidebar( 'home-widget-1' ) ) : ?>
				<div class="widget-wrapper">

					<div class="widget-title-home"><h3><?php _e( 'Home Widget 1', 'impactshirts' ); ?></h3></div>
					<div
						class="textwidget"><?php _e( 'This is your first home widget box. To edit please go to Appearance > Widgets and choose 6th widget from the top in area 6 called Home Widget 1. Title is also manageable from widgets as well.', 'impactshirts' ); ?></div>

				</div><!-- end of .widget-wrapper -->
			<?php endif; //end of home-widget-1 ?>

			<?php impactshirts_widgets_end(); // impactshirts after widgets hook ?>
		</div><!-- end of .col-300 -->

		<div id="home_widget_2" class="grid col-300">
			<?php impactshirts_widgets(); // impactshirts above widgets hook ?>

			<?php if ( !dynamic_sidebar( 'home-widget-2' ) ) : ?>
				<div class="widget-wrapper">

					<div class="widget-title-home"><h3><?php _e( 'Home Widget 2', 'impactshirts' ); ?></h3></div>
					<div
						class="textwidget"><?php _e( 'This is your second home widget box. To edit please go to Appearance > Widgets and choose 7th widget from the top in area 7 called Home Widget 2. Title is also manageable from widgets as well.', 'impactshirts' ); ?></div>

				</div><!-- end of .widget-wrapper -->
			<?php endif; //end of home-widget-2 ?>

			<?php impactshirts_widgets_end(); // after widgets hook ?>
		</div><!-- end of .col-300 -->

		<div id="home_widget_3" class="grid col-300 fit">
			<?php impactshirts_widgets(); // above widgets hook ?>

			<?php if ( !dynamic_sidebar( 'home-widget-3' ) ) : ?>
				<div class="widget-wrapper">

					<div class="widget-title-home"><h3><?php _e( 'Home Widget 3', 'impactshirts' ); ?></h3></div>
					<div
						class="textwidget"><?php _e( 'This is your third home widget box. To edit please go to Appearance > Widgets and choose 8th widget from the top in area 8 called Home Widget 3. Title is also manageable from widgets as well.', 'impactshirts' ); ?></div>

				</div><!-- end of .widget-wrapper -->
			<?php endif; //end of home-widget-3 ?>

			<?php impactshirts_widgets_end(); // after widgets hook ?>
		</div><!-- end of .col-300 fit -->
	</div><!-- end of #widgets -->
<?php impactshirts_widgets_after(); // after widgets container hook ?>