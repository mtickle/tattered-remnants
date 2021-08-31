<?php
/**
 * Template part for displaying Hero Content
 *
 * @package JetBlack
 */

$jetblack_playlist_type = jetblack_gtm( 'jetblack_playlist_type' );

if ( jetblack_gtm( 'jetblack_playlist_page' ) ) {
	$jetblack_args = array(
		'page_id' => absint( jetblack_gtm( 'jetblack_playlist_page' ) ),
	);
} elseif ( 'post' === $jetblack_playlist_type && jetblack_gtm( 'jetblack_playlist_post' ) ) {
	$jetblack_args = array(
		'p' => absint( jetblack_gtm( 'jetblack_playlist_post' ) ),
	);
}

// If $jetblack_args is empty return false
if ( empty( $jetblack_args ) ) {
	return;
}

$jetblack_args['posts_per_page'] = 1;

$jetblack_loop = new WP_Query( $jetblack_args );

while ( $jetblack_loop->have_posts() ) :
	$jetblack_loop->the_post();

	$subtitle      = jetblack_gtm( 'jetblack_playlist_custom_subtitle' );
	?>

	<div id="playlist-section" class="playlist-section dark-background section content-position-right default">
		<div class="section-featured-page">
			<div class="container">
				<div class="row">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="ff-grid-6 featured-page-thumb">
						<?php the_post_thumbnail( 'jetblack-hero', array( 'class' => 'alignnone' ) );?>
					</div>
					<?php endif; ?>

					<!-- .ff-grid-6 -->
					<div class="ff-grid-6 featured-page-content">
						<div class="featured-page-section">
							<div class="section-title-wrap">
								<?php if ( $subtitle ) : ?>
								<p class="section-top-subtitle"><?php echo esc_html( $subtitle ); ?></p>
								<?php endif; ?>

								<?php the_title( '<h2 class="section-title">', '</h2>' ); ?>

								<span class="divider"></span>
							</div>

							<div class="featured-info">
								<?php the_content(); ?>
							</div><!-- .featured-info -->
						</div><!-- .featured-page-section -->
					</div><!-- .ff-grid-6 -->
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .section-featured-page -->
	</div><!-- .section -->
<?php
endwhile;

wp_reset_postdata();
