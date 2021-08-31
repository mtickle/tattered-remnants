<?php

function bekento_thumbnail_recent_posts_init() {
	register_widget('bekento_thumbnail_recent_posts');
}
add_action('widgets_init', 'bekento_thumbnail_recent_posts_init');

class bekento_thumbnail_recent_posts extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'bekento_thumbnail_recent_posts',
			'description' => __('Posts with Thumbnails from Categories'),
			'customize_selective_refresh' => true,
		);
		parent::__construct('bekento-recent-posts', __('Thumbnail Category Posts'), $widget_ops);
		$this->alt_option_name = 'bekento_thumbnail_recent_posts';
	}

	public function widget($args, $instance) {
		if (!isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}

		$title = (!empty($instance['title'])) ? $instance['title'] : esc_html__('Recent Posts', 'bekento');
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

      $post_cat = isset($instance['post_cat']) ? intval($instance['post_cat']) : 0;
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$ordered = isset($instance['ordered']) ? esc_attr($instance['ordered']) : 0;
		$show_images = isset($instance['show_images']) ? esc_attr($instance['show_images']) : 'on';
		$travel_markers = isset($instance['travel_markers']) ? esc_attr($instance['travel_markers']) : 0;

		$ul_class = '';
		if($show_images) {
			$ul_class .= 'show_images ';
		}
		if($travel_markers) {
			$ul_class .= 'travel_markers ';
		}

		if(!$ordered) {
			$orderby_query = 'post_date';
		} else {
			$orderby_query = 'post_views';
		}

		$r = new WP_Query(apply_filters('widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'cat'         			 => absint($post_cat),
			'orderby'				 => $orderby_query,
		)));

		if ($r->have_posts()) :
		?>
		<?php echo $args['before_widget']; ?>
		<?php if ($title) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
		<ul class="<?php echo $ul_class; ?>">
		<?php while ($r->have_posts()) : $r->the_post(); ?>
			<?php
			$post_thumb = '';
			if($show_images) {
				$post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
				if($post_thumb[0]) {
					$post_thumb = esc_url($post_thumb[0]);
				}
			}
			?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<div class='post-thumbnail' style='background-image: url(<?php echo $post_thumb; ?>);'>
						<div class='marker'></div>
					</div>
					<div class='post-title'><span><?php echo get_the_title(); ?></span></div>
				</a>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $args['after_widget']; ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['post_cat'] = absint($new_instance['post_cat']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['ordered'] = sanitize_text_field($new_instance['ordered']);
		$instance['show_images'] = sanitize_text_field($new_instance['show_images']);
		$instance['travel_markers'] = sanitize_text_field($new_instance['travel_markers']);
		return $instance;
	}

	public function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$post_cat = isset($instance['post_cat']) ? absint($instance['post_cat']) : '';
		$ordered = isset($instance['ordered']) ? esc_attr($instance['ordered']) : '';
		$show_images = isset($instance['show_images']) ? esc_attr($instance['show_images']) : 'on';
		$travel_markers = isset($instance['travel_markers']) ? esc_attr($instance['travel_markers']) : '';
	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p>
			<label for="<?php echo  esc_attr($this->get_field_id('post_cat')); ?>"><?php esc_html_e('Category:', 'bekento'); ?></label>
			<?php
			$cat_args = array(
				'orderby' => 'name',
				'hide_empty' => 1,
				'class' => 'widefat',
				'taxonomy' => 'category',
				'name' => $this->get_field_name('post_cat'),
				'id' => $this->get_field_id('post_cat'),
				'selected' => $post_cat,
				'show_option_all' => esc_html__('All Categories','bekento'),
			);
			wp_dropdown_categories($cat_args);
			?>
		</p>

		<p>
			<input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number of posts to show', 'bekento'); ?></label>
		</p>
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id('show_images'); ?>" name="<?php echo $this->get_field_name('show_images'); ?>" <?php checked($show_images, 'on'); ?> />
			<label for="<?php echo $this->get_field_id('show_images'); ?>"><?php esc_html_e('Thumbnails', 'bekento'); ?></label>
		</p>
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id('travel_markers'); ?>" name="<?php echo $this->get_field_name('travel_markers'); ?>" <?php checked($travel_markers, 'on'); ?> />
			<label for="<?php echo $this->get_field_id('travel_markers'); ?>"><?php esc_html_e('Travel Markers', 'bekento'); ?></label>
		</p>
		<?php if (class_exists('Post_Views_Counter')) { ?>
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id('ordered'); ?>" name="<?php echo $this->get_field_name('ordered'); ?>" <?php checked($ordered, 'on'); ?> />
			<label for="<?php echo $this->get_field_id('ordered'); ?>"><?php esc_html_e('Most Viewed First', 'bekento'); ?></label>
		</p>
	<?php } ?>

<?php
	}
}
