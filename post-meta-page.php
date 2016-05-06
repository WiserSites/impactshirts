<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Page Meta-Data Template-Part File
 *
 * @file           post-meta-page.php
 * @package        Impactshirts
 * @author         Emil Uzelac
 * @copyright      2015 - 2016 WiserSites
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/impactshirts/post-meta-page.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
?>

	<h1 class="entry-title post-title"><?php the_title(); ?></h1>

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