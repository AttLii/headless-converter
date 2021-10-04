<?php
/**
 * Plugin Name:       Headless Plugin
 * Description:       A Wordpress plugin that converts frontend to JSON response
 * Version:           0.1
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Atte Liimatainen
 * Author URI:        https://github.com/AttLii
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Stop execution if not in Wordpress environment
 */
defined("WPINC") or die;

include_once "vendor/autoload.php";

$app = new HeadlessPlugin\App();