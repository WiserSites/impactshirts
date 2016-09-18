<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
Template Name: SEO Landing Page
*/

/**
 * Globalize Theme Options
 */
$impactshirts_options = impactshirts_get_options();
$data = get_option('impact-options');
/**
 * If front page is set to display the
 * blog posts index, include home.php;
 * otherwise, display static front page
 * content
 */
if( isset( $data['homepage_template'] ) && $data['homepage_template'] == 'modular_template' ){
	get_template_part( 'page-modular-template' );
} elseif ( 'posts' == get_option( 'show_on_front' ) && $impactshirts_options['front_page'] != 1 ) {
	get_template_part( 'home' );
} elseif ( 'page' == get_option( 'show_on_front' ) && $impactshirts_options['front_page'] != 1 ) {
	$template = get_post_meta( get_option( 'page_on_front' ), '_wp_page_template', true );
	$template = ( $template == 'default' ) ? 'index.php' : $template;
	locate_template( $template, true );
} else {

	get_header();

	//test for first install no database
	$db = get_option( 'impactshirts_theme_options' );
	//test if all options are empty so we can display default text if they are
	$empty = ( empty( $impactshirts_options['home_headline'] ) && empty( $impactshirts_options['home_subheadline'] ) && empty( $impactshirts_options['home_content_area'] ) ) ? false : true;
	?>
	<?php $data = get_option('impact-options');
// echo '<pre>';
// print_r($data);
// echo '</pre>';
        ?>
	<div id="featured" class="grid col-940">
    	<?php if(isset($data['designIdeas1']['src'])): ?>
		<div id="widgets" class="home-widgets">
			<div id="home_widget_1" class="grid col-300">
				<div id="text-6" class="widget-wrapper widget_text">			
					<div class="textwidget designIdeaContainer <?php echo $data['designIdeasAlignment1']; ?>">
						<a href="<?php echo $data['designIdeaUrl1']; ?>">
							<img src="<?php echo $data['designIdeas1']['src']; ?>" alt="" title="">
							<div class="designIdeaTextContainer">
								<div class="designIdeaButton"><?php echo $data['designIdeaBottomText1']; ?></div>
								<div class="designIdeaTopText"><?php  echo (isset($data['designIdeaTopText1']) ? $data['designIdeaTopText1'] : ""); ?></div>
							</div>
						</a>
					</div>
				</div>
			</div>
          	<?php endif; ?>
			<!-- end of .col-300 -->
            <?php if(isset($data['designIdeas2']['src'])): ?>
			<div id="home_widget_1" class="grid col-300">
				<div id="text-6" class="widget-wrapper widget_text">			
					<div class="textwidget designIdeaContainer  <?php echo $data['designIdeasAlignment2']; ?>">
						<a href="<?php echo $data['designIdeaUrl2']; ?>">
							<img src="<?php echo $data['designIdeas2']['src']; ?>" alt="" title="">
							<div class="designIdeaTextContainer">
								<div class="designIdeaButton"><?php echo $data['designIdeaBottomText2']; ?></div>
								<!--<div class="designIdeaTopText"><?php // echo stripslashes($data['designIdeaTopText2']); ?></div>-->
								<div class="designIdeaTopText"><?php   echo (isset($data['designIdeaTopText2']) ? stripslashes($data['designIdeaTopText2']) : ""); ?></div>
							</div>
						</a>
					</div>
				</div>
			</div>
          	<?php endif; ?>
			<!-- end of .col-300 -->
            <?php if(isset($data['designIdeas3']['src'])): ?>
			<div id="home_widget_1" class="grid col-300 fit">
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
			</div>
            <?php endif; ?>
			<!-- end of .col-300 -->
            <?php if(isset($data['designIdeas4']['src'])): ?>
			<div id="home_widget_1" class="grid col-300">
				<div id="text-6" class="widget-wrapper widget_text">			
					<div class="textwidget designIdeaContainer <?php echo $data['designIdeasAlignment4']; ?>">					
						<a href="<?php echo $data['designIdeaUrl4']; ?>">
							<img src="<?php echo $data['designIdeas4']['src']; ?>" alt="" title="">
							<div class="designIdeaTextContainer">
								<div class="designIdeaButton"><?php echo $data['designIdeaBottomText4']; ?></div>
								<!--<div class="designIdeaTopText"><?php // echo stripslashes($data['designIdeaTopText4']); ?></div>-->
								<div class="designIdeaTopText"><?php echo (isset($data['designIdeaTopText4']) ? stripslashes($data['designIdeaTopText4']) : ""); ?></div>
							</div>
						</a>
					</div>
				</div>
			</div>
            <?php endif; ?>
			<!-- end of .col-300 -->
            <?php if(isset($data['designIdeas5']['src'])): ?>
			<div id="home_widget_1" class="grid col-300">
				<div id="text-6" class="widget-wrapper widget_text">			
					<div class="textwidget designIdeaContainer <?php echo $data['designIdeasAlignment5']; ?>">					
						<a href="<?php echo $data['designIdeaUrl5']; ?>">
							<img src="<?php echo $data['designIdeas5']['src']; ?>" alt="" title="">
							<div class="designIdeaTextContainer">
								<div class="designIdeaButton"><?php echo $data['designIdeaBottomText5']; ?></div>
								<!--<div class="designIdeaTopText"><?php // echo stripslashes($data['designIdeaTopText5']); ?></div>-->
								<div class="designIdeaTopText"><?php echo (isset($data['designIdeaTopText5']) ? stripslashes($data['designIdeaTopText5']) : ""); ?></div>
							</div>
						</a>
					</div>
				</div>
			</div>
            <?php endif; ?>
			<!-- end of .col-300 -->
            <?php if(isset($data['designIdeas6']['src'])): ?>
			<div id="home_widget_1" class="grid col-300 fit">
				<div id="text-6" class="widget-wrapper widget_text">			
					<div class="textwidget designIdeaContainer <?php echo $data['designIdeasAlignment6']; ?>">					
						<a href="<?php echo $data['designIdeaUrl6']; ?>">
							<img src="<?php echo $data['designIdeas6']['src']; ?>" alt="" title="">
							<div class="designIdeaTextContainer">
								<div class="designIdeaButton"><?php echo $data['designIdeaBottomText6']; ?></div>
								<!--<div class="designIdeaTopText"><?php // echo stripslashes($data['designIdeaTopText6']); ?></div>-->
								<div class="designIdeaTopText"><?php echo (isset($data['designIdeaTopText6']) ? stripslashes($data['designIdeaTopText6']) : ""); ?></div>
							</div>
						</a>
					</div>
				</div>
			</div>
            <?php endif; ?>
			<!-- end of .col-300 -->
		<div class="clearfix"></div>
	</div>
	<div id="featured-content" class="grid col-460">
		<a href="<?php echo $data['viewShirtStylesUrl']; ?>">
			<img class="shirtStyles" src="<?php echo $data['viewShirtStyles']['src']; ?>" alt="" title="" />
		</a>
		<a href="<?php echo $data['viewShirtStylesUrl2']; ?>">
			<img class="shirtStyles" src="<?php echo $data['viewShirtStyles2']['src']; ?>" alt="" title="" />
		</a>
	</div>
		<!-- end of .col-460 -->

		<div id="featured-image" class="grid col-460 fit">

			<?php customerReviews(); ?>

		</div>
		<!-- end of #featured-image -->

	</div><!-- end of #featured -->
    	<?php if($data['homePageTextBlock']): ?>
        <div class="grid col-940">
        	<p class="homePageText"><?php echo $data['homePageTextBlock']; ?></p>
        </div>
        <?php endif; ?>
        <?php
		$q = new WP_Query( 'posts_per_page=3');
		if($q->have_posts()):
				echo '<div class="homePageBlogPosts">';
				
				// Loop through the Blog Posts
				while($q->have_posts()):
					$q->the_post();
					echo '<article class="modularBlogPosts">';
					echo '<a href="'.get_the_permalink().'">';
					the_post_thumbnail( 'medium', array( 'class' => 'alignleft' ) );
					echo '</a>';
					echo '<h2 class="entry-title post-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';
					echo '<p>'.nc_the_excerpt('Read more &raquo;', 125, 1).'</p>';
					echo '</article>';
					echo '<div class="clearfix"></div>';
				endwhile;
				echo '</div>';
			endif;	
		?>
        <div class="grid col-940 liveTextArea">
        	<?php if($data['liveTextImage1'] && $data['liveTextTitle1'] && $data['liveTextText1']): ?>
        	<div class="grid col-460">
            	<div class="grid col-220">
                	<img src="<?php echo $data['liveTextImage1']['src']; ?>" />
                </div>
                <div class="grid col-700 fit">
                	<h3 style="background-image:url(<?php echo $data['starsImage']['src']; ?>);"><?php echo $data['liveTextTitle1']; ?></h3>
                    <p><?php echo $data['liveTextText1']?></p>
                </div>
            </div>
            <?php endif; ?>
        	<?php if($data['liveTextImage2'] && $data['liveTextTitle2'] && $data['liveTextText2']): ?>
        	<div class="grid col-460 fit">
            	<div class="grid col-220">
                	<img src="<?php echo $data['liveTextImage2']['src']; ?>" />
                </div>
                <div class="grid col-700 fit">
                	<h3 style="background-image:url(<?php echo $data['starsImage']['src']; ?>);"><?php echo $data['liveTextTitle2']; ?></h3>
                    <p><?php echo $data['liveTextText2']?></p>
                </div>
            </div>
            <?php endif; ?>
        	<?php if($data['liveTextImage3'] && $data['liveTextTitle3'] && $data['liveTextText3']): ?>
        	<div class="grid col-460">
            	<div class="grid col-220">
                	<img src="<?php echo $data['liveTextImage3']['src']; ?>" />
                </div>
                <div class="grid col-700 fit">
                	<h3 style="background-image:url(<?php echo $data['starsImage']['src']; ?>);"><?php echo $data['liveTextTitle3']; ?></h3>
                    <p><?php echo $data['liveTextText3']?></p>
                </div>
            </div>
            <?php endif; ?>
        	<?php if($data['liveTextImage4'] && $data['liveTextTitle4'] && $data['liveTextText4']): ?>
        	<div class="grid col-460 fit">
            	<div class="grid col-220">
                	<img src="<?php echo $data['liveTextImage4']['src']; ?>" />
                </div>
                <div class="grid col-700 fit">
                	<h3 style="background-image:url(<?php echo $data['starsImage']['src']; ?>);"><?php echo $data['liveTextTitle4']; ?></h3>
                    <p><?php echo $data['liveTextText4']?></p>
                </div>
            </div>
            <?php endif; ?>
            </div>
        </div>

	<?php
	get_footer();
}
?>
