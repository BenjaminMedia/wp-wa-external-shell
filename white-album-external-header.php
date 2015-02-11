<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           White_Album_External_Header
 *
 * @wordpress-plugin
 * Plugin Name:       WhiteAlbum External Header
 * Plugin URI:        http://example.com/white-album-external-header-uri/
 * Description:       Co-branding for blogs collaborating commercially with Bonnier Media AS
 * Version:           1.0.0
 * Author:            Bonnier Interactive & Duke UX
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       white-album-external-header
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-white-album-external-header-activator.php
 */
function activate_white_album_external_header() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-white-album-external-header-activator.php';
  White_Album_External_Header_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-white-album-external-header-deactivator.php
 */
function deactivate_white_album_external_header() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-white-album-external-header-deactivator.php';
  White_Album_External_Header_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_white_album_external_header' );
register_deactivation_hook( __FILE__, 'deactivate_white_album_external_header' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-white-album-external-header.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_white_album_external_header() {

  $plugin = new White_Album_External_Header();
  $plugin->run();

}
run_white_album_external_header();
