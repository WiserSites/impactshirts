<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
Template Name: SEO Landing Page #2
*/
add_filter( 'body_class', 'my_class_names' );
function my_class_names( $classes ) {
	$classes[] = 'landing-page';
	return $classes;
}
$impactshirts_options = impactshirts_get_options();
/**
 * If front page is set to display the
 * blog posts index, include home.php;
 * otherwise, display static front page
 * content
 */
if ( 'posts' == get_option( 'show_on_front' ) && $impactshirts_options['front_page'] != 1 ) {
	get_template_part( 'home' );
} elseif ( 'page' == get_option( 'show_on_front' ) && $impactshirts_options['front_page'] != 1 ) {
	$template = get_post_meta( get_option( 'page_on_front' ), '_wp_page_template', true );
	$template = ( $template == 'default' ) ? 'index.php' : $template;
	locate_template( $template, true );
} else {

	get_header();

	$data = get_fields();
	if (function_exists('socialWarfare')) :
		echo '<div class="grid col-460 noBMargin">';
		echo '<h1>'. get_the_title() .'</h1>';
		echo '</div>';
		echo '<div class="grid col-460 fit noBMargin">';
		socialWarfare();
		echo '</div>';
	else:
		echo '<h1>'. get_the_title() .'</h1>';
	endif;
	if($data['headerImage']):
		echo '<div class="grid col-940 headerImageArea" 
			style="background:url('.$data['headerImage']['url'].') no-repeat center; background-size: cover;">';
		if($data['videoTextToggle'] == 'Live Text'):
			echo '<div class="headerImageTextArea">';
			echo '<h2>'.$data['headerImageTitle'].'</h2>';
			echo '<p>'.$data['headerImageText'].'</p>';
			// if($data['headerButton'] == 'Yes'):
			//	echo '<a href="'.$data['headerButtonLink'].'" class="button">'.$data['headerButtonText'].'</a>';
			// endif;
			echo '</div>';
		endif;
		echo '</div>';
	endif;
	if($data['liveText']):
        echo '<div class="grid col-940 seoPageText">';
        echo $data['liveText'];
        echo '</div>';
    endif;
	?>
    
	<!-- end of #featured-image -->


    <div id="featured" class="grid col-940">
        <div class="splitDesignForm">
        	<div class="clearfix"></div>
            <div class="splitDesignFormLeft">
                <div class="headerTitle">
                    <h3>View Customizable Church Designs</h3>
                </div>
                <div class="leftDesigns">
                    <?php
					foreach($data['designs'] as $idea):
						echo '<a class="leftDesignPromo" href="#">';
						echo '<img src="'.$idea['image']['url'].'" />';
						echo '<h3>'.$idea['title'].'</h3>';
						echo $idea['text'];
						echo '<div class="seeDesignsButton">See Designs</div>';
						echo '<div class="clearfix"></div>';
						echo '</a>';
						echo '<div class="clearfix"></div>';
					endforeach;
					?>
                </div>
            </div>
            <div class="splitDesignFormRight">
                <div class="headerTitle">
                    <h3>Get a Free Church Design in your inbox.</h3>
                </div>
                <div class="rightDesigns">
                    <?php echo do_shortcode('[gravityform id="8" title="false" description="false"]'); ?>
                </div>
            </div>
        	<div class="clearfix"></div>
        </div>
    </div>
	<!-- end of #featured -->

	<?php 
	
	if($data['slider']):
		echo '<div class="clearfix"></div>';
		echo '<div class="testimonialSlider">';
		echo '<div class="arrowContainerLeft"><div class="arrow"></div></div>';
		echo '<div class="arrowContainerRight"><div class="arrow"></div></div>';
		echo '<div class="testimonialStretchContainer">';
		foreach($data['slider'] as $review):
			echo '<div class="testimonial">';
			echo '<img src="'.$review['image']['url'].'" />';
			echo '<p>'.$review['testimony'].'<br /><span class="author">'.$review['author'].'</span></p>';
			echo '</div>';
		endforeach;
		echo '</div>';
        echo '</div>';
		echo '<div class="clearfix"></div>';
	endif; 
	?>
        <?php $stars = get_option('impact-options'); ?>
        <?php if($data['liveTextBlocks']): ?>
        <div class="grid col-940 liveTextArea">
        	<?php $i = 0; foreach($data['liveTextBlocks'] as $block): ++$i; ?>
        	<div class="grid col-460 <?php if($i % 2 == 0) echo 'fit'; ?>">
            	<div class="grid col-220">
                	<img src="<?php echo $block['image']['url']; ?>" />
                </div>
                <div class="grid col-700 fit">
                	<?php if($data['stars'] == 'Yes'): ?>
                	<h3 style="background-image:url(<?php echo $stars['starsImage']['src']; ?>);"><?php echo $block['title']; ?></h3>
                    <?php else: ?>
                	<h3 style="background-image:none"><?php echo $block['title']; ?></h3>
                    <?php endif; ?>
                    <p><?php echo $block['text']?></p>
                </div>
            </div>
            <?php if($i %2 == 0) echo '<div class="clearfix"></div>'; ?>
            <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

	<?php
	get_footer();
}
?>