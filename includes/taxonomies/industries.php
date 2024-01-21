<?php

// Register Custom Taxonomy for Industry
function macdes_register_taxonomy_industry() {
    $labels = array(
        'name'                       => _x( 'Industries', 'Taxonomy General Name', 'macdes' ),
        'singular_name'              => _x( 'Industry', 'Taxonomy Singular Name', 'macdes' ),
        'menu_name'                  => __( 'Industry', 'macdes' ),
        'all_items'                  => __( 'All Industries', 'macdes' ),
        'parent_item'                => __( 'Parent Industry', 'macdes' ),
        'parent_item_colon'          => __( 'Parent Industry:', 'macdes' ),
        'new_item_name'              => __( 'New Industry Name', 'macdes' ),
        'add_new_item'               => __( 'Add New Industry', 'macdes' ),
        'edit_item'                  => __( 'Edit Industry', 'macdes' ),
        'update_item'                => __( 'Update Industry', 'macdes' ),
        'view_item'                  => __( 'View Industry', 'macdes' ),
        'separate_items_with_commas' => __( 'Separate industries with commas', 'macdes' ),
        'add_or_remove_items'        => __( 'Add or remove industries', 'macdes' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'macdes' ),
        'popular_items'              => __( 'Popular Industries', 'macdes' ),
        'search_items'               => __( 'Search Industries', 'macdes' ),
        'not_found'                  => __( 'Not Found', 'macdes' ),
        'no_terms'                   => __( 'No industries', 'macdes' ),
        'items_list'                 => __( 'Industries list', 'macdes' ),
        'items_list_navigation'      => __( 'Industries list navigation', 'macdes' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_graphql'            => true,
        'graphql_single_name'        => 'Industry',
        'graphql_plural_name'        => 'Industries',
    );
    register_taxonomy( 'industry', array( 'macdes_clients' ), $args );
}
add_action( 'init', 'macdes_register_taxonomy_industry', 0 );

// Similar functions for 'service_type', 'location', 'status', 'project_type'
// Replace 'industry' with the respective taxonomy name and labels
// Set 'hierarchical' to true for hierarchical taxonomies (like categories)
// and false for non-hierarchical taxonomies (like tags)