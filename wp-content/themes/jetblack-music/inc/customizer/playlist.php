<?php
/**
 * Playlist Options
 *
 * @package JetBlack
 */

class JetBlack_Playlist_Options {
	public function __construct() {
		// Register Playlist Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'jetblack_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'jetblack_playlist_visibility' => 'disabled',
		);

		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Add layouts section and its controls
	 */
	public function register_options( $wp_customize ) {
		$wp_customize->add_section( 'jetblack_ss_playlist',
			array(
				'title' => esc_html__( 'Playlist', 'jetblack-music' ),
				'panel' => 'jetblack_sp_sortable'
			)
		);

		JetBlack_Customizer_Utilities::register_option(
			array(
				'settings'          => 'jetblack_playlist_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'jetblack_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'jetblack-music' ),
				'section'           => 'jetblack_ss_playlist',
				'choices'           => JetBlack_Customizer_Utilities::section_visibility(),
			)
		);

		JetBlack_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'JetBlack_Simple_Notice_Custom_Control',
				'sanitize_callback' => 'sanitize_text_field',
				'settings'          => 'jetblack_playlist_add_info',
				'label'             =>  esc_html__( 'Info', 'jetblack-music' ),
				'description'       =>  sprintf( esc_html__( 'If you dont know how to add playlist in page/post, check %1$sthis%2$s', 'jetblack-music' ), '<a href="https://www.beginwp.com/how-to-add-audio-video-playlist-wordpress/" target="_blank">', '</a>' ),
				'section'           => 'jetblack_ss_playlist',
				'active_callback'   => array( $this, 'is_playlist_visible' ),
			)
		);

		// Add Edit Shortcut Icon.
		$wp_customize->selective_refresh->add_partial( 'jetblack_playlist_visibility', array(
			'selector' => '#playlist-section',
		) );

		JetBlack_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'JetBlack_Dropdown_Posts_Custom_Control',
				'sanitize_callback' => 'absint',
				'settings'          => 'jetblack_playlist_page',
				'label'             => esc_html__( 'Select Page', 'jetblack-music' ),
				'section'           => 'jetblack_ss_playlist',
				'active_callback'   => array( $this, 'is_playlist_visible' ),
				'input_attrs' => array(
					'post_type'      => 'page',
					'posts_per_page' => -1,
					'orderby'        => 'name',
					'order'          => 'ASC',
				),
			)
		);

		JetBlack_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'jetblack_text_sanitization',
				'settings'          => 'jetblack_playlist_custom_subtitle',
				'label'             => esc_html__( 'Top Subtitle', 'jetblack-music' ),
				'section'           => 'jetblack_ss_playlist',
				'active_callback'   => array( $this, 'is_playlist_visible' ),
			)
		);
	}

	/**
	 * Playlist visibility active callback.
	 */
	public function is_playlist_visible( $control ) {
		return ( jetblack_display_section( $control->manager->get_setting( 'jetblack_playlist_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$jetblack_ss_playlist = new JetBlack_Playlist_Options();
