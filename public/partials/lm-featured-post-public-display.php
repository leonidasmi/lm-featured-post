<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://profiles.wordpress.org/leonidasmilossis
 * @since      1.0.0
 *
 * @package    Lm_Featured_Post
 * @subpackage Lm_Featured_Post/public/partials
 */

?>

<?php
// Get the Featured Post.
$myquery = new WP_Query( 'post_type=post&meta_key=lmfp_is_featuredpost&meta_value=1' );

if ( $myquery->have_posts() ) {

	// WEBSITE OPTIONS.
	$lmfp_style = 'display: none;';
	$lmfp_style_a = '';

	// Change the colours.
	$options = get_option( $this->plugin_name . '-settings' );
	$lmfp_bg = $options['lmfp_bgcolor_featuredpost'];
	$lmfp_color = $options['lmfp_color_featuredpost'];

	if ( $lmfp_bg ) {

		$lmfp_style .= 'background-color: ' . $lmfp_bg . '; ';

	}
	if ( $lmfp_color ) {

		$lmfp_style_a .= 'color: ' . $lmfp_color . '; ';

	}

	// Change the headline.
	if ( $options['lmfp_headline_featuredpost'] ) {

		$lmfp_headline = $options['lmfp_headline_featuredpost'] . ': ';

	} else {

		$lmfp_headline = 'Featured Post: ';

	}

	// Change the display placement.
	if ( $options['lmfp_placement_featuredpost'] ) {

			$lmfp_placements = array();

		foreach ( $options['lmfp_placement_featuredpost'] as $option ) {

			if ( 'top_header' == $option ) {
				array_push( $lmfp_placements, 'top-header' );
			}
			if ( 'under_header' == $option ) {
				array_push( $lmfp_placements, 'under-header' );
			}
		}
	} else {

		$lmfp_placements[0] = 'under-header';

	}

	while ( $myquery->have_posts() ) {

		$myquery->the_post();
		$show_featured_post = false;

		// Check if post has expired.
		if ( get_post_meta( get_the_ID(), 'lmfp_has_expiration_date', true ) == 1 ) {

			if ( get_post_meta( get_the_ID(), 'lmfp_expiration_date', true ) ) {

				$time = current_time( 'Y-m-d' );
				$expiration_date = get_post_meta( get_the_ID(), 'lmfp_expiration_date', true );

				if ( get_post_meta( get_the_ID(), 'lmfp_expiration_time', true ) ) {
					$time = current_time( 'Y-m-d H:i' );
					$expiration_date = get_post_meta( get_the_ID(), 'lmfp_expiration_date', true ) . ' ' . get_post_meta( get_the_ID(), 'lmfp_expiration_time', true );
				}

				if ( $time <= $expiration_date ) {
					$show_featured_post = true;
				}
			} else {
				$show_featured_post = true;
			}
		} else {
			$show_featured_post = true;
		}

		if ( true == $show_featured_post ) {

			foreach ( $lmfp_placements as $lmfp_placement ) {

				// Display Featured Post.
				echo '<div class="lmfp-featuredpost ' . esc_attr( $lmfp_placement ) . '" id="lmfp-featuredpost" style="' . esc_attr( $lmfp_style ) . '"" >';

				if ( get_post_meta( get_the_ID(), 'lmfp_custom_title', true ) ) {

					$lmfp_title = get_post_meta( get_the_ID(), 'lmfp_custom_title', true );

				} else {
					$lmfp_title = get_the_title();

				}

				echo '<a href="' . get_the_permalink() . '" style="' . esc_attr( $lmfp_style_a ) . '" ><strong>' . esc_attr( $lmfp_headline ) . '</strong>' . esc_attr( $lmfp_title ) . '</a>';
				echo '</div>';
			}
		}
	}
}

