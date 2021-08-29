<?php

function bekento_calc_mtr($post_id) {

	$content = get_post_field('post_content', $post_id, 'display');
	$word_count = str_word_count(strip_tags($content));
	$mtr_raw = ($word_count / 180);
	$mtr = round($mtr_raw);

	set_transient($post_id . '-bekento-mtr',
		array(
			'value' => $mtr,
			'time' => time(),
		), 0);

	return $mtr;
}

function bekento_get_mtr($post_id) {
	$transient = get_transient($post_id . '-bekento-mtr');

	if (false === $transient) {
		$mtr = bekento_calc_mtr($post_id);
	} else {
			// Recalculating if edited
		if(get_the_modified_time('U', $post_id) > $transient['time'] ) {
			$mtr = bekento_calc_mtr($post_id);
		} else {
			$mtr = $transient['value'];
		}
	}
	return $mtr;
}