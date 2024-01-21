<?php

function macdes_register_taxonomy_skills_used() {
    $labels = array(
        'name'                       => _x( 'Skills Used', 'Taxonomy General Name', 'macdes' ),
        'singular_name'              => _x( 'Skill Used', 'Taxonomy Singular Name', 'macdes' ),
        'menu_name'                  => __( 'Skills Used', 'macdes' ),
        'all_items'                  => __( 'All Skills', 'macdes' ),
        'new_item_name'              => __( 'New Skill Name', 'macdes' ),
        'add_new_item'               => __( 'Add New Skill', 'macdes' ),
        'edit_item'                  => __( 'Edit Skill', 'macdes' ),
        'update_item'                => __( 'Update Skill', 'macdes' ),
        'view_item'                  => __( 'View Skill', 'macdes' ),
        'separate_items_with_commas' => __( 'Separate skills with commas', 'macdes' ),
        'add_or_remove_items'        => __( 'Add or remove skills', 'macdes' ),
        'choose_from_most_used'      => __( 'Choose from the most used skills', 'macdes' ),
        'popular_items'              => __( 'Popular Skills', 'macdes' ),
        'search_items'               => __( 'Search Skills', 'macdes' ),
        'not_found'                  => __( 'Not Found', 'macdes' ),
        'no_terms'                   => __( 'No skills', 'macdes' ),
        'items_list'                 => __( 'Skills list', 'macdes' ),
        'items_list_navigation'      => __( 'Skills list navigation', 'macdes' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false, // Set to false for a tag-like taxonomy
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_graphql'            => true,
        'graphql_single_name'        => 'SkillUsed',
        'graphql_plural_name'        => 'SkillsUsed',
    );
    register_taxonomy( 'skills_used', array( 'macdes_clients' ), $args );
}
add_action( 'init', 'macdes_register_taxonomy_skills_used', 0 );
