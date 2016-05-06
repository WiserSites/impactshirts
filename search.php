<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Search Template
 *
 *
 * @file           search.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2015 - 2016 WiserSites
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/impactshirts/search.php
 * @link           http://codex.wordpress.org/Theme_Development#Search_Results_.28search.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>



	<?php 
	
	global $query_string;
	$s_results = query_posts( $query_string . '&posts_per_page=20' );
	if( get_current_user_id() == 1 && false ){
		//restore_current_blog();
		$s_query = $query_string . '&posts_per_page=20&post_type=any';
		/*$q1 = get_posts(array(
			'post_type' => 'any',
			's' => get_search_query()
		));
		$q2 = get_posts(array(
			'post_type' => 'any',
			'meta_query' => array(
				array(
					'key' => 'ncDesignNumber',
					'value' => get_search_query(),
					'compare' => 'LIKE'
				)
			)
		));
		$s_results = array_merge( $q1, $q2 );*/

		echo '<br><br><br> start <br><br><br>';
		//$s_results = get_posts( $s_query );
		global $wpdb; echo $wpdb->posts;
		i_print( $s_results );
	}
	
	if( have_posts() ) : ?>


	<div class="full_image_outer">
    	<div class="full_image_inner">
        	<div class="grid col-940 nomargin">
        		<h2 class="full_image_title">Showing search results for <b><?php echo get_search_query(); ?></b></h2>
            </div>
            <div class="grid col-940 search_recs">
                <div class="rec_simpler">
                    Refine your search.
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="search_page_form">
            	<div class="widget-wrapper"><?php get_search_form(); ?></div>
            </div>
            <?php display_search_terms(); ?>
            <div class="clearfix"></div>
        </div>
    </div>

<?php
		echo '<div id="wrapper" class="clearfix">';
		echo '<div id="content-search" class="grid col-940" style="text-align:center;">';
 
		// get_template_part( 'loop-header' ); ?>

				<div class="cat-gallery">
					<ul>
						<?php 
							$post_counter = 0;
							while( have_posts() ) : 
							the_post(); 
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
        
        <?php
        $args = array(
			'end_size' 	=> 0,
			'mid_size' 	=>5,
			'type'		=> 'list'
		);

		echo paginate_links( $args );

		echo '</div>';
		echo '</div>';

	// If we don't have any matches
	else : ?>

	<div class="full_image_outer">
    	<div class="full_image_inner">
        	<div class="grid col-940 nomargin">
        		<h2 class="full_image_title">Sorry, we couldn't find any matches for <b><?php echo get_search_query(); ?></b></h2>
            </div>
            <div class="grid col-940 search_recs">
                <div class="rec_spelling">
             		Make sure the spelling is correct.
                </div>
                <div class="rec_simpler">
                    Try using a simpler search.
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="search_page_form">
            	<div class="widget-wrapper"><?php get_search_form(); ?></div>
            </div>
            <?php display_search_terms(); ?>
            <div class="clearfix"></div>
        </div>
    </div>
    
    
    
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


	endif;
	?>

</div><!-- end of #content-search -->

<?php get_footer(); ?>
