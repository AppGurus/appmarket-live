<?php
   /*
   Plugin Name: Applay - Member
   Plugin URI: http://leafcolor.com/
   Description: Applay - Member post type functions
   Version: 1.0
   Author: leafcolor
   Author URI: http://leafcolor.com/
   License: GPL2
   */
   
if ( ! defined( 'APP_MEMBER_BASE_FILE' ) )
    define( 'APP_MEMBER_BASE_FILE', __FILE__ );
if ( ! defined( 'APP_MEMBER_BASE_DIR' ) )
    define( 'APP_MEMBER_BASE_DIR', dirname( APP_MEMBER_BASE_FILE ) );
if ( ! defined( 'APP_MEMBER_PLUGIN_URL' ) )
    define( 'APP_MEMBER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
include('post-type.php');
include('shortcode-member.php');
