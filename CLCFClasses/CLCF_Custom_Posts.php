<?php

namespace CollectLeadContactForm;

if (!defined('ABSPATH')) {
    echo esc_html('Hi there!  I\'m just a plugin, not much I can do when called directly.');
    exit;
}

class CLCF_Custom_Posts
{
    // Init custom posts
    public function __construct()
    {
        add_action('init', array($this, 'clcf_leads'));
        add_filter('manage_clcf_leads_posts_columns', array($this, 'clcf_leads_posts_columns'));
        add_action('manage_clcf_leads_posts_custom_column', array($this, 'fill_clcf_column_data'), 10, 2);
        add_action('admin_init', array($this, 'modify_clcf_search'));
    }

    // Register custom post
    public function clcf_leads()
    {
        $labels = array(
            'name'                => _x('Leads', 'Post Type General Name', 'collect_lead_form'),
            'singular_name'       => _x('Lead', 'Post Type Singular Name', 'collect_lead_form'),
            'menu_name'           => __('Collected Leads', 'collect_lead_form'),
            'edit_item'           => __('View Lead', 'collect_lead_form'),
        );

        $args = array(
            'label'               => __('Leads', 'collect_lead_form'),
            'labels'              => $labels,
            'supports'            => false,
            'has_archive'         => true,
            'capability_type'     => 'post',
            'capabilities' => array(
                'create_posts' => false,
            ),
            'public' => true,
            'publicly_queryable'  => false,
            'map_meta_cap' => true,
            'menu_icon'           => 'dashicons-id-alt',

        );

        // Registering your Custom Post Type
        register_post_type('clcf_leads', $args);
    }

    // Add custom posts columns
    public function clcf_leads_posts_columns($columns)
    {
        $columns = [
            'cb' => $columns['cb'],
            'name' => __('Name'),
            'email' => __('Email'),
            'message' => __('Message'),
            'date' => $columns['date']
        ];

        return $columns;
    }

    // Add custom posts columns data
    public function fill_clcf_column_data($column, $post_id)
    {
        switch ($column) {
            case 'name':
                echo get_post_meta(absint($post_id), 'name', true);
                break;

            case 'email':
                echo get_post_meta(absint($post_id), 'email', true);
                break;

            case 'message':
                echo get_post_meta(absint($post_id), 'message', true);
                break;
        }
    }

    // Modify custom posts search in admin area
    public function modify_clcf_search()
    {
        global $typenow;

        if ($typenow == 'clcf_leads') {
            add_filter('posts_search', array($this, 'override_clcf_search'), 10, 2);
        }
    }

    // Function custom posts search in admin area
    public function override_clcf_search($search, $query)
    {
        global $wpdb;

        if ($query->is_main_query() && !empty($query->query['s'])) {
            $sql    = "
              or exists (
                  select * from {$wpdb->postmeta} where post_id={$wpdb->posts}.ID
                  and meta_key in ('name','email')
                  and meta_value like %s
              )
          ";
            $like   = '%' . $wpdb->esc_like($query->query['s']) . '%';
            $search = preg_replace(
                "#\({$wpdb->posts}.post_title LIKE [^)]+\)\K#",
                $wpdb->prepare($sql, $like),
                $search
            );
        }

        return $search;
    }
}
