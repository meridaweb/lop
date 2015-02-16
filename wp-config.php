<?php

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'd_lop');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'r00t');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'nHxZL/xb:9+q8|-L7?Ip@5AWb96B/_z;ZIt;-<!`.vNJ@B|6umiR|nSze{z;+iWo');
define('SECURE_AUTH_KEY',  '!<]N<AN+_|</JR&7(Gdg{.1GB5 m[~O)r]xFcj/d+LT?:WOoRqe9J8NE-;WPmh:W');
define('LOGGED_IN_KEY',    '&UUYUC0ChYD)($Wu-Ih//Zty9$%%k!,hvA2[%0$HoGl@]7KUW.~|&NF),$r<^77F');
define('NONCE_KEY',        '4@y_EXvxzwm<+un-SM*!+|O %?u9PU1UL3Gyz12l@emgoJ-T,s3!mh<~g-n*J*Wb');
define('AUTH_SALT',        'OMjo }a(X s(%cu(B+RM6Z5DlOrgZ&#o/O0KFsX);3(NL1Y.[jT^8x%Y_GPUSG~3');
define('SECURE_AUTH_SALT', 'gZ2;@Bs?Y]/bc7[+~H8C<Ihq(sBEG~Bw3}Ig,w]shmVw|wh1-%z-%s -V2E4w|Si');
define('LOGGED_IN_SALT',   '@,]7g6hT_2]dc`#I[{hZ/^.9<z>:k,E:(||D5T&1f. @=n+]9P3(SC+P.TtG1>Z:');
define('NONCE_SALT',       'hK??eWKC/`g;m-yJhXR[Nd:PJ!LZOf6HaYsS`Fs,%{#P+j25QpFGhf<^X|{j*U#k');


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
