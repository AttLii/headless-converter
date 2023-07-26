<?php
namespace HeadlessConverter;

/**
 * Stop execution if not in Wordpress environment
 */
defined( 'WPINC' ) || die;

/**
 * Class for adding Template related functionalities
 */
class Template {

	/**
	 * Class constructor
	 */
	public function __construct() {
		$this->add_hooks();
	}

	/**
	 * Separate method for adding Wordpress hooks,
	 */
	public function add_hooks() {
		add_filter( 'template_redirect', array( $this, 'override_template_with_json' ) );
		add_filter( 'application_password_is_api_request', '__return_true' );
	}

	/**
	 * Overrides theme template with json output.
	 *
	 * @throws \Exception If in unit testing environment, this seems to be the only way to test exit.
	 */
	public function override_template_with_json() {
		$user_id = wp_validate_application_password( null );

		if ( $user_id !== null && user_can( $user_id, 'manage_options' ) ) {
			require_once __DIR__ . '/output.php';

			if ( defined( 'UNIT_TESTING' ) ) {
				throw new \Exception();
			} else {
				exit;
			}
		}
	}
}
