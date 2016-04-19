<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Template Name: Group Names Archive
 */

// Output the page header
get_header();

// Create the page container
echo '<div class="grid col-940">';
	echo '<h1>'.get_the_title().'</h1>';
	the_content();

	// Begin the gallery
	echo '<div class="cat-gallery group-names"><ul>';

		// asort($fields['names']);

		// Begin the loop
		$i = 0;

		$args = array( 'post_type' => 'group_name', 'posts_per_page' => -1 );
		$posts = get_posts( $args );
		if( count( $posts ) )
		foreach( $posts as $post){
			$i++;
			$group_name = get_fields( $post->ID );
			// var_dump($group_name);
			$the_link = '';
			if( $group_name['image_or_design'] == 'Design' ){
				if( $i_link = get_permalink( $group_name['design']->ID ) )$the_link = $i_link;
			} else {
				if( $group_name['link'] ) $the_link = $group_name['link'];
			}
			// Begin the container
			echo '<li class="grid col-172"><ul><li>';

			if( $the_link )
				echo '<a class="archive_single_a" href="'.$the_link.'"> ';
				echo '<h4>'.$group_name['group_name'].'</h4> ';
				if( $the_link )
					echo '</a>';
			if( $the_link )
				echo '<a class="archive_single_a" href="'.$the_link.'"> ';
				echo '<h6>'.$group_name['tagline'].'</h6> ';
				if( $the_link )
					echo '</a>';

			// Check if we have an image to output
			if($group_name['image_or_design'] == 'Image' && $group_name['image']):

				if( $the_link ):
					echo '<a href="'.$the_link.'">';
				endif;

				echo '<img class="attachment-post-thumbnail wp-post-image" src="'.$group_name['image'].'" title="'.$group_name['group_name'].'" alt="'.$group_name['group_name'].'" height="500" width="405">';

				if( $the_link):
					echo '</a>';
				endif;

			// Check if we have a design to output
			elseif($group_name['image_or_design'] == 'Design' && $group_name['design']):

				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $group_name['design']->ID ), 'large' );
				if( $the_link )
					echo '<a href="'.$the_link.'">';

				echo '<img class="attachment-post-thumbnail wp-post-image" src="'.$image[0].'" title="'.$group_name['group_name'].'" alt="'.$group_name['group_name'].'" height="500" width="405">';

				if( $the_link )
					echo '</a>';

			endif;

			// Close the container
			echo '</li></ul></li>';

		}

		// Close the Gallery HTML
		echo '</ul></div>';

	// Close the page container
	echo '</div>';


// Output the page footer
get_footer();

?>