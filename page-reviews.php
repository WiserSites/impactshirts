<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
Template Name: Customer Reviews
*/

get_header(); ?>
<div id="featured">
    <div class="grid col-540">
    	<h2><?php the_title(); ?></h2>

	<?php
	// Setup the container and header for the reviews
	echo '<div class="customerReviews">';
	echo '<div class="customerReviewsHeader">';
	echo '<p>Read what real customers have to say getting their church t-shirts</p>';
	echo '</div>';
	echo '<div class="customerReviewsContent" style="overflow-y:visible;height:auto;">';
	
	// Setup the loop to display the reviews
	$args = array(
		'post_type' 		=> 'reviews',
		'posts_per_page' 	=> -1
	);
	// switch_to_blog(1);
	$q = new WP_Query($args);
	if($q->have_posts()):
		while($q->have_posts()):
			$q->the_post();
			
			$rating = get_post_meta(get_the_ID(), 'reviewRating',true);
			$name = get_post_meta(get_the_ID(), 'reviewName',true);
			$groupName = get_post_meta(get_the_ID(), 'groupName',true);
			$width = (110 / 5) * $rating;
			$date = date('m/d/Y',strtotime(get_the_date()));
			echo '<div class="singleReview">';
			if($name || $groupName): 
				echo '<div class="reviewRating" style="width:'.$width.'px"></div>';
				echo '<div class="clearfix"></div>';
				echo '<div class="reviewDate">'.$date.'</div>';
				echo '<div class="reviewName">';
				if($name && $groupName): 
					echo $name.', '.$groupName;
				elseif($name):
					echo $name;
				elseif($groupName):
					echo $groupName;
				endif;
				echo '</div>';
				echo '<div class="clearfix"></div>';
			else:
				echo '<div class="reviewRating" style="width:'.$width.'px"></div>';
				echo '<div class="clearfix"></div>';
			endif;
			the_content();
			echo '</div>';
		endwhile;
	endif;
	wp_reset_postdata();
	// restore_current_blog();
	
	// Reset and close up shop
	echo '</div>';
	echo '</div>';
	?>
    
    </div>
    <div class="grid col-380 fit">
        <h2>Leave Your Own Review</h2>
        <div class="post-entry">
            <?php the_content(  ); ?>
        </div>
        <!-- end of .post-entry -->
    </div><!-- end of #content -->
</div>
<?php get_footer(); ?>