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
define('DB_NAME', 'wordpress');

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
define('AUTH_KEY',         'Tutj}~:&GnNiS;vRDusGu0m4%%;|o[jFbX:DLi`&b5Ve?%;O!j%K)|!k-EnyD%:Q');
define('SECURE_AUTH_KEY',  '^4#G=p^|[A>R`jCq4*!x[RHC_#uY[(aaEIhu:?(6A4FMwEGlK[]J`U;:*7z/;Pb[');
define('LOGGED_IN_KEY',    'uQ74QyV|N!-?Kmh |..ICdw(PRoY;O`+yI0q8$p=&F=9Xb,S2-toXJ*i+x/+!H#B');
define('NONCE_KEY',        '*0i#++&Gd[-ppN.qPdtED7BdS#{^-3TnWpT2,[NW[]Reru+RjtVsX*9m@hQOPppE');
define('AUTH_SALT',        ':a$vrgFquz1)l<bTgVyye/30k`7;Db^[Yuw(+R lNJmZJ1xuRkX;}&S5`-mQ$B@[');
define('SECURE_AUTH_SALT', '77+Jh4`, ei>zC-}_;5AjGp!+wEMab5TS4[!v][y,KpRr(qKk`w,53M#w-A6hx]B');
define('LOGGED_IN_SALT',   'GW#t=L|DvY6#>)S }-Gs/Ra!(me-p041~aOHjA5.W4yrg9I(%BfzlI$bzx$sk>@*');
define('NONCE_SALT',       '?i6#yn`DDp#?|z+k!T#[3O5h+Mc@U#hW.eF~?bn+PM(SAwqP7~):GKb7]pJ*uMMz');

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
define('WP_DEBUG', true);
define('API_URL_HOME','http://local.reportapp.com:8080/index.php');
define('API_URL','http://local.reportapp.com:8080/index.php/search/search_ajax');
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

date_default_timezone_set('Australia/Sydney');