<?php

add_action( 'cmb2_init', 'pepsized_pht_mb_register_post_metabox' );
/**
 * Define the metabox and field configurations.
 *
 * @param array   $meta_boxes
 * @return array
 */
function pepsized_pht_mb_register_post_metabox() {

	$prefix = 'ph_';

	$custom_excerpt = array(
		'name' => __( 'Custom excerpt', 'pht' ),
		'desc' => __( 'Add a custom excerpt. If this field is left empty, a 20-words-long automatic excerpt will be generated', 'pht' ),
		'id'   => $prefix . 'custom_excerpt',
		'type'    => 'wysiwyg',
		'options' => array(
			'media_buttons' => false, // show insert/upload button(s)
			'tinymce' => false, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
			'quicktags' => true, // load Quicktags, can be used to pass settings directly to Quicktags using an array()
			'textarea_rows' => 3,
		)
	);

	$upload_freebie = array(
		'name' => __( 'Upload freebie', 'pht' ),
		'id'   => $prefix . 'attachment_link',
		'type'    => 'file',
	);

	$donate_button = array(
		'name' => __( 'Donate Button', 'pht' ),
		'desc' => __( 'Check to add a donate button.', 'pht' ),
		'id'   => $prefix . 'donate_button',
		'type' => 'checkbox'
	);

	$demo_link = array(
		'name' => __( 'Demo', 'pht' ),
		'desc' => __( 'Insert a link to the demo.', 'pht' ),
		'id'   => $prefix . 'demo_link',
		'type' => 'text_url'
	);

	$custom_category = array(
		'name' => __( 'Custom type name', 'pht' ),
		'desc' => __( 'Insert a custom post type to be displayed on the home page. If left empty the current parent category will be used.', 'pht' ),
		'id'   => $prefix . 'custom_post_type',
		'type' => 'text'
	);

	$custom_css = array(
		'name' => __( 'Custom styles', 'pht' ),
		'desc' => __( 'Custom styles - just for this post. Don\'t overuse.', 'pht' ),
		'id'   => $prefix . 'custom_style',
		'type' => 'textarea_code'
	);

	$cmb_post = new_cmb2_box( array(
			'id'            => $prefix . 'pepsized_settings',
			'title'         => __( 'PEPSized Settings', 'pht' ),
			'object_types'  => array( 'post' ), // Post type
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true, 
			'closed'     => false
		) );

	$cmb_post->add_field( $custom_excerpt );
	$cmb_post->add_field( $upload_freebie );
	$cmb_post->add_field( $demo_link );
	//$cmb_post->add_field( $custom_category ); // it was a strange idea...
	$cmb_post->add_field( $donate_button );
	$cmb_post->add_field( $custom_css );
}