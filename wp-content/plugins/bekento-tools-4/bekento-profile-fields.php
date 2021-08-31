<?php

// USER: Add Meta

add_action('show_user_profile', 'bekento_extra_user_profile_fields');
add_action('edit_user_profile', 'bekento_extra_user_profile_fields');

function bekento_extra_user_profile_fields($user) {
	if(function_exists(get_template().'_social_networks')) {
		$social_networks_list = call_user_func(get_template().'_social_networks');
	} else {
		$social_networks_list = array('' => '');
	}
?>

	<table class="form-table bekento-uploader">
		<tr>
			<th><label for="bekento_author_fields[avatar]"><?php esc_html_e('Custom Avatar', 'bekento'); ?></label></th>
			<td>
				<input type="text" class='bekento-input-img' name="bekento_author_fields[avatar]" id="bekento_author_fields[avatar]" value="<?php echo esc_url(bekento_get_author_meta('avatar', $user->ID)); ?>" class="regular-text" /> <button class='button'><?php esc_html_e('Select / Upload Image', 'bekento'); ?></button>
			</td>
		</tr>
	</table>

	<table class="form-table bekento-uploader">
		<tr>
			<th><label for="bekento_author_fields[background]"><?php esc_html_e('Profile Background', 'bekento'); ?></label></th>
			<td>
				<input type="text" class='bekento-input-img' name="bekento_author_fields[background]" id="bekento_author_fields[background]" value="<?php echo esc_url(bekento_get_author_meta('background', $user->ID)); ?>" class="regular-text" /> <button class='button'><?php esc_html_e('Select / Upload Image', 'bekento'); ?></button>
			</td>
		</tr>
	</table>

	<script type="text/javascript">
		jQuery(document).ready(function($){
			$('.bekento-uploader button').click(function(e) {
				e.preventDefault();
				var $thisBtn = $(this);
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
					console.log($(this));
					$thisBtn.parent().find('.bekento-input-img').val(image_url);
				});
			});
		});
	</script>

	<h3><?php esc_html_e("Social Networks", "bekento"); ?></h3>

	<p class='description'><?php esc_html_e("Full URL e.g. https://www.instagram.com/doyoutravel", "bekento"); ?></p>

	<table class="form-table">
		<?php

		// This are local values, not escaping

		foreach($social_networks_list as $bekento_social_name => $color) {

			if(strpos($bekento_social_name, "-")) {
				$bekento_social_title = substr($bekento_social_name, 0, strpos($bekento_social_name, "-"));
			} else {
				$bekento_social_title = $bekento_social_name;
			}
			
			if($bekento_social_title == 'envelope') {
				$bekento_social_title = 'email';
			} else {
				$bekento_social_title = $bekento_social_title;
			}

			?>
			<tr>
				<th><label for="bekento_author_fields[<?php echo esc_attr($bekento_social_title); ?>]"><?php echo esc_attr(ucwords($bekento_social_title)); ?></label></th>
				<td>
					<input type="text" name="bekento_author_fields[<?php echo esc_attr($bekento_social_title); ?>]" id="bekento_author_fields[<?php echo esc_attr($bekento_social_title); ?>]" value="<?php echo esc_attr(bekento_get_author_meta($bekento_social_title, $user->ID)); ?>" class="regular-text" />
				</td>
			</tr>
		<?php } ?>
	</table>
<?php }

// USER: Save Meta

add_action('personal_options_update', 'bekento_save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'bekento_save_extra_user_profile_fields');

function bekento_save_extra_user_profile_fields($user_id) {
	global $bekento;
	if (!current_user_can('edit_user', $user_id)) { 
		return false;
	}

	if(isset($_POST['bekento_author_fields'])) {
		$curVal = get_user_meta($user_id, 'bekento_author_fields');
		if($curVal) {
			update_user_meta($user_id, 'bekento_author_fields', $_POST['bekento_author_fields']);
		} else {
			add_user_meta($user_id, 'bekento_author_fields',  $_POST['bekento_author_fields'], true);
		}
	} else {
		delete_user_meta($user_id, 'bekento_post_fields');
	}
}

// USER: Get Meta

function bekento_get_author_meta($value, $g_author='') {
	global $post, $bekento_author_data;
	if($g_author == '') {
		$g_author = get_the_author_meta('ID');
	}
	if(!isset($bekento_author_data[$g_author])) {
		$bekento_author_data[$g_author] = get_user_meta($g_author, 'bekento_author_fields', true);
	}
	if(isset($bekento_author_data[$g_author][$value])) {
		return $bekento_author_data[$g_author][$value];
	} else {
		return '';
	}
}
