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

	<div class="full_image_outer no_page">
    	<div class="full_image_inner">
        	<div class="grid col-940 nomargin">
        		<h2 class="full_image_title"><b>Page not available. But Josh is.</b></h2>
            </div>
            <div class="grid col-940 search_recs">
                <p>Josh is a <?php bloginfo('name'); ?> designer who loves sans serif fonts and fast Macs.</p>
                <p><b>Or if you prefer, you can search for designs here.</b></p>
            </div>
            <div class="clearfix"></div>
            <div class="search_page_form">
            	<div class="widget-wrapper"><?php get_search_form(); ?></div>
            </div>
            <?php // display_search_terms(); ?>
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







get_footer(); ?>
