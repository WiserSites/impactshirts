<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sidebar/Content Template
 *
Template Name:  Sidebar/Content
 *
 * @file           sidebar-content-page.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2015 - 2016 WiserSites
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/impactshirts/sidebar-content-page.php
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */
?>
<?php get_header(); ?>

<div id="content" class="grid-right col-620 fit">

	<?php if ( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php get_impactshirts_breadcrumb_lists(); ?>

			<?php impactshirts_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php impactshirts_entry_top(); ?>

				<h1 class="post-title"><?php the_title(); ?></h1>

				<?php if ( comments_open() ) : ?>
					<div class="post-meta">
						<?php impactshirts_post_meta_data(); ?>

						<?php if ( comments_open() ) : ?>
							<span class="comments-link">
                        <span class="mdash">&mdash;</span>
								<?php comments_popup_link( __( 'No Comments &darr;', 'impactshirts' ), __( '1 Comment &darr;', 'impactshirts' ), __( '% Comments &darr;', 'impactshirts' ) ); ?>
                        </span>
						<?php endif; ?>
					</div><!-- end of .post-meta -->
				<?php endif; ?>

				<div class="post-entry">
					<?php the_content( __( 'Read more &#8250;', 'impactshirts' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'impactshirts' ), 'after' => '</div>' ) ); ?>
				</div>
				<!-- end of .post-entry -->

				<?php if ( comments_open() ) : ?>
					<div class="post-data">
						<?php the_tags( __( 'Tagged with:', 'impactshirts' ) . ' ', ', ', '<br />' ); ?>
						<?php the_category( __( 'Posted in %s', 'impactshirts' ) . ', ' ); ?>
					</div><!-- end of .post-data -->
				<?php endif; ?>

				<div class="post-edit"><?php edit_post_link( __( 'Edit', 'impactshirts' ) ); ?></div>

				<?php impactshirts_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php impactshirts_entry_after(); ?>

			<?php impactshirts_comments_before(); ?>
			<?php comments_template( '', true ); ?>
			<?php impactshirts_comments_after(); ?>

		<?php
		endwhile;

		get_template_part( 'loop-nav', get_post_type() );

	else :

		get_template_part( 'loop-no-posts', get_post_type() );

	endif;
	?>

</div><!-- end of #content -->

<?php get_sidebar( 'left' ); ?>
<?php get_footer(); ?>