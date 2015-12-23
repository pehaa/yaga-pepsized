<?php 
if ( isset( $_GET['id'] ) ) {
	$get_id = (int) $_GET['id'];
	if ( get_post_meta( $get_id, 'ph_demo_link', true ) &&  get_post_meta( $get_id, 'ph_demo_id', true ) ) {
		wp_redirect( get_permalink( get_post_meta( $get_id, 'ph_demo_id', true ) ) );
		exit; 
	}
} else {

}

?>