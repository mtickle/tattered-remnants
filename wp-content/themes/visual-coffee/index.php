<?php
get_header(); ?>

<?php
if ( have_posts() ) :

	while ( have_posts() ) : the_post();
		get_template_part( 'partials/content', get_post_format() );
	endwhile;

	the_posts_pagination();

else :
	get_template_part( 'partials/content', 'none' );
endif; ?>

<?php
get_footer();