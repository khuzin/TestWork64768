<?php

/*
Template Name: Create product
*/


if ( $_POST['tt_new_name'] && $_POST['tt_new_price'] ) {
	header( 'Location: ' . $_SERVER['REQUEST_URI'] . '#success', true, 301);
}
// echo '<pre>';
// print_r($_SERVER);
// echo '</pre>';

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) :
			the_post();

			do_action( 'storefront_page_before' );

			get_template_part( 'content', 'page' );

			/**
			 * Functions hooked in to storefront_page_after action
			 *
			 * @hooked storefront_display_comments - 10
			 */
			do_action( 'storefront_page_after' );

		endwhile; // End of the loop.
		?>

		<h2 id="tt_publish_statis"></h2>
		<script type="text/javascript">
			jQuery( document ).ready(function($) {
				if ( document.location.hash == '#publish' ) {
					$('#tt_publish_statis').text('Missing required fields');
				}
				if ( document.location.hash == '#success' ) {
					$('#tt_publish_statis').text('Product is created');
				}
			})
		</script>

		<form id="tt_create_product_form" method="post" action="<?php echo $_SERVER['REDIRECT_URL']; ?>#publish" enctype="multipart/form-data">
			<p class="form-row form-row-wide">
				<label for="tt_new_name">Product name <abbr class="required" title="required">*</abbr></label>
				<input type="text" name="tt_new_name" id="tt_new_name" value="<?php echo $_POST['tt_new_name']; ?>">
			</p>

			<p class="form-row form-row-wide">
				<label for="tt_new_price">Price (<?php echo get_woocommerce_currency(); ?>) <abbr class="required" title="required">*</abbr></label>
				<input type="number" min="0" name="tt_new_price" id="tt_new_price" value="<?php echo $_POST['tt_new_price']; ?>">
			</p>

			<p class="form-row form-row-first">
				<label for="tt_new_date">Date of publication</label>
				<input type="datetime-local" name="tt_new_date" id="tt_new_date" value="<?php echo $_POST['tt_new_date']; ?>">
			</p>

			<p class="form-row form-row-last">
				<label for="tt_new_select">Select</label>
				<select name="tt_new_select">
					<option value="">None</option>
					<option value="Rare">Rare</option>
					<option value="Frequent">Frequent</option>
					<option value="Unusual">Unusual</option>
				</select>
				
			</p>

			<p class="form-row form-row-wide">
				<label for="tt_new_image">Image</label>
				<input type="file" accept="image/png, image/jpeg" name="tt_new_image" id="tt_new_image" value=""/>
				<!-- <input type="hidden" name="post_id" id="post_id" value="55" /> -->
				<?php wp_nonce_field( 'tt_new_image', 'tt_new_image_nonce' ); ?>
			</p>

			<p class="form-row form-row-first">
				<button type="submit" name="submit">Create product</button>
			</p>
			
		</form>

		<?php

		function product_validation( $tt_new_name, $tt_new_price )  {
			global $reg_errors;
			$reg_errors = new WP_Error;

			if ( empty( $tt_new_name ) ) {
			    $reg_errors->add('field', 'Title field is missing');
			}

			if ( empty( $tt_new_price ) || 0 > $tt_new_price || is_int( $tt_new_price ) ) {
			    $reg_errors->add( 'price_value', 'Incorrect price value' );
			}

			if ( is_wp_error( $reg_errors ) && count( $reg_errors->errors ) > 0 ) {
			    foreach ( $reg_errors->get_error_messages() as $error ) {
			        echo '<div>';
			        echo '<strong>ERROR</strong>:';
			        echo $error . '<br/>';
			        echo '</div>';
			    }
			    return false;
			} else {
				return true;
			}

		}


		if ( isset($_POST['submit'] ) ) {

			if ( product_validation( $_POST['tt_new_name'], $_POST['tt_new_price'] ) ) {

				$post = array(
					    'post_author' => 1,
					    'post_content' => '',
					    'post_status' => 'publish',
					    'post_title' =>  $_POST['tt_new_name'],
					    'post_type' => 'product',
					);
				$post_id = wp_insert_post( $post );

				wp_set_object_terms($post_id, 16, 'product_cat');

				update_post_meta( $post_id, '_regular_price', $_POST['tt_new_price']);

				update_post_meta( $post_id, 'tt_custom_select', $_POST['tt_new_select']);

				if ( ! empty( $_POST['tt_new_date'] ) ) {
					wp_update_post(
					    array (
					        'ID'            => $post_id,
					        'post_date'     => $_POST['tt_new_date'],
					        'post_date_gmt' => get_gmt_from_date( $_POST['tt_new_date'] )
					    )
					);
				}

				if ( isset( $_POST['tt_new_image_nonce'], $post_id )
					&& wp_verify_nonce( $_POST['tt_new_image_nonce'], 'tt_new_image' ) ) {

					require_once( ABSPATH . 'wp-admin/includes/image.php' );
					require_once( ABSPATH . 'wp-admin/includes/file.php' );
					require_once( ABSPATH . 'wp-admin/includes/media.php' );

					$thumbid = media_handle_upload( 'tt_new_image', $post_id );
					set_post_thumbnail($post_id, $thumbid);
				}

			}
	    }

		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php

do_action( 'storefront_sidebar' );
get_footer();

?>