<?php


/**
 * Codepress Twitter Shortcode
 *
 * @since 0.1
 */
class Codepress_Twitter_Shortcode {

	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	function __construct() {

		add_action( 'media_buttons', array( $this, 'add_shortcode_button' ), 100 );
		add_action( 'admin_footer', array( $this, 'popup' ) );

		// styling
		add_action( 'admin_print_styles', array( $this, 'admin_styles') );
		add_filter( 'tiny_mce_plugins', array( $this, 'admin_scripts') );


		// add shortcode
		add_shortcode( 'fetch_tweets', array( $this, 'shortcode_handler' ) );

	}

	/**
	 * Register admin css
	 *
	 * @since 0.1
	 */
	public function admin_styles() {
		if ( $this->has_permissions() && $this->is_edit_screen() ) {
			wp_enqueue_style( 'cptw-admin-css', CPTW_URL . '/assets/css/admin_shortcode.css', array(), CPTW_VERSION, 'all' );
		}
	}

	/**
	 * Register admin scripts
	 *
	 * @since 0.1
	 */
	public function admin_scripts( $plugins ) {
		if ( $this->has_permissions() && $this->is_edit_screen() ) {
			wp_enqueue_script( 'cptw-admin-js', CPTW_URL . '/assets/js/admin_shortcode.js', array( 'jquery' ), CPTW_VERSION );
		}

		return $plugins;
	}

	/**
	 * Is edit screen
	 *
	 * @since 0.4
	 */
	private function is_edit_screen() {
		global $pagenow;

		if ( in_array( $pagenow, array( 'post-new.php', 'page-new.php', 'post.php', 'page.php', 'profile.php', 'user-edit.php', 'user-new.php' ) ) )
			return true;

		return false;
	}

	/**
	 * has permissions
	 *
	 * @since 0.4
	 */
	private function has_permissions() {
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) )
			return true;

		return false;
	}

	/**
	 * Add shortcode button to TimyMCE
	 *
	 * Image from: https://dev.twitter.com/docs/image-resources
	 *
	 * @since 0.1
	 *
	 * @param string $page
	 * @param string $target
	 */
	public function add_shortcode_button( $page = null, $target = null ) {

		if ( ! $this->has_permissions() || ! $this->is_edit_screen() )
			return false;

		?>
			<a href="#TB_inline?width=640&amp;height=600&amp;inlineId=cptw-wrap" class="thickbox" title="<?php _e( 'Insert Twitter', CPSH_TEXTDOMAIN ); ?>" data-page="<?php echo $page; ?>" data-target="<?php echo $target; ?>">
				<img src="<?php echo CPTW_URL . "/assets/images/bird_blue_16.png";?>" alt="" />
			</a>
		<?php
	}

	/**
	 * TB window Popup
	 *
	 * @since 0.1
	 */
	public function popup() {

		?>

		<div id="cptw-wrap" style="display:none">
			<div id="cptw">
				<div id="cptw-shell">

					<div id="cptw-header">

						<div class="cptw-shortcodes">
							<h2 class="cptw-title"><?php _e( "Twitter", CPTW_TEXTDOMAIN ); ?></h2>
							<p class="field">
								<label for="twitter_usernames"><?php _e( "Usernames", CPTW_TEXTDOMAIN ); ?></label>
								<input id="twitter_usernames" type="text" class="regular-text" placeholder="">
							</p>
							<p class="description"><?php _e( "Fill in one or more usernames seperated by a comma.", CPTW_TEXTDOMAIN ); ?></p>
							<p class="field">
								<label for="twitter_search"><?php _e( "Search", CPTW_TEXTDOMAIN ); ?></label>
								<input id="twitter_search" type="text" class="regular-text" placeholder="">
							</p>
							<p class="description">
								<?php _e( "Fill in search query by topical interest, full name, company name, location, or hashtag.", CPTW_TEXTDOMAIN ); ?><br/>
								<?php _e( "For example: #wordpress, #wordpressplugins, Codepress", CPTW_TEXTDOMAIN ); ?>
							</p>
							<p class="field">
								<label for="twitter_favorites"><?php _e( "Favorites", CPTW_TEXTDOMAIN ); ?></label>
								<input id="twitter_favorites" type="text" class="regular-text">
							</p>
							<p class="description"><?php _e( "Fill in one or more usernames seperated by a comma.", CPTW_TEXTDOMAIN ); ?></p>
							<p>
								<label for="twitter_count"><?php _e( "Number of tweets", CPTW_TEXTDOMAIN ); ?></label>
								<input id="twitter_count" type="number" min="0" step="1" value="5" class="small-text">
							</p>

							<a href="javascript:;" id="cptw-insert-shortcode" class="button button-small"><?php _e( "Insert Twitter shortcode", CPTW_TEXTDOMAIN ); ?></a>

						</div><!--.cptw-shortcodes-->

					</div><!--cptw-generator-header-->

				</div><!--cptw-generator-shell-->
			</div>
		</div>

		<?php
	}

	/**
	 * Shortcode Handler
	 *
	 * @since 0.1
	 */
	public function shortcode_handler( $atts, $content = null, $name='' ) {

		$atts = shortcode_atts( array(
			"usernames" => '',
			"search" 	=> '',
			"favorites" => '',
			"count"		=> 5,
		), $atts );

		$usernames	= sanitize_text_field( $atts['usernames'] );
		$search	 	= sanitize_text_field( $atts['search'] );
		$favorites	= sanitize_text_field( $atts['favorites'] );
		$count 		= sanitize_text_field( $atts['count'] );

		// data attributes
		$attr  = '';
		$attr .= $usernames 	? ' data-usernames="' . $usernames . '"' 	: '';
		$attr .= $search 		? ' data-search="' . $search . '"' 			: '';
		$attr .= $favorites 	? ' data-favorites="' . $favorites . '"' 	: '';
		$attr .= $count 		? ' data-count="' . $count . '"' 			: '';

		return '<div class="cp-tweets"' . $attr . '></div>';
	}
}

new Codepress_Twitter_Shortcode();

