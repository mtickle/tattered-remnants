<?php
get_header(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('grid__item error-404 not-found'); ?>>
	<strong style="font-size: 9rem;"><?php _e( '404', 'visual-coffee' ); ?></strong>

	<header class="page-header">
		<h2 class="page-title"><?php _e( '404 - Page not found', 'visual-coffee' ); ?></h2>
	</header><!-- .page-header -->

	<div class="entry-content">
		<div class="clearfix"></div>
		<p><?php _e( 'It looks like nothing was found at this location. Maybe search will help.', 'visual-coffee' ); ?></p>
		<div class="clearfix"><br><br></div>

		<?php get_search_form(); ?>

		<div class="clearfix"><br><br></div>
	</div>
</article>

<?php get_footer(); ?>
