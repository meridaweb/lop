<?php


/**
 * Codepress Twitter Admin
 *
 * @since 0.1
 */
class Codepress_Twitter_Admin {

	/**
	 * Notices
	 *
	 * @since 0.1
	 */
	private $notices = array();

	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	function __construct() {

		// Admin UI
		add_action( 'admin_menu', array( $this, 'settings_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_filter( 'plugin_action_links',  array( $this, 'add_settings_link' ), 1, 2 );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Admin Menu.
	 *
	 * Create the admin menu link for the settings page.
	 *
	 * @since 0.1
	 */
	public function settings_menu() {

		// options page; title, menu title, capability, slug, callback
		$page = add_options_page( __( 'Twitter', CPTW_TEXTDOMAIN ), __( 'Twitter', CPTW_TEXTDOMAIN ), 'manage_options', CPTW_SLUG, array( $this, 'plugin_settings_page') );

		// settings page specific styles and scripts
		add_action( "admin_print_styles-{$page}", array( $this, 'admin_styles') );

		// verify credentials
		add_action( "load-{$page}", array( $this, 'verify_credentials' ) );
	}

	/**
	 * Verify Credentials on storing credentials
	 *
	 * @since 0.1
	 */
	function verify_credentials() {

		if ( false !== get_option('cptw_options') && isset( $_REQUEST['settings-updated'] ) && 'true' == $_REQUEST['settings-updated'] ) {

			$twitter = new Codepress_Twitter();
			$account = $twitter->verify_credentials();

			if ( !empty( $account->errors ) ) {
				foreach ( $account->errors as $error ) {
					$this->notices[] = (object) array(
						'message' 	=> __('Twitter response', CPTW_TEXTDOMAIN ) . ': ' . $error->message . ' (<a href="https://dev.twitter.com/docs/error-codes-responses">' . $error->code . '</a>)',
						'class'		=> 'error'
					);
				}
			}

			else {
				$this->notices[] = (object) array(
					'message' 	=> __('Succesfully verified credentials.', CPTW_TEXTDOMAIN ),
					'class'		=> 'updated'
				);
			}
		}
	}

	/**
	 * Register admin css
	 *
	 * @since 0.1
	 */
	public function admin_styles() {

		wp_enqueue_style( 'cptw-admin', CPTW_URL.'/assets/css/admin_settings.css', array(), CPTW_VERSION, 'all' );
	}

	/**
	 * Add Settings link to plugin page
	 *
	 * @since 0.1
	 */
	public function add_settings_link( $links, $file ) {

		if ( $file != plugin_basename( __FILE__ ) )
			return $links;

		array_unshift( $links, '<a href="' .  admin_url("admin.php") . '?page=' . CPTW_SLUG . '">' . __( 'Settings', CPTW_TEXTDOMAIN) . '</a>' );

		return $links;
	}

	/**
	 * Sanitize options
	 *
	 * @since 0.1
	 */
	public function sanitize_options( $options ) {

		$options = array_map( 'sanitize_text_field', $options );
		$options = array_map( 'trim', $options );

		return $options;
	}

	/**
	 * Register plugin options
	 *
	 * @since 0.1
	 */
	public function register_settings() {

		// If we have no options in the database, let's add them now.
		if ( false === get_option( 'cptw_options' ) ) {
			add_option( 'cptw_options', $this->get_default_values() );
		}

		register_setting( 'cptw-settings-group', 'cptw_options', array( $this, 'sanitize_options' ) );
	}

	/**
	 * Returns the default plugin options.
	 *
	 * @since 0.1
	 */
	public function get_default_values() {

		$defaults = array(
			'consumerkey'		=> '',
			'consumersecret' 	=> '',
			'accesstoken'		=> '',
			'accesstokensecret'	=> ''
		);

		return apply_filters( 'cptw_defaults', $defaults );
	}

	/**
	 * Admin Notices
	 *
	 * @since 0.1
	 */
	function admin_notices() {

		if ( ! $this->notices )
			return;


		foreach ( $this->notices as $notice ) {
			?>
		    <div class="<?php echo $notice->class; ?>">
		        <p><?php echo $notice->message; ?></p>
		    </div>
		    <?php
		}
	}

	/**
	 * Settings Page Template.
	 *
	 * This function in conjunction with others usei the WordPress
	 * Settings API to create a settings page where users can adjust
	 * the behaviour of this plugin.
	 *
	 * @since 0.1
	 */
	public function plugin_settings_page() {

		$options = get_option( 'cptw_options' );

		$fields = array(
			'consumerkey'		=> __( 'Consumer key', CPTW_TEXTDOMAIN ),
			'consumersecret' 	=> __( 'Consumer secret', CPTW_TEXTDOMAIN ),
			'accesstoken'		=> __( 'Access token', CPTW_TEXTDOMAIN ),
			'accesstokensecret'	=> __( 'Access token secret', CPTW_TEXTDOMAIN )
		);
	?>
	<div id="cptw" class="wrap">
		<?php screen_icon( CPTW_SLUG ); ?>
		<h2><?php _e('Twitter Settings', CPTW_TEXTDOMAIN); ?></h2>

		<form method="post" action="options.php">

			<?php settings_fields( 'cptw-settings-group' ); ?>

			<table class="form-table">
				<tbody>

					<tr valign="top">
						<th scope="row" colspan="2">
							<ol>
								<li><?php _e('Go to', CPTW_TEXTDOMAIN ); ?> <a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a></li>
								<li><?php _e('Create a new application', CPTW_TEXTDOMAIN ); ?></li>
								<li><?php _e('Create access tokens', CPTW_TEXTDOMAIN ); ?></li>
								<li><?php _e('Then fill in your created Consumer keys and Access tokens below and save changes.', CPTW_TEXTDOMAIN ); ?></a></li>
								<li><?php _e('You can now add a twitter widget to your site. Or use the twitter shortcode in one of your pages.', CPTW_TEXTDOMAIN ); ?></a></li>
							</ol>
						</th>
					</tr>

				<?php foreach( $fields as $key => $label ) : ?>

					<tr valign="top">
						<th scope="row">
							<label for="<?php echo $key; ?>"><?php echo $label; ?></label>
						</th>
						<td>
							<label for="<?php echo $key; ?>">
								<input type="text" class="regular-text code" id="<?php echo $key; ?>" name="cptw_options[<?php echo $key; ?>]" value="<?php echo $options[ $key ]; ?>">
							</label>
						</td>
					</tr>

				<?php endforeach; ?>

				</tbody>
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
			</p>
		</form>
	</div>
	<?php
	}
}

new Codepress_Twitter_Admin();

