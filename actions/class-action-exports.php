<?php

/**
 * User Activity Export Actions
 *
 * @package User/Activity/Actions/Export
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Export actions
 *
 * @since 0.1.0
 */
class WP_User_Activity_Action_Export extends WP_User_Activity_Action {

	/**
	 * What type of object is this?
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	public $object_type = 'export';

	/**
	 * Add hooks
	 *
	 * @since 0.1.0
	 */
	public function __construct() {

		// Setup callbacks
		$this->action_callbacks = array(

			// Export
			'export' => array(
				'labels' => array(
					'description' => esc_html__( '%1$s exported "%2$s" %3$s.', 'wp-user-activity' )
				)
			)
		);

		// Actions
		add_action( 'export_wp', array( $this, 'export_wp' ) );

		// Setup callbacks
		parent::__construct();
	}

	/** Actions ***************************************************************/

	/**
	 * Callback for returning human-readable output.
	 *
	 * @since 0.1.0
	 *
	 * @param  object  $post
	 * @param  array   $meta
	 *
	 * @return string
	 */
	public function export_action_callback( $post, $meta = array() ) {
		return sprintf(
			$this->get_activity_action( 'export' ),
			$this->get_activity_author_link( $post ),
			$meta->object_name,
			$this->get_how_long_ago( $post )
		);
	}

	/** Logging ***************************************************************/

	/**
	 * Data exported out of WordPress
	 *
	 * @since 0.1.0
	 *
	 * @param array $args
	 */
	public function export_wp( $args = array() ) {

		// Get content name
		$name = isset( $args['content'] )
			? $args['content']
			: 'all';

		// Insert activity
		wp_insert_user_activity( array(
			'object_type' => $this->object_type,
			'object_name' => $name,
			'object_id'   => 0,
			'action'      => 'export',
		) );
	}
}
new WP_User_Activity_Action_Export();
