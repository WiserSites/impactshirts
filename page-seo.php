<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
Template Name: SEO Landing Page
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
			style="background-image:url('.$data['headerImage']['url'].')">';
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
    
    <?php if($data['designIdeas']): ?>
	<div id="featured" class="grid col-940">
    	<?php $i = 0; foreach($data['designIdeas'] as $idea): ++$i; ?>
		<div id="widgets" class="home-widgets designIdeas grid col-300 <?php if($i % 3 == 0) echo 'fit'; ?>">
			<div id="home_widget_1" class="">
				<div id="text-6" class="widget-wrapper widget_text">			
					<div class="textwidget designIdeaContainer <?php echo (isset($idea['textAlignment']) ? strtolower($idea['textAlignment']) : ""); ?>">
					<div class="textwidget designIdeaContainer <?php // echo strtolower($idea['textAlignment']); ?>">
						<a href="<?php echo $idea['url']; ?>">
							<img src="<?php echo $idea['image']['url']; ?>" alt="<?php echo $idea['image']['alt']; ?>" title="<?php echo $idea['image']['title']; ?>" />
                            <?php if($idea['topText']): ?>
							<div class="designIdeaTextContainer">
                            	<?php if($idea['button']): ?>
                                <div class="designIdeaButton"><?php echo $idea['button']; ?></div>
                                <?php else: ?>
                                <div class="designIdeaButton">See Design Ideas</div>
                                <?php endif; ?>
								<div class="designIdeaTopText"><?php echo $idea['topText']; ?></div>
							</div>
                            <?php endif; ?>
						</a>
					</div>
				</div>
			</div>
                        <h3><?php echo $idea['paragraphTitle']; ?></h3>
                        <div class="designIdeaBottomText"><?php echo $idea['bottomText']; ?></div>
        </div>
		<?php if($i % 3 == 0) echo '<div class="clearfix"></div>'; ?>
        <?php endforeach; endif; ?>	
        <div class="clearfix divider"></div>
    
		<?php if($data['shirtStylesLeft']): ?>
        <div id="featured-content" class="grid col-460">
            <?php foreach($data['shirtStylesLeft'] as $style): ?>
            <a href="<?php echo $style['url']; ?>">
                <img class="shirtStyles" src="<?php echo $style['image']['url']; ?>" alt="<?php echo $style['image']['alt']; ?>" title="<?php echo $style['image']['title']; ?>" />
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <!-- end of .col-460 -->
    
        <?php if($data['customerReviews']): ?>
        <div class="grid col-460 fit">
            <?php customerReviews(); ?>
        </div>
        <?php else: ?>
            <?php if($data['shirtStylesRight']): ?>
            <div id="featured-content" class="grid col-460 fit">
                <?php foreach($data['shirtStylesRight'] as $style): ?>
                <a href="<?php echo $style['url']; ?>">
                    <img class="shirtStyles" src="<?php echo $style['image']['url']; ?>" alt="<?php echo $style['image']['alt']; ?>" title="<?php echo $style['image']['title']; ?>" />
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
	<!-- end of #featured-image -->

	<!-- end of #featured -->

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