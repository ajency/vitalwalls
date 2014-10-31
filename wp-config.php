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
define('DB_NAME', 'vitalwalls');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '5nxn`shiS7Qi-Hnm2o3-v8fKg`q63s`^`!E&6j01zo}yZP7Y9Mg2mu6AroD40X?f');
define('SECURE_AUTH_KEY',  '1Z.?;*V5}wLIy+~k@f-wAL1g1c.ki1I{MOIZWk*KD|-C*h:L2]=AKdVqdO@U4)dq');
define('LOGGED_IN_KEY',    ';|-6;jROHl@+8DRjyr?,&G*,8i|HfqCPGK$GMvGAwK{Qdjp3PdEc|&@+GFj5|Mi{');
define('NONCE_KEY',        'u]-qt|?fS7LoD@}(]ijbw1I%3DH!*Hi`uC&#[o3PJtx);T}cYw0d0?&YojCf_>b3');
define('AUTH_SALT',        'r5|r3fw1K7!B2D69d.VSUY,.j69cLwg[E-NA6[6p%an~e21uXD5+:@ 0a`U*+mug');
define('SECURE_AUTH_SALT', 'R{,v5MSY&T2~A9*NIfh^t:T^PG&i^HEL2N{gyHt7M]yUi s=OhUcYRT[fHC%=B-(');
define('LOGGED_IN_SALT',   '%YfTv(F;AN?,.!P<EDI9vNc2l[0u_$Ab2r#g29#KC|1^fM-&35VUFo-w|~m>f-S:');
define('NONCE_SALT',       'aLH,{%>. Dk.FLjwA[}S&u=pdi:%@F#,|DzT bl|=9L~FK(p2!7DIm6K;/0I8pzr');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
