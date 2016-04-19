<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Widget Template
 *
 *
 * @file           sidebar.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/impactshirts/sidebar.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 * @since          available since Release 1.0
 */

/*
 * Load the correct sidebar according to the page layout
 */
$layout = impactshirts_get_layout();
switch ( $layout ) {
	case 'sidebar-content-page':
		get_sidebar( 'left' );
		return;
		break;

	case 'content-sidebar-half-page':
		get_sidebar( 'right-half' );
		return;
		break;

	case 'sidebar-content-half-page':
		get_sidebar( 'left-half' );
		return;
		break;

	case 'full-width-page':
		return;
		break;
}
?>
<?php $data = get_option('impact-options'); ?>
	<div class="grid col-300 fit">
			<div class="widget-wrapper">

			<?php if(isset($data['designIdeas1']['src'])): ?>
				<div id="text-6" class="widget-wrapper widget_text">			
					<div class="textwidget designIdeaContainer <?php echo $data['designIdeasAlignment1']; ?>">
						<a href="<?php echo $data['designIdeaUrl1']; ?>">
							<img src="<?php echo $data['designIdeas1']['src']; ?>" alt="" title="">
							<div class="designIdeaTextContainer">
								<div class="designIdeaButton"><?php echo $data['designIdeaBottomText1']; ?></div>
								<!--<div class="designIdeaTopText"><?php // echo $data['designIdeaTopText1']; ?></div>-->
								<div class="designIdeaTopText"><?php echo (isset($data['designIdeaTopText1']) ? $data['designIdeaTopText1'] : ""); ?></div>
							</div>
						</a>
					</div>
				</div>
          	<?php endif; ?>
            <?php if(isset($data['designIdeas2']['src'])): ?>
				<div id="text-6" class="widget-wrapper widget_text">			
					<div class="textwidget designIdeaContainer  <?php echo $data['designIdeasAlignment2']; ?>">
						<a href="<?php echo $data['designIdeaUrl2']; ?>">
							<img src="<?php echo $data['designIdeas2']['src']; ?>" alt="" title="">
							<div class="designIdeaTextContainer">
								<div class="designIdeaButton"><?php echo $data['designIdeaBottomText2']; ?></div>
								<div class="designIdeaTopText"><?php // echo stripslashes($data['designIdeaTopText2']); ?></div>
								<div class="designIdeaTopText"><?php echo (isset($data['designIdeaTopText2']) ? stripslashes($data['designIdeaTopText2']) : ""); ?></div>
							</div>
						</a>
					</div>
				</div>
          	<?php endif; ?>
			<!-- end of .col-300 -->
            <?php if(isset($data['designIdeas3']['src'])): ?>
				<div id="text-6" class="widget-wrapper widget_text">			
					<div class="textwidget designIdeaContainer <?php echo $data['designIdeasAlignment3']; ?>">					
						<a href="<?php echo $data['designIdeaUrl3']; ?>">
							<img src="<?php echo $data['designIdeas3']['src']; ?>" alt="" title="">
							<div class="designIdeaTextContainer">
								<div class="designIdeaButton"><?php echo $data['designIdeaBottomText3']; ?></div>
								<!--<div class="designIdeaTopText"><?php // echo stripslashes($data['designIdeaTopText3']); ?></div>-->
								<div class="designIdeaTopText"><?php echo (isset($data['designIdeaTopText3']) ? stripslashes($data['designIdeaTopText3']) : ""); ?></div>
							</div>
						</a>
					</div>
				</div>
            <?php endif; ?>
			<!-- end of .col-300 -->

			</div><!-- end of .widget-wrapper -->
		</div>