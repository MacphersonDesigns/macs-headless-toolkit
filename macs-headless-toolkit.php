<?php

/**
 *
 * @link              https://macphersondesigns.com
 * @since             1.0.0
 * @package           Macs_Headless_Toolkit
 *
 * @wordpress-plugin
 * Plugin Name:       Mac's Headless Toolkit!
 * Plugin URI:        https://macphersondesigns.com/plugins/macs-headless-toolkit
 * Description:       A modular toolkit for managing headless WordPress installations.
 * Version:           1.0.0
 * Author:            Alex Macpherson
 * Author URI:        https://macphersondesigns.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       macs-headless-toolkit
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 */
define( 'MACS_HEADLESS_TOOLKIT_VERSION', '1.0.0' );

// Include Custom Post Types, Taxonomies, Meta Boxes
require_once plugin_dir_path(__FILE__) . 'includes/post-types/clients.php';
require_once plugin_dir_path(__FILE__) . 'includes/taxonomies/industries.php';
require_once plugin_dir_path(__FILE__) . 'includes/taxonomies/skills.php';
require_once plugin_dir_path(__FILE__) . 'includes/meta-boxes/client-details.php';
