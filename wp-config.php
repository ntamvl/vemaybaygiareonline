<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'vemaybaygiareonline_net');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'nguyen');

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
define('AUTH_KEY',         '+iJ=Q$rLwII4x,W4.c+(Gq3fCPbB=4CKALwny}aSR|00Sc|Z%R:]2mA;Kr6(JX?:');
define('SECURE_AUTH_KEY',  '(Fikb[RmeR.qfws7HVFD%js)E]Uot: d$}ce?24+%EO_u@oc&8B-1Y_2jQC`R}-F');
define('LOGGED_IN_KEY',    ']_m+fp$^0<F*xA *4zKTWJ:a/pt,{3sr+kOX+.Ng5s6=cr/-AFD/33IK$/lXtt,l');
define('NONCE_KEY',        '6UTaq^q.3PYQOaUoh&@jd}(2RFQ)H?$9=&z-R7PvwqL:o;6lSaC8J7TY)M]+}qzC');
define('AUTH_SALT',        'SPP0u&qo=<7Ol-^X^-|K1)`Y^;|1aPk!}dL^D,->y0/qImw%yG{YH9-+l/S`E+T#');
define('SECURE_AUTH_SALT', 'sj9mwiy*H|3_+MtF)#,h(G*]x~>Ru{izh]J9S?`bFRxTS$*)SC3TC(GgU3#yr!#;');
define('LOGGED_IN_SALT',   'K?8Bq%*Kvhz0x}G;0vCbpskD;wC52i#f/ E0(s{d(?X16tInx[+wcV^*p6BL3->g');
define('NONCE_SALT',       '$|HI_C](E=}+T7HBNL[5O=RO_-`5E#qo+CP+#+]Mz_-bhLwEu!s7C;R&DPYr_+QR');

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

define('FS_METHOD', 'direct');
