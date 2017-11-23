<?php
defined('ABSPATH') or die('No script kiddies please!');

/*
Plugin Name:  VWest Plugin Pack
*/
// Directories
define('VWESTPLUGIN_ABSPATH', plugin_dir_path(__FILE__));

// Various tools
require_once(VWESTPLUGIN_ABSPATH . 'youtube-plugin/cathys-youtube-plugin.php');


/**
 * Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
 */
add_action( 'wp_enqueue_scripts', 'vwest_add_my_stylesheet', 100);

/**
 * Enqueue plugin style-file
 */
function vwest_add_my_stylesheet() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'vwest-tracks', plugins_url('override.css', __FILE__) );
    wp_enqueue_style( 'vwest-tracks' );
}