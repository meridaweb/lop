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
    'about'  => __('About  & Email'),
    'social-footer'  => __('Social links in footer'),
));

/**
 * Sidebars
 *
 */
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
add_theme_support( 'post-thumbnails', array( 'post', 'page', 'project', 'case', 'gewoonleuk' ) );
add_image_size( 'front', 412, 800, false ); // width, height
add_image_size( 'side', 196, 300, false );
add_image_size( 'gewoonleuk', 196, 175, true );
add_image_size( 'about', 440, 440, true );
add_image_size( 'archive', 654, 654, false );
add_image_size( 'archive-large', 860, 2000, false );

/**
 *	Theme styles and scripts
 *
 */
function codepress_styles() {
	$version = '1.1';

	/** Styles */
	wp_enqueue_style( 'cp-normalize', get_stylesheet_directory_uri() . '/assets/css/normalize.css', '', $version );
	wp_enqueue_style( 'cp-flexslider', get_stylesheet_directory_uri() . '/assets/css/flexslider.css', '', $version );
	wp_enqueue_style( 'cp-wordpress', get_stylesheet_directory_uri() . '/assets/css/WordPress.css', '', $version );
	wp_enqueue_style( 'cp-forms', get_stylesheet_directory_uri() . '/assets/css/forms.css', '', $version );
	wp_enqueue_style( 'cp-screen', get_stylesheet_directory_uri() . '/assets/css/screen.css', '', $version );
	wp_enqueue_style( 'cp-print', get_stylesheet_directory_uri() . '/assets/css/print.css', '', $version, 'print' );

	/** Footer Scripts */
	if(is_page_template('page-templates/about.php')){
		wp_enqueue_script('swap', get_stylesheet_directory_uri() . '/assets/js/swap-first-two-divs.js', array(), $version, true);
    }
	if( is_archive() || is_page_template('page-templates/about.php') || is_search() ){
		wp_enqueue_script('imagesloaded-plugin', get_stylesheet_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js', array(), $version, true);
    	wp_enqueue_script('masonry-plugin', get_stylesheet_directory_uri() . '/assets/js/masonry.pkgd.min.js', array(), $version, true);
    	wp_enqueue_script('trigger-masonry', get_stylesheet_directory_uri() . '/assets/js/trigger-masonry.js', array(), $version, true);
    }
	wp_enqueue_script('cp-jquery-flexslider', get_stylesheet_directory_uri() . '/assets/js/jquery.flexslider-min.js', array('jquery'), $version );
	wp_enqueue_script('cp-global', get_stylesheet_directory_uri() . '/assets/js/global.js', array('jquery'), $version, true );

	/** Localize */
	wp_localize_script( 'cp-global', 'codepress', array(
		'ajaxurl' => admin_url('admin-ajax.php')
	));
}
add_action('wp_enqueue_scripts', 'codepress_styles');

/**
 *	Register post types
 *
 */
function codepress_add_post_types() {
        $args = array(
        'labels' => array(
            'name'          => __( 'Gewoon leuks', 'codepress' ),
            'singular_name' => __( 'Gewoon leuk', 'codepress' ),
        ),
        'menu_icon'         => 'dashicons-smiley',
        'has_archive'       => 'gewoonleuk',
        'public'            => true,
		'show_ui'			=> true,
        'supports'          => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
    );
    register_post_type( 'gewoonleuk', apply_filters( 'codepress_register_post_type_args', $args  ) );

}
add_action( 'init', 'codepress_add_post_types', 10 );


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

// custom styling of comment markup
function codepress_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        extract($args, EXTR_SKIP);
    ?>
    <div <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">

        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">

        <?php comment_text(); ?>

        <div class="comment-author vcard">
        - <?php echo get_comment_author(); ?>, <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_date("d F Y, H:i"); ?></a>
        </div>
    </div>

<?php }

/**
 *  Remove some actions from the wp_head
 *
 */
function codepress_clean_wp_head() {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
}
add_action( 'init', 'codepress_clean_wp_head' );
