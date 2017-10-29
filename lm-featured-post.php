<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://profiles.wordpress.org/leonidasmilossis
 * @since             1.0.0
 * @package           Lm_Featured_Post
 *
 * @wordpress-plugin
 * Plugin Name:       LM Featured Post
 * Plugin URI:        #
 * Description:       This plugin offers the admin the ability to mark any post as Featured Post.
 * Version:           1.0.0
 * Author:            Leonidas Milosis
 * Author URI:        https://profiles.wordpress.org/leonidasmilossis
 * License:           MIT License
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       lm-featured-post
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lm-featured-post-activator.php
 */
function activate_lm_featured_post() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lm-featured-post-activator.php';
	Lm_Featured_Post_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lm-featured-post-deactivator.php
 */
function deactivate_lm_featured_post() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lm-featured-post-deactivator.php';
	Lm_Featured_Post_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lm_featured_post' );
register_deactivation_hook( __FILE__, 'deactivate_lm_featured_post' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lm-featured-post.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lm_featured_post() {

	$plugin = new Lm_Featured_Post();
	$plugin->run();

}
run_lm_featured_post();
