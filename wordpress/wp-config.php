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

    // Required for batcache use
    define('WP_CACHE', true);

    // ** MySQL settings - You can get this info from your web host ** //
    /** The name of the database for WordPress */
    define('DB_NAME', 'wordpress_db1');

    if (isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'],'Google App Engine') !== false) {
        /** Live environment Cloud SQL login and SITE_URL info */
        /** Note that from App Engine, the password is not required, so leave it blank here */
        define('DB_HOST', ':/cloudsql/appmarket-live:wordpress');
        define('DB_USER', 'root');
        define('DB_PASSWORD', '');
    } else {
        /** Local environment MySQL login info */
        define('DB_HOST', 'localhost');
        define('DB_USER', 'root');
        define('DB_PASSWORD', '');
    }

    // Determine HTTP or HTTPS, then set WP_SITEURL and WP_HOME
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
    {
        $protocol_to_use = 'https://';
    } else {
        $protocol_to_use = 'http://';
    }
    define( 'WP_SITEURL', $protocol_to_use . $_SERVER['HTTP_HOST']);
    define( 'WP_HOME', $protocol_to_use . $_SERVER['HTTP_HOST']);

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
    define('AUTH_KEY',         'QVBmV_K,l(+r;}v+{]6LbqVxpe;#]O#|juh}pTz4E QdT1Kl&@9[4Ic=c^e5d#{+');
define('SECURE_AUTH_KEY',  '$>A3[)!6AZg?+Xn6ylF> ;mjEtqz=/Ckl}[vJpgNH9$=o`-b&#XZs+2uFZ)]I1Dr');
define('LOGGED_IN_KEY',    'v-APHz6Q8f/toU{%yQ$>VVVE9+|+{Dd&VZ|^N,FfX4g+FU-tpZ%EaT4#{@-28B! ');
define('NONCE_KEY',        '28qht-fPomkE-mR:R$8)&w:m:BTUBRg{m.!5M|4#<3|%v-mx9U-+BSwlvmT6X(9|');
define('AUTH_SALT',        'Gkq zs+l.=MjD/9Nt]3qn9Q9ca#Y`9XU:fww)s+x^/?*@QlVO!56@A1X||Coj8X8');
define('SECURE_AUTH_SALT', 'A+f(sRa&eL+$4P+Qdg&PS%a-k*;Kexa|=v:Zb@@nF$t+L$;}*]9N&M[cqp0YFORL');
define('LOGGED_IN_SALT',   'p8,R/}]?x@.UjK|k0tj}gld#3bN5_rr+##jit,e0pws?U@k-h!pjf[YvzeVeiR{D');
define('NONCE_SALT',       'Ayj?i6Y;v+e<J|t5~>]-vEP`pmm7$,l]Q+P8#BDet%^N,{fOh{l5Y$)6+-zI4xHZ');

    /**#@-*/

    /**
     * WordPress Database Table prefix.
     *
     * You can have multiple installations in one database if you give each a unique
     * prefix. Only numbers, letters, and underscores please!
     */
    $table_prefix  = 'wp_';

    /**
     * WordPress Localized Language, defaults to English.
     *
     * Change this to localize WordPress. A corresponding MO file for the chosen
     * language must be installed to wp-content/languages. For example, install
     * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
     * language support.
     */
    define('WPLANG', '');

    /**
     * For developers: WordPress debugging mode.
     *
     * Change this to true to enable the display of notices during development.
     * It is strongly recommended that plugin and theme developers use WP_DEBUG
     * in their development environments.
     */
    define('WP_DEBUG', false);
    
    /**
     * Disable default wp-cron in favor of a real cron job
     */
    define('DISABLE_WP_CRON', true);
    
    // configures batcache
    $batcache = [
      'seconds'=>0,
      'max_age'=>30*60, // 30 minutes
      'debug'=>false
    ];
    /* That's all, stop editing! Happy blogging. */

    /** Absolute path to the WordPress directory. */
    if ( !defined('ABSPATH') )
        define('ABSPATH', dirname(__FILE__) . '/wordpress/');

    /** Sets up WordPress vars and included files. */
    require_once(ABSPATH . 'wp-settings.php');


