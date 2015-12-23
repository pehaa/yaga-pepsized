<?php 

class Pepsized_Demo {

	private $demo_post_type_slug = 'pepsized_demo';

	private $demo_slug = 'demo';

	private $settings = array();

	public function __construct() {
		
		
		add_filter( $this->demo_post_type_slug . '_phtspt_post_type_args', array( $this, 'pepsized_demo_args' ), 10 );
		add_action( 'save_post', array( $this, 'maybe_generate_demo' ), 11, 2 );
		add_action( 'wp_enqueue_scripts', array( $this, 'demo_css' ), 11 );
	
	}

	public function pepsized_demo_args( $args ) {
		$this->change_default_settings();
		return wp_parse_args( $this->settings, $args );
	}

	private function change_default_settings() {

		//$this->remove_from_dashboard();
		$this->rewrite_slug();
		$this->disable_archive();

	}

	private function remove_from_dashboard() {
		$this->settings['show_ui'] = false;
	}
	private function rewrite_slug() {
		$this->settings['rewrite']['slug'] = $this->demo_slug;
	}
	private function disable_archive() {
		$this->settings['archive'] = false;
	}

	public function maybe_generate_demo( $post_id, $post ) {

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

		if ( get_post_status( $demo_id ) && ( (int) $demo_id ) > 0 ) {
			return;
		}



		$demo_id = wp_insert_post(
			array(
				'post_title'		=>	$post->post_title . ' - Demo',
				'post_status'		=>	'publish',
				'post_type'		=>	$this->demo_post_type_slug
			)
		);

		if ( $demo_id && get_post_status( $demo_id ) ) {
			update_post_meta( $post_id, 'ph_demo_id', $demo_id );
			update_post_meta( $demo_id, 'ph_demo_post_id', $post_id );
		} 

	}

	public function demo_css() {
	
		if ( is_singular( $this->demo_post_type_slug ) ) {
			$deps = apply_filters( 'pehaathemes_load_stylesheet_css', true ) ? 'pehaathemes-s-style' : 'pehaathemes-t-style';
			wp_enqueue_style( 'pepsized-demo-css', get_stylesheet_directory_uri() . '/css/demo.css', $deps );		
		}
	}

}