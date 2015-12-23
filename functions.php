<?php

/* To start customizing your css, please edit css/style.css. Nothing needs to be done here. */

/* Uncomment the following line if you want to write your css from scratch, the parent stylesheet will not be loaded. */
/*  add_filter( 'pht_load_template_css', '__return_false' ); */

/* Uncomment the following line if you do not customize your theme stylesheet at all, the child-theme stylesheet will not be loaded. */
/*  add_filter( 'pht_load_stylesheet_css', '__return_false' ); */

include_once get_stylesheet_directory() . '/includes/metaboxes/metaboxes-post.php';
require_once get_stylesheet_directory() . '/includes/class-pepsized-demo.php';

$pepsized_demo = new Pepsized_Demo();

add_filter( 'get_the_excerpt', 'pepsized_excerpt', 11 );

function pepsized_excerpt( $excerpt ) {
	
	global $post;

	if ( !isset( $post->ID ) ) {
		return $excerpt;
	}

	$custom_excerpt = get_post_meta( $post->ID, 'ph_custom_excerpt', true );

	if ( $custom_excerpt ) {
		return "$custom_excerpt <br /><a class='excerpt' href='". get_permalink( $post->ID ) . "' title='Read more: " . esc_attr( get_the_title( $post->ID ) )."'>Read more &raquo;</a>";
	}

	return $excerpt;

}

add_action( 'wp_enqueue_scripts', 'pepsized_post_custom_css', 13 );

function pepsized_post_custom_css() {
	
	if ( is_single() ) {
		
		global $post;

		if ( !isset( $post->ID ) ) {
			return;
		}

		$custom_css = get_post_meta( $post->ID, 'ph_custom_style', true );
		
		if ( '' !== trim( $custom_css ) ) {
			$deps = apply_filters( 'pehaathemes_load_stylesheet_css', true ) ? 'pehaathemes-s-style' : 'pehaathemes-t-style';
			wp_add_inline_style( $deps, html_entity_decode( $custom_css ) );
		}
		
	}
}

//add_action( 'save_post', 'pepsized_maybe_generate_demo', 11, 3 );

function pepsized_maybe_generate_demo( $post_id, $post ) {

	if ( ! $post ) {
		return;
	}
	if ( !isset( $_POST['nonce_CMB2phpph_pepsized_settings'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['nonce_CMB2phpph_pepsized_settings'], 'nonce_CMB2phpph_pepsized_settings' ) ) {
		return;
	}

	$demo_link = trim( get_post_meta( $post_id, 'ph_demo_link', true ) );
	$demo_id = get_post_meta( $post_id, 'ph_demo_id', true );


	if ( ! $demo_link ) {
		update_post_meta( $post_id, 'ph_demo_id', '-1' );
		if ( $post_id === (int) get_post_meta( $demo_id, 'ph_demo_post_id', true ) ) {
			wp_delete_post( $demo_id, true );					
		}
		return;
	}

	// $demo_link is set

	if ( (int) $demo_id > 0 ) {
		return;
	}

	$demo_id = wp_insert_post(
		array(
			'post_title'		=>	$post->post_title . ' - Demo',
			'post_status'		=>	'publish',
			'post_type'		=>	'pepsized_demo'
		)
	);

	if ( $demo_id ) {
		update_post_meta( $post_id, 'ph_demo_id', $demo_id );
		update_post_meta( $demo_id, 'ph_demo_post_id', $post_id );
	}

}

//add_action( 'wp_enqueue_scripts', 'pepsized_demo_css', 11 );

function pepsized_demo_css() {
	
	if ( is_singular( 'pepsized_demo' ) ) {
		$deps = apply_filters( 'pehaathemes_load_stylesheet_css', true ) ? 'pehaathemes-s-style' : 'pehaathemes-t-style';
		wp_enqueue_style( 'pepsized-demo-css', get_stylesheet_directory_uri() . '/css/demo.css', $deps );		
	}
}

//add_filter( 'pepsized_demo' . '_phtspt_post_type_args', 'pepsized_demo_args', 10, 3 );

function pepsized_demo_args( $args, $key, $array ) {
	
	$args['show_ui'] = false;
	$args['rewrite']['slug'] = 'demo';
	$args['has_archive'] = false;
	return $args;

}

add_action( 'yaga_just_before_the_content', 'pepsized_post_buttons' );
function pepsized_post_buttons() {
	get_template_part( 'buttons' );
}
add_action( 'widgets_init', 'pepsized_widgets', 11 );
/**
 * Recent_Posts with thumbnailswidget class
 *
 */

function pepsized_widgets() {
	require_once get_stylesheet_directory().'/includes/class-pehaa-our-authors.php';
	register_widget( 'Yaga_Widget_Our_Authors' );
	
}

