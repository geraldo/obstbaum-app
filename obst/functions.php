<?php
/**
 * obst functions and definitions
 *
 * @package obst
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'obst_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function obst_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on obst, use a find and replace
	 * to change 'obst' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'obst', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'obst' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif; // obst_setup
add_action( 'after_setup_theme', 'obst_setup' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for WordPress 3.3
 * using feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Remove the 3.3 support when WordPress 3.6 is released.
 *
 * Hooks into the after_setup_theme action.
 */
function obst_register_custom_background() {
	$args = array(
		'default-color' => 'ffffff',
		'default-image' => '',
	);

	$args = apply_filters( 'obst_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		if ( ! empty( $args['default-image'] ) )
			define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'obst_register_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function obst_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'obst' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'obst_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function obst_scripts() {
	/* load scripts for jquery tabs */
	if ( !is_admin() ) {
		wp_register_style( 'tabs_css', get_template_directory_uri().'/jquery-ui-1.8.23.custom.css' );
		wp_enqueue_style( 'tabs_css' );
		wp_enqueue_script('jquery-ui-tabs');
	}

	wp_enqueue_style( 'obst-style', get_stylesheet_uri() );

	wp_enqueue_script( 'obst-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'obst-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'obst-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'obst_scripts' );

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );


/* create custom post type BAUM */
add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'baum',
		array(
			'labels' => array(
				'name' => __( 'Bäume' ),
				'singular_name' => __( 'Baum' )
			),
		'public' => true,
		'has_archive' => false,
		)
	);
	add_post_type_support( 'baum', 
		array(
			'comments',
			'custom-fields'
		));
}

/* ajaxifying theme */
if ( ! is_admin() ) {
    $url = get_stylesheet_directory_uri() . '/js/';
    wp_enqueue_script( 'hash-change', "{$url}jquery.ba-hashchange.min.js", array('jquery'), '', true);
    wp_enqueue_script( 'ajax-theme', "{$url}ajax.js", array( 'hash-change' ), '', true);
}

if (is_admin()) {
	wp_enqueue_style( 'obst-style', get_template_directory_uri() . '/admin.css');
}


/* redirect after login */
function admin_default_page() {
  return ( '/' );
}
add_filter('login_redirect', 'admin_default_page');

/* Add custom logo */
function custom_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url(http://linz.pflueckt.at/static/leaflet051/images/leaf-green.png) !important; background-size: 38px 95px !important; }
	</style>';
}
add_action('login_head', 'custom_login_logo');

/* remove admin bar */
add_filter( 'show_admin_bar', '__return_false' );

/* hide admin menu */
function hide_menus() {
    if ( !current_user_can('manage_options') ) {
        ?>
        <style>
           #adminmenuback, #adminmenuwrap, #wp-admin-bar-wp-logo{
                display:none;
            }
        </style>
        <?php
    }
}
add_action('admin_head', 'hide_menus');
