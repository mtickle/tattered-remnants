<?php

// Social Share

function bekento_social_share() {

	global $post;

	$url = get_permalink();
	$post_title = get_the_title();

	?>
	<div class='post-share'>
		<div class='share-buttons'>
			<div><a target='_blank' rel='nofollow' href='http://www.facebook.com/sharer.php?u=<?php echo urlencode($url); ?>'><i class='fab fa-facebook-f'></i></a></div>
			<div><a target='_blank' rel='nofollow' href='https://twitter.com/share?text=<?php echo urlencode($post_title);?>&amp;url=<?php echo urlencode($url); ?>'><i class='fab fa-twitter'></i></a></div>
			<div><a target='_blank' rel='nofollow' href='https://pinterest.com/pin/create/bookmarklet/?media=<?php the_post_thumbnail_url(); ?>&amp;url=<?php echo urlencode($url); ?>'><i class='fab fa-pinterest'></i></a></div>
			<?php if(function_exists('bekento_pig_url')) {?>
				<div><a target='_blank' rel='nofollow' href='<?php echo bekento_pig_url(get_the_ID()); ?>'><i class='far fa-image'></i></a></div>
			<?php } ?>
			<div class='callout'><span><?php esc_html_e('Share this', 'bekento'); ?></span></div>
		</div>
	</div>
	<?php
}