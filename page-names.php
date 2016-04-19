<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
Template Name: Youth Group Names
 */

get_header(); ?>

<div id="content-full" class="grid col-960"><!-- taxonomy.php -->
	<div class="category-slider">
	<?php
	$image = get_post_meta($post->ID, 'ncImage', true);
 	if($image):
		echo '<img class="catBannerImg" src="'.$image['url'].'" />';
	else:
		echo '<img class="catBannerImg" src="'.$data['defaultDesignBanner']['src'].'" />';
	endif;
	?>
	</div>
</div>
<div class="grid col-460 youthGroupNames">
	
	<div class="clearfix"></div>
	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php // get_template_part( 'loop-header' ); ?>

			<?php impactshirts_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php impactshirts_entry_top(); ?>

				<?php get_template_part( 'post-meta-page' ); ?>

				<?php
					$topText = get_post_meta($post->ID, 'ncTopText', true);
					echo '<p>'.$topText.'</p>';
				?>
				<div class="post-entry">
					<?php $groups = get_post_meta($post->ID, 'ncGroups', true); 
						array_multisort($groups);
						foreach($groups as $group):
							echo '<h4>'.$group['ncGroupName'].'</h4><p>'.$group['ncSubtitle'].'</p>';
						endforeach;
					
					?>
					<?php // the_content( __( 'Read more &#8250;', 'impactshirts' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'impactshirts' ), 'after' => '</div>' ) ); ?>
				</div>
				<div class="clearfix"></div>
		<div class="show-contact">
		<?php
			echo '<div>'. do_shortcode('[gravityform id="2" name="Youth Group Names" title="false" description="false"]') .'</div>';
		?>
	</div>
				<!-- end of .post-entry -->

				<?php get_template_part( 'post-data' ); ?>

				<?php impactshirts_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php impactshirts_entry_after(); ?>

			<?php impactshirts_comments_before(); ?>
			<?php comments_template( '', true ); ?>
			<?php impactshirts_comments_after(); ?>

		<?php
		endwhile;

		get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content -->
<div class="grid col-460 fit">
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php impactshirts_entry_top(); ?>
				<?php
				$args = array(
				'posts_per_page' => -1,
				'post_type' => 'design',
				'tax_query' => array(
					array(
						'taxonomy' => 'design-category',
						'field'    => 'slug',
						'terms'    => 'youth-group-t-shirt-designs',
					)
				),
			);
			$q = new WP_Query( $args ); ?>
				
				<div class="cat-gallery">
					<ul>
						<?php $post_counter = 0; ?>
						<?php 
							
							while( $q->have_posts() ) : 
							$q->the_post(); ?>
						<?php $post_counter++; ?>
						<?php 
							$featuredImage = get_the_post_thumbnail();
							$itemNumber = get_post_meta($post->ID, 'ncDesignNumber', true);
						?>
						<li class="grid col-460 <?php if( $post_counter == 2 ){ echo 'fit'; $post_counter = 0; } else { } ?>">
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
                                    <?php
										$title = get_the_title();
										$title = strlen($title) > 27 ? substr($title,0,27) : $title;
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
				<!-- end of .post-entry -->
</div>
<?php get_footer(); ?>
