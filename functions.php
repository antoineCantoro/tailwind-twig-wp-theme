<?php
/**
 * Test functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Test
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function test_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Test, use a find and replace
		* to change 'test' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'test', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'test' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'test_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'test_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function test_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'test_content_width', 640 );
}
add_action( 'after_setup_theme', 'test_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function test_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'test' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'test' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'test_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function test_scripts() {
	wp_enqueue_style( 'test-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'test-style', 'rtl', 'replace' );

	// wp_enqueue_script( 'test-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action('wp_enqueue_scripts', 'test_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load Composer dependencies.
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Initialize Timber.
 */
Timber\Timber::init();

/**
 * Load Vite with HMR in development, and build files in production.
 */
add_action('wp_enqueue_scripts', 'enqueue_vite_assets');

function enqueue_vite_assets() {
    if (vite_is_dev_server_running()) {
			echo '<!-- Vite dev server is running -->';

			echo '<script type="module" crossorigin src="http://localhost:5173/@vite/client"></script>';
			echo '<script type="module" crossorigin src="http://localhost:5173/main.ts"></script>';
		} else {
			echo '<!-- Vite dev server is not running -->';
			$manifest_path = get_theme_file_path('/dist/.vite/manifest.json');
			
			if (!file_exists($manifest_path)) {
				return;
			}

			$manifest = json_decode(file_get_contents($manifest_path), true);
			$entry = $manifest['index.html'];

			// JS
			if (!empty($entry['file'])) {
				wp_enqueue_script(
					'theme-js',
					get_theme_file_uri('/dist/' . $entry['file']),
					[],
					null,
					true
				);
			} 

			// CSS
			if (!empty($entry['css'])) {
        wp_enqueue_style(
            'theme-css',
            get_theme_file_uri('/dist/' . $entry['css'][0])
        );
    	}
		}
}

/**
 * Check if Vite dev server is running
 */
function vite_is_dev_server_running(): bool {
	return @fsockopen('localhost', 5173) !== false;
}

/**
 * Deregister the block library CSS
 */
function wps_deregister_styles() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'global-styles-inline-css' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'wp-emoji-styles' );
	wp_dequeue_style( 'wp-emoji-release' );
	wp_dequeue_style( 'classic-theme-styles' );
}

/**
 * Deregister the js
 */
function wps_deregister_scripts() {

	wp_dequeue_script( 'wp-emoji-styles' );
	wp_dequeue_script( 'wp-emoji-release' );
}
add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
add_action( 'wp_print_scripts', 'wps_deregister_scripts', 100 );
add_filter( 'should_load_separate_core_block_assets', '__return_false', 99 );

remove_action( 'wp_head', 'wp_enqueue_emoji_styles', 7 );
// remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );
remove_action( 'wp_head', 'wp_img_auto_sizes_contain_inline_css' );