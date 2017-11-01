<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/leonidasmilossis
 * @since      1.0.0
 *
 * @package    Lm_Featured_Post
 * @subpackage Lm_Featured_Post/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Lm_Featured_Post
 * @subpackage Lm_Featured_Post/public
 * @author     Leonidas Milosis <leonidas.milosis@gmail.com>
 */
class Lm_Featured_Post_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Lm_Featured_Post_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lm_Featured_Post_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lm-featured-post-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Lm_Featured_Post_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lm_Featured_Post_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lm-featured-post-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Display the current Featured Post, if any.
	 *
	 * @since    1.0.0
	 */
	public function lmfp_display_featuredpost() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/lm-featured-post-public-display.php';

	}
}
