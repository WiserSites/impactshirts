<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Archive Template
 *
 *
 * @file           archive.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1
 * @filesource     wp-content/themes/impactshirts/archive.php
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28archive.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>

<div id="content-archive" class="<?php echo implode( ' ', impactshirts_get_content_classes() ); ?>"><!-- archive -->

	<?php 
	
		// Setup the page that we're on
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
		// Setup the query arguments
		$args = array(
			'posts_per_page' => 10,
			'paged' => $paged,
			'nopaging' => false,
			'posts_per_archive_page' => 10,
			'show_posts' => 10,
		);
	
		// Query for the posts
		// query_posts(  $args );
		
		// If we have posts proceed...
		if(have_posts()):

		// Build the container and output each post
		echo '<div class="homePageBlogPosts">';
		while( have_posts() ) : the_post();
			echo '<article class="modularBlogPosts">';
			echo '<a href="'.get_the_permalink().'">';
			the_post_thumbnail( 'medium', array( 'class' => 'alignleft' ) );
			echo '</a>';
			echo '<h2 class="entry-title post-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';
			echo '<p>'.nc_the_excerpt('Read more &raquo;', 125, 1).'</p>';
			echo '</article>';
			echo '<div class="clearfix"></div>';
			
		endwhile;

		$navArgs = array(
			'end_size' 	=> 0,
			'mid_size' 	=> 8,
			'type'		=> 'list'
		);

		echo paginate_links( $navArgs );

		get_template_part( 'loop-nav' );
		
		
		echo '</div>';

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content-archive -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
