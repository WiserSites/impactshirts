<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Error 404 Template
 *
 *
 * @file           404.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2015 - 2016 WiserSites
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/impactshirts/404.php
 * @link           http://codex.wordpress.org/Creating_an_Error_404_Page
 * @since          available since Release 1.0
 */
?>


<?php get_header(); ?>
<?php
$title = 'Page not available. But Josh is.';
$content = ''; $bg_image_src = ''; $data = array();
$the_slug = '404-not-found';
$args = array(
	'name'        => $the_slug,
	'post_type'   => 'page',
	'post_status' => 'any',
	'numberposts' => 1
);
$post = get_posts($args);
if( !empty( $post ) ){
	$post = $post[0];
	// Fetch the custom field data
	$data = get_fields( $post->ID );
	$title = ''; //$post->post_title;
	$content = $post->post_content;
	$bg_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
	if( $bg_image )
		$bg_image_src = $bg_image[0];
}
//i_print( $post );
?>
<style type="text/css">
	html {
		margin-top: 0 !important;
	}
</style>
<?php
if( !isset( $data['modules'] ) || empty( $data['modules'] ) ) {
	?>
	<style type="text/css">
		.no_page.full_image_outer {
		<?php
		if( $bg_image_src )
		echo 'background-image: url("'.$bg_image_src.'");';
		?>
		}
	</style>
	<div class="full_image_outer no_page">
		<div class="full_image_inner">
			<div class="grid col-940 nomargin">
				<?php
				if ($title)
					echo '<h2 class="full_image_title"><b> ' . $title . '</b></h2>';
				?>
			</div>
			<div class="grid col-940 search_recs">
				<?php
				if ($content == '') {
					?>
					<p>Josh is a <?php bloginfo('name'); ?> designer who loves sans serif fonts and fast Macs.</p>
					<p><b>Or if you prefer, you can search for designs here.</b></p>
					<?php
				} else {
					echo $content;
				}
				?>

			</div>
			<div class="clearfix"></div>
			<div class="search_page_form">
				<div class="widget-wrapper"><?php get_search_form(); ?></div>
			</div>
			<?php // display_search_terms();
			?>
			<div class="clearfix"></div>
		</div>
	</div>
	<?php
} else {

///////////////////////////////// Modular logic start// Set the SEO Containers
	echo '<div id="content">';

	echo '<div class="post-entry hentry">';
	$module_n = 0;
	foreach ( $data['modules'] as $module ):
		$module_n++;
		/*********************************************
		Module Type: Slider
		 *********************************************/

		if($module['moduleType'] == 'slider'):
			echo '<div class="home-slider">'.do_shortcode( '[metaslider id='.$module['sliderID'].']' ).'</div>';
			echo '<div class="clearfix"></div>';

		/*********************************************
		Module Type: Two Column Banners
		 *********************************************/

		elseif($module['moduleType'] == 'twobanners'):

			// CONTAINER: Create a full width grid container to keep both columns next to each other
			echo '<div class="grid col-940">';

			//
			//	LEFT SIDE OF THE MODULE
			//
			// LEFT: Create the 50% left side of the two columns
			echo '<div class="grid col-460 dualBanner">';

			// IF the Left Link is Activated
			if($module['left_full_banner_link']):
				echo '<a href="'.$module['left_full_banner_link'].'">';
			endif;

			// LEFT: Output the banner image
			echo '<img src="'.$module['left_banner_image'].'" />';

			// IF the button option was selected....
			if($module['left_text_or_button'] == 'button'):

				echo '<a href="'.$module['left_button_link'].'" class="button">'.$module['left_button_text'].'</a>';

			// IF the text module was selected
			elseif($module['left_text_or_button'] == 'text' && $module['left_text_field']):

				echo '<p class="dual_banner_text">'.$module['left_text_field'].'</p>';

			endif;

			// IF the Left Link is Activated
			if($module['left_full_banner_link']):
				echo '</a>';
			endif;

			// LEFT: Close the 50% left side of the two columns
			echo '</div>';

			//
			//	RIGHT SIDE OF THE MODULE
			//
			// RIGHT: Create the 50% left side of the two columns
			echo '<div class="grid col-460 fit dualBanner">';

			// IF the Right Link is Activated
			if($module['right_full_banner_link']):
				echo '<a href="'.$module['right_full_banner_link'].'">';
			endif;

			// RIGHT: Output the banner image
			echo '<img src="'.$module['right_banner_image'].'" />';

			// IF the button option was selected....
			if($module['right_text_or_button'] == 'button'):

				echo '<a href="'.$module['right_button_link'].'" class="button">'.$module['right_button_text'].'</a>';

			// IF the text module was selected
			elseif($module['right_text_or_button'] == 'text' && $module['right_text']):

				echo '<p class="dual_banner_text">'.$module['right_text_field'].'</p>';

			endif;

			// IF the Right Link is Activated
			if($module['right_full_banner_link']):
				echo '</a>';
			endif;

			// RIGHT: Close the 50% left side of the two columns
			echo '</div>';

			// CONTAINER: Close the Full width grid container that houses this module
			echo '</div>';

		/*********************************************
		Module Type: Text and Image
		 *********************************************/

		elseif($module['moduleType'] == 'textAndImage'):

			// Check if we are using text or a video on the left
			if($module['videoTextToggle'] == 'Live Text'):

				// Output the container with our custom background image
				echo '<div class="grid col-940 headerImageArea" style="background-image:url('.$module['headerImage']['url'].')">';

				echo '<div class="headerImageTextArea">';

				// Output a title if one exists
				if($module['headerImageTitle'] && !$module['headerImageTitleColor']):
					echo '<h2>'.$module['headerImageTitle'].'</h2>';
				elseif($module['headerImageTitle'] && $module['headerImageTitleColor']):
					echo '<h2 style="color:'.$module['headerImageTitleColor'].'">'.$module['headerImageTitle'].'</h2>';
				endif;

				// Output the paragraph text if it exists
				if($module['headerImageText']):
					$t_style = '';
					if( $module['headerImageText_color'] )
						$t_style = 'color: '.$module['headerImageText_color'].' !important;';
					echo '<p style="'.$t_style.'">'.$module['headerImageText'].'</p>';

				endif;

				// Output the call to action button if one was populated
				if($module['headerButton'] == 'Yes' && $module['buttonColorScheme'] == 'Default'):
					echo '<a href="'.$module['headerButtonLink'].'" class="button">'.$module['headerButtonText'].'</a>';
				elseif($module['headerButton'] == 'Yes' && $module['buttonColorScheme'] == 'Light Color'):
					echo '<a href="'.$module['headerButtonLink'].'" class="button lightColor">'.$module['headerButtonText'].'</a>';
				endif;
				echo '</div>';

			// Add the video if a video was loaded
			elseif($module['videoTextToggle'] == 'Video'):

				// Output the container with our custom background image
				echo '<div class="grid col-940 headerImageArea" style="background-image:url('.$module['headerImage']['url'].')">';echo '<div class="headerImageTextArea">';
				echo $module['headerVideo'];
				echo '</div>';
			elseif($module['videoTextToggle'] == 'Image Only'):
				echo '<div class="grid col-940 headerImageArea">';
				if($module['image_link']):
					echo '<a href="'.$module['image_link'].'">';
				endif;
				echo '<img src="'.$module['headerImage']['url'].'" />';
				if($module['image_link']):
					echo '</a>';
				endif;
				echo '</div>';
			endif;

			// Close this module and move on to the next one
			echo '</div>';
			echo '<div class="clearfix"></div>';

		/*********************************************
		Module Type: WYSIWYG Text Block
		 *********************************************/

		elseif($module['moduleType'] == 'textBlock'):
			echo '<div class="grid col-940 entry-content">';
			echo $module['textBlock'];
			echo '</div>';
			echo '<div class="clearfix"></div>';

		/*********************************************
		Module Type: Design Ideas
		 *********************************************/

		elseif($module['moduleType'] == 'designIdeas'):

			echo '<div id="featured" class="grid col-940">';
			echo '<div id="widgets" class="home-widgets">';

			// Cycle through and display the design ideas
			$i = 0; foreach($module['designIdeas'] as $idea): ++$i;

			echo '<div id="home_widget_1" class="designIdeas grid col-300'.($i % 3 == 0 ? ' fit' : '').' ">';
			// echo '<div id="text-6" class="widget-wrapper widget_text">';
			echo '<div class="textwidget designIdeaContainer '.strtolower($idea['textAlignment']).'">';
			echo '<a href="'.$idea['url'].'">';
			echo '<img src="'.$idea['image']['url'].'" alt="'.$idea['image']['alt'].'" title="'.$idea['image']['title'].'" />';
			if($idea['topText']):
				echo '<div class="designIdeaTextContainer">';
				if($idea['button']):
					echo '<div class="designIdeaButton">'.$idea['button'].'</div>';
				else:
					echo '<div class="designIdeaButton">See Design Ideas</div>';
				endif;
				echo '<div class="designIdeaTopText">'.$idea['topText'].'</div>';
				echo '</div>';
			endif;
			echo '</a>';
			// echo '</div>';
			echo '</div>';

			// Output the paragraph text
			echo '<h3>'.$idea['paragraphTitle'].'</h3>';
			echo '<div class="designIdeaBottomText">'.$idea['bottomText'].'</div>';
			echo '</div>';
			if($i % 3 == 0) echo '<div class="clearfix"></div>';
		endforeach;
			echo '</div>';
			echo '</div>';
			echo '<div class="clearfix divider"></div>';

		/*********************************************
		Module Type: Split Content and/or Reviews
		 *********************************************/

		elseif($module['moduleType'] == 'splitContent'):

			// Display the Shirt Styles on the Left Column
			if($module['shirtStylesLeft']):
				echo '<div class="grid col-460">';
				foreach($module['shirtStylesLeft'] as $style):
					echo '<a href="'.$style['url'].'">';
					echo '<img class="shirtStyles" src="'.$style['image']['url'].'" alt="'.$style['image']['alt'].'" title="'.$style['image']['title'].'" />';
					echo '</a>';
				endforeach;
				echo '</div>';
			endif;

			// Display the Customer Reviews Block on the Right
			if($module['customerReviews']):
				echo '<div class="grid col-460 fit">';
				customerReviews();
				echo '</div>';

			// Or Display another Column of Shirt Styles
			else:
				if($module['shirtStylesRight']):
					echo '<div class="grid col-460 fit">';
					foreach($module['shirtStylesRight'] as $style):
						echo '<a href="'.$style['url'].'">';
						echo '<img class="shirtStyles" src="'.$style['image']['url'].'" alt="'.$style['image']['alt'].'" title="'.$style['image']['title'].'" />';
						echo '</a>';
					endforeach;
					echo '</div>';
				endif;
			endif;

		/*********************************************
		Module Type: Split Content and Form
		 *********************************************/

		elseif($module['moduleType'] == 'splitForm'):

			// Setup the split view container
			echo '<div class="splitDesignForm">';
			echo '<div class="clearfix"></div>';
			echo '<div class="splitDesignFormLeft">';

			// Output the header on the left
			echo '<div class="headerTitle">';
			echo '<h3>'.$module['leftTitle'].'</h3>';
			echo '</div>';
			echo '<div class="leftDesigns">';

			// Loop through the design boxes
			foreach($module['designs'] as $idea):
				echo '<a class="leftDesignPromo" href="'.$idea['link'].'">';
				echo '<img src="'.$idea['image']['url'].'" />';
				echo '<h3>'.$idea['title'].'</h3>';
				echo $idea['text'];
				echo '<div class="seeDesignsButton">See Designs</div>';
				echo '<div class="clearfix"></div>';
				echo '</a>';
				echo '<div class="clearfix"></div>';
			endforeach;
			echo '</div>';
			echo '</div>';
			echo '<div class="splitDesignFormRight">';

			// Output the header on the right
			echo '<div class="headerTitle">';
			echo '<h3>'.$module['rightTitle'].'</h3>';
			echo '</div>';

			// Output the form from Gravity forms
			echo '<div class="rightDesigns">';
			echo do_shortcode('[gravityform id="8" title="false" description="false"]');
			echo '</div>';
			echo '</div>';
			echo '<div class="clearfix"></div>';
			echo '</div>';
			echo '<div class="clearfix"></div>';

		/*********************************************
		Module Type: Live Text Boxes
		 *********************************************/

		elseif($module['moduleType'] == 'liveTextBoxes'):

			// Fetch the stars image for this site
			$stars = get_option('impact-options');

			// Begin the Live Text Area container
			echo '<div class="grid col-940 liveTextArea">';

			// Loop through each block
			$i = 0; foreach($module['liveTextBlocks'] as $block): ++$i;
			echo '<div class="grid col-460 '.($i % 2 == 0 ? 'fit' : '') .'">';

			// Output the image on the left
			echo '<div class="grid col-220">';
			if(isset($module['link'])):
			else:
				echo '<a href="'.(isset($module['link']) ? $module['link'] : "#").'">';
//						echo '<a href="'.$module['link'].'">';
				echo '<img src="'.$block['image']['url'].'" />';
				echo '</a>';
			endif;
			echo '</div>';

			// Output the title with or without stars
			echo '<div class="grid col-700 fit">';
			if($module['stars'] == 'Yes'):
				if(isset($module['link'])):
					echo '<a href="'.$module['link'].'">';
					echo '<h3 style="background-image:url('.$stars['starsImage']['src'].');">'.$block['title'].'</h3>';
					echo '</a>';
				else:
					echo '<h3 style="background-image:url('.$stars['starsImage']['src'].');">'.$block['title'].'</h3>';
				endif;
			else:
				if(isset($module['link'])):
					echo '<a href="'.$module['link'].'">';
					echo '<h3 style="background-image:none">'.$block['title'].'</h3>';
					echo '</a>';
				else:
					echo '<h3 style="background-image:none">'.$block['title'].'</h3>';
				endif;
			endif;

			// Output the text
			echo '<p>'.$block['text'].'</p>';
			echo '</div>';
			echo '</div>';

			// If this is an even numbered block, make sure we clear to begin a new row
			if($i %2 == 0) echo '<div class="clearfix"></div>';
		endforeach;
			echo '</div>';

			// Clearfix the end of the module
			echo '<div class="clearfix"></div>';

		/*********************************************
		Module Type: Testimonials Slider
		 *********************************************/

		elseif($module['moduleType'] == 'testimonialsBlock'):

			// Initialize the Slider Container Elements
			echo '<div class="clearfix"></div>';

			// Output the background color if one is selected
			if($module['testimonialColor']):
				echo '<div class="testimonialSlider" style="background-color:'.$module['testimonialColor'].';">';
			else:
				echo '<div class="testimonialSlider">';
			endif;
			echo '<div class="arrowContainerLeft"><div class="arrow"></div></div>';
			echo '<div class="arrowContainerRight"><div class="arrow"></div></div>';
			echo '<div class="testimonialStretchContainer">';

			// Loop through and output each testimonial
			foreach($module['testimonialSlider'] as $review):
				echo '<div class="testimonial">';
				echo '<img src="'.$review['image']['url'].'" />';
				echo '<p>'.$review['testimony'].'<br /><span class="author">'.$review['author'].'</span></p>';
				echo '</div>';
			endforeach;

			// Close the slider elements and ClearFix
			echo '</div>';
			echo '</div>';
			echo '<div class="clearfix"></div>';

		/*********************************************
		Module Type: Designs From a Category
		 *********************************************/

		elseif($module['moduleType'] == 'designCategory'):

			// Fetch the Design Category that we'll be using
			unset($taxArray);
			if($module['designCategory']):
				$taxArray = array(
					'taxonomy' => 'design-category',
					'field'    => 'id',
					'terms'    => $module['designCategory'],
				);
			else:
				$taxArray = array(
					'taxonomy' => 'specific-design-categories',
					'field'    => 'id',
					'terms'    => $module['secondaryDesignCategory'],
				);
			endif;

			// Setup the WP Query Arguments
			unset($args);
			$args = array(
				'post_type' 		=> 'design',
				'tax_query' 		=> array( $taxArray ),
				'offset'			=> $module['offset'],
				'posts_per_page' 	=> $module['designCount']
			);
			$q = new WP_Query( $args );

			// Begin the gallery container
			echo '<div class="cat-gallery">';
//                        asort($q);
			echo '<ul>';
			$post_counter = 0;

			// Begin looping through the posts
			while( $q->have_posts() ) :
				$q->the_post();
//                                        $q->set( 'orderby', 'title' );
//        $q->set( 'order', 'ASC' );

				// Collect and update the necessary variables and attributes
				$post_counter++;
				$featuredImage = get_the_post_thumbnail();
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
				$itemNumber = get_post_meta($post->ID, 'ncDesignNumber', true);

				// Output this design to the screen
				echo '<li class="grid col-220 '; if( $post_counter == 4 ){ echo 'fit'; $post_counter = 0; } else { }; echo '">';
				echo '<ul>';
				echo '<li>';
				echo '<a class="group_image_class" href="'.get_the_permalink().'">';
				if ( has_post_thumbnail() ) :
					echo '<img class="attachment-post-thumbnail wp-post-image" src="'.$image[0].'" title="'.get_the_title().'" alt="'.get_the_title().'" height="'.$image[2].'" width="'.$image[1].'"/>';
					echo '<div class="hoverLabel">VIEW</div>';
				endif;
				echo '</a>';
				echo '</li>';

				// Output the shirt name and product number boxes
				echo '<li class="item">';
				echo '<a href="'.get_the_permalink().'" title="'.get_the_title().'">';
				$title = get_the_title();
				$title = strlen($title) > 27 ? substr($title,0,27) : $title;
				$title = ucwords($title);
				echo '<ul>';
				echo '<li class="item-view" style="width:77%;"><p>'.$title.'</p></li>';
				echo '<li class="item-number" style="width:25%"><p>'.$itemNumber.'</p></li>';
				echo '</ul>';
				echo '</a>';
				echo '</li>';
				echo '</ul>';
				echo '</li>';
			endwhile;
			echo '</ul>';

			// Output the view all button if it has been activated
			if($module['viewAll']):
				if($module['designCategory']):
					$link = get_term_link( $module['designCategory'][0] , 'design-category' );
				else:
					$link = get_term_link( $module['secondaryDesignCategory'][0] , 'specific-design-categories' );
				endif;
				echo '<a class="viewAllDesigns" href="'.$link.'">View All Designs</a>';
			endif;

			echo '</div>';

			// Reset the WP Query so that it doesn't interfere with loops that may appear in other modules
			wp_reset_query();

		/*********************************************
		Module Type: Group Names
		 *********************************************/

		elseif($module['moduleType'] == 'groupNames'):

			// Fetch the Design Category that we'll be using
			unset($taxArray);
			if($module['group_names_category']):
				$taxArray = array(
					'taxonomy' => 'group_category',
					'field'    => 'id',
					'terms'    => $module['group_names_category'],
				);
			else:
				$taxArray = array(
					'taxonomy' => 'specific-design-categories',
					'field'    => 'id',
					'terms'    => $module['secondary_group_names_category'],
				);
			endif;

			// Setup the WP Query Arguments
			unset($args);
			if( trim( $module['group_namesOffset'] ) == '' )
				$module['group_namesOffset'] = '1';
			$args = array(
				'post_type' 		=> 'group_name',
				'orderby'               => 'title',
				'order'                 => 'ASC',
				'tax_query' 		=> array( $taxArray ),
				'offset'			=> $module['group_namesOffset'],
				'posts_per_page' 	=> $module['group_namesCount'],
				'numberposts' => $module['group_namesCount'],
				'ignore_custom_sort'	=> true
			); //echo $module['group_namesOffset'];
			$posts = get_posts( $args );
//			$posts->set( 'orderby', $posts->post_title );
//        $posts->set( 'order', 'ASC' );
			// Begin the gallery container
			echo '<div class="cat-gallery group-names">';
//                        asort($posts);
			echo '<ul>';
			$post_counter = 0;
			$i = 0;
			// Begin looping through the posts
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
					echo '<h2>'.$group_name['group_name'].'</h2> ';
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
							echo '<a class="group_image_class" href="'.$the_link.'">';
						endif;

						echo '<img class="attachment-post-thumbnail wp-post-image" src="'.$group_name['image'].'" title="'.$group_name['group_name'].'" alt="'.$group_name['group_name'].'" height="500" width="405">';

						if( $the_link):
							echo '</a>';
						endif;

					// Check if we have a design to output
					elseif($group_name['image_or_design'] == 'Design' && $group_name['design']):

						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $group_name['design']->ID ), 'large' );
						if( $the_link )
							echo '<a class="group_image_class" href="'.$the_link.'">';

						echo '<img class="attachment-post-thumbnail wp-post-image" src="'.$image[0].'" title="'.$group_name['group_name'].'" alt="'.$group_name['group_name'].'" height="500" width="405">';

						if( $the_link )
							echo '</a>';

					endif;

					// Close the container
					echo '</li></ul></li>';

				}

			echo '</ul>';
			echo '</div>';
			echo '<div>';
			// Output the view all button if it has been activated
			if($module['group_names_viewAll']):
				if($module['group_names_category']):
					$link = get_term_link( $module['group_names_category'][0] , 'group_category' );
				else:
					$link = get_term_link( $module['secondary_group_names_category'][0] , 'specific-design-categories' );
				endif;
				if( is_string( $link ) )
					echo '<a class="viewAllDesigns" href="'.$link.'">View All Designs</a>';
			endif;

			echo '</div>';

		// Reset the WP Query so that it doesn't interfere with loops that may appear in other modules
		//wp_reset_query();

		/*********************************************
		Module Type: Blog Posts
		 *********************************************/

		elseif($module['moduleType'] == 'blogPosts'):

			// Unset Previously Used Variables
			unset($args);
			unset($taxArray);

			// Setup Most Recent Blog Posts Query
			if($module['blogPostsType'] == 'recent'):
				$q = new WP_Query( 'posts_per_page='.$module['blogPostsCount']);

			// Setup the Category Blog Posts Query
			else:

				// Setup the Taxonomy Query
				$taxArray = array(
					'taxonomy' => 'category',
					'field'    => 'id',
					'terms'    => $module['blogPostsCategory'],
				);

				// Setup the Query Arguments
				$args = array(
					'post_type' 		=> 'post',
					'tax_query' 		=> array( $taxArray ),
					'posts_per_page' 	=> $module['blogPostsCount']
				);

				// Run the Query
				$q = new WP_Query( $args );

			endif;

			// Check the returned posts
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
			wp_reset_query();

		/*********************************************
		Module Type: Responsive banner
		 *********************************************/

		elseif($module['moduleType'] == 'responsive_banner'):
			$banner_content = $module['banner_content'];
			//i_print( $banner_content );
			if( $banner_content ){
				echo '<div class="i_responsive_banner_wrapper grid col-940 entry-content i_row">';
				$banner_n = 0;
				foreach ( $banner_content as $banner){
					$banner_n++;
					$banner_class = 'banner_'.$module_n.'_'.$banner_n;
					$banner_url = $banner['banner_url'];
					//if( $banner['banner_width'] == 'edge_to_edge'){}
					//Render style
					echo '<style> .'.$banner_class.'{ background-color:'.$banner['background_color'].';';
					if( $banner['banner_image'] )
						echo 'background-image: url('.$banner['banner_image']['url'].'); ';
					if( $banner['banner_height'] )
						echo 'height: '.$banner['banner_height'].'px; ';
					echo ' }';

					echo '.'.$banner_class.' .i_resp_banner_title{';
					if( $banner['title_text_color'] )
						echo 'color: '.$banner['title_text_color'].' !important; ';
					if( $banner['title_font_size'] && $banner['title_font_size'] != 'default')
						echo 'font-size: '.$banner['title_font_size'].'px !important; ';
					echo ' }';

					echo '.'.$banner_class.' .i_resp_banner_tagline{';
					if( $banner['tagline_text_color'] )
						echo 'color: '.$banner['tagline_text_color'].' !important; ';
					if( $banner['tagline_text_color'] && $banner['tagline_text_color'] != 'default')
						echo 'font-size: '.$banner['tagline_text_color'].'px !important; ';
					echo ' }';

					echo '.'.$banner_class.' .i_resp_btn{';
					if( $banner['button_color'] )
						echo 'background: '.$banner['button_color'].' !important; ';
					echo ' }';
					// html body
					echo '.'.$banner_class.' .i_resp_search_form #searchform .submit,';
					echo '.'.$banner_class.' .i_resp_search_form #searchform .submit:hover {';
					if( $banner['search_box_color'] )
						echo 'background-color: '.$banner['search_box_color'].' !important; ';
					echo ' }';

					echo '</style>';
					//end rendering style

					echo '<div class="i_responsive_banner col-md-'.$banner['banner_width'].'"> <div class="i_responsive_banner_inner"> <div class="i_responsive_banner_content '.$banner_class.'  clearfix"><div class="i_centering_div">';

					/*if( $banner['banner_image'] )
                        echo '<img src="'.$banner['banner_image']['url'].'" >';*/

					if( $banner['enable_title'] ) {
						echo '<h2 class="i_resp_banner_title" >';
						if( $banner['title_text'] )
							echo $banner['title_text'];
						echo '</h2>';
					}
					if( $banner['enable_tagline'] ) {
						echo '<h4 class="i_resp_banner_tagline">';
						if( $banner['tagline_text'] )
							echo $banner['tagline_text'];
						echo '</h4>';
					}

					if( $banner['enable_button'] ) {
						$button_div_class = '';
						if( $banner['i_button_size'] != 0 ){
							$button_div_class = 'banner_ind_button col-md-'.$banner['i_button_size'];
						}
						echo '<div class="banner_ind_button_div"> <div class="'.$button_div_class.'">';
						if( $banner['button_text'] )
							echo '<a href="'.$banner_url.'" class="i_resp_btn">'.$banner['button_text'].'</a>';
						echo '</div></div>';
					}

					if( $banner['enable_search_box'] ){
						echo '<div class="i_resp_search_form">';
						get_search_form();
						echo '</div>';
					}

					echo '</div> </div> </div> </div>';
				}
				echo '</div>';
			}
			echo '<div class="clearfix"></div>';


		/*********************************************
		Module Type: A button
		 *********************************************/

		elseif($module['moduleType'] == 'a_button'):
			$a_button_text = $module['a_button_text'];
			//i_print( $banner_content );
			if( $a_button_text ){

				$a_button_class = 'a_button_'.$module_n;
				$a_button_url = $module['a_button_url'];
				$a_button_width = $module['a_button_width'];
				$a_target = '';
				if( $module['a_button_open_in_new_tab'] )
					$a_target = '_blank';

				echo '<div class="a_button_wrapper col-md-'.$a_button_width.' '.$a_button_class.'"> <div class="a_button_inner">';
				echo '<a href="'.$a_button_url.'" class="a_button" target="'.$a_target.'" >'.$a_button_text.'</a>';
				echo '</div> </div>';
				//Render style
				echo '<style> .'.$a_button_class.'{ }';

				echo '.'.$a_button_class.' .a_button{';
				if( $module['a_button_text_color'] )
					echo 'color: '.$module['a_button_text_color'].' !important; ';
				if( $module['a_button_background_color'] )
					echo 'background-color: '.$module['a_button_background_color'].' !important; ';
				echo ' }';

				echo '.'.$a_button_class.' .a_button:hover {';
				if( $module['a_button_text_hover_color'] )
					echo 'color: '.$module['a_button_text_hover_color'].' !important; ';
				if( $module['a_button_hover_background_color'] )
					echo 'background-color: '.$module['a_button_hover_background_color'].' !important; ';
				echo ' }';

				echo '</style>';
				//end rendering style
			}
			//echo '<div class="clearfix"></div>';
			///////////////////////////////////////////////////////////////////////////////////////

		endif;

	endforeach;
	// Close the SEO containers
	echo '</div></div>';

}

///////////////////////////////// Modular logic end
?>
    
    <div id="wrapper" class="clearfix">
    <div id="content-search" class="grid col-940" style="text-align:center;">
<?php


// get_template_part( 'loop-no-posts' );

		$taxonomy     = 'design-category';
		$orderby      = 'name';
		$show_count   = 0;      // 1 for yes, 0 for no
		$pad_counts   = 0;      // 1 for yes, 0 for no
		$hierarchical = 1;      // 1 for yes, 0 for no
		$title        = '';
		$walker		  = new Walker_Category_Find_Parents();

		$args = array(
		  'taxonomy'     => $taxonomy,
		  'orderby'      => $orderby,
		  'show_count'   => $show_count,
		  'pad_counts'   => $pad_counts,
		  'hierarchical' => $hierarchical,
		  'title_li'     => $title,
		  'walker'		 => $walker
		);
		?>
		<div class="cat-list">
        	<h3>Popular Design Categories</h3>
			<ul>
			<?php wp_list_categories( $args ); ?>
			</ul>
		</div> <?php

		$args = array( 
			'post_type' 	=> 'design',
			'orderby' 		=> 'date',
			'order'   		=> 'DESC', 
		);
		$q = new WP_Query( $args );

		if( $q->have_posts() ) : ?>
					<h3>Our Most Recent Designs</h3>
					<div class="cat-gallery">
						<ul>
							<?php 
								$post_counter = 0;
								while( $q->have_posts() ) : 
								$q->the_post(); 
								$post_counter++; 
								$featuredImage = get_the_post_thumbnail();
								$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
								$itemNumber = get_post_meta($post->ID, 'ncDesignNumber', true);
							?>
							<li class="grid col-172 <?php if( $post_counter == 5 ){ echo 'fit'; $post_counter = 0; } else { } ?>">
								<ul>
	
									<li>
										<a href="<?php the_permalink() ?>"><?php 
										if ( has_post_thumbnail() ) : 
										  echo '<img class="attachment-post-thumbnail wp-post-image" src="'.$image[0].'" title="'.get_the_title().'" alt="'.get_the_title().'" height="'.$image[2].'" width="'.$image[1].'"/>';
										  echo '<div class="hoverLabel">VIEW</div>';
										endif; 
										?></a>
									</li>
									<li class="item">
									<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
									<?php 
										$title = get_the_title();
										$title = strlen($title) > 23 ? substr($title,0,23) : $title;
										$title = ucwords($title);
									?>
									<ul>
									<li class="item-view" style="width:77%;"><p><?php echo $title; ?></p></li>
									<li class="item-number" style="width:25%"><p><?php echo $itemNumber ?></p></li>
									</ul>
									</a>
									</li>
								</ul>
							</li>
							<?php endwhile; ?>
						</ul>
					</div>
                    </div>
	<?php
		wp_reset_query();
		endif;







get_footer(); ?>
