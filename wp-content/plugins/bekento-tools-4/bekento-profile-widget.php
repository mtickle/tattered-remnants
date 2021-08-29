<?php

function bekento_profile_init() {
	register_widget('bekento_profile_widget');
}
add_action('widgets_init', 'bekento_profile_init');

class bekento_profile_widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'bekento_profile_widget',
			'description' => esc_html__('Display Users Profile', 'bekento'),
			'customize_selective_refresh' => true,
		);
		parent::__construct('bekento-profile', esc_html__('Profile', 'bekento'), $widget_ops);
		$this->alt_option_name = 'bekento_profile_widget';
	}

	public function widget($args, $instance) {
		if (! isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}

		$title = (! empty($instance['title'])) ? $instance['title'] : '';
      $user_one = ! empty($instance['user_sel']) ? $instance['user_sel'] : 0;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		if($user_one != '') {
		?>
		<?php echo $args['before_widget']; ?>
		<?php if ($title) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>

		<?php
		$avatar = get_avatar_url($user_one, array('size' => '300'));
		$custom_avatar = bekento_get_author_meta('avatar', $user_one);
		if($custom_avatar) {
			$avatar = $custom_avatar;
		}
		?>
		<div class='author-bio'>
			<div class='people'>
				<div class='person'>
					<div>
						<a href="<?php echo get_author_posts_url($user_one); ?>"><div class='picture' style='background-image: url(<?php echo esc_url($avatar); ?>);'></div></a>
					</div>
					<div class='text'>
						<h3 class='name'><a href="<?php echo get_author_posts_url($user_one); ?>"><?php echo esc_html(get_the_author_meta('display_name', $user_one)); ?></a></h3>
						<p><?php echo esc_html(get_the_author_meta('description', $user_one)); ?></p>
						<?php if(function_exists(get_template().'_social_images')) {
							echo call_user_func(get_template().'_social_images', $user_one);
						} ?>
					</div>
				</div>
			</div>
		</div>
		<?php echo $args['after_widget']; ?>
		<?php
		}
	}

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['user_sel'] = absint($new_instance['user_sel']);
		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$user_sel = isset($instance['user_sel']) ? absint($instance['user_sel']) : '';
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p>
			<label for="<?php echo  esc_attr($this->get_field_id('user_sel')); ?>"><?php esc_html_e('User:', 'bekento'); ?></label>
			<?php
			$user_args = array(
				'role_in' => ['author', 'editor', 'administrator'],
				'hide_empty' => 1,
				'orderby' => 'user_login',
				'show' => 'user_login',
				'class' => 'widefat',
				'taxonomy' => 'category',
				'name' => $this->get_field_name('user_sel'),
				'id' => $this->get_field_id('user_sel'),
				'selected' => $user_sel,
			);
			wp_dropdown_users($user_args);
			?>
		</p>

<?php
	}
}
