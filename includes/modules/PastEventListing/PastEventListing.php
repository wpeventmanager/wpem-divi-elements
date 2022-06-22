<?php

class WPEM_Past_Event_Listing extends ET_Builder_Module {
	
	public $slug       = 'wpem_past_event_listing';
	public $vb_support = 'off';

	protected $module_credits = array(
		'module_uri' => 'www.wp-eventmanager.com',
		'author'     => 'WPEM Team',
		'author_uri' => 'www.wp-eventmanager.com',
	);

	public function init() {
		$this->name = esc_html__( 'Past Event Listing', 'wp-event-manager-divi-elements' );
	}

	public function get_fields() {
		$fields = array(
			'show_pagination'     => array(
				'label'            => esc_html__( 'Show Pagination', 'wp-event-manager-divi-elements' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'true'  => esc_html__( 'Yes', 'wp-event-manager-divi-elements' ),
					'false' => esc_html__( 'No', 'wp-event-manager-divi-elements' ),
				),
				'default'          => 'false',
				'description'      => esc_html__( 'Turn pagination on and off.', 'wp-event-manager-divi-elements' ),
				
				'toggle_slug'      => 'main_content',
				//'hover'            => 'tabs',
			),
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
			'order'             => array(
				'label'            => esc_html__( 'Order', 'wp-event-manager-divi-elements' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'ASC' => esc_html__( 'Ascending', 'wp-event-manager-divi-elements' ),
					'DESC' => esc_html__( 'Descending', 'wp-event-manager-divi-elements' ),
					
				),
				'default_on_front' => 'ASC',
				'description'      => esc_html__( 'Choose how your events should be ordered.', 'wp-event-manager-divi-elements' ),
				'toggle_slug'      => 'main_content',
			),
			'orderby'             => array(
				'label'            => esc_html__( 'Orderby', 'wp-event-manager-divi-elements' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'event_start_date' => esc_html__( 'Sort Event Start Date', 'wp-event-manager-divi-elements' ),
					'ID' => esc_html__( 'ID', 'wp-event-manager-divi-elements' ),
					'title' => esc_html__( 'Title', 'wp-event-manager-divi-elements' ),
					'name' => esc_html__( 'Name', 'wp-event-manager-divi-elements' ),
					'modified' => esc_html__( 'Modified', 'wp-event-manager-divi-elements' ),
					'parent' => esc_html__( 'Parent', 'wp-event-manager-divi-elements' ),
					'rand' => esc_html__( 'Random', 'wp-event-manager-divi-elements' ),
				),
				'default_on_front' => 'event_start_date',
				'description'      => esc_html__( 'Choose how your events should be ordered.', 'wp-event-manager-divi-elements' ),
				'toggle_slug'      => 'main_content',
			),
			'location' => array(
				'label' => esc_html__('Location', 'simp-simple-extension'),
				'type' => 'text',
				'option_category' => 'configuration',
				'description' => esc_html__('Add any location value to the location filter.', 'simp-simple-extension'),
				'toggle_slug' => 'main_content',
			),
			'keywords' => array(
				'label' => esc_html__('Keywords', 'simp-simple-extension'),
				'type' => 'text',
				'option_category' => 'configuration',
				'description' => esc_html__('Add any keyword value to the keyword search filter.', 'simp-simple-extension'),
				'toggle_slug' => 'main_content',
			),
			'include_categories'  => array(
				'label'            => esc_html__( 'Select Categories', 'wp-event-manager-divi-elements' ),
				'type'             => 'categories',
				// 'meta_categories'  => array(
				// 	'all'     => esc_html__( 'All Categories', 'wp-event-manager-divi-elements' ),
				// ),
				'renderer_options' => array(
					'use_terms' => true,
					'term_name' => 'event_listing_category',
				),
				'depends_show_if'  => 'event_listing_category',
				'description'      => esc_html__( 'Choose which categories you would like to include.', 'wp-event-manager-divi-elements' ),
				'taxonomy_name'    => 'event_listing_category',
				'toggle_slug'      => 'main_content',
			),
			'include_event_types'  => array(
				'label'            => esc_html__( 'Select Event Types', 'wp-event-manager-divi-elements' ),
				'type'             => 'categories',
				'meta_categories'  => array(
					'all'     => esc_html__( 'All Event Types', 'wp-event-manager-divi-elements' ),
				),
				'renderer_options' => array(
					'use_terms' => true,
					'term_name' => 'event_listing_type',
				),
				'depends_show_if'  => 'event_listing_type',
				'description'      => esc_html__( 'Choose which event type you would like to include.', 'wp-event-manager-divi-elements' ),
				'taxonomy_name'    => 'event_listing_type',
				'toggle_slug'      => 'main_content',
			),

		);

		return $fields;
	}
	
	function past_event_listing( $args = array(), $conditional_tags = array(), $current_page = array() ) {
		foreach ( $args as $arg => $value ) {
			$this->props[ $arg ] = $value;
		}

		$post_id            = isset( $current_page['id'] ) ? (int) $current_page['id'] : 0;
		$posts_number       = $this->props['per_page'];
		$event_types       		= $this->props['include_event_types'];
		$categories       		= $this->props['include_categories'];
        $orderby       		= $this->props['orderby'];
		$keywords       		= $this->props['keywords'];
		$location       		= $this->props['location'];
		$cancelled       		= $this->props['cancelled'];
		$featured       		= $this->props['featured'];
		$event_types       		= $this->props['include_event_types'];
		$categories       		= $this->props['include_categories'];
		$show_filters       		= $this->props['show_filters'];
		$order       		= $this->props['order'];
		$show_pagination       		= $this->props['show_pagination'];


		$shortcode = sprintf(
			'[events  per_page="%1$s" event_types="%2$s" categories="%3$s"]',
			esc_attr( $posts_number ),
			esc_attr( $event_types ),
			esc_attr( $categories ),
			esc_attr( $orderby ),
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
			esc_attr( $show_pagination ),
		
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
			$this->past_event_listing( array(), array(), array( 'id' => $this->get_the_ID() ) )
		);
		return $output;
	}
}

new WPEM_Past_Event_Listing;