<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gallery Widget Template
 *
 *
 * @file           sidebar-gallery.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2015 - 2016 WiserSites
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/impactshirts/sidebar-gallery.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 * @since          available since Release 1.0
 */
?>
<?php impactshirts_widgets_before(); // above widgets container hook ?>
	<div id="widgets" class="grid col-300 fit gallery-meta">
		<?php impactshirts_widgets(); // above widgets hook ?>
		<div class="widget-wrapper">

			<div class="widget-title"><h3><?php _e( 'Image Information', 'impactshirts' ); ?></h3></div>
			<ul>
				<?php
				$impactshirts_data = get_post_meta( $post->ID, '_wp_attachment_metadata', true );

				if ( is_array( $impactshirts_data ) ) {
					?>
					<span class="full-size"><?php _e( 'Full Size:', 'impactshirts' ); ?> <a href="<?php echo wp_get_attachment_url( $post->ID ); ?>"><?php echo esc_attr( $impactshirts_data['width'] ) . '&#215;' . esc_attr( $impactshirts_data['height'] ); ?></a>px</span>

					<?php
					if ( is_array( $impactshirts_data['image_meta'] ) ) {
						?>
						<?php if ( $impactshirts_data['image_meta']['aperture'] ) { ?>
							<span class="aperture"><?php _e( 'Aperture: f&#47;', 'impactshirts' ); ?><?php echo esc_attr( $impactshirts_data['image_meta']['aperture'] ); ?></span>
						<?php } ?>

						<?php if ( $impactshirts_data['image_meta']['focal_length'] ) { ?>
							<span
								class="focal-length"><?php _e( 'Focal Length:', 'impactshirts' ); ?> <?php echo esc_attr( $impactshirts_data['image_meta']['focal_length'] ); ?><?php _e( 'mm', 'impactshirts' ); ?></span>
						<?php } ?>

						<?php if ( $impactshirts_data['image_meta']['iso'] ) { ?>
							<span class="iso"><?php _e( 'ISO:', 'impactshirts' ); ?> <?php echo esc_attr( $impactshirts_data['image_meta']['iso'] ); ?></span>
						<?php } ?>

						<?php if ( $impactshirts_data['image_meta']['shutter_speed'] ) { ?>
							<span class="shutter"><?php _e( 'Shutter:', 'impactshirts' ); ?>
								<?php
								if ( ( 1 / $impactshirts_data['image_meta']['shutter_speed'] ) > 1 ) {
									echo "1/";
									if ( number_format( ( 1 / esc_attr( $impactshirts_data['image_meta']['shutter_speed'] ) ), 1 ) == number_format( ( 1 / esc_attr( $impactshirts_data['image_meta']['shutter_speed'] ) ), 0 ) ) {
										echo number_format( ( 1 / esc_attr( $impactshirts_data['image_meta']['shutter_speed'] ) ), 0, '.', '' ) . ' ' . __( 'sec', 'impactshirts' );
									}
									else {
										echo number_format( ( 1 / esc_attr( $impactshirts_data['image_meta']['shutter_speed'] ) ), 1, '.', '' ) . ' ' . __( 'sec', 'impactshirts' );
									}
								}
								else {
									echo esc_attr( $impactshirts_data['image_meta']['shutter_speed'] ) . ' ' . __( 'sec', 'impactshirts' );
								}
								?>
								</span>
						<?php } ?>

						<?php if ( $impactshirts_data['image_meta']['camera'] ) { ?>
							<span class="camera"><?php _e( 'Camera:', 'impactshirts' ); ?> <?php echo esc_attr( $impactshirts_data['image_meta']['camera'] ); ?></span>
						<?php
						}
					}
				}
				?>
			</ul>

		</div><!-- end of .widget-wrapper -->
	</div><!-- end of #widgets -->

<?php if ( !is_active_sidebar( 'gallery-widget' ) ) {
	return;
} ?>

<?php if ( is_active_sidebar( 'gallery-widget' ) ) : ?>

	<div id="widgets" class="grid col-300 fit">

		<?php impactshirts_widgets(); // above widgets hook ?>

		<?php dynamic_sidebar( 'gallery-widget' ); ?>

		<?php impactshirts_widgets_end(); // after widgets hook ?>
	</div><!-- end of #widgets -->
	<?php impactshirts_widgets_after(); // after widgets container hook ?>

<?php endif; ?>