<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpressuser' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Boomer!2025' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'p]7@xq>v:GRCA`];{uQ=R?)i3JYl)oT@YZ0Z)ZY!zYr:F(#^8=2<5_DK~7C?B*}I' );
define( 'SECURE_AUTH_KEY',  'Nw$}<zi;xf/rux>Krqbg$.FZmYk%b@9c$!gEn2NMi@Sg!9}+H#}&Ev43cI+|:=5E' );
define( 'LOGGED_IN_KEY',    '4Xbj4vmTV W;1;_HrK9v%1t91tLokPEtuGQ30gR]dNm>{LXgA(Rog:9bQX1>H]xY' );
define( 'NONCE_KEY',        '+m|b8c&V)KM-CWWh5O;hD5s4fr,f$]XKOQZ)F;AhSxM= 6x&RdVR||s*==|;GOo]' );
define( 'AUTH_SALT',        '^|0Lhii30{BjlQ+n`cm&|&}6U+%/7vz&){QBliPYvZnLvHYoaK?zX~, JXJvhSK6' );
define( 'SECURE_AUTH_SALT', '?;qKDG{/4,wq~n5&nq9.kj_?yg<N#+6F_bJo9SqnQ9jh;QMG,|Nb|L:D/-fKzf,^' );
define( 'LOGGED_IN_SALT',   'rc2Oy{9?wrbE_=&F!&,%`#zQ3YnYK xV_VzT2:dcF%U8u+=WoxKW=oBrY]I0b_PT' );
define( 'NONCE_SALT',       'NJe[EliM bNrJm Ouy2GR-B&s1xNw%fRTid^t}Cu}84/rp|CH2SAGVHI:q:~W&Kg' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
