<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://profiles.wordpress.org/leonidasmilossis
 * @since      1.0.0
 *
 * @package    Lm_Featured_Post
 * @subpackage Lm_Featured_Post/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Lm_Featured_Post
 * @subpackage Lm_Featured_Post/includes
 * @author     Leonidas Milosis <leonidas.milosis@gmail.com>
 */
class Lm_Featured_Post_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		// Delete plugin settings
		delete_option( 'lm-featured-post-settings' );

	}

}
