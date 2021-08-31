<?php

// Display blog post date

function visualcoffee_posted_on( $args = array() ) {

	$time_string   = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	$time_string_1 = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	$time_string_2 = '<time class="updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'd M Y' ) )
	);

	$time_string_1 = sprintf(
		$time_string_1,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'd M Y' ) )
	);

	$time_string_2 = sprintf(
		$time_string_2,
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date( 'd M Y' ) )
	);

	$posted_on = sprintf(
		esc_html( '%s', 'post date', 'visual-coffee' ),
		'<a href="' . esc_url( get_permalink() ) . '">' . $time_string_1 . '</a>'
	);

	$updated_on = sprintf(
		esc_html( '%s', 'post date', 'visual-coffee' ),
		'<a href="' . esc_url( get_permalink() ) . '">' . $time_string_2 . '</a>'
	);

	$postedupdated_on = sprintf(
		esc_html( '%s', 'post date', 'visual-coffee' ),
		'<a href="' . esc_url( get_permalink() ) . '">' . $time_string . '</a>'
	);

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		echo '<div class="posted-on">' . _x( 'Published on', 'visual-coffee' ) . ' ' . $posted_on . ' ' . _x( '— Last update', 'visual-coffee' ) . ' ' . $updated_on . '</div>';
	} else {
		echo '<div class="posted-on">' . _x( 'Published on', 'visual-coffee' ) . ' ' . $postedupdated_on . '</div>';
	}
}

// Single page entry footer

if ( ! function_exists( 'visualcoffee_entry_footer' ) ) {
	function visualcoffee_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			// translators: used between list items, there is a space after the comma
			$tags_list = get_the_tag_list( '', ' ' );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( ' Tagged %1$s', 'visual-coffee' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'visual-coffee' ), esc_html__( '1 Comment', 'visual-coffee' ), esc_html__( '% Comments', 'visual-coffee' ) );
			echo '</span>';
		}
	}
}

// Post author

if ( ! function_exists( 'visualcoffee_posted_by' ) ) {
	function visualcoffee_posted_by() {
		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'visual-coffee' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline">' . $byline . '</span>'; // WPCS: XSS OK.

	}
}

// Post date

if ( ! function_exists( 'visualcoffee_posted_on' ) ) {
	function visualcoffee_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date( 'd M' ) ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date( 'd M' ) )
		);

		echo '<span class="posted-on">' . $time_string . '</span>'; // WPCS: XSS OK.
	}
}

// Post category

if ( ! function_exists( 'visualcoffee_posted_cat' ) ) {
	function visualcoffee_posted_cat() {
		foreach ( ( get_the_category() ) as $category ) {
			echo '<a href="' . esc_url( get_category_link( $category ) ) . '" class="category-name">' . esc_html( $category->cat_name ) . '</a> ';
		}
	}
}
