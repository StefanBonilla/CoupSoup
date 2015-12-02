<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'bitnami_wordpress');

/** MySQL database username */
define('DB_USER', 'bn_wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'b34bd7e2a9');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1:3306');

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
define('AUTH_KEY',         '8399b304f0d0f4e19318662ecc0f987c8b7f478ef51dece293c5c64d1a1cc88e');
define('SECURE_AUTH_KEY',  '24f4302073f63d9e10ed8c032f016aac7e73b7f95bb0827289668923a09f70f4');
define('LOGGED_IN_KEY',    'e38c49f77f65579843bd82eefb533d8f89adcb9f26dede6de40df0e1fa8b2a84');
define('NONCE_KEY',        '8ec252f893cedfee8922fd1411f50c95e6084444650c9c0704f301733c64c7d2');
define('AUTH_SALT',        'f018dcb2bdc0d4687c35785feb4f37d243bbe02d08f840cab6cfc557305180f3');
define('SECURE_AUTH_SALT', '7f9e27ff766b59ee1df5f4a03aaa57e0a8ccf8c026da40f574d7f20560c32518');
define('LOGGED_IN_SALT',   'd8eb602766ad651b65d00ccd45f9bc2e93c760b5af3b260c25ece321966204e8');
define('NONCE_SALT',       '083b55186398abd466fda669295df8d92ccf18a8d49ecf5c0471e2cc6103d5f9');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */
/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','http://example.com');
 *  define('WP_SITEURL','http://example.com');
 *
*/

define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/wordpress');
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] . '/wordpress');


/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('WP_TEMP_DIR', 'C:/Bitnami/wampstack-5.5.30-0/apps/wordpress/tmp');

