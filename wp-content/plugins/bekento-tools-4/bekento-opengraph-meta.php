<?php

// Social OpenGraph

function bekento_opengraph_meta() {
	global $post;
	if (is_singular()) {
		echo '<meta property="og:title" content="' . get_the_title() . '"/>';
		echo '<meta property="og:type" content="article"/>';
		echo '<meta property="og:url" content="' . get_permalink() . '"/>';
		if(has_post_thumbnail($post->ID)) {
			$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
			echo '<meta property="og:image" content="'.esc_attr($thumbnail_src[0]).'"/>';
		}
	}
	$colors = call_user_func(get_template().'_api_color_scheme');
	if(is_array($colors)) {
		echo '<meta name="theme-color" content="'.$colors[0].'">';
	}
	
}
add_action('wp_head', 'bekento_opengraph_meta');