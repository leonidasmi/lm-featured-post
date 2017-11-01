<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://profiles.wordpress.org/leonidasmilossis
 * @since      1.0.0
 *
 * @package    Lm_Featured_Post
 * @subpackage Lm_Featured_Post/admin/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
	<form method="post" action="options.php">
	<?php
	// This prints out all hidden setting fields.
	settings_fields( 'lm-featured-post-settings' );
	do_settings_sections( 'lm-featured-post-settings' );

	// We are going to see if there is currently an active Featured Post and display its edit link.
	$myquery = new WP_Query( 'post_type=post&meta_key=lmfp_is_featuredpost&meta_value=1' );

	if ( $myquery->have_posts() ) {
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
			?>
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php esc_html_e( 'Current Featured Post', 'lm-featured-post' ); ?></th>
						<td>
						<?php
						edit_post_link( get_the_title(), '<p>', '</p>' );
						?>
						</td>
					</tr>
				</tbody>
			</table>
			<?php
			}
		}
		/* Restore original Post Data */
		wp_reset_postdata();
	}
	submit_button();
	?>
	</form>
</div>
