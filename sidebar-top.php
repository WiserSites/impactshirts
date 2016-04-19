<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}
$data = get_option('impact-options');

impactshirts_widgets_before(); // above widgets container hook ?>
	<div id="top-widget" class="top-widget">
		<div class="caps">
			<div class="phoneDescription">talk to a real person</div>
			<span class="head-phone">
				<?php echo '<a href="tel:'.$data['phoneNumber'].'">'.$data['phoneNumber'].'</a>'; ?>
			</span>
			<div class="phoneDescription">
			here to help from 9am-5pm pst<br/>
			monday-friday</div>
		</div>
	</div><!-- end of #top-widget -->
<?php impactshirts_widgets_after(); // after widgets container hook ?>