<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/leonidasmilossis
 * @since      1.0.0
 *
 * @package    Lm_Featured_Post
 * @subpackage Lm_Featured_Post/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Lm_Featured_Post
 * @subpackage Lm_Featured_Post/admin
 * @author     Leonidas Milosis <leonidas.milosis@gmail.com>
 */
class Lm_Featured_Post_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lm-featured-post-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'timepicki', plugin_dir_url( __FILE__ ) . 'css/lib/timepicki.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'wp-color-picker' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lm-featured-post-admin.js', array( 'wp-color-picker' ), $this->version, false );

		wp_enqueue_script( 'jquery-ui-datepicker' );
    	wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );

		wp_enqueue_script( 'timepicki', plugin_dir_url( __FILE__ ) . 'js/lib/timepicki.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the settings page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function register_settings_page() {

		// Create our settings page as a menu page.
		add_menu_page(
			__( 'Featured Post Options', 'lm-featured-post' ),      // page title
			__( 'Featured Post Options', 'lm-featured-post' ),      // menu title
			'manage_options',
			'featured-post',
			array( $this, 'display_settings_page' )  // callable function
		 );

	}

	/**
	 * Display the settings page content for the page we have created.
	 *
	 * @since    1.0.0
	 */
	public function display_settings_page() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/lm-featured-post-admin-display.php';

	}

	/**
	 * Register the settings for our settings page.
	 *
	 * @since    1.0.0
	 */
	public function register_settings() {

		// Here we are going to register our setting.
		register_setting(
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings',
			array( $this, 'sandbox_register_setting' )
		);

		// Here we are going to add a section for our setting.
		add_settings_section(
			$this->plugin_name . '-settings-section',
			__( 'Featured Post Options', 'lm-featured-post' ),
			array( $this, 'sandbox_add_settings_section' ),
			$this->plugin_name . '-settings'
		);

		add_settings_field(
			'lmfp_headline_featuredpost',
			__( 'Featured Post Headline', 'lm-featured-post' ),
			array( $this, 'sandbox_add_settings_field_input_text' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'lmfp_headline_featuredpost',
				'default'   => __( 'Featured Post', 'lm-featured-post' )
			)
		);

		add_settings_field(
			'lmfp_bgcolor_featuredpost',
			__( 'Background Color', 'lm-featured-post' ),
			array( $this, 'sandbox_add_settings_field_input_color' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'lmfp_bgcolor_featuredpost',
				'default'   => '#333333'
			)
		);

		add_settings_field(
			'lmfp_color_featuredpost',
			__( 'Text Color', 'lm-featured-post' ),
			array( $this, 'sandbox_add_settings_field_input_color' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'lmfp_color_featuredpost',
				'default'   => '#ffd600'
			)
		);

		add_settings_field(
			'lmfp_placement_featuredpost',
			__( 'Where to place the Featured Post', 'lm-featured-post' ),
			array( $this, 'sandbox_add_settings_field_multiple_checkbox' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'lmfp_placement_featuredpost',
				'description' => __( 'The Featured Post will be displayed only to the checked locations.', 'lm-featured-post' )
			)
		);

	}

	/**
	 * Sandbox our settings.
	 *
	 * @since    1.0.0
	 */
	public function sandbox_register_setting( $input ) {

		$new_input = array();

		if ( isset( $input ) ) {
			// Loop trough each input and sanitize the value if the input id isn't post-types
			foreach ( $input as $key => $value ) {
				if ( $key == 'lmfp_placement_featuredpost' ) {
					$new_input[ $key ] = $value;
				} else {
					$new_input[ $key ] = sanitize_text_field( $value );
				}
			}
		}

		return $new_input;

	}

	/**
	 * Sandbox our section for the settings.
	 *
	 * @since    1.0.0
	 */
	public function sandbox_add_settings_section() {

		return;

	}

	/**
	 * Sandbox our inputs with text
	 *
	 * @since    1.0.0
	 */
	public function sandbox_add_settings_field_input_text( $args ) {

		$field_id = $args['label_for'];
		$field_default = $args['default'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = $field_default;

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = $options[ $field_id ];

		}

		?>
		
			<input type="text" name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" value="<?php echo esc_attr( $option ); ?>" class="regular-text" />

		<?php

	}

	/**
	 * Sandbox our inputs with text
	 *
	 * @since    1.0.0
	 */
	public function sandbox_add_settings_field_input_color( $args ) {

		$field_id = $args['label_for'];
		$field_default = $args['default'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = $field_default;

		if ( ! empty( $options[ $field_id ] ) && preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $options[ $field_id ] ) ) {

			$option = $options[ $field_id ];

		}

		?>
		
			<input type="color" class="color-field" name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" value="<?php echo esc_attr( $option ); ?>" />

		<?php

	}

	/**
	 * Sandbox our multiple checkboxes
	 *
	 * @since    1.0.0
	 */
	public function sandbox_add_settings_field_multiple_checkbox( $args ) {

		$field_id = $args['label_for'];
		$field_description = $args['description'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = array();

		if ( ! empty( $options[ $field_id ] ) ) {
			$option = $options[ $field_id ];
		}

		if ( empty( $option ) ) {
			$option[0] = 'under_header';
		}

		if ( $field_id == 'lmfp_placement_featuredpost' ) {

			$featured_post_places = array(
										    array(
										        'name' => __('Below the menu (Default)', 'lm-featured-post'),
										        'id' => 'under_header'
										    ),
											array(
										        'name' => __('At the top of the header', 'lm-featured-post'),
										        'id' => 'top_header'
										    )
										);

			foreach ( $featured_post_places as $featured_post_place ) {

				if ( in_array( $featured_post_place['id'], $option ) ) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}

				?>

					<fieldset>
						<label for="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $featured_post_place['id'] . ']'; ?>">
							<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $featured_post_place['id'] . ']'; ?>" value="<?php echo esc_attr( $featured_post_place['id'] ); ?>" <?php echo $checked; ?> />
							<span class="description"><?php echo esc_html( $featured_post_place['name'] ); ?></span>
						</label>
					</fieldset>

				<?php				

			}

		}

		?>

			<p class="description"><?php echo esc_html( $field_description ); ?></p>

		<?php

	}

	/**
	 * Sandbox our inputs with text
	 *
	 * @since    1.0.0
	 */
	public function lmfp_expiration_check( $args ) {
		//Get the Featured POst
		$myquery = new WP_Query( "post_type=post&meta_key=lmfp_is_featuredpost&meta_value=1" );

		if ( $myquery->have_posts() ) {
			while ( $myquery->have_posts() ) {
				$myquery->the_post();
				$expire_featured_post = false;

				//Check if post has expired
				if( get_post_meta( get_the_ID(), 'lmfp_has_expiration_date', true ) && get_post_meta( get_the_ID(), 'lmfp_expiration_date', true ) ){
					$time = current_time( 'Y-m-d');
					$expiration_date = get_post_meta( get_the_ID(), 'lmfp_expiration_date', true );

					if( get_post_meta( get_the_ID(), 'lmfp_expiration_time', true ) ){
						$time = current_time( 'Y-m-d H:i');
						$expiration_date = get_post_meta( get_the_ID(), 'lmfp_expiration_date', true ) . ' ' . get_post_meta( get_the_ID(), 'lmfp_expiration_time', true );
					}

					if( $time > $expiration_date){
						$expire_featured_post = true;
					}

				}

				if( $expire_featured_post == true ){
				    delete_post_meta( get_the_ID(), 'lmfp_is_featuredpost');
				    delete_post_meta( get_the_ID(), 'lmfp_custom_title');
				    delete_post_meta( get_the_ID(), 'lmfp_has_expiration_date');
				    delete_post_meta( get_the_ID(), 'lmfp_expiration_date');
				    delete_post_meta( get_the_ID(), 'lmfp_expiration_time');
				}
			}
		}

		wp_reset_postdata();
	
	}

}
