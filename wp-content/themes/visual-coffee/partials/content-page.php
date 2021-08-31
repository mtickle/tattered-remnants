<article id="post-<?php the_ID(); ?>" <?php post_class('grid__item'); ?>>
    <header class="entry-header">
        <?php visualcoffee_posted_cat(); ?>
        <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
    </header>

    <div class="entry-content">
        <div class="entry-thumbnail-single">
            <?php the_post_thumbnail( 'full' ); ?>
        </div>

        <?php the_content(); ?>

        <?php
        wp_link_pages( array(
            'before' => '<div class="page-links">' . __( 'Pages:', 'visual-coffee' ),
            'after'  => '</div>',
        ) ); ?>
    </div>
</article>