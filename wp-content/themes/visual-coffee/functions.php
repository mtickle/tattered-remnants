<?php
// Set the content width based on the theme's design and stylesheet
if ( ! isset( $content_width ) ) {
	$content_width = 580;
}

//Set version constant
define( 'VISUALCOFFEE_VERSION', '1.6' );

// Theme setup
if ( ! function_exists( 'visualcoffee_setup' ) ) {
	function visualcoffee_setup() {
		// Menus
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'visual-coffee' ),
		) );

		// Add theme support
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-logo', array(
			'width'       => 400,
			'height'      => 150,
			'flex-height' => true,
			'flex-width'  => true,
		) );
		$defaults = array(
			'default-color' => 'fbf3e4',
		);
		add_theme_support( 'custom-background', $defaults );

		// Available for translation
		load_theme_textdomain( 'visual-coffee', get_template_directory() . '/languages' );
	}
}
add_action( 'after_setup_theme', 'visualcoffee_setup' );

// Register widget area
function visualcoffee_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'visual-coffee' ),
		'id'            => 'sidebar',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'visualcoffee_widgets_init' );

// Enqueue scripts and styles
function visualcoffee_scripts() {
	wp_enqueue_style( 'visualcoffee-style', get_template_directory_uri() . '/style.css', array(), VISUALCOFFEE_VERSION );

	// Enqueue the editor css
	wp_enqueue_style( 'visualcoffee-editor-style', get_template_directory_uri() . '/editor.css', array(), VISUALCOFFEE_VERSION );

	wp_enqueue_script( 'visualcoffee-nprogress', get_template_directory_uri() . '/assets/js/nprogress.min.js', array( 'jquery' ), VISUALCOFFEE_VERSION, true );
	wp_enqueue_script( 'visualcoffee-customjs', get_template_directory_uri() . '/assets/js/custom.min.js', array( 'jquery' ), VISUALCOFFEE_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'visualcoffee_scripts' );

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 */
function visualcoffee_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content" tabindex="20">' . __( 'Skip to the content', 'visual-coffee' ) . '</a>';
}

add_action( 'wp_body_open', 'visualcoffee_skip_link', 5 );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function visualcoffee_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
        /(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'visualcoffee_skip_link_focus_fix' );

// Includes

require get_template_directory() . '/inc/common.php';
require get_template_directory() . '/inc/customizer.php';
