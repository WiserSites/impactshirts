<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Footer Template
 *
 *
 * @file           footer.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2015 - 2016 WiserSites
 * @license        license.txt
 * @version        Release: 1.2
 * @filesource     wp-content/themes/impactshirts/footer.php
 * @link           http://codex.wordpress.org/Theme_Development#Footer_.28footer.php.29
 * @since          available since Release 1.0
 */

/*
 * Globalize Theme options
 */
global $impactshirts_options;
$impactshirts_options = impactshirts_get_options();
?>
<?php impactshirts_wrapper_bottom(); // after wrapper content hook ?>
</div><!-- end of #wrapper -->
<?php impactshirts_wrapper_end(); // after wrapper hook ?>
</div><!-- end of #container -->
<?php impactshirts_container_end(); // after container hook ?>

<!--<div id="footer-masthead-wrapper">
	<div id="footer-masthead">
		<div class="col-460 grid social-foot">
			<div class="widget-wrapper">
				<ul>-->
<?php 
	
//	$data = get_option('impact-options');
//	
//	// Google Plus
//	if(isset($data['GooglePlus'])):
//		echo '<li><a href="'.$data['GooglePlus'].'" title="Google Plus" target="_blank"><span class="google16"></span></a></li>';
//	endif;
//	
//	// Facebook
//	if(isset($data['Facebook'])):
//		echo '<li><a href="'.$data['Facebook'].'" title="Facebook" target="_blank"><span class="fb16"></span></a></li>';
//	endif;
//	
//	// Twitter
//	if(isset($data['Twitter'])):
//		echo '<li><a href="'.$data['Twitter'].'" title="Google Plus" target="_blank"><span class="twitter16"></span></a></li>';
//	endif;
//	
//	// Pinterest
//	if(isset($data['Pinterest'])):
//		echo '<li><a href="'.$data['Pinterest'].'" title="Google Plus" target="_blank"><span class="pin16"></span></a></li>';
//	endif;


    ?>
					<!-- <li><a href="" title="Pinterest" target="_blank"><span class="pin16"></span></a></li>
					<li><a href="" title="FaceBook" target="_blank"><span class="fb16"></span></a></li> -->
<!--				</ul>
			</div>
		</div>-->
        <?php // $header_nav_search = get_field('header_nav_search', 'option'); ?>
        <?php // if( $header_nav_search == true ) : ?>
		<!--<div class="col-460 grid fit search-foot"><div class="widget-wrapper"><?php // get_search_form(); ?></div></div>-->
		<?php // endif; ?>
<!--    </div>
</div>-->
<div id="footer" class="clearfix">
	<?php impactshirts_footer_top(); ?>
	<div id="footer-wrapper">

		<div class="grid col-940">
			<div class="grid col-460">
			<?php if( has_nav_menu( 'footer-menu', 'impactshirts' ) ) { ?>
				<div class="widget-title"><h3>Important Links</h3></div>
					<?php wp_nav_menu( array(
							'container'      => '',
							'fallback_cb'    => false,
							'menu_class'     => '',
							'theme_location' => 'footer-menu'
						)
					);
					?>
				<?php } ?>
			</div>
			<div class="grid col-460 fit">
				<!-- Begin MailChimp Signup Form -->
<div id="mc_embed_signup">
<form action="//ministrygear.us4.list-manage.com/subscribe/post?u=2b0d2c891bf52ff2f7ef11a1b&amp;id=b341f88719" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
	<div class="widget-title"><h3>Subscribe To Our Mailing List</h3></div>
<div class="mc-field-group">
	<!--<label for="mce-EMAIL">Email Address </label>-->
	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email Address">
</div>
<div class="mc-field-group">
	<!--<label for="mce-FNAME">First Name </label>-->
	<input type="text" value="" name="FNAME" class="" id="mce-FNAME" placeholder="First Name">
</div>
<div class="mc-field-group">
	<!--<label for="mce-LNAME">Last Name </label>-->
	<input type="text" value="" name="LNAME" class="" id="mce-LNAME" placeholder="Last Name">
</div>
	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;"><input type="text" name="b_2b0d2c891bf52ff2f7ef11a1b_b341f88719" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
</form>
</div>

<!--End mc_embed_signup-->
			</div>
		</div>

		<div class="grid col-940">

			<div class="grid col-540">

			</div>
			<!-- end of col-540 -->

			<div class="grid col-380 fit">
				<?php echo impactshirts_get_social_icons() ?>
			</div>
			<!-- end of col-380 fit -->

		</div>
		<!-- end of col-940 -->
		<?php get_sidebar( 'colophon' ); ?>

		<div class="grid col-300 copyright">
			<?php esc_attr_e( '&copy;', 'impactshirts' ); ?> <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>
		</div>
		<!-- end of .copyright -->

		<!--<div class="grid col-300 scroll-top"><a href="#scroll-top" title="<?php // esc_attr_e( 'scroll to top', 'impactshirts' ); ?>"><?php // _e( '&uarr;', 'impactshirts' ); ?></a></div>-->

		<div class="grid col-300 fit powered">
				An Impact Shirts Production
		</div>
		<!-- end .powered -->

	</div>
	<!-- end #footer-wrapper -->

	<?php impactshirts_footer_bottom(); ?>
</div><!-- end #footer -->
<?php impactshirts_footer_after(); ?>

<?php wp_footer(); ?>
<?php

	$trackingCode = get_field('trackingCode');
	if($trackingCode):
		echo $trackingCode;
	endif;
	the_field('business_schema','options');
?>
</body>
</html>