<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Single Garment
 *
 *
 * @file           single-garment.php
 * @package        Impact Shirts
 * @author         Jason T. Wiser
 * @copyright      2014 Wiser Sites
 * @license        license.txt
 * @version        Release: 1.0
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>

<div id="content-full" class="grid col-940"><!-- single-garment.php -->

	

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>
		
		<?php 
			$featuredImage = get_the_post_thumbnail();
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
			$colors = get_post_meta($post->ID, 'ncCheckboxList', false);
			$thumbNailOne = get_post_meta($post->ID, 'ncthumbNailOne', true);
			$thumbNailTwo = get_post_meta($post->ID, 'ncthumbNailTwo', true);
			$thumbNailThree = get_post_meta($post->ID, 'ncthumbNailThree', true);
			$contactForm = get_post_meta($post->ID, 'ncContactForm', true);
			$tableID = get_post_meta($post->ID, 'ncTableID', true);
			$table2ID = get_post_meta($post->ID, 'ncTable2ID', true);
			$displayColors = get_post_meta($post->ID, 'colorImages', true);
		
		?>

			<?php impactshirts_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php impactshirts_entry_top(); ?>

				<div class="col-460 grid">
					<div class="garment-main">
						<p><?php echo '<img class="attachment-post-thumbnail wp-post-image" src="'.$image[0].'" title="'.get_the_title().'" alt="'.get_the_title().'" height="'.$image[2].'" width="'.$image[1].'"/>'; ?></p>
					</div>
					<?php socialWarfare(); ?>
					<!--
					<div class="garment-mini-contain">
						<div class="garment-mini"><p><img src="<?php // echo $thumbNailOne['url']; ?>" alt="" title="" /></p></div>
						<div class="garment-mini"><p><img src="<?php  echo (isset($thumbNailOne['url']) ? $thumbNailOne['url'] : ""); ?>" alt="" title="" /></p></div>
						<div class="garment-mini"><p><img src="<?php // echo $thumbNailTwo['url']; ?>" alt="" title="" /></p></div>
						<div class="garment-mini"><p><img src="<?php  echo (isset($thumbNailTwo['url']) ? $thumbNailTwo['url'] : ""); ?>" alt="" title="" /></p></div>
						<div class="garment-mini"><p><img src="<?php // echo $thumbNailThree['url']; ?>" alt="" title="" /></p></div>
						<div class="garment-mini"><p><img src="<?php  echo (isset($thumbNailThree['url']) ? $thumbNailThree['url'] : ""); ?>" alt="" title="" /></p></div>
					</div> -->
					<?php 
					// Get the colors for this garment page
						$colors = get_post_meta($post->ID, 'ncCheckboxList', false);
					?>
					<div class="show-colors" data-postid="<?php echo $post->ID; ?>" data-displayoption="<?php echo $displayColors; ?>">
						<h3 class="colorsHeader">Colors</h3>
						<p class="colorsDescription">There are <?php echo count($colors); ?> colors available</p>
						<div class="clearfix"></div>
						<?php 
						
						// Get the manufacturer of this particular garment
						$manufacturer = get_post_meta($post->ID, 'manufacturer', true);
						
						// Sort the master color list into an array that we can reference for output
						switch_to_blog(1);
						$data = get_option('impact-options'); 
						foreach ($data['re_'] as $thisOne) : 
							$masterColors[$thisOne['colorName']] = $thisOne;
						endforeach;
						restore_current_blog();			
						
						// Cycle through the colors and output them to the screen
						foreach ($colors as $thisOne):
							echo '<div class="colorOption" data-label="'.$masterColors[$thisOne]['colorName'].'">';
							echo '<div class="colorCircle" style="background:#'.$masterColors[$thisOne]['colorCode'].'"></div>';
							echo '<div class="colorLabel">'.$masterColors[$thisOne]['colorName'].'</div>';
							echo '</div>';
						endforeach;
						
						$fit['junior'] = 'Junior Sizing';
						$fit['womens'] = 'Women\'s Cut';
						$fit['slim'] = 'Slim Fit';
						$fit['generous'] = 'Generous Cut';
						$fit['true'] = 'True to Size';
						
						?>
						<!-- <p><img src="/wp-content/themes/impactshirts/images/colors.jpg" alt="" title="" /></p> -->
						<div class="clearfix"></div>
					</div>
					<?php if($tableID): ?>
					<div class="show-table">
                    	<?php echo do_shortcode('[table id='.$tableID.'/]'); ?>
					</div>
					<?php endif; ?>
					<?php if($table2ID): ?>
					<div class="show-table">
						<?php echo do_shortcode('[table id='.$table2ID.'/]');  ?>
					</div>
					<?php endif; ?>
					<div class="caps">
						talk to a real person<br/>
						<span class="head-phone"><?php echo $data['phoneNumber']; ?></span><br/>
						here to help from 9am-5pm pst<br/>
						monday-friday
					</div>
				</div>
				
				<div class="col-460 grid fit">
					<div class="show-back">
					<?php if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'],'garment-category') !== false ): ?>
						<p><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><span style="color:#0971A8;margin-right:10px"><i class="fa fa-chevron-left fa-lg"></i></span>Back to Garments</a></p>
					<?php else: ?>
						<p><a href="/garment-category/all/"><span style="color:#0971A8;margin-right:10px"><i class="fa fa-chevron-left fa-lg"></i></span>Back to Garments</a></p>
					<?php endif; ?>
					</div>
				<div class="garment-details">
						<?php showCalendar(); ?>
						<h3><?php the_title(); ?></h3>
						<p><?php // the_content(); ?></p>
						<h4>Description</h4>
						<p><span class="thisIsTheNumber"><?php echo get_post_meta($post->ID, 'ncGarmentNumber', true); ?></span>: <?php echo get_post_meta($post->ID, 'ncdescription', true); ?></p>
						<h4>Sizes</h4>
						<p><?php echo get_post_meta($post->ID, 'ncsizes', true); ?></p>
						<h4>Fit</h4>
						<p><?php echo $fit[get_post_meta($post->ID, 'fit', true)]; ?></p>
						<?php
							$postObjects = get_field('related_products');
							if($postObjects):
								echo '<h4>Related Products</h4>';
								$count = 1;
								foreach ($postObjects as $postObject):
									if($count > 1) echo ', ';
									$url = get_permalink($postObject->ID);
									echo '<a href="'.$url.'">'.$postObject->post_title.'</a>';
									$count++;
								endforeach;
							endif;
						?>
						<h4>Features</h4>
						<ul>
						<?php $features = get_post_meta($post->ID, 'ncre_', false); $features = $features[0];
						
							foreach($features as $feature):
								echo '<li>'.$feature['ncfeatures'].'</li>';
							endforeach;
						?>
						</ul>
					</div>						
					<div class="show-contact">
						<h3>Get A Quote</h3>
						<div><?php echo do_shortcode('[gravityform id="5" name="Request a Free Mockup - Garment" title="false" description="false"]'); ?></div>
					</div>
				</div>
				<!-- end of .post-entry -->


				<?php impactshirts_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php impactshirts_entry_after(); ?>


		<?php
		endwhile;

		get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content -->

<?php get_footer(); ?>