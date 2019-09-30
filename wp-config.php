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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'qprcar01' );

/** MySQL database username */
define( 'DB_USER', 'qprcar01' );

/** MySQL database password */
define( 'DB_PASSWORD', '8C1ZRN56TOo4pBY' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          'U8Dnd1f02<`TPtygp@js6w&d)qSu4;@T5kH9go0[-z?/sV#0JqcW=d[wT. +)CMy' );
define( 'SECURE_AUTH_KEY',   '5n~ybk6.%DE8v^<NiF{<$<N^3fByNu sA1Qg<[^{mubK6.+bA<Kt-o-794!5enK1' );
define( 'LOGGED_IN_KEY',     '<>/1NLK7fhT9<>RAYy|E<%]h8T3v(4vI>c(yH7e 41{Yu~m>F)Rw~DL}65qj>qPI' );
define( 'NONCE_KEY',         '.NCapM5PG5_V}rfmE,qB1w#83+k;av`*)3dvPIm[x(I^?9_7D3+ `^`sW3hFX70j' );
define( 'AUTH_SALT',         '{;c`)JYZXP[G}Ldy7cV0yCrq1$:c0>d5zxXpd])=NSg*K&|RBX{IV>8almh]Y&P8' );
define( 'SECURE_AUTH_SALT',  'X^+zF(F Y%he`[3r~62B1ba&h1,fwi+ <.y[3cLv4E,+Jt&^omaXD@4YUrD8GRM-' );
define( 'LOGGED_IN_SALT',    'N.M6xCdWZp?rvQ%ZdGh8>5t3J/.LiWV hgPY41t$Fs0B1j+v(>]+g7DG7}YD~+ib' );
define( 'NONCE_SALT',        '&L8.E]a si3J }Dn^bSGHuH)DJzo;UjNt?cO0WA4ZXLr$+dqO=zF9pb!WlWRe&PF' );
define( 'WP_CACHE_KEY_SALT', 'YfV/*q4M+lXvc,cro[@pLd%PF?f2|T+?DX-=PEjCh]Zj7zljECp~+FVj [{b{`!D' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
