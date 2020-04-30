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

// set global environment var
$GLOBALS['environment'] = getenv('environment') ?: getenv('APP_LOCATION') ?: '';
switch ( $GLOBALS['environment'] ) {
	case 'prod':
		require_once(dirname(__FILE__) . '/env.prod.php');
		break;
	case 'stage':
		require_once(dirname(__FILE__) . '/env.stage.php');
		break;
	default:
		require_once(dirname(__FILE__) . '/env.dev.php');
		break;
}

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
define('AUTH_KEY',         '499f026a276d8cb9dd0c5336b06af9b37c406039');
define('SECURE_AUTH_KEY',  '73fc1d0c080c4058dccf8c523898055da50de944');
define('LOGGED_IN_KEY',    'c970def699dfb6d2ba15e1d21adcfe5d3599b6f3');
define('NONCE_KEY',        '3f06fd0c875c35b537a43a583a9866887d0063a4');
define('AUTH_SALT',        '32e0b8cc2728c3c7d8448e7144804cda45aa2103');
define('SECURE_AUTH_SALT', 'bd41a4b4497e45f41fda6708aaf01af381085f66');
define('LOGGED_IN_SALT',   '8081559e6203cbe6ccc0c2009238162bb7a35c02');
define('NONCE_SALT',       '07f67603da15df536c97ae7824a98f6b959fb885');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define('WP_DEBUG', in_array($GLOBALS['environment'], array('dev','local')) ? true : false);
define('WP_DEBUG_LOG', WP_DEBUG);
if (!$_GET['debugIt']) {
    define('WP_DEBUG_DISPLAY', false);
    ini_set('display_errors', 'Off');
}
else {
	define('WP_DEBUG_DISPLAY', true);
	ini_set('display_errors', 'On');
    if ($_GET['debugIt'] == 'php') {
    	phpinfo();
    }
}

// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}

// Custom structure
$proto = $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
define('WP_HOME', $proto . $_SERVER['HTTP_HOST']);
define('WP_SITEURL', $proto . $_SERVER['HTTP_HOST'] . '/core');
define('WP_CONTENT_FOLDERNAME', 'main');
define('WP_CONTENT_DIR', dirname(__FILE__) . '/main');
define('WP_CONTENT_URL', '/main');

// force direct fs access
define('FS_METHOD', 'direct');
// disable plugin and theme file edits from wp admin
define( 'DISALLOW_FILE_EDIT', true );

/* Multisite */
define('WP_ALLOW_MULTISITE', true);
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'web-picasso.'.$GLOBALS['environment'].'.aplaceformom.com');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
