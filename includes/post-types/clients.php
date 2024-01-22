<?php

if ( ! function_exists('macdes_register_clients') ) {

    // Register Custom Post Type
    function macdes_register_clients() {

        $labels = array(
            'name'                  => _x( 'Clients', 'Post Type General Name', 'macdes' ),
            'singular_name'         => _x( 'Client', 'Post Type Singular Name', 'macdes' ),
            'menu_name'             => __( 'Clients', 'macdes' ),
            'name_admin_bar'        => __( 'Client', 'macdes' ),
            'archives'              => __( 'Client Archives', 'macdes' ),
            'attributes'            => __( 'Client Attributes', 'macdes' ),
            'parent_item_colon'     => __( 'Parent Client:', 'macdes' ),
            'all_items'             => __( 'All Clients', 'macdes' ),
            'add_new_item'          => __( 'Add New Client', 'macdes' ),
            'add_new'               => __( 'Add New', 'macdes' ),
            'new_item'              => __( 'New Client', 'macdes' ),
            'edit_item'             => __( 'Edit Client', 'macdes' ),
            'update_item'           => __( 'Update Client', 'macdes' ),
            'view_item'             => __( 'View Client', 'macdes' ),
            'view_items'            => __( 'View Clients', 'macdes' ),
            'search_items'          => __( 'Search Clients', 'macdes' ),
            'not_found'             => __( 'Not found', 'macdes' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'macdes' ),
            'featured_image'        => __( 'Client Logo', 'macdes' ),
            'set_featured_image'    => __( 'Set Client Logo', 'macdes' ),
            'remove_featured_image' => __( 'Remove Client Logo', 'macdes' ),
            'use_featured_image'    => __( 'Use as Client Logo', 'macdes' ),
            'insert_into_item'      => __( 'Insert into Client', 'macdes' ),
            'uploaded_to_this_item' => __( 'Uploaded to this Client', 'macdes' ),
            'items_list'            => __( 'Clients list', 'macdes' ),
            'items_list_navigation' => __( 'Clients list navigation', 'macdes' ),
            'filter_items_list'     => __( 'Filter clients list', 'macdes' ),
        );
        $args = array(
            'label'                 => __( 'Client', 'macdes' ),
            'description'           => __( 'Post Type for managing clients', 'macdes' ),
						'rewrite' => array('slug' => 'clients'),
            'labels'                => $labels,
            'supports'              => array( 'title', 'thumbnail', 'custom-fields' ),
            'taxonomies'            => array( 'industry', ' service_type', ' location', ' status', ' project_type' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-businessman',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'clients',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => false,
            'show_in_graphql'       => true,
            'graphql_single_name'   => 'Client',
            'graphql_plural_name'   => 'Clients',
        );

        register_post_type( 'macdes_clients', $args );
    }
    add_action( 'init', 'macdes_register_clients', 0 );
}