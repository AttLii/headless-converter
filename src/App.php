<?php
namespace HeadlessConverter;

use HeadlessConverter\Template;

/**
 * Stop execution if not in Wordpress environment
 */
defined( 'WPINC' ) || die;

/**
 * Class for plugin's object composition. Here we instanciate different classes that add plugin's features.
 */
class App {
	/**
	 * Instantiated Template class.
	 *
	 * @var Template
	 */
	public $template;

	/**
	 * Class constructor
	 */
	public function __construct() {
		$this->template = new Template();
	}
}
