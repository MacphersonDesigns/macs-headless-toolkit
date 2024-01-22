<?php

class My_Plugin_Auto_Update {

    private $repo_url = 'https://github.com/MacphersonDesigns/macs-headless-toolkit';
    private $plugin_slug = 'macs-headless-toolkit';
    private $plugin_file = 'macs-headless-toolkit/macs-headless-toolkit.php';


    public function __construct() {
        $this->plugin_file = plugin_basename(__DIR__ . '/main-plugin-file.php');

        add_action('init', array($this, 'init_update_check'));
        add_action('my_plugin_check_update', array($this, 'check_for_update'));
    }

    public function init_update_check() {
        if (!wp_next_scheduled('my_plugin_check_update')) {
            wp_schedule_event(time(), 'daily', 'my_plugin_check_update');
        }
    }

    public function check_for_update() {
        $latest_release_url = $this->repo_url . '/releases/latest';

        $response = wp_remote_get($latest_release_url);
        if (is_wp_error($response)) {
            return;
        }

        $release_data = json_decode(wp_remote_retrieve_body($response), true);
        $latest_version = $release_data['tag_name'];

        if (!function_exists('get_plugin_data')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $this->plugin_file);
        $current_version = $plugin_data['Version'];

        if (version_compare($latest_version, $current_version, '>')) {
            $this->perform_update($latest_version);
        }
    }

    private function perform_update($new_version) {
        $zip_url = $this->repo_url . "/releases/download/{$new_version}/{$this->plugin_slug}-{$new_version}.zip";

        $tmp_zip = download_url($zip_url);
        if (is_wp_error($tmp_zip)) {
            return;
        }

        $result = unzip_file($tmp_zip, WP_PLUGIN_DIR . '/' . $this->plugin_slug);
        if (is_wp_error($result)) {
            unlink($tmp_zip);
            return;
        }

        unlink($tmp_zip); // Clean up
    }
}

new My_Plugin_Auto_Update();
