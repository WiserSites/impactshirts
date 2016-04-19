<?php if( !defined( 'ABSPATH' ) ) {	exit; };

	// Get the page header
	get_header();
	echo '<a href="http://ministrygear.com/photo-contest-submission/">';
	echo '<img src="http://ministrygear.com/wp-content/uploads/2014/10/Contest.jpg" />';
	echo '</a>';
	echo '<div class="clearfix"></div>';

	echo '<div class="grid col-940">';
	
	// Fetch the contest categories (iterations)
	$catArgs = array(
		'type'			=> 'post',
		'hide_empty'	=> TRUE,
		'hierarchical'	=> 1,
		'number'		=> 5,
		'taxonomy'		=> 'contest-category',
	);
	$categories = get_categories( $catArgs );
	
	// Loop through each category with the newest on top
	foreach($categories as $cat):
	
		echo '<h2>'.$cat->name.'</h2>';
		echo '<p>'.$cat->description.'</p>';
		$image = get_tax_meta($cat->term_id,'categoryImage');
		if($image):
			echo '<img src="'.$image.'" />';
		endif;
		echo '<div class="clearfix"></div>';
	
		// Query for posts in this particular contest iteration
		$args = array(
			'posts_per_page' 	=> -1,
			'post_type' 		=> 'contest',
			'meta_key'			=> '_totes',
			'orderby'			=> 'meta_value_num',
			'order'				=> 'DESC'
		);
		$q = new WP_Query( $args );
		
		
		if( $q->have_posts() ) :
			$i = 1;
			while( $q->have_posts() ):
				$q->the_post();
			
				// Output this entry to the screen
				if($i % 3 == 0):
					echo '<div class="grid col-300 fit">';
				else:
					echo '<div class="grid col-300">';
				endif;
				echo '<a href="'.get_the_permalink().'"><h3>'.get_the_title().'</h3></a>';
				echo '<a href="'.get_the_permalink().'">';
				the_post_thumbnail( 'contest' );
				echo '</a>';
				echo '<a href="'.get_the_permalink().'">';
				echo '<li class="item"><a href="'. get_the_permalink().'"><ul>';
				echo '<li class="item-number" style="z-index:99"><p>Vote Now</p></li>';
				echo '<li class="item-view" style="width:52%;"><p>'.get_post_meta(get_the_ID(),'_totes',true).' Votes</p></li></ul></a></li>';
				social_warfare();
				echo '</a></div>';
				++$i;
				
			endwhile;
		endif;
		
	endforeach;
	
	echo '</div>';

	get_footer();

?>