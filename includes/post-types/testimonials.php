<?php

function macdes_register_testimonial_cpt() {
    $labels = array(
        'name'               => _x('Testimonials', 'post type general name', 'macdes'),
        'singular_name'      => _x('Testimonial', 'post type singular name', 'macdes'),
        'menu_name'          => _x('Testimonials', 'admin menu', 'macdes'),
        'name_admin_bar'     => _x('Testimonial', 'add new on admin bar', 'macdes'),
        'add_new'            => _x('Add New', 'testimonial', 'macdes'),
        'add_new_item'       => __('Add New Testimonial', 'macdes'),
        'new_item'           => __('New Testimonial', 'macdes'),
        'edit_item'          => __('Edit Testimonial', 'macdes'),
        'view_item'          => __('View Testimonial', 'macdes'),
        'all_items'          => __('All Testimonials', 'macdes'),
        'search_items'       => __('Search Testimonials', 'macdes'),
        'not_found'          => __('No testimonials found.', 'macdes'),
        'not_found_in_trash' => __('No testimonials found in Trash.', 'macdes'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'testimonials'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor'),
        'show_in_rest'          => false,
        'show_in_graphql'       => true,
        'graphql_single_name'   => 'Testimonial',
        'graphql_plural_name'   => 'Testimonials',
    );

    register_post_type('macdes_testimonial', $args);
}
add_action('init', 'macdes_register_testimonial_cpt');


function macdes_add_testimonial_import_page() {
    add_submenu_page(
        'edit.php?post_type=macdes_testimonial', // Parent slug
        'Import Testimonials',                   // Page title
        'Import',                                // Menu title
        'manage_options',                        // Capability
        'macdes_import_testimonials',            // Menu slug
        'macdes_import_testimonials_page_html'   // Callback function
    );
}
add_action('admin_menu', 'macdes_add_testimonial_import_page');

function macdes_import_testimonials_page_html() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // HTML for the import page
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form method="post" enctype="multipart/form-data">
            <?php
            // Nonce field for security
            wp_nonce_field('macdes_testimonial_import_action', 'macdes_testimonial_import_nonce');
            ?>
            <input type="file" name="macdes_testimonial_file" id="macdes_testimonial_file" accept=".csv">
            <input type="submit" class="button button-primary" value="Import Testimonials">
        </form>
    </div>
    <?php
}


function macdes_handle_testimonial_import() {
    if (isset($_POST['macdes_testimonial_import_nonce'], $_FILES['macdes_testimonial_file']) && wp_verify_nonce($_POST['macdes_testimonial_import_nonce'], 'macdes_testimonial_import_action')) {

        $file = $_FILES['macdes_testimonial_file'];

        if ($file['error'] === UPLOAD_ERR_OK) {
            $filename = $file['tmp_name'];
            $handle = fopen($filename, 'r');

            // Skip the header row if your CSV has one
            fgetcsv($handle);

            while (($data = fgetcsv($handle)) !== FALSE) {
                // Create testimonial post
                $testimonial_id = wp_insert_post(array(
                    'post_type'    => 'macdes_testimonial',
                    'post_title'   => sanitize_text_field($data[0]), // Assuming name is in the first column
                    'post_content' => sanitize_textarea_field($data[3]), // Assuming message is in the fourth column
                    'post_status'  => 'publish',
                ));

                // Assuming other fields are in the CSV and mapping them correctly
                update_post_meta($testimonial_id, 'macdes_business_affiliation', sanitize_text_field($data[1])); // Business Affiliation in second column
                update_post_meta($testimonial_id, 'macdes_star_rating', sanitize_text_field($data[2])); // Star Rating in third column
                // Add more fields as necessary
            }

            fclose($handle);

            // Redirect or show a success message
        }
    }
}
add_action('admin_init', 'macdes_handle_testimonial_import');
