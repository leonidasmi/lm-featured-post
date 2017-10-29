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
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
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
		//Get the Featured Post
		$myquery = new WP_Query( "post_type=post&meta_key=lmfp_is_featuredpost&meta_value=1" );

		// The Loop
		if ( $myquery->have_posts() ) {

			//// Website Options
			$lmfp_style	= 'display: none;';
			$lmfp_style_a = '';

			// Change the colours
			$options = get_option( $this->plugin_name . '-settings' );
			$lmfp_bg = $options[ 'lmfp_bgcolor_featuredpost' ];
			$lmfp_color = $options[ 'lmfp_color_featuredpost' ];

			if ( $lmfp_bg ){

				$lmfp_style .= 'background-color: ' . $lmfp_bg . '; ';

			}
			if ( $lmfp_color ){

				$lmfp_style_a .= 'color: ' . $lmfp_color . '; ';

			}

			// Change the headline
			if ( $options[ 'lmfp_headline_featuredpost'] ){

				$lmfp_headline = $options[ 'lmfp_headline_featuredpost'] . ': ';

			} else {

				$lmfp_headline = 'Featured Post' . ': ';

			}

			// Change the display placement 
			if ( $options[ 'lmfp_placement_featuredpost'] ){

					$lmfp_placements = array();

				foreach ( $options[ 'lmfp_placement_featuredpost'] as $option) {
					
					if ( $option == 'top_header' )	
						array_push( $lmfp_placements, "top-header" );
					if ( $option == 'under_header' )					
						array_push( $lmfp_placements, "under-header" );
				}

			} else {
				
				$lmfp_placements[0] = 'under-header';

			}

			while ( $myquery->have_posts() ) {

				$myquery->the_post();
				$show_featured_post = false;

				//Check if post has expired
				if( get_post_meta( get_the_ID(), 'lmfp_has_expiration_date', true ) == 1 ){

					if( get_post_meta( get_the_ID(), 'lmfp_expiration_date', true ) ){

						$time = current_time( 'Y-m-d');
						$expiration_date = get_post_meta( get_the_ID(), 'lmfp_expiration_date', true );

						if( get_post_meta( get_the_ID(), 'lmfp_expiration_time', true ) ){

							$time = current_time( 'Y-m-d H:i');
							$expiration_date = get_post_meta( get_the_ID(), 'lmfp_expiration_date', true ) . ' ' . get_post_meta( get_the_ID(), 'lmfp_expiration_time', true );

						}

						if( $time <= $expiration_date) {

							$show_featured_post = true;

						}

					} else {

						$show_featured_post = true;

					}
				} else {

					$show_featured_post = true;

				}

				if( $show_featured_post == true ){

					foreach ($lmfp_placements as $lmfp_placement) {

						//Display Featured Post
						echo '<div class="lmfp-featuredpost ' . $lmfp_placement .  '" id="lmfp-featuredpost" style="' . $lmfp_style . '"" >';

						if( get_post_meta( get_the_ID(), 'lmfp_custom_title', true ) ) {

							$lmfp_title = get_post_meta( get_the_ID(), 'lmfp_custom_title', true );

						} else {
							$lmfp_title = get_the_title();

						}

						echo '<a href="' . get_the_permalink() . '" style="' . $lmfp_style_a . '" ><strong>' . $lmfp_headline . '</strong>' . $lmfp_title . '</a>';
						echo '</div>';
					}
				}
			}
		}
	}
}
