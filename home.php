<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Blog Template
 *
 * @file           home.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2015 - 2016 WiserSites
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/impactshirts/home.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */

get_header();

global $more;
$more = 0;
?>

	<div id="content-blog" class="<?php echo implode( ' ', impactshirts_get_content_classes() ); ?>">

		<!-- Blog page title -->
		<?php if( impactshirts_free_get_option( 'blog_post_title_toggle' ) ) { ?>
			<h1> <?php echo impactshirts_free_get_option( 'blog_post_title_text' ); ?> </h1>
		<?php } ?>

		<?php get_template_part( 'loop-header' ); ?>

		<?php if( have_posts() ) : ?>

			<?php while( have_posts() ) : the_post(); ?>

				<?php impactshirts_entry_before(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php impactshirts_entry_top(); ?>

					<?php get_template_part( 'post-meta' ); ?>
                    
					<div class="post-entry">
						<?php if( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php the_post_thumbnail(); ?>
							</a>
						<?php endif; ?>
						<?php the_content( __( 'Read more &#8250;', 'impactshirts' ) ); ?>
						<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'impactshirts' ), 'after' => '</div>' ) ); ?>
					</div>
					<!-- end of .post-entry -->

					<?php get_template_part( 'post-data' ); ?>

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

	</div><!-- end of #content-blog -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>