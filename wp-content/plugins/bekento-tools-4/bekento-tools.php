<?php
/*
Plugin Name: Bekento Tools 4
Plugin URI: https://bekento.space/tools
Description: Bunch of useful Widgets
Version: 4.191213
Author: Bekento
Author URI: https://bekento.space/
*/

include(plugin_dir_path(__FILE__) . 'bekento-profile-fields.php');
include(plugin_dir_path(__FILE__) . 'bekento-social-share.php');
include(plugin_dir_path(__FILE__) . 'bekento-opengraph-meta.php');
include(plugin_dir_path(__FILE__) . 'bekento-recent-posts-widget.php');
include(plugin_dir_path(__FILE__) . 'bekento-profile-widget.php');
include(plugin_dir_path(__FILE__) . 'bekento-mtr.php');
include(plugin_dir_path(__FILE__) . 'bekento-category.php');

function bekento_register_menu_page() {
	add_menu_page(
		esc_html__('Customize', 'bekento'),
		'Theme Options',
		'manage_options',
		'customize.php',
		'',
		'dashicons-admin-generic',
		160
	);
}
add_action('admin_menu', 'bekento_register_menu_page');