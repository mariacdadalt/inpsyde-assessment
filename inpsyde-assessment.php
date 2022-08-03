<?php
/**
 * Plugin Name: Maria C. Dadalt's Inpsyde Assessment
 * Plugin URI:
 * Description: A plugin build to assess coding ability.
 * Version: 1.0
 * Author: Maria C. Dadalt
 * Author URI:
 * License: MIT
 */

if ( ! defined( 'PLUGIN_ASSESSMENT_DIR' ) ) {
    define( 'PLUGIN_ASSESSMENT_DIR', WP_CONTENT_DIR . '/plugins/inpsyde-assessment/' );
}

if ( ! defined( 'PLUGIN_ASSESSMENT_LANG' ) ) {
    define( 'PLUGIN_ASSESSMENT_LANG', 'inpsyde-assessment' );
}

/**
 * Autoload utility functions
 */
function load_assessment_functions() {
    foreach ( glob( PLUGIN_ASSESSMENT_DIR . '/src/Functions/*.php' ) as $file ) {
        require_once $file;
    }
}
load_assessment_functions();


/**
 * Register the plugin instance with the Core Plugin.
 */
core()->register_plugin( new \Plugin\Assessment\Plugin() );