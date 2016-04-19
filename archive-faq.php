<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}
 
get_header(); ?>

<div id="content" class="<?php echo implode( ' ', impactshirts_get_content_classes() ); ?>"><!-- single.php -->

<?php get_template_part( 'loop-header' ); ?>
<h2>Frequently Asked Questions</h2>
<hr />
<p>&nbsp;</p>
<?php 

	
	
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'faq'
		);
		$q = new WP_Query( $args );
	
		if( $q->have_posts() ) :
			while( $q->have_posts() ) : 
				$q->the_post();
				echo '<h3 class="faqTitle" data-label="'.get_the_ID().'">'.get_the_title().'</h3>';
				echo '<div class="faqContent" data-label="'.get_the_ID().'">';
				the_content();
				echo '</div>';
				echo '<hr />';
			endwhile;
		endif;
	 ?>


</div><!-- end of #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>