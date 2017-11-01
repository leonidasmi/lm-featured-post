<?php
/**
 * The metabox-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Lm_Featured_Post
 * @subpackage Lm_Featured_Post/admin
 * @author     Leonidas Milosis <leonidas.milosis@gmail.com>
 */
class Lm_Featured_Post_Admin_Metaboxes {

	/**
	 * The post meta data
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string $meta The post meta data.
	 */
	private $meta;

	/**
	 * The ID of this plugin.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->set_meta();

	}

	/**
	 * Registers metaboxes with WordPress
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function add_metaboxes() {

		add_meta_box(
			'lm_featured_post_metabox',
			__( 'Featured Post', 'lm-featured-post' ),
			array( $this, 'metabox' ),
			'post',
			'normal',
			'default'
		);

	}



	/**
	 * Check each nonce. If any don't verify, $nonce_check is increased.
	 * If all nonces verify, returns 0.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $posted The _POST.
	 * @return int The value of $nonce_check
	 */
	private function check_nonces( $posted ) {

		$nonces = array();
		$nonce_check = 0;

		$nonces[] = 'featured_post';

		foreach ( $nonces as $nonce ) {
			if ( ! isset( $posted[ $nonce ] ) ) {
				$nonce_check++;
			}

			if ( isset( $posted[ $nonce ] ) && ! wp_verify_nonce( $posted[ $nonce ], $this->plugin_name ) ) {
				$nonce_check++;
			}
		}

		return $nonce_check;

	}

	/**
	 * Returns an array of the all the metabox fields and their respective types
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array Metabox fields and types
	 */
	private function get_metabox_fields() {

		$fields = array();

		$fields[] = array( 'lmfp_is_featuredpost', 'checkbox' );
		$fields[] = array( 'lmfp_custom_title', 'text' );
		$fields[] = array( 'lmfp_has_expiration_date', 'checkbox' );
		$fields[] = array( 'lmfp_expiration_date', 'date' );
		$fields[] = array( 'lmfp_expiration_time', 'time' );

		return $fields;

	}

	/**
	 * Calls a metabox file specified in the add_meta_box args.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object $post The Post.
	 * @return void
	 */
	public function metabox( $post ) {

		wp_nonce_field( $this->plugin_name, 'featured_post' );

		$values = get_post_custom( $post->ID );
		$is_featuredpost        = isset( $values['lmfp_is_featuredpost'] ) ? esc_attr( $values['lmfp_is_featuredpost'][0] ) : '';
		$custom_title           = isset( $values['lmfp_custom_title'] ) ? esc_attr( $values['lmfp_custom_title'][0] ) : '';
		$has_expiration_date    = isset( $values['lmfp_has_expiration_date'] ) ? esc_attr( $values['lmfp_has_expiration_date'][0] ) : '';
		$expiration_date        = isset( $values['lmfp_expiration_date'] ) ? esc_attr( $values['lmfp_expiration_date'][0] ) : '';
		$expiration_time        = isset( $values['lmfp_expiration_time'] ) ? esc_attr( $values['lmfp_expiration_time'][0] ) : '';

		$show_featured_post = false;

		// Check if post has expired, to correctly show the first page load.
		if ( 1 == $has_expiration_date ) {
			if ( $expiration_date ) {
				$time = current_time( 'Y-m-d' );
				$expiration_date_temp = $expiration_date;

				if ( $expiration_time ) {
					$time = current_time( 'Y-m-d H:i' );
					$expiration_date_temp = $expiration_date . ' ' . $expiration_time;
				}
				if ( $time <= $expiration_date_temp ) {
					$show_featured_post = true;
				}
			} else {
				$show_featured_post = true;
			}
		} else {
			$show_featured_post = true;
		}

		if ( false == $show_featured_post ) {
			$is_featuredpost        = '';
			$custom_title           = '';
			$has_expiration_date    = '';
			$expiration_date        = '';
			$expiration_time        = '';
		}

		?>
		<div class="form-group">
			<div class="form-check">
				<label class="form-check-label">
					<input class="form-check-input" type="checkbox" name="lmfp_is_featuredpost" id="is_featuredpost" value="1" <?php echo ( 1 == $is_featuredpost ? 'checked' : '' ); ?>>
					<?php esc_html_e( 'Make this post a Featured Post.', 'lm-featured-post' ); ?>
				</label>
			</div>
		</div>
		<div class="form-group form-text-line">
			<label><?php esc_html_e( 'Featured Post Title', 'lm-featured-post' ); ?></label>
			<input type="text" class="form-control" name="lmfp_custom_title" id="custom_title" value="<?php echo esc_html( $custom_title ); ?>">
		</div>
		<div class="form-group">
			<div class="form-check">
				<label class="form-check-label">
					<input class="form-check-input" type="checkbox" name="lmfp_has_expiration_date" id="has_expiration_date" value="1" <?php echo ( 1 == $has_expiration_date ? 'checked' : '' ); ?>>
					<?php esc_html_e( 'This Featured Post has an expiration date.', 'lm-featured-post' ); ?>
				</label>
			</div>
		</div>    
		<div class="form-group form-text-line" id="expiration-datetime" 
		<?php
		if ( 1 != $has_expiration_date ) {
			echo 'style="display:none;"';
		}
		?>
		>
			<label><?php esc_html_e( 'Expiration Date', 'lm-featured-post' ); ?></label>
			<input type="text" class="form-control MyDate" name="lmfp_expiration_date" id="expiration_date" value="<?php echo esc_html( $expiration_date ); ?>"><br> 
			<label><?php esc_html_e( 'Expiration Time', 'lm-featured-post' ); ?></label>
			<input class='timepicker' type='text' name="lmfp_expiration_time" id="expiration_time" value="<?php echo esc_html( $expiration_time ); ?>" />
		</div>
		<?php
	}

	/**
	 * Sanitizes the data from the metabox.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $type The field type for this data.
	 * @param  mixed  $data The data to sanitize.
	 * @return string
	 */
	private function sanitizer( $type, $data ) {

		if ( empty( $type ) ) {
			return;
		}
		if ( empty( $data ) ) {
			return;
		}

		$return = '';
		$sanitizer = new Lm_Featured_Post_Sanitize();

		$sanitizer->set_data( $data );
		$sanitizer->set_type( $type );

		$return = $sanitizer->clean();

		unset( $sanitizer );

		return $return;

	}

	/**
	 * Sets the class variable $options
	 */
	public function set_meta() {

		global $post;

		if ( empty( $post ) ) {
			return;
		}
		if ( 'post' != $post->post_type ) {
			return;
		}

		$this->meta = get_post_custom( $post->ID );

	}

	/**
	 * Saves metabox data
	 *
	 * Repeater section works like this:
	 * Loops through meta fields
	 * Loops through submitted data
	 * Sanitizes each field into $clean array
	 * Gets max of $clean to use in FOR loop
	 * FOR loops through $clean, adding each value to $new_value as an array
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  int    $post_id The post ID.
	 * @param  object $object  The post object.
	 * @return void
	 */
	public function validate_meta( $post_id, $object ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		if ( 'post' !== $object->post_type ) {
			return;
		}

		$nonce_check = $this->check_nonces( $_POST );

		if ( 0 < $nonce_check ) {
			return;
		}

		$metas = $this->get_metabox_fields();

		foreach ( $metas as $meta ) {

			$name = $meta[0];
			$type = $meta[1];

			$new_value[ $name ] = $this->sanitizer( $type, $_POST[ $name ] );

		}

		// check if post is selected as featured post, so as to delete any preexisting featured post.
		if ( 1 == $new_value['lmfp_is_featuredpost'] ) {
			$allposts = get_posts( array(
				'numberposts'       => -1,
			));

			foreach ( $allposts as $postinfo ) {
				delete_post_meta( $postinfo->ID, 'lmfp_is_featuredpost' );
				delete_post_meta( $postinfo->ID, 'lmfp_custom_title' );
				delete_post_meta( $postinfo->ID, 'lmfp_has_expiration_date' );
				delete_post_meta( $postinfo->ID, 'lmfp_expiration_date' );
				delete_post_meta( $postinfo->ID, 'lmfp_expiration_time' );
			}

			$expire_featured_post = false;

			// Check if post has expired, so as to appear correctly in first page load.
			if ( $new_value['lmfp_has_expiration_date'] && $new_value['lmfp_expiration_date'] ) {
				$time = current_time( 'Y-m-d' );
				$expiration_date_temp = $new_value['lmfp_expiration_date'];

				if ( $new_value['lmfp_expiration_time'] ) {
					$time = current_time( 'Y-m-d H:i' );
					$expiration_date_temp = $new_value['lmfp_expiration_date'] . ' ' . $new_value['lmfp_expiration_time'];
				}

				if ( $time > $expiration_date_temp ) {
					$expire_featured_post = true;
				}
			}

			if ( true != $expire_featured_post ) {
				update_post_meta( $post_id, 'lmfp_is_featuredpost', $new_value['lmfp_is_featuredpost'] );
				update_post_meta( $post_id, 'lmfp_custom_title', $new_value['lmfp_custom_title'] );
				update_post_meta( $post_id, 'lmfp_has_expiration_date', $new_value['lmfp_has_expiration_date'] );

				if ( 1 == $new_value['lmfp_has_expiration_date'] ) {
					update_post_meta( $post_id, 'lmfp_expiration_date', $new_value['lmfp_expiration_date'] );
					if ( $new_value['lmfp_expiration_date'] ) {
						update_post_meta( $post_id, 'lmfp_expiration_time', $new_value['lmfp_expiration_time'] );
					}
				}
			} else {
				delete_post_meta( $post_id, 'lmfp_is_featuredpost' );
				delete_post_meta( $post_id, 'lmfp_custom_title' );
				delete_post_meta( $post_id, 'lmfp_has_expiration_date' );
				delete_post_meta( $post_id, 'lmfp_expiration_date' );
				delete_post_meta( $post_id, 'lmfp_expiration_time' );
			}
		} else {
			delete_post_meta( $post_id, 'lmfp_is_featuredpost' );
			delete_post_meta( $post_id, 'lmfp_custom_title' );
			delete_post_meta( $post_id, 'lmfp_has_expiration_date' );
			delete_post_meta( $post_id, 'lmfp_expiration_date' );
			delete_post_meta( $post_id, 'lmfp_expiration_time' );
		}
	}

}
