<?php

function macdes_add_testimonial_meta_box() {
    add_meta_box(
        'macdes_testimonial_details',
        'Testimonial Details',
        'macdes_testimonial_meta_box_callback',
        'macdes_testimonial', // Ensure this matches your Testimonial Post Type key
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'macdes_add_testimonial_meta_box');

function macdes_testimonial_meta_box_callback($post) {
    wp_nonce_field('macdes_save_testimonial_meta', 'macdes_testimonial_nonce');
    $business_affiliation = get_post_meta($post->ID, 'macdes_business_affiliation', true);
    $testimonial_rating = get_post_meta($post->ID, 'macdes_testimonial_rating', true);
    $testimonial_featured = get_post_meta($post->ID, 'macdes_testimonial_featured', true);

    // Fields HTML
    echo '<div class="macdes-meta-field">';
    echo '<label for="macdes_business_affiliation">Business Affiliation:</label>';
    echo '<input type="text" id="macdes_business_affiliation" name="macdes_business_affiliation" value="' . esc_attr($business_affiliation) . '">';
    echo '</div>';

    echo '<div class="macdes-meta-field">';
    echo '<label for="macdes_testimonial_rating">Star Rating (1-5):</label>';
    echo '<input type="number" id="macdes_testimonial_rating" name="macdes_testimonial_rating" value="' . esc_attr($testimonial_rating) . '" min="1" max="5" />';
    echo '</div>';

    echo '<div class="macdes-meta-field">';
    echo '<label for="macdes_testimonial_featured">Featured:</label>';
    echo '<input type="checkbox" id="macdes_testimonial_featured" name="macdes_testimonial_featured" ' . checked($testimonial_featured, 'on', false) . ' />';
    echo '</div>';
}

function macdes_save_testimonial_meta($post_id) {
    // Check if nonce is set and valid
    if (!isset($_POST['macdes_testimonial_nonce']) || !wp_verify_nonce($_POST['macdes_testimonial_nonce'], 'macdes_save_testimonial_meta')) {
        return;
    }

    // Check if the current user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check for autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save Business Affiliation
    if (isset($_POST['macdes_business_affiliation'])) {
        update_post_meta($post_id, 'macdes_business_affiliation', sanitize_text_field($_POST['macdes_business_affiliation']));
    }

    // Save Message
    if (isset($_POST['macdes_testimonial_message'])) {
        update_post_meta($post_id, 'macdes_testimonial_message', sanitize_textarea_field($_POST['macdes_testimonial_message']));
    }

    // Save Star Rating
    if (isset($_POST['macdes_testimonial_rating'])) {
        $rating = (int) $_POST['macdes_testimonial_rating'];
        $rating = ($rating >= 1 && $rating <= 5) ? $rating : ''; // Ensure rating is within 1-5
        update_post_meta($post_id, 'macdes_testimonial_rating', $rating);
    }

    // Save Featured Checkbox
    $is_featured = isset($_POST['macdes_testimonial_featured']) ? 'on' : 'off';
    update_post_meta($post_id, 'macdes_testimonial_featured', $is_featured);
}
add_action('save_post', 'macdes_save_testimonial_meta');



add_action('graphql_register_types', function () {
    // Register Business Affiliation
    register_graphql_field('Testimonial', 'businessAffiliation', [
        'type' => 'String',
        'description' => 'The business affiliation of the testimonial author',
        'resolve' => function($post) {
            return get_post_meta($post->ID, 'macdes_business_affiliation', true);
        }
    ]);

    // Register Message
    register_graphql_field('Testimonial', 'message', [
        'type' => 'String',
        'description' => 'The message of the testimonial',
        'resolve' => function($post) {
            return get_post_meta($post->ID, 'macdes_testimonial_message', true);
        }
    ]);

    // Register Star Rating
    register_graphql_field('Testimonial', 'starRating', [
        'type' => 'Integer',
        'description' => 'The star rating given in the testimonial',
        'resolve' => function($post) {
            return (int) get_post_meta($post->ID, 'macdes_star_rating', true);
        }
    ]);

    // Register Featured
    register_graphql_field('Testimonial', 'featured', [
        'type' => 'Boolean',
        'description' => 'Whether the testimonial is marked as featured',
        'resolve' => function($post) {
            return 'on' === get_post_meta($post->ID, 'macdes_testimonial_featured', true);
        }
    ]);

    // Add more fields as necessary
});
