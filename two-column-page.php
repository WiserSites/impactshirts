<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
Template Name: Two Column Template
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
<div class="grid col-540">
	<div class="clearfix"></div>

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'loop-header' ); ?>

			<?php impactshirts_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php impactshirts_entry_top(); ?>

				<?php get_template_part( 'post-meta-page' ); ?>

				<div class="post-entry">
					<?php the_content( __( 'Read more &#8250;', 'impactshirts' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'impactshirts' ), 'after' => '</div>' ) ); ?>
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
	$tableID = get_post_meta($post->ID, 'ncContactForm', true);
	?>

</div><!-- end of #content -->
<div class="grid col-380 fit">
	<div class="show-contact">
		<h3>Get in touch with us</h3>
		<?php
		if($tableID):
			echo '<div>'. do_shortcode('[gravityform id="'.$tableID.'" name="Contact Us" title="false" description="false"]') .'</div>';
		else:
			echo '<div>'. do_shortcode('[gravityform id="3" name="Contact Us" title="false" description="false"]') .'</div>';
		endif;
		?>
	</div>
</div>
<?php get_footer(); ?>
