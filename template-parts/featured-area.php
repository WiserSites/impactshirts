<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$impactshirts_options = impactshirts_get_options();
//test for first install no database
$db = get_option( 'impactshirts_theme_options' );
//test if all options are empty so we can display default text if they are
$empty     = ( empty( $impactshirts_options['home_headline'] ) && empty( $impactshirts_options['home_subheadline'] ) && empty( $impactshirts_options['home_content_area'] ) ) ? false : true;
$emtpy_cta = ( empty( $impactshirts_options['cta_text'] ) ) ? false : true;

?>

<div id="featured" class="grid col-940">

	<div id="featured-content" class="grid col-460">

		<h1 class="featured-title">
			<?php
			if ( isset( $impactshirts_options['home_headline'] ) && $db && $empty )
				echo $impactshirts_options['home_headline'];
			else {
				_e( 'Hello, World!', 'impactshirts' );
			}
			?>
		</h1>

		<h2 class="featured-subtitle">
			<?php
			if ( isset( $impactshirts_options['home_subheadline'] ) && $db && $empty )
				echo $impactshirts_options['home_subheadline'];
			else
				_e( 'Your H2 subheadline here', 'impactshirts' );
			?>
		</h2>

		<?php
		if ( isset( $impactshirts_options['home_content_area'] ) && $db && $empty ) {
			echo do_shortcode( wpautop( $impactshirts_options['home_content_area'] ) );
		} else {
			echo '<p>' . __( 'Your title, subtitle and this very content is editable from Theme Option. Call to Action button and its destination link as well. Image on your right can be an image or even YouTube video if you like.', 'impactshirts' ) . '</p>';
		} ?>


		<?php if ( $impactshirts_options['cta_button'] == 0 ): ?>

			<div class="call-to-action">

				<a href="<?php echo $impactshirts_options['cta_url']; ?>" class="blue button">
					<?php
					if ( isset( $impactshirts_options['cta_text'] ) && $db && $emtpy_cta )
						echo $impactshirts_options['cta_text'];
					else
						_e( 'Call to Action', 'impactshirts' );
					?>
				</a>

			</div><!-- end of .call-to-action -->

		<?php endif; ?>

	</div><!-- end of .col-460 -->

	<div id="featured-image" class="grid col-460 fit">

		<?php $featured_content = ( !empty( $impactshirts_options['featured_content'] ) ) ? $impactshirts_options['featured_content'] : '<img class="aligncenter" src="' . get_template_directory_uri() . '/core/images/featured-image.png" width="440" height="300" alt="" />'; ?>

		<?php echo do_shortcode( wpautop( $featured_content ) ); ?>

	</div><!-- end of #featured-image -->

</div><!-- end of #featured -->