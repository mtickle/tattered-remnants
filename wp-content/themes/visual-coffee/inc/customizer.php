<?php
function visualcoffee_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';

	// Social Media Icons

	$wp_customize->add_section(
		'visualcoffee_social_media_section',
		array(
			'title'    => __( 'Social Media Icons', 'visual-coffee' ),
			'priority' => 2,
		)
	);

	$wp_customize->add_setting(
		'visualcoffee_social_media_twitter_setting',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'visualcoffee_social_media_twitter_control',
			array(
				'label'    => __( 'Twitter URL', 'visual-coffee' ),
				'section'  => 'visualcoffee_social_media_section',
				'settings' => 'visualcoffee_social_media_twitter_setting',
				'type'     => 'text',
			)
		)
	);

	$wp_customize->add_setting(
		'visualcoffee_social_media_instagram_setting',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'visualcoffee_social_media_instagram_control',
			array(
				'label'    => __( 'Instagram URL', 'visual-coffee' ),
				'section'  => 'visualcoffee_social_media_section',
				'settings' => 'visualcoffee_social_media_instagram_setting',
				'type'     => 'text',
			)
		)
	);

	$wp_customize->add_setting(
		'visualcoffee_social_media_pinterest_setting',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'visualcoffee_social_media_pinterest_control',
			array(
				'label'    => __( 'Pinterest URL', 'visual-coffee' ),
				'section'  => 'visualcoffee_social_media_section',
				'settings' => 'visualcoffee_social_media_pinterest_setting',
				'type'     => 'text',
			)
		)
	);

	$wp_customize->add_setting(
		'visualcoffee_social_media_facebook_setting',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'visualcoffee_social_media_facebook_control',
			array(
				'label'    => __( 'Facebook URL', 'visual-coffee' ),
				'section'  => 'visualcoffee_social_media_section',
				'settings' => 'visualcoffee_social_media_facebook_setting',
				'type'     => 'text',
			)
		)
	);

	$wp_customize->add_setting(
		'visualcoffee_social_media_snapchat_setting',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'visualcoffee_social_media_snapchat_control', array(
				'label'    => __( 'Snapchat URL', 'visual-coffee' ),
				'section'  => 'visualcoffee_social_media_section',
				'settings' => 'visualcoffee_social_media_snapchat_setting',
				'type'     => 'text',
			)
		)
	);

	$wp_customize->add_setting(
		'visualcoffee_social_media_bloglovin_setting',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'visualcoffee_social_media_bloglovin_control', array(
				'label'    => __( 'Bloglovin URL', 'visual-coffee' ),
				'section'  => 'visualcoffee_social_media_section',
				'settings' => 'visualcoffee_social_media_bloglovin_setting',
				'type'     => 'text',
			)
		)
	);

	$wp_customize->add_setting(
		'visualcoffee_social_media_youtube_setting',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'visualcoffee_social_media_youtube_control',
			array(
				'label'    => __( 'YouTube URL', 'visual-coffee' ),
				'section'  => 'visualcoffee_social_media_section',
				'settings' => 'visualcoffee_social_media_youtube_setting',
				'type'     => 'text',
			)
		)
	);

	$wp_customize->add_setting(
		'visualcoffee_social_media_rss_setting',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'visualcoffee_social_media_rss_control',
			array(
				'label'    => __( 'RSS', 'visual-coffee' ),
				'section'  => 'visualcoffee_social_media_section',
				'settings' => 'visualcoffee_social_media_rss_setting',
				'type'     => 'text',
			)
		)
	);
}

add_action( 'customize_register', 'visualcoffee_customize_register' );