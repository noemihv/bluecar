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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'wordpress' );

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
define('AUTH_KEY',         '&_3LZM{5}C=wB]KpHv<TP;UTuL7g6eg~-jA|-R;xI_$9fe5gD!`sUd|XxJl8KJ%-');
define('SECURE_AUTH_KEY',  '|!%shMgHLuvVqc9>|50i3#u{M9f6hcL[8?c{V+xSQ-r)D3dlZm62M{9,Eg23silJ');
define('LOGGED_IN_KEY',    '~?oA|PQ[Dw#slN5|/rA7|XZFceQbm7p@<j@k!IQN(g>,,:gg4io753xrSjpu*iHE');
define('NONCE_KEY',        'UXA+tCC{XH3V;:fq+8&A6?]H?uI*tdN <P1C[ZN`^JmiKN~Icf|;5FAT|*k.!B1c');
define('AUTH_SALT',        ')FvAxr<._w$XS)b:[k_spWrL=.hT_w|,Wu`O{f{CFX_d%z$_C,K[8B{6rC{+Ab|,');
define('SECURE_AUTH_SALT', '-CX[5W=(Ww5Xa)sE&Iq{O$iY@GjCdLoQNHxAWp~d7fQJ=m$%HMqg{(r)<>MPI)X[');
define('LOGGED_IN_SALT',   'yWGm=NHOv=_-ioX1sX}K0#;tXYly2m>seD_bu 2(N0?3U1++nkN|~@GA#R!CI)Le');
define('NONCE_SALT',       '`/^yH]Wv9eH~GIL?u4bEgi2Cf&7oJV^V(d{(e(K@p)?n+AC%zZ|Q(1_#lJ7=d}(!');


/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
