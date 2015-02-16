<?php

/*
Plugin Name: 	Codepress Twitter
Version: 		0.1
Description: 	Get Tweets from Twitter API. Authenticating via OAuth API V1.1
Author: 		Codepress
Author URI: 	http://www.codepress.nl
Plugin URI: 	http://www.codepress.nl/plugins/
Text Domain: 	codepress-twitter
Domain Path: 	/languages
License:		GPLv2

Copyright 2011-2013  Codepress  info@codepress.nl

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License version 2 as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'CPTW_VERSION', 	'0.1' );
define( 'CPTW_URL', 		plugins_url( '', __FILE__ ) );
define( 'CPTW_TEXTDOMAIN', 	'codepress-twitter' );
define( 'CPTW_SLUG', 		'codepress-twitter' );

// translations
load_plugin_textdomain( CPTW_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


require_once 'classes/class-admin.php';
require_once 'classes/class-shortcode.php';

/**
 * Codepress Twitter
 *
 * @since 0.1
 */
class Codepress_Twitter {

	/**
	 * OAuth credentials
	 *
	 * @since 0.1
	 */
	private $oauth;

	/**
	 * OAuth connection
	 *
	 * @since 0.1
	 */
	private $connection;

	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	function __construct( $auth_credentials = array() ) {

		$this->oauth = get_option('cptw_options');

		// apply credentials when you create your own instance of the class.
		if ( $auth_credentials )
			$this->oauth = $auth_credentials;

		add_action( 'wp_enqueue_scripts' , array( $this, 'scripts') );

		add_action( 'wp_ajax_codepress_get_tweets', array( $this, 'ajax_get_tweets' ) );
		add_action( 'wp_ajax_nopriv_codepress_get_tweets', array( $this, 'ajax_get_tweets' ) );
	}

	/**
	 * Scripts
	 *
	 * @since 0.1
	 */
	public function scripts() {

		wp_enqueue_style( 'cptw-twitter-css', CPTW_URL . '/assets/css/twitter.css', '', CPTW_VERSION );
		wp_enqueue_script( 'cptw-twitter-js', CPTW_URL . '/assets/js/twitter.js', array('jquery'), CPTW_VERSION, true );

		wp_localize_script( 'cptw-twitter-js', 'cptw', array(
			'ajaxurl' => admin_url('admin-ajax.php')
		));
	}

	/**
	 * Human Time Diff
	 *
	 * Source: http://wordpress.org/plugins/rotatingtweets/
	 *
	 * @since 0.1
	 */
	private function human_time_diff( $to, $from = false ) {

		$time_diff = false;

		if( !$from )
			$from = current_time('timestamp');

		$n = $from - $to;

		if ( $n <= 1 )
			$time_diff 	= __( 'less than a second ago', CPTW_TEXTDOMAIN );
		elseif ( $n < 60 )
			$time_diff 	= sprintf(__( '%d seconds ago', CPTW_TEXTDOMAIN ), $n );
		elseif ( $n < (60*60) ) {
			$minutes 	= round( $n/60 );
			$time_diff 	= sprintf( _n('about a minute ago', 'about %d minutes ago', $minutes, CPTW_TEXTDOMAIN ), $minutes );
		}
		elseif( $n < (60*60*16) ) {
			$hours 		= round($n/(60*60));
			$time_diff 	= sprintf( _n('about an hour ago', 'about %d hours ago', $hours, CPTW_TEXTDOMAIN ), $hours );
		}
		elseif( $n < ($from - strtotime('yesterday')))
			$time_diff 	=  __( 'yesterday', CPTW_TEXTDOMAIN );
		elseif( $n < (60*60*24) ) {
			$hours		= round($n/(60*60));
			$time_diff 	= sprintf( _n('about an hour ago', 'about %d hours ago', $hours, CPTW_TEXTDOMAIN ), $hours);
		}
		elseif( $n < (60*60*24*6.5) ) {
			$days 		= round($n/(60*60*24));
			$time_diff 	= sprintf( _n('about a day ago', 'about %d days ago', $days, CPTW_TEXTDOMAIN ), $days);
		}
		elseif( $n < ($from - strtotime('last week')))
			$time_diff 	= __( 'last week', CPTW_TEXTDOMAIN );
		elseif( $n < (60*60*24*7*3.5) ) {
			$weeks 		= round($n/(60*60*24*7));
			$time_diff 	= sprintf( _n('about a week ago', 'about %d weeks ago', $weeks, CPTW_TEXTDOMAIN ), $weeks);
		}
		elseif( $n < ($from - strtotime('last month')))
			$time_diff 	= __( 'last month', CPTW_TEXTDOMAIN );
		elseif( $n < (60*60*24*7*4*11.5) ) {
			$months 	= round($n/(60*60*24*7*4)) ;
			$time_diff 	= sprintf( _n('about a month ago', 'about %d months ago', $months, CPTW_TEXTDOMAIN ), $months);
		}
		elseif( $n >= (60*60*24*7*4*12) ){
			$years		= round($n/(60*60*24*7*52)) ;
			$time_diff 	= sprintf( _n('about a year ago', 'about %d years ago', $years, CPTW_TEXTDOMAIN ), $years);
		}

		return ucfirst( $time_diff );
	}

	/**
	 * AJAX Get Tweets
	 *
	 * @since 0.1
	 */
	public function ajax_get_tweets() {

		$usernames 	= !empty( $_POST['usernames'] ) ? explode( ',', $_POST['usernames'] ) 	: array();
		$search 	= !empty( $_POST['search'] ) 	? explode( ',', $_POST['search'] ) 		: array();
		$favorites 	= !empty( $_POST['favorites'] ) ? explode( ',', $_POST['favorites'] ) 	: array();
		$count 		= !empty( $_POST['count'] ) 	? (int) $_POST['count'] 				: 10;

		// Feed args
		$feed_args = array(
			'usernames'	=> $usernames,
			'search'	=> $search,
			'favorites'	=> $favorites,
			'count'		=> $count
		);

		$tweets = $this->get_lastest_tweet_objects( $feed_args );

		if ( !empty( $tweets ) ) {
			foreach( $tweets as $k => $tweet ) {

				// User
				$user_id 	= '';
				$user_name 	= '';
				if ( isset( $tweet->user ) ) {
					$user_id 	= $tweet->user->id;
					$user_name 	= $tweet->user->name;
				}
				elseif( isset( $tweet->from_user_id ) ) {
					$user_id 	= $tweet->from_user_id;
					$user_name 	= $tweet->from_user_name;
				}

				// time difference
				// WP version: $time_ago = human_time_diff( $tweet->timestamp, current_time('timestamp') );
				$time_ago = $this->human_time_diff( $tweet->timestamp );

				?>
				<div class='cp-tweet'>
					<p class='cp-tweet-text'>
						<?php echo $tweet->text; ?>
					</p>
					<p class='cp-tweet-meta'>
						<a class='cp-tweet-timestamp' href="https://twitter.com/twitterapi/status/<?php echo $tweet->id_str; ?>"><?php echo $time_ago; ?></a> <?php _e( 'from' ); ?> <a class='cp-tweet-author' href="https://twitter.com/intent/user?user_id=<?php echo $user_id; ?>" title="<?php echo esc_attr( $user_name ); ?>"><?php echo $user_name; ?></a>.
					</p>
				</div>
				<?php
			}
		}

		exit;
	}

	/**
	 * OAUTH
	 *
	 * @reference http://www.webdevdoor.com/php/authenticating-twitter-feed-timeline-oauth/
	 *
	 * @since 0.1
	 */
	private function authenticate() {

		session_start();
		require_once 'twitteroauth/twitteroauth.php';

		// oAuth credentials
		$oauth_defaults = array(
			'consumerkey'		=> '',
			'consumersecret' 	=> '',
			'accesstoken'		=> '',
			'accesstokensecret'	=> '',
		);

		$credentials = (object) wp_parse_args( $this->oauth, $oauth_defaults );

		$this->connection = new TwitterOAuth( $credentials->consumerkey, $credentials->consumersecret, $credentials->accesstoken, $credentials->accesstokensecret );
	}

	/**
	 * Verify Credentials
	 *
	 * @since 0.1
	 */
	public function verify_credentials() {

		$this->authenticate();

		return $this->connection->get('https://api.twitter.com/1.1/account/verify_credentials.json');
	}

	/**
	 * Add timestamp
	 *
	 * @since 0.1
	 */
	private function add_timestamp( $tweet ) {
		$tweet->timestamp = strtotime( $tweet->created_at );
	}

	/**
	 * Cleanup
	 *
	 * Tweet transient will get to big if we do not cleanup
	 *
	 * @since 0.1
	 */
	private function cleanup( $tweet ) {

		if( isset( $tweet->entities ) )
			unset( $tweet->entities );

		if( isset( $tweet->user ) )
			unset( $tweet->user->entities );

		if( isset( $tweet->metadata ) )
			unset( $tweet->metadata );

		if( isset( $tweet->geo ) )
			unset( $tweet->geo );
	}

	/**
	 * Sortby timestamp
	 *
	 * @since 0.1
	 */
	private function sortby_timestamp( $a, $b ) {

		return strcmp( $b->timestamp, $a->timestamp );
	}

	/**
	 * Get latest tweets
	 *
	 * @since 0.1
	 */
	public function get_lastest_tweet_objects( $feed_args = array() ) {

		$previous_tweet_ids = get_transient( 'cp_latest_tweet_ids' );
		$current_tweet_ids 	= array();

		$tweets = $this->get_tweet_objects( $feed_args );

		if ( ! $tweets )
			exit;

		// the twitter box is empty, so we return all tweets to fill it up
		if ( '0' !== $_POST['is_empty'] ) {

			foreach ( $tweets as $k => $tweet ) {

				// store current tweet ids
				$current_tweet_ids[] = $tweet->id;

				// remove tweets that have already been served
				if ( !empty( $previous_tweet_ids ) && in_array( $tweet->id, $previous_tweet_ids ) ){
					unset( $tweets[ $k ] );
				}
			}

			set_transient( 'cp_latest_tweet_ids', $current_tweet_ids );
		}

		return $tweets;
		exit;
	}

	/**
	 * Shprt Hash for caching unique tweets
	 *
	 * @since 0.1
	 */
	private function generate_hash( $input = '' ) {
		if ( is_array( $input ) )
			$input = serialize( $input );

		return substr( strtolower( preg_replace('/[0-9_\/]+/', '', base64_encode( sha1( $input ) ) ) ), 0, 12 );
	}

	/**
	 * Get Tweets
	 *
	 * @since 0.1
	 */
	public function get_tweet_objects( $feed_args = array(), $clear_cache = false ) {

		// feed arguments
		$defaults = array(
			'usernames' => array(),
			'search'	=> array(),
			'favorites' => array(),
			'count'		=> 10
		);
		$args = wp_parse_args( $feed_args, $defaults );

		// generate cache_key so each setting get's stored seperately
		$cache_key = 'cptweets' . $this->generate_hash( $args );

		// authenticate
		$this->authenticate();

		// debug only
		if ( $clear_cache ) delete_transient( $cache_key );

		// cache
		$tweets = get_transient( $cache_key );

		// cache expired?
		if ( ! $tweets ) {

			extract( $args );

			$tweets = array();

			// Usernames
			if ( !empty( $usernames ) ) {
				foreach( $usernames as $username ) {
					$result = $this->connection->get( "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $username . "&count=" . $count );

					if( empty( $result ) ) continue;

					$tweets = array_merge( $tweets, $result );
				}
			}

			// Search
			if ( !empty( $search ) ) {
				foreach( $search as $phrase ) {
					$result = $this->connection->get( "https://api.twitter.com/1.1/search/tweets.json?q=" . urlencode( $phrase ) . "&rpp=" . $count . "&include_entities=true&result_type=mixed" );

					if( empty( $result->statuses ) ) continue;

					$tweets = array_merge( $tweets, $result->statuses );
				}
			}

			// Favorites
			if ( !empty( $favorites ) ) {
				foreach( $favorites as $username ) {
					$result = $this->connection->get( "https://api.twitter.com/1.1/favorites/list.json?screen_name=" . $username . "&count=" . $count );

					if( empty( $result ) ) continue;

					$tweets = array_merge( $tweets, $result );
				}
			}


			// Parse URLs inside Tweet text
			array_map( array( $this, 'parse_message' ), $tweets );

			// Add timestamp
			array_map( array( $this, 'add_timestamp' ), $tweets );

			// Sort by timestamp
			uasort( $tweets, array( $this, 'sortby_timestamp' ) );

			// Limit array length
			array_slice( $tweets, 0, $count );

			// Cleanup twitter entities for transient storage ( in some cases it created a fatal error, maybe size? )
			array_map( array( $this, 'cleanup' ), $tweets );

			// Caching
			if ( !empty( $tweets ) ) {
				set_transient( $cache_key, $tweets, 30 ); // 30 seconds
				set_transient( $cache_key . 'long', $tweets, 3600 * 24 * 30 ); // month
			}
		}

		// if last retrieval failed, let's try and use the long term cache if it is available
		if ( empty( $tweets ) ) {
			$tweets_cache = get_transient( $cache_key . 'long' );
			if ( !empty( $tweets_cache ) ) {
				$tweets = $tweets_cache;
			}
		}

		return $tweets;
	}

	/**
	 * Parse Tweet Text
	 *
	 * @reference: https://gist.github.com/styledev/3337428
	 * @reference: https://gist.github.com/thenew/5487645
	 *
	 * @since 0.1
	 */
	private function parse_message( $tweet, $encoding = "UTF-8" ) {
	    $replace_index = array();

	    if ( isset($tweet->entities) ) {
	        foreach ($tweet->entities as $area => $items) {
	            switch ( $area ) {
	                case 'hashtags':
	                    $find 	= 'text';
	                    $prefix = '#';
	                    $url 	= 'https://twitter.com/search/?src=hash&q=%23';
	                    break;
	                case 'user_mentions':
	                    $find 	= 'screen_name';
	                    $prefix = '@';
	                    $url 	= 'https://twitter.com/';
	                    break;
	                case 'media': case 'urls':
	                    $find 	= 'display_url';
	                    $prefix = '';
	                    $url 	= '';
	                    break;
	                default: break;
	            }
	            foreach ($items as $item) {
	                $text = $tweet->text;
	                if($area == 'urls') {
	                    $replace 	= mb_substr($text,$item->indices[0],$item->indices[1]-$item->indices[0], $encoding);
	                    $with 		= '<a href="'.$item->expanded_url.'" target="_blank">'.$item->display_url.'</a>';
	                } else {
	                    $string = $item->$find;
	                    $href 	= $url.$string;
	                    if ($area != "hashtags" && $area != "user_mentions" && (!(strpos($href, 'https://') === 0) || !(strpos($href, 'http://') === 0)) ) $href = "http://".$href;
	                    $replace 	= mb_substr($text,$item->indices[0],$item->indices[1]-$item->indices[0], $encoding);
	                    $with 		= "<a href=\"$href\" target=\"_blank\">{$prefix}{$string}</a>";
	                }
	                $replace_index[$replace] = $with;
	            }
	        }
	        foreach ( $replace_index as $replace => $with ) {
	        	$tweet->text = str_replace( $replace, $with, $tweet->text );
	        }
	    }
	    return $tweet;
	}
}

/**
  * Init of Twitter
  *
  * @since 0.1
  */
function init_codepress_twitter() {

	new Codepress_Twitter();

	/*
	// DEBUG
	$twitter = new Codepress_Twitter( array(
		'consumerkey'		=> '',
		'consumersecret' 	=> '',
		'accesstoken'		=> '',
		'accesstokensecret'	=> ''
	));
	$tweets = $twitter->get_tweet_objects( array( 'search' => array( '#wordpress' ) ), $clear_cache = true );
	echo '<pre>'; print_r( $tweets ); echo '</pre>';
	$account = $twitter->verify_credentials();
	$tweets = $twitter->get_tweet_objects( array( 'usernames' => array( 'codepressNL' ) ), $clear_cache = true );
	echo '<pre>'; print_r( $tweets ); echo '</pre>';
	$account = $twitter->verify_credentials();
	echo '<pre>'; print_r( $account ); echo '</pre>';
	exit;
	*/
}
add_action( 'init', 'init_codepress_twitter' );

