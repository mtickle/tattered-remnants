<div class="grid__item">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<a href="<?php the_permalink(); ?>" class="entry-thumbnail">
            <?php echo get_the_post_thumbnail(null, 'large' ); ?>
		</a>

		<header class="entry-header">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php the_title( sprintf( '<h2 class="entry-title"><span>', esc_url( get_permalink() ) ), '</span></h2>' ); ?>
			</a>
		</header>

        <div class="entry-content">
			<?php the_excerpt(); ?>

			<?php wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'visual-coffee' ),
					'after'  => '</div>',
				)
			);
			?>
        </div>

		<footer>
			<?php visualcoffee_posted_on(); ?>
		</footer>
	</article>
</div>
