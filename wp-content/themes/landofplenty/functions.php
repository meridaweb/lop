<?php
/**
 * This depends on these plugins:
 * - Codepress Core
 *
 */
// error_reporting(1);
// ini_set( 'error_reporting', E_ALL - E_STRICT );

/**
 * Codepress Twitter
 *
 * Keys are from https://dev.twitter.com/apps/4556486/show
 *
 * @since 1.0
 */
define( 'CPTW_CONSUMER_KEY', 'OvGA8dj2qwRPj55YyuOIQ' );
define( 'CPTW_CONSUMER_SECRET', 'Qvq2Drzv2d7SLcRnee47ZKmOassnVQ261FY5oivrqo0' );
define( 'CPTW_ACCESS_TOKEN', '108322003-5wEbWkRxkIWwWwAaWKzqCiOnM83JWcUADcEL549B' );
define( 'CPTW_ACCESS_SECRET', 'TBdQ5ziO7ubQ3wUygPtsgSohrid48K1Nmyc7xZ96cY0' );

/**
 *  Register menu's
 *
 */
register_nav_menus( array(
    'main'  => __('Main navigation'),
));

/**
 * Sidebars
 *
 */
register_sidebar( array(
	'name'			=> 'Project / Cases',
	'id'			=> 'project',
	'description'	=> '',
	'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
	'after_widget'	=> "</div>\n",
	'before_title'	=> '<h2 class="widgettitle">',
	'after_title'	=> "</h2>\n"
));
register_sidebar( array(
	'name'			=> 'Blog',
	'id'			=> 'blog',
	'description'	=> '',
	'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
	'after_widget'	=> "</div>\n",
	'before_title'	=> '<h2 class="widgettitle">',
	'after_title'	=> "</h2>\n"
));

/**
 * Tell WordPress that Nginx has rewrite enabled
 *
 */
add_filter( 'got_rewrite', '__return_true', 999 );

/**
 * Login logo
 *
 */
function codepress_login_logo() {

    return get_stylesheet_directory_uri() . '/logo.png';
}
add_filter( 'codepress_login_logo_uri', 'codepress_login_logo' );

/**
 *	Thumbnail theme support
 *
 */
add_theme_support( 'post-thumbnails', array( 'post', 'page', 'project', 'case' ) );
add_image_size( 'front', 412, 800, false ); // width, height
add_image_size( 'side', 180, 300, false );
add_image_size( 'about', 440, 440, true );
add_image_size( 'archive', 634, 2000, true );
add_image_size( 'archive-large', 879, 2000, true );

/**
 *	Theme styles and scripts
 *
 */
function codepress_styles() {
	$version = '1.0';

	// Load fancybox
	// codepress_enqueue_fancybox();

	/** Styles */
	wp_enqueue_style( 'cp-normalize', get_stylesheet_directory_uri() . '/assets/css/normalize.css', '', $version );
	wp_enqueue_style( 'cp-flexslider', get_stylesheet_directory_uri() . '/assets/css/flexslider.css', '', $version );
	wp_enqueue_style( 'cp-wordpress', get_stylesheet_directory_uri() . '/assets/css/WordPress.css', '', $version );
	wp_enqueue_style( 'cp-forms', get_stylesheet_directory_uri() . '/assets/css/forms.css', '', $version );
	wp_enqueue_style( 'cp-screen', get_stylesheet_directory_uri() . '/assets/css/screen.css', '', $version );
	wp_enqueue_style( 'cp-print', get_stylesheet_directory_uri() . '/assets/css/print.css', '', $version, 'print' );

	/** Header Scripts */
	//wp_enqueue_script('addthis', 'http://s7.addthis.com/js/250/addthis_widget.js', '', $version);

	/** Footer Scripts */
	wp_enqueue_script('cp-jquery-flexslider', get_stylesheet_directory_uri() . '/assets/js/jquery.flexslider-min.js', array('jquery'), $version );
	wp_enqueue_script('cp-global', get_stylesheet_directory_uri() . '/assets/js/global.js', array('jquery'), $version, true );

	/** Localize */
	wp_localize_script( 'cp-global', 'codepress', array(
		'ajaxurl' => admin_url('admin-ajax.php')
	));
}
add_action('wp_enqueue_scripts', 'codepress_styles');

/**
 * Register taxonomies
 *
 */
function codepress_add_taxonomies() {
	$args = array(
        'labels' => array(
            'name'          => __( "Thema's", 'codepress' ),
            'singular_name' => __( 'Thema', 'codepress' ),
        ),
        'hierarchical'  => true,
        'rewrite'       => array( 'slug' => 'project' )
    );
    register_taxonomy( 'thema', array('project'), apply_filters( 'codepress_register_taxonomy_args', $args ) );

    $args = array(
        'labels' => array(
            'name'          => __( "Thema's", 'codepress' ),
            'singular_name' => __( 'Thema', 'codepress' ),
        ),
        'hierarchical'  => true,
        'rewrite'       => array( 'slug' => 'case' )
    );
    //register_taxonomy( 'thema_case', array('case'), apply_filters( 'codepress_register_taxonomy_args', $args ) );

}
add_action( 'init', 'codepress_add_taxonomies', 9 );

/**
 *	Register post types
 *
 */
function codepress_add_post_types() {
    $args = array(
        'labels' => array(
            'name'          => __( 'Projecten', 'codepress' ),
            'singular_name' => __( 'Project', 'codepress' ),
        ),
        'menu_icon'         => get_stylesheet_directory_uri() . '/assets/images/rainbow.png',
        'has_archive'       => 'project',
        'rewrite' => array(
            'slug'          => 'project/%thema%',
            'with_front'    => false
        ),
        'public'            => true,
		'show_ui'			=> true,
        'supports'          => array( 'title', 'editor', 'thumbnail' ),
    );
    register_post_type( 'project', apply_filters( 'codepress_register_post_type_args', $args  ) );

    $args = array(
        'labels' => array(
            'name'          => __( 'Cases', 'codepress' ),
            'singular_name' => __( 'Case', 'codepress' ),
        ),
        'menu_icon'         => get_stylesheet_directory_uri() . '/assets/images/briefcase.png',
        'has_archive'       => 'case',
      /*  'rewrite' => array(
            'slug'          => 'case/%thema_case%',
            'with_front'    => false
        ),*/
        'public'            => true,
		'show_ui'			=> true,
        'supports'          => array( 'title', 'editor', 'thumbnail' ),
    );
    register_post_type( 'case', apply_filters( 'codepress_register_post_type_args', $args  ) );

}
add_action( 'init', 'codepress_add_post_types', 10 );

/**
 * Rewrite permalink
 *
 */
function document_cat_permalink( $post_link, $post ) {

	if ( $taxonomies = get_taxonomies() ) {
	    foreach ( get_taxonomies() as $tax ) {
		    if ( false !== strpos( $post_link, "%{$tax}%" ) ) {
		        $term       = get_the_terms( $post->ID, $tax );
		        if( $term && ! is_wp_error( $term ) ) {
		            $post_link  = str_replace( "%{$tax}%", array_pop( $term )->slug, $post_link );
		        }
			}
		}
	}
    return $post_link;
}
add_filter( 'post_type_link', 'document_cat_permalink', 10, 2 );


/**
 *	Remove WordPress SEO added columns
 *
 */
add_filter( 'wpseo_use_page_analysis', '__return_false' );

/**
 *	Set the wordpress SEO meta Box below other metaboxes
 *
 */
function codepress__return_low() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'codepress__return_low' );

/**
 *  Remove Dashboard Widgets
 *
 */
function codepress_remove_dashboard_widgets() {

	// WordPress Core
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
	remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
	remove_meta_box('dashboard_quick_press', 'dashboard', 'normal');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal');
	remove_meta_box('dashboard_primary', 'dashboard', 'normal');
	remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
	//remove_meta_box('dashboard_right_now', 'dashboard', 'normal');

	// Yoast Widgets
	remove_meta_box('yoast_db_widget', 'dashboard', 'normal');
	remove_meta_box('yst_db_widget', 'dashboard', 'normal');
	remove_meta_box('blogplay_db_widget', 'dashboard', 'normal');
}
add_action('admin_init', 'codepress_remove_dashboard_widgets');

/**
 *	Adding advanced color button to WYSIWYG-editor
 *
 */
function fb_change_mce_buttons( $initArray ) {
	$initArray['theme_advanced_default_foreground_color'] = '#000';
	$initArray['theme_advanced_text_colors'] = '#e62339,#c8950a,#757373,#000,#fff';
	$initArray['theme_advanced_buttons1_add'] = 'forecolor';
	return $initArray;
}
add_filter('tiny_mce_before_init', 'fb_change_mce_buttons');

/**
 *	Post has a certain term
 *
 */
function codepress_post_has_term( $slug = '', $post_id = '' ) {

	foreach ( array('thema', 'thema_case' ) as $tax ) {
		$terms = wp_get_post_terms( $post_id, $tax, array( "fields" => "slugs" ) );
		if ( $terms && ! is_wp_error( $terms ) ) {
			if ( in_array( $slug, $terms ) ) {
				return true;
			}
		}
	}
	return false;
}

/**
 *	Get single thema term
 *
 */
function codepress_get_single_thema_term( $post_id = '' ) {

	foreach ( array('thema', 'thema_case' ) as $tax ) {
		$terms = wp_get_post_terms( $post_id, $tax );
		if ( $terms && ! is_wp_error( $terms ) ) {
			return $terms[0];
		}
	}
	return false;
}

