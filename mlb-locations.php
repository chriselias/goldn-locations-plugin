<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://mylocalbeacon.com
 * @since             0.0.2
 * @package           MLB Locations
 *
 * @wordpress-plugin
 * Plugin Name:       GOLDN Locations
 * Plugin URI:        http://mylocalbeacon.com
 * Description:       Pull in location data with shortcodes
 * Version:           0.0.2
 * Author:            My Local Beacon
 * Author URI:        http://mylocalbeacon.com/
 * License:           Closed source
 * Text Domain:       goldn-locations-plugin 
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/chriselias/goldn-locations-plugin',
	__FILE__,
	'goldn-locations-plugin'
);

//Optional: Set the branch that contains the stable release.
$myUpdateChecker->setBranch('master');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mlb-locations.php';


/**
 * Create shortcodes for the locations
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mlb-shortcodes.php';

/**
 * Create locations widget
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mlb-locations-widget.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mlb_locations() {

  $plugin = new MLB_LOCATIONS();
  $plugin->run();

}
run_mlb_locations();


// updated plugin test again....