<?php

class Yaga_Widget_Our_Authors extends Yaga_Widget {

	public function __construct() {
		$widget_ops = array( 
			'classname' => 'widget_recent_entries yaga_widget_pehaa_authors', 
			'description' => esc_html__( "Our Contributors.", 'yaga' ) 
		);
		parent::__construct( 'yaga_widget_pehaa_our_authors', 'Yaga - Our Contributors', $widget_ops );
		$this->alt_option_name = 'yaga_widget_pehaa_our_authors';

	}

	public function widget( $args, $instance ) {

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Our Authors', 'yaga' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		if ( is_author() ) {
			$title = "Our other authors";
		}
		
		$this->yaga_before_widget( $args );
		$this->yaga_widget_title( $title, $args );

		$this->list_authors();
		$this->yaga_after_widget( $args );
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	public function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Our Authors' ) );
		
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : ''; ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'yaga' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
	<?php
	}

	private function list_authors( $args = '' ) {
		global $wpdb;

		$defaults = array(
			'orderby' => 'post_count', 'order' => 'DESC', 'number' => '',
			'optioncount' => true, 'exclude_admin' => true,
			'show_fullname' => true, 'hide_empty' => true,
			'feed' => '', 'feed_image' => '', 'feed_type' => '', 'echo' => true,
			'style' => 'list', 'exclude' => '', 'include' => ''
		);

		$args = wp_parse_args( $args, $defaults );

		$return = '<ul>';

		$query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number', 'exclude', 'include' ) );
		$query_args['fields'] = 'ids';
		$authors = get_users( $query_args );

		$author_count = array();
		foreach ( (array) $wpdb->get_results( "SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE " . get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author" ) as $row ) {
			$author_count[$row->post_author] = $row->count;
		}
		foreach ( $authors as $author_id ) {
			$author = get_userdata( $author_id );

			if ( 'admin' == $author->display_name ) {
				continue;
			}

			
			if ( (is_author() ) && ( $author->ID === get_query_var( 'author' ) ) )  {
				continue;
			}

			$posts = isset( $author_count[$author->ID] ) ? $author_count[$author->ID] : 0;

			if ( ! $posts && $args['hide_empty'] ) {
				continue;
			}

			$name = $author->display_name;
			

			if ( 'list' == $args['style'] ) {
				$return .= '<li class="media media--small pht-widget_recent_entries__entry">';
			}
			$avatar_img =  get_avatar( $author->ID, 72 );


			$link = '<a href="' . get_author_posts_url( $author->ID, $author->user_nicename ) . '" title="' . esc_attr( sprintf(__("Posts by %s"), $author->display_name) ) . '" class="pht-secondfont">' . $name . '</a>';

			if ( $avatar_img ) {
				$return .= '<a href="' . get_author_posts_url( $author->ID, $author->user_nicename ) . '" title="' . esc_attr( sprintf(__("Posts by %s"), $author->display_name) ) . '"  class="media__img">';
				$return .= $avatar_img;
				$return .= '</a>';

			}
			//$return .= '<div>';
			
			 
			if ( $args['optioncount'] ) {
				$link .= ' ('. $posts . ')';
			}

			$return .= $link;
			if ( $args['show_fullname'] && $author->first_name && $author->last_name ) {
				$return .=  "<br/><small><em>"."$author->first_name $author->last_name"."</em></small>";
			}
			$return .= '<p class="pht-micro pht-mb0">' . $this->truncate( get_the_author_meta('description', $author->ID ), 320 ) . '</p>';
			//$return .= '</div>';
			$return .= ( 'list' == $args['style'] ) ? '</li>' : ', ';
		}
		$return .= '</ul>';
		$return = rtrim( $return, ', ' );

		if ( ! $args['echo'] ) {
			return $return;
		}
		echo $return;
	}

	private function truncate( $string, $limit, $break = '', $pad = '...' ) {
			  // return with no change if string is shorter than $limit
		if( strlen( $string ) <= $limit ) {
			return $string;
		} 

		$string = substr( $string, 0, $limit );
		
		if ( false !== ( $breakpoint = strrpos( $string, $break ) ) ) {
			$string = substr($string, 0, $breakpoint);
		}
		return $string . $pad;
	}
}