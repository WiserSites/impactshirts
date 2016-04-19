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

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );  
$data = get_tax_meta($term->term_id,'categoryImage');
?>

<div id="content-full" class="grid col-940"><!-- taxonomy.php -->
	<div class="category-slider">
	<?php
 	if($data):
		echo '<img class="catBannerImg" src="'.$data.'" />';
	else:
		echo '<img class="catBannerImg" src="/wp-content/themes/impactshirts/images/defaultImage.jpg" />';
	endif;
	?>
	</div>
	<div class="clearfix"></div>
	
	<?php if( have_posts() ) : ?>
	
		<?php 
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
							$itemNumber = get_field('design_number');
						?>
						<li class="grid col-220 <?php if( $post_counter == 4 ){ echo 'fit'; $post_counter = 0; } else { } ?>">
							<ul>

								<li>
									<a href="<?php the_permalink() ?>"><?php 
									if ( 1 ) { // check if the post has a Post Thumbnail assigned to it.
									  echo $featuredImage;
									} 
									?></a>
								</li>
								<li class="item">
									<a href="<?php the_permalink() ?>">
										<ul>
											<li class="item-number"><p><?php echo $itemNumber ?></p></li>
											<li class="item-view"><p>View</p></li>
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


		get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content-full -->

<?php get_footer(); ?>
