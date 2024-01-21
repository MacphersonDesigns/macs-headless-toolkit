<?php

function macdes_add_custom_meta_box() {
    add_meta_box(
        'macdes_custom_meta_box',       // ID
        'Additional Client Details',    // Title
        'macdes_display_custom_meta_box', // Callback function
        'macdes_clients',               // Post type
        'normal',                       // Context
        'high'                          // Priority
    );
}
add_action('add_meta_boxes', 'macdes_add_custom_meta_box');

function macdes_display_custom_meta_box($post) {
    // Add nonce for security
    wp_nonce_field(basename(__FILE__), 'macdes_nonce');

    // Custom field HTML
    echo '<label for="macdes_field">Custom Field:</label>';
    echo '<input type="text" id="macdes_field" name="macdes_field" value="'.esc_attr(get_post_meta($post->ID, 'macdes_field', true)).'">';
    // Add more fields as needed
}

function macdes_save_custom_meta_box($post_id) {
    // Check nonce for security
    if (!isset($_POST['macdes_nonce']) || !wp_verify_nonce($_POST['macdes_nonce'], basename(__FILE__))) {
        return;
    }

    // Save custom field data
    if (isset($_POST['macdes_field'])) {
        update_post_meta($post_id, 'macdes_field', sanitize_text_field($_POST['macdes_field']));
    }
    // Handle additional fields similarly
}
add_action('save_post', 'macdes_save_custom_meta_box');
