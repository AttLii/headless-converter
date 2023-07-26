<?php
/**
 * Plugin Name:       Headless Converter
 * Plugin URI:        https://github.com/AttLii/headless-converter
 * Description:       Converts frontend to JSON response when request is done with certain conditions.
 * Version:           1.0.8
 * Requires at least: 6.1.1
 * Tested up to:      6.3
 * Requires PHP:      8.1
 * Author:            Atte Liimatainen
 * Author URI:        https://github.com/AttLii
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Stop execution if not in Wordpress environment
 */
defined( 'WPINC' ) || die;

if ( ! class_exists( 'HeadlessConverter\App' ) ) {
	require_once 'vendor/autoload.php';
	$headless_converter_plugin = new HeadlessConverter\App();
}
