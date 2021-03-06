<?php

// Custom fields admin form

add_action( 'woocommerce_product_options_general_product_data', 'tt_add_custom_fields' );

function tt_add_custom_fields() {
	global $product, $post;
	echo '<div id="tt_custom_fields" class="options_group">';
	echo '<h2>Product custom fields</h2>';
	echo '<form id="tt_custom_fields_form" method="post" action="#" enctype="multipart/form-data">';

	echo '<p class="form-field tt_custom_image_field"><label for="tt_custom_image">Image</label>';

	$image_id = get_post_thumbnail_id();
	if( $image = wp_get_attachment_image_src( $image_id ) ) {
		echo 	'<a href="#" id="tt_image_upload">
					<img src="' . $image[0] . '"/>
				</a>
				<a href="#" id="tt_image_remove" style="vertical-align: top;">Remove image</a>
				<input type="hidden" name="tt_custom_image" value="' . $image_id . '">';
	} else {
		echo '<a href="#" id="tt_image_upload">Upload image</a>
		      <a href="#" id="tt_image_remove" style="vertical-align: top; display: none;">Remove image</a>
		      <input type="hidden" name="tt_custom_image" value="">';
	} 

	echo '</p>';

	woocommerce_wp_text_input(
	    array(
	        'id' 	=> 'tt_custom_date',
	        'label' => __('Date', 'woocommerce'),
	        'type' 	=> 'datetime-local',
	        'value'	=> get_the_date("Y-m-d") . 'T' . get_the_date("H:i"),
	    )
	);
	
	woocommerce_wp_select( array(
	   'id'       => 'tt_custom_select',
	   'label'    => 'Select',
	   'options'  => array(
	      ''   => __( 'None', 'woocommerce' ),
	      'Rare'   => __( 'Rare', 'woocommerce' ),
	      'Frequent' => __( 'Frequent', 'woocommerce' ),
	      'Unusual' => __( 'Unusual', 'woocommerce' ),
	   ),
	) );

	echo 	'<p>
				<input id="tt_custom_clear" type="button" class="button" value="Clear custom fields" style="margin-left: 0;">
				<input id="tt_custom_submit" type="submit" class="button button-primary button-large" value="Update product">
			</p>';
	echo '</form>';
	echo '</div>';



	?>
	<script type="text/javascript">
		jQuery( document ).ready(function($) {

			// On Upload button click
			$('body').on( 'click', '#tt_image_upload', function(e){

				e.preventDefault();

				var button = $(this),
				custom_uploader = wp.media({
					title: 'Insert image',
					library : {
						type : 'image'
					},
					button: {
						text: 'Use this image'
					},
					multiple: false
				}).on('select', function() {
					var attachment = custom_uploader.state().get('selection').first().toJSON();
					button.html('<img src="' + attachment.sizes.thumbnail.url + '">').next().show().next().val(attachment.id);
					console.log(attachment);
				}).open();
			});

			// On Remove image button click
			$('body').on('click', '#tt_image_remove', function(e){
				e.preventDefault();
				$(this).next().val('');
				$(this).hide().prev().html('Upload image');
			});

			// On Clear fields button click
			$('body').on('click', '#tt_custom_clear', function(e) {
			    e.preventDefault();
			    $('#tt_custom_fields').find('input[type=text], input[type=datetime-local], input[type=file], select').val('');
			    $('#tt_image_remove').click();
			});

			// On Update product button click
			$('body').on('click', '#tt_custom_submit', function(e) {
			    e.preventDefault();
			    $('#publish').click();
			});
		});
	</script>

	<?php
}


// Save custom fields by admin

add_action( 'woocommerce_process_product_meta', 'tt_custom_fields_save', 10 );

function tt_custom_fields_save( $post_id ) {

	// Save image field
	$tt_custom_image = $_POST['tt_custom_image'];
	if ( ! empty( $tt_custom_image ) ) {
		set_post_thumbnail( $post_id, $tt_custom_image );
	} else {
		delete_post_thumbnail( $post_id );
	}

	// Save date field
	$tt_custom_date = $_POST['tt_custom_date'];
	if ( ! empty( $tt_custom_date ) ) {
		wp_update_post(
		    array (
		        'ID'            => $post_id,
		        'post_date'     => $tt_custom_date,
		        'post_date_gmt' => get_gmt_from_date( $tt_custom_date )
		    )
		);
	}
	
	// Save select field
	$tt_custom_select = $_POST['tt_custom_select'];
	update_post_meta( $post_id, 'tt_custom_select', esc_attr( $tt_custom_select ) );

}

?>