<?php

/**
 *
 * @link              https://macphersondesigns.com
 * @since             1.0.0
 * @package           Macs_Headless_Toolkit
 *
 * @wordpress-plugin
 * Plugin Name:       Mac's Headless Toolkit!
 * Github Plugin URI: https://github.com/MacphersonDesigns/macs-headless-toolkit
 * Plugin URI:        https://github.com/MacphersonDesigns/macs-headless-toolkit
 * Primary Branch:    main
 * Description:       A modular toolkit for managing headless WordPress installations.
 * Version:           1.0.1
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

require_once 'version.php';

// Include Custom Post Types, Taxonomies, Meta Boxes
require_once plugin_dir_path(__FILE__) . 'includes/post-types/clients.php';
require_once plugin_dir_path(__FILE__) . 'includes/taxonomies/industries.php';
require_once plugin_dir_path(__FILE__) . 'includes/taxonomies/skills.php';
require_once plugin_dir_path(__FILE__) . 'includes/meta-boxes/client-details.php';


function check_for_plugin_update() {
    global $repo_url, $plugin_slug, $plugin_file;

    $latest_release_url = $repo_url . '/releases/latest';

    // Use wp_remote_get to fetch release data
    $response = wp_remote_get($latest_release_url);

    if (is_wp_error($response)) {
        // Handle error; could not fetch latest release
        return;
    }

    $release_data = json_decode(wp_remote_retrieve_body($response), true);
    $latest_version = $release_data['tag_name']; // Assuming the tag name is the version

    // Get current version
    if (!function_exists('get_plugin_data')) {
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }
    $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin_file);
    $current_version = $plugin_data['Version'];

    // Compare versions
    if (version_compare($latest_version, $current_version, '>')) {
        return $latest_version; // Return the new version if an update is available
    }

    return false; // No update available
}


function perform_plugin_update($new_version) {
    global $repo_url, $plugin_slug;

    $zip_url = $repo_url . "/releases/download/{$new_version}/{$plugin_slug}-{$new_version}.zip";

    // Download ZIP file
    $tmp_zip = download_url($zip_url);
    if (is_wp_error($tmp_zip)) {
        // Handle error
        return;
    }

    // Unzip and replace plugin files
    $result = unzip_file($tmp_zip, WP_PLUGIN_DIR);
    if (is_wp_error($result)) {
        // Handle error
        return;
    }

    unlink($tmp_zip); // Delete temporary file
}


add_action('init', function() {
    if (!wp_next_scheduled('my_plugin_check_update')) {
        wp_schedule_event(time(), 'daily', 'my_plugin_check_update');
    }
});
add_action('my_plugin_check_update', 'check_for_plugin_update');
