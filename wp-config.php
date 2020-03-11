<?php
define('WP_CACHE', true);
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

/** MySQL database username */

/** MySQL database password */

/** MySQL hostname */
define( 'DB_HOST', 'mysql' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '1uEd0.L,|hNoJF5.>ve;[V?f&jiQd]kkS</KM1wqJ,{g!TDcY@mER@_zPy^|8L7)' );
define( 'SECURE_AUTH_KEY',   'rSCv]s1o3|dZNxZ8qv2GN ,~FA:__,X.$}L*^J!HyA=]&*P31^5H1+`}dynSPei7' );
define( 'LOGGED_IN_KEY',     '5#QTOj=#0tA{|jZ$y<Ba5xF^1U3-5b3?deD;Os=HcE4=r;h$xQm%xRJ] I*hWfT.' );
define( 'NONCE_KEY',         'R_r}.X|}3{O#lwhtx]+GR;0?RT5kDI@^/;sAY7d9)bO*XCBJO >=|!x[AuRu<Mw)' );
define( 'AUTH_SALT',         '=,r+hw[,6]vqp<a24Yp/EWyD/ HU|tZ6cx!1H3sj>G)K0@`Z0g4e/1zI5OZY?0 I' );
define( 'SECURE_AUTH_SALT',  '.2}RyaTBLJ06{;R)2/H)cRRK+omVUu_ETRbN#`fz)8k*+|<Wd:9l&;a*-W!mJ|P>' );
define( 'LOGGED_IN_SALT',    '>co]]w%+1&L!:p::-U<ju]e~~n,j_u%>-Kt#{Ufn1XZE~f1h-eIRj/WvhJQap3U_' );
define( 'NONCE_SALT',        'D8{SW9s;j*bKgOmbHJf *Cx,?3I>{}8UwJ9>8U+6R;~;J*F)V &6laxNpuh;IJz3' );
define( 'WP_CACHE_KEY_SALT', 'r{oA7!sn*n7t;q?73n@U?2=#(RzZrPR.Zf_$E;]]Rj7<?dft#f/{X83 !/_m7XBH' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
