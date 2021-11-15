<?php
namespace HeadlessConverter;

/**
 * Stop execution if not in Wordpress environment
 */
defined( 'WPINC' ) || die;

/**
 * Class for constant values that can be used by this plugin or themes/plugins using this plugin
 */
class Constants {

	/**
	 * Filter's name for modifying content before serving it
	 */
	const FILTER_MODIFY_DATA = 'headless-converter-modify-data';
}
