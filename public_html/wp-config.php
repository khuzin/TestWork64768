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
define('DB_NAME', 'f0644638_testing');

/** MySQL database username */
define('DB_USER', 'f0644638_testing');

/** MySQL database password */
define('DB_PASSWORD', '081030');

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
define('AUTH_KEY',         'cDS0Vpp8EwJ%t3QNclodyWBOlBGQQL1l!@I0l&Ht1A6EeutxaBuGBpXKyY6vZz)7');
define('SECURE_AUTH_KEY',  '^D%Tw%KmEjR#zHu(5Ka6M4vTYra0d4jvLvJw)7nD#RcTxr#8Ld)EsP6heC4pa!l2');
define('LOGGED_IN_KEY',    'AYZ@niEjcVctkDy^ZNR%8ObUtuLTAAVYy6Adlew#G(MsKu4xUj19M8!d1SEr9*yH');
define('NONCE_KEY',        '&1o)s6LrToGWGhRrDZ!AltsFu&%#Ck36BPoMODRL^HxC1rN78iWW9nhxGqZa73SW');
define('AUTH_SALT',        'JpJfoIQjIq4DtNeCzEVw1^lgO%MT6pF3aiYAWz3dn2v1n4)3YTUAZ3Ycdzwnj)Un');
define('SECURE_AUTH_SALT', '1NZGwWwCbIOb8#MQtxxMLN1Z*osSTvDCE%^4KtlaMl)lUx((B(7ZNP0#%KoBv!S6');
define('LOGGED_IN_SALT',   'va#weNpChCT@1JcJAYjj^0XDbRDCdUs6MGD(R&mAup)qGHSgpQolSNMhPY&Uqdf!');
define('NONCE_SALT',       'UNEQ(MEtkU(Qrb2@qF0WXo3KpwLvb2YahHFdD0Ui(S#LwnKNrG2YB9H75FWbeGl3');
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

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define( 'WP_ALLOW_MULTISITE', true );

define ('FS_METHOD', 'direct');
