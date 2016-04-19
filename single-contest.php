<?php if( !defined( 'ABSPATH' ) ) {	exit; };

	get_header();

	echo '<div id="content-full" class="grid col-940">';
	
	if(have_posts()):
		while(have_posts()):
			the_post();
			
			echo '<img src="http://ministrygear.com/wp-content/uploads/2014/10/HelpUsWin.jpg" />';
			social_warfare();
			echo '<h1>'.get_the_title().'</h1>';
			the_post_thumbnail();
			
			the_content();
			echo '<div class="clearfix"></div>';
			echo '<h4>Related Styles and Designs</h4>';
			$related = get_field('relatedDesigns');
			if($related):
				foreach($related as $item): 
					if($item->post_type == 'garment'):
						$itemNumber = get_post_meta($item->ID, 'ncGarmentNumber', true);
					else:
						$itemNumber = get_post_meta($item->ID, 'ncDesignNumber', true);
					endif;
					$featuredImage = get_the_post_thumbnail($item->ID);
					$post_counter++;
								
					echo '<li class="grid col-220 '.( $post_counter % 4 == 0 ? 'fit' : '').' ">';
					echo '<ul><li><a href="'.get_the_permalink($item->ID).'">'; 
					echo $featuredImage;
					echo '</a></li><li class="item"><a href="'.get_the_permalink($item->ID).'">';
					echo '<ul><li class="item-number"><p>'.$itemNumber.'</p></li>';
					echo '<li class="item-view"><p>View</p></li>';
					echo '</ul></a></li></ul></li>';
					
				endforeach;
			endif;
			
			echo '<div class="clearfix"></div>';
			$taxonomy     = 'design-category';
			$orderby      = 'name';
			$show_count   = 0;      // 1 for yes, 0 for no
			$pad_counts   = 0;      // 1 for yes, 0 for no
			$hierarchical = 1;      // 1 for yes, 0 for no
			$title        = '';
	
			$args = array(
			  'taxonomy'     => $taxonomy,
			  'orderby'      => $orderby,
			  'show_count'   => $show_count,
			  'pad_counts'   => $pad_counts,
			  'hierarchical' => $hierarchical,
			  'title_li'     => $title
			);
			echo '<div class="cat-list">';
			echo '<ul>';
			wp_list_categories( $args );
			echo '</ul></div>';
			
		endwhile;
	endif;

	echo '</div>';

	get_footer();

?>