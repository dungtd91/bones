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
define('DB_NAME', 'sample_wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '0|F.iPRWr>(>%!<m<sWeT&]OHTV>=%G|lPrEXhcvDuakKr^]OY7t] R@!&=y4+rB');
define('SECURE_AUTH_KEY',  'mMu7{#XDA-[QI%g;-+H4d-z3l6V5L+bO$|_|`Nym,mkvN}sHZ9,chBoPY0i5.iPe');
define('LOGGED_IN_KEY',    '$EgI_j.(Yaag(e&O-9|*8aT+-Mf2K/vI@+Pbdr{GZXhC!lc:M-2lJw|0I:IM@c-V');
define('NONCE_KEY',        'T$a6qJJ$(U_4.zeb5n@ftXPm&nbx&!QaSA$x6wgkB9ER.L-n4VIL(]U;ikI-=zpP');
define('AUTH_SALT',        'g: ,|jm`&r).b2GMe#jP6wpMx1[D8/8R-:,zmsDy=-W1@ >)T1vH3tPlGvk7=<e~');
define('SECURE_AUTH_SALT', '=e_><SeUh4`V|XQZ:qm:{~%lhCJ%*>|7 ]vT-:+nz@/k|<+@5dN*,B!>9#u5`:/2');
define('LOGGED_IN_SALT',   '=-({ky[5mL#*0}5dH{aA2L^d$!hT>__9qB%BU8|aU|$AT_Dk5tN*m}_xN+G^4V!]');
define('NONCE_SALT',       '1K~#=c6Qi1-Oj xlzH/%6/`Vt~y0ZN|`~+9w&RY583kk<Y^l=OS,l(<,SrO[*cs;');

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

