<?php

class WPEM_Event_Dashboard extends ET_Builder_Module {

	public $slug       = 'wpem_event_dashboard';
	public $vb_support = 'off';

	protected $module_credits = array(
		'module_uri' => 'www.wp-eventmanager.com',
		'author'     => 'Wpem Team',
		'author_uri' => 'www.wp-eventmanager.com',
	);

	public function init() {
		$this->name = esc_html__( 'Event Dashboard', 'wpem-wpem-event-dashboard' );
	}

	public function get_fields() {
		return array(
			'per_page'        => array(
				'default'          => '10',
				'label'            => esc_html__( 'Events per page', 'wp-event-manager-divi-elements' ),
				'type'             => 'text',
				'option_category'  => 'configuration',
				'description'      => esc_html__( 'Define the number of events that should be displayed per page.', 'wp-event-manager-divi-elements' ),
				'computed_affects' => array(
					'__event_listing',
				),
				'toggle_slug'      => 'main_content',
			),
		);
	}
	function get_event_dashboard( $args = array(), $conditional_tags = array(), $current_page = array() ) {
		foreach ( $args as $arg => $value ) {
			$this->props[ $arg ] = $value;
		}

		$post_id            = isset( $current_page['id'] ) ? (int) $current_page['id'] : 0;
		/*$layout             = $this->props['layout'];*/
		$posts_number       = $this->props['per_page'];
        /*$orderby       		= $this->props['orderby'];
		$keywords       		= $this->props['keywords'];
		$location       		= $this->props['location'];
		$cancelled       		= $this->props['cancelled'];
		$featured       		= $this->props['featured'];
		$event_types       		= $this->props['include_event_types'];
		$categories       		= $this->props['include_categories'];
		$show_filters       		= $this->props['show_filters'];
		$order       		= $this->props['order'];
		$show_pagination       		= $this->props['show_pagination'];*/


		$shortcode = sprintf(
			'[events  per_page="%1$s"]',
			esc_attr( $posts_number ),
			/*esc_attr( $orderby ),
            esc_attr( $layout ),
			esc_attr( $keywords ),
			esc_attr( $keywords ),
			esc_attr( $location ),
			esc_attr( $cancelled ),
			esc_attr( $featured ),
			esc_attr( $event_types ),
			esc_attr( $categories ),
			esc_attr( $show_filters ),
			esc_attr( $order ),
			esc_attr( $show_pagination ),*/
		
		);
		wp_enqueue_script( 'chosen');
		wp_enqueue_script( 'wp-event-manager-content-event-listing');
		wp_enqueue_script( 'wp-event-manager-ajax-filters');

		do_action( 'et_pb_event_before_print_event_listing' );

		$output_events = do_shortcode( $shortcode );

		do_action( 'et_pb_event_after_print_event_listing' );

		return $output_events;
	}
	public function render( $attrs, $content, $render_slug ) {

		/*$posts_number            = $this->props['per_page'];
		$shortcode = sprintf(
			'[event_dashboard per_page="%1$s"]',
			esc_attr( $posts_number ),
		);
		$output_events = do_shortcode( $shortcode );*/
		$posts_number            = $this->props['per_page'];
		$output = sprintf(
			'<div>
				%1$s
			</div>',
			$this->get_event_dashboard( array(), array(), array( 'id' => $this->get_the_ID() ) )
		);
		return $output;
	}
}

new WPEM_Event_Dashboard;