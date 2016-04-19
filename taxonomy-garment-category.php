<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Category Landing Page
 *
 *
 * @file           taxonomy.php
 * @package        Impact Shirts
 * @author         Jason T. Wiser
 * @copyright      2014 Webination Station
 * @license        license.txt
 * @version        Release: 1.0
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */

get_header();

$term 			= get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );  
$image 			= get_tax_meta($term->term_id,'categoryImage');
$headerTitle 	= get_tax_meta($term->term_id,'categoryHeader');
$smallTitle 	= get_tax_meta($term->term_id,'categorySmallTitle');
$description 	= get_tax_meta($term->term_id,'categoryDescription');
$data = get_option('impact-options');
?>

<div id="content-full" class="grid col-940"><!-- taxonomy.php -->
	<div class="category-slider">
	<?php
	// If all the SEO texts have been filled in:
	if($headerTitle && $smallTitle && $description):
		echo '<div class="categoryHeaderSection">';
		echo '<h1>'.$headerTitle.'</h1>';
		echo '<div class="grid col-700">';
		if($image):
			echo '<img class="catBannerImg" src="'.$image.'" />';
		else:
			echo '<img class="catBannerImg" src="'.$data['defaultGarmentBanner']['src'].'" />';
		endif;
		echo '</div>';
		echo '<div class="grid col-220 fit" style="background-color:#ddd">';
		echo '<h3>'.$smallTitle.'</h3>';
		echo '<p>'.$description.'</p>';
		echo '</div>';
		echo '</div>';

	// If all the SEO texts have NOT been filled in:
	else:
		if($image):
			echo '<img class="catBannerImg" src="'.$image.'" />';
		else:
			echo '<img class="catBannerImg" src="'.$data['defaultGarmentBanner']['src'].'" />';
		endif;
	endif;
	?>
	</div>
	<div class="clearfix"></div>
	
	<?php 
		global $query_string;
		query_posts( $query_string . '&posts_per_page='.$data['pagiGarments'] );
		if( have_posts() ) : 
		
		//list terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)

		$taxonomy     = 'garment-category';
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
		?>
		<div class="cat-list">
			<ul>
			<?php wp_list_categories( $args ); ?>
			</ul>
		</div>
		
			<?php impactshirts_entry_before(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php impactshirts_entry_top(); ?>
				<div class="cat-gallery">
					<ul>
						<?php $post_counter = 0; ?>
						<?php while( have_posts() ) : the_post(); ?>
						<?php $post_counter++; ?>
						<?php 
							$featuredImage = get_the_post_thumbnail();
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
							$itemNumber = get_post_meta($post->ID, 'ncGarmentNumber', true);
						?>
						<li class="grid col-220 <?php if( $post_counter == 4 ){ echo 'fit'; $post_counter = 0; } else { } ?>">
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
									<a href="<?php the_permalink() ?>">
										<ul>
											<li class="item-number-gc"><p><?php echo $itemNumber ?></p></li>
											<li class="item-view-gc"><p>View</p></li>
										</ul>
									</a>
								</li>
							</ul>
						</li>
						<?php endwhile; ?>
					</ul>
				</div>
				<!-- end of .post-entry -->

				<?php impactshirts_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php impactshirts_entry_after(); ?>

		<?php


		$args = array(
			'end_size' 	=> 0,
			'mid_size' 	=>5,
			'type'		=> 'list'
		);

		echo paginate_links( $args );
		// get_template_part( 'loop-nav' );

	else :
	
		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content-full -->

<?php get_footer(); ?>
