<?php

function macdes_add_client_meta_box() {
    add_meta_box(
        'macdes_client_details',
        'Client Details',
        'macdes_client_meta_box_callback',
        'macdes_clients', // Ensure this matches your Client Post Type key
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'macdes_add_client_meta_box');

function macdes_client_meta_box_callback($post) {
    wp_nonce_field('macdes_save_client_details', 'macdes_client_details_nonce');

    // Retrieving existing meta data
    $size_of_business = get_post_meta($post->ID, 'macdes_size_of_business', true);
    $project_types = get_post_meta($post->ID, 'macdes_project_types', true);
    $client_background = get_post_meta($post->ID, 'macdes_client_background', true);
    $target_audience = get_post_meta($post->ID, 'macdes_target_audience', true);
    $geographical_reach = get_post_meta($post->ID, 'macdes_geographical_reach', true);
    $client_goals = get_post_meta($post->ID, 'macdes_client_goals', true);
    $client_testimonial = get_post_meta($post->ID, 'macdes_client_testimonial', true);
    $collaboration_details = get_post_meta($post->ID, 'macdes_collaboration_details', true);
    $repeat_business = get_post_meta($post->ID, 'macdes_repeat_business', true);

    // HTML for each field
    // Size of Business
    echo '<div class="macdes-meta-field">';
    echo '<label for="macdes_size_of_business">Size of Business:</label>';
    echo '<input type="text" id="macdes_size_of_business" name="macdes_size_of_business" value="' . esc_attr($size_of_business) . '">';
    echo '</div>';


    // Project Types
    echo '<div class="macdes-meta-field">';
    echo '<label for="macdes_project_types">Project Type(s):</label>';
    echo '<input type="text" id="macdes_project_types" name="macdes_project_types" value="' . esc_attr($project_types) . '">';
    echo '</div>';

    // Client Background
    echo '<div class="macdes-meta-field">';
    echo '<label for="macdes_client_background">Client Background:</label>';
    echo '<textarea id="macdes_client_background" name="macdes_client_background">' . esc_textarea($client_background) . '</textarea>';
    echo '</div>';

    // Target Audience
        echo '<div class="macdes-meta-field">';
    echo '<label for="macdes_target_audience">Client\'s Target Audience:</label>';
    echo '<input type="text" id="macdes_target_audience" name="macdes_target_audience" value="' . esc_attr($target_audience) . '">';
        echo '</div>';

    // Geographical Reach
        echo '<div class="macdes-meta-field">';
    echo '<label for="macdes_geographical_reach">Geographical Reach:</label>';
    echo '<input type="text" id="macdes_geographical_reach" name="macdes_geographical_reach" value="' . esc_attr($geographical_reach) . '">';
        echo '</div>';

    // Client Goals and Objectives
        echo '<div class="macdes-meta-field">';
    echo '<label for="macdes_client_goals">Client Goals and Objectives:</label>';
    echo '<textarea id="macdes_client_goals" name="macdes_client_goals">' . esc_textarea($client_goals) . '</textarea>';
        echo '</div>';

    // Client Testimonial or Feedback
        echo '<div class="macdes-meta-field">';
    echo '<label for="macdes_client_testimonial">Client Testimonial or Feedback:</label>';
    echo '<textarea id="macdes_client_testimonial" name="macdes_client_testimonial">' . esc_textarea($client_testimonial) . '</textarea>';
        echo '</div>';

    // Collaboration Details
        echo '<div class="macdes-meta-field">';
    echo '<label for="macdes_collaboration_details">Collaboration Details:</label>';
    echo '<textarea id="macdes_collaboration_details" name="macdes_collaboration_details">' . esc_textarea($collaboration_details) . '</textarea>';
        echo '</div>';

    // Repeat Business Checkbox
        echo '<div class="macdes-meta-field">';
    echo '<label for="macdes_repeat_business">Repeat Business:</label>';
    echo '<input type="checkbox" id="macdes_repeat_business" name="macdes_repeat_business" ' . checked($repeat_business, 'on', false) . '>';
        echo '</div>';
}



function macdes_save_client_details($post_id) {
    if (!isset($_POST['macdes_client_details_nonce']) || !wp_verify_nonce($_POST['macdes_client_details_nonce'], 'macdes_save_client_details')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save Size of Business
    if (isset($_POST['macdes_size_of_business'])) {
        update_post_meta($post_id, 'macdes_size_of_business', sanitize_text_field($_POST['macdes_size_of_business']));
    }


    update_post_meta($post_id, 'macdes_project_types', sanitize_text_field($_POST['macdes_project_types']));
    update_post_meta($post_id, 'macdes_client_background', sanitize_textarea_field($_POST['macdes_client_background']));
    update_post_meta($post_id, 'macdes_target_audience', sanitize_text_field($_POST['macdes_target_audience']));
    update_post_meta($post_id, 'macdes_geographical_reach', sanitize_text_field($_POST['macdes_geographical_reach']));
    update_post_meta($post_id, 'macdes_client_goals', sanitize_textarea_field($_POST['macdes_client_goals']));
    update_post_meta($post_id, 'macdes_client_testimonial', sanitize_textarea_field($_POST['macdes_client_testimonial']));
    update_post_meta($post_id, 'macdes_collaboration_details', sanitize_textarea_field($_POST['macdes_collaboration_details']));
    update_post_meta($post_id, 'macdes_repeat_business', isset($_POST['macdes_repeat_business']) ? 'on' : 'off');

    // Save Repeat Business Checkbox
    $repeat_business = isset($_POST['macdes_repeat_business']) ? 'on' : 'off';
    update_post_meta($post_id, 'macdes_repeat_business', $repeat_business);

}
add_action('save_post', 'macdes_save_client_details');


add_action('graphql_register_types', function () {
    // Fields registration for each meta field
    $client_meta_fields = [
        'sizeOfBusiness' => 'macdes_size_of_business',
        'projectTypes' => 'macdes_project_types',
        'clientBackground' => 'macdes_client_background',
        'targetAudience' => 'macdes_target_audience',
        'geographicalReach' => 'macdes_geographical_reach',
        'goalsAndObjectives' => 'macdes_client_goals',
        'testimonialOrFeedback' => 'macdes_client_testimonial',
        'collaborationDetails' => 'macdes_collaboration_details',
        'repeatBusiness' => [
            'key' => 'macdes_repeat_business',
            'type' => 'Boolean',
            'resolve' => function($post) {
                return 'on' === get_post_meta($post->ID, 'macdes_repeat_business', true);
            }
        ],
    ];

    foreach ($client_meta_fields as $graphQLFieldName => $metaKey) {
        $type = 'String'; // Default type
        $resolveCallback = null;

        if (is_array($metaKey)) {
            $type = $metaKey['type'];
            $resolveCallback = $metaKey['resolve'];
            $metaKey = $metaKey['key'];
        } else {
            $resolveCallback = function($post) use ($metaKey) {
                return get_post_meta($post->ID, $metaKey, true);
            };
        }

        register_graphql_field('Client', $graphQLFieldName, [
            'type' => $type,
            'description' => "The ${graphQLFieldName} of the client",
            'resolve' => $resolveCallback,
        ]);
    }
});
