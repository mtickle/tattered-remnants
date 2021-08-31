<?php

function bekento_load_wp_media_files() {
	wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'bekento_load_wp_media_files');

function bekento_taxonomy_edit_meta_field($term) {

	wp_enqueue_media();

	// Getting colors from theme
	$bekento_colors_available = '';
	$bekento_category_color = '';
	$bekento_category_image = '';
	if(function_exists(get_template().'_api_color_scheme')) {
		$colors = call_user_func(get_template().'_api_color_scheme');
		if(is_array($colors)) {
			$bekento_colors_available = '<br/>'.esc_html__('Current color scheme:', 'bekento').' ';
			$bekento_category_color = $colors[array_rand($colors)];
			foreach ($colors as $value) {
				$bekento_colors_available .= '<code style="background-color: '.$value.'; color: #fff; padding: 5px; border-radius: 6px;">'.$value.'</code>';
			}
		}
	}

	if(isset($term->term_id)) {
		$t_id = $term->term_id;
		// retrieve the existing value(s) for this meta field. This returns an array
		$term_meta = get_option("taxonomy_".$t_id);
		// Checking if set
		if($term_meta['bekento_category_color']) {
			$bekento_category_color = $term_meta['bekento_category_color'];
		} else {
			// Not set, trying transient
			$bekento_category_color = get_transient('bekento_category_color_'.$t_id.'');
		}
		if($term_meta['bekento_category_image']) {
			$bekento_category_image = $term_meta['bekento_category_image'];
		}
	}


	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[bekento_category_color]"><?php esc_html_e('Category Color', 'bekento'); ?></label></th>
		<td>
			<input type="color" name="term_meta[bekento_category_color]" id="term_meta[bekento_category_color]" style="width: 65px; height: 30px;" value="<?php echo $bekento_category_color; ?>"/> <?php echo $bekento_colors_available; ?>
			<br/><br/>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[bekento_category_image]"><?php esc_html_e('Category Image URL', 'bekento'); ?></label></th>
		<td>
			<input type="text" name="term_meta[bekento_category_image]" class='bekento-input-img' id="term_meta[bekento_category_image]" value="<?php echo $bekento_category_image; ?>"/> <button class='button bekento-upload-btn'><?php esc_html_e('Select / Upload Image', 'bekento'); ?></button>
			<br/><br/>
		</td>
	</tr>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$('.bekento-upload-btn').click(function(e) {
				e.preventDefault();
				var image = wp.media({ 
					title: 'Upload Image',
					// mutiple: true if you want to upload multiple files at once
					multiple: false
					}).open().on('select', function(e){
					// This will return the selected image from the Media Uploader, the result is an object
					var uploaded_image = image.state().get('selection').first();
					// We convert uploaded_image to a JSON object to make accessing it easier
					// Output to the console uploaded_image
					console.log(uploaded_image);
					var image_url = uploaded_image.toJSON().url;
					// Let's assign the url value to the input field
					$('.bekento-input-img').val(image_url);
				});
			});
		});
	</script>
<?php
}
add_action('category_edit_form_fields', 'bekento_taxonomy_edit_meta_field', 10, 2);
add_action('category_add_form_fields', 'bekento_taxonomy_edit_meta_field', 10, 2);

// CATEGORY: Saving

add_action('edited_category', 'bekento_save_taxonomy_custom_meta', 10, 2);
add_action('create_category', 'bekento_save_taxonomy_custom_meta', 10, 2);

function bekento_save_taxonomy_custom_meta($term_id) {
	if(isset($_POST['term_meta'])) {
		$t_id = $term_id;
		$term_meta = get_option("taxonomy_".$t_id);
		$cat_keys = array_keys($_POST['term_meta']);
		foreach ($cat_keys as $key) {
			if (isset($_POST['term_meta'][$key])) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option('taxonomy_'.$t_id, $term_meta);
	}
}

// CATEGORY: Get Option

function bekento_category_color($t_id) {
	$cat_data = get_option("taxonomy_".$t_id);
	$option = '';
	if(isset($cat_data['bekento_category_color'])) {
		$option = $cat_data['bekento_category_color'];
	} else {
		// Get Temporary color from transient
		$category_color_transient = get_transient('bekento_category_color_'.$t_id.'');
		if($category_color_transient) {
			// Transient set
			$option = $category_color_transient;
		} else {
			// New Installation Setting Transient
			if(function_exists(get_template().'_api_color_scheme')) {
				$colors = call_user_func(get_template().'_api_color_scheme');
				if(is_array($colors)) {
					set_transient('bekento_category_color_'.$t_id.'', $colors[array_rand($colors)]);
				}
			}
		}
	}
	return esc_attr($option);
}

function bekento_category_image($t_id) {
	$cat_data = get_option("taxonomy_".$t_id);
	$option = '';
	if(isset($cat_data['bekento_category_image'])) {
		if($cat_data['bekento_category_image'] !== '') {
			$option = $cat_data['bekento_category_image'];
		}	else {
			$option = bekento_category_post_image($t_id);
		}
	} else {
		$option = bekento_category_post_image($t_id);
	}
	
	return esc_attr($option);
}

function bekento_category_post_image($t_id) {
	$args = array(
			'posts_per_page' => 1, // we need only the latest post, so get that post only
			'cat' => $t_id, // Use the category id, can also replace with category_name which uses category slug
			//'category_name' => 'SLUG OF FOO CATEGORY,
		);
	$q = new WP_Query($args);

	if($q->have_posts()) {
		while($q->have_posts()) {
			$q->the_post();
			$post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
			$option = $post_thumb[0];
		}
		wp_reset_postdata();
	}
	return $option;
}

// Clearing temporary category colors

function bekento_clear_transient() {
	global $wpdb;
	$sql = 'DELETE FROM '.$wpdb->options.' WHERE option_name LIKE "_transient_bekento_category_color_%"';
	$wpdb->query($sql);
}
add_action('customize_save_after', 'bekento_clear_transient');

