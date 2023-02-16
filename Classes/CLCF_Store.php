<?php

namespace CollectLeadContactForm;

if (!defined('ABSPATH')) {
    echo esc_html('Hi there!  I\'m just a plugin, not much I can do when called directly.');
    exit;
}

class CLCF_Store
{
    // Store the lead data that came with $params 
    public function clcf_store_the_lead($params)
    {
        $postArr = [
            'post_title' => esc_html($params['name']),
            'post_type' => 'clcf_leads',
            'post_status' => 'publish',
        ];

        $post_id = wp_insert_post($postArr);

        foreach ($params as $key => $value) {
            add_post_meta($post_id, $key, $value);
        }
    }
}
