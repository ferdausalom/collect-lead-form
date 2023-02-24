<?php

namespace CollectLeadContactForm;

if (!defined('ABSPATH')) {
    echo esc_html('Hi there!  I\'m just a plugin, not much I can do when called directly.');
    exit;
}

use CollectLeadContactForm\CLCF_Validate;
use CollectLeadContactForm\CLCF_Email;
use CollectLeadContactForm\CLCF_Create_Email_Template;
use WP_REST_Request;

class CLCF_Rest_Routes
{

    // Init REST API 
    public function __construct()
    {
        add_action('rest_api_init', array($this, 'create_clcf_rest_endpoints'));
    }

    // Register REST API
    public function create_clcf_rest_endpoints()
    {
        register_rest_route('clcf/v1/', 'collect-lead-form', array(
            'methods' => 'POST',
            'callback' => array($this, 'clcf_submit_form'),
            'args' => $this->clcf_rest_args(),
            'show_in_index'       => false,
        ));
    }

    // REST API args 
    public function clcf_rest_args()
    {
        $args = array();

        $args['name'] = array(
            'type'              => 'string',
            'required'          => true
        );

        $args['email'] = array(
            'required' => true,
        );

        return $args;
    }

    // Submit REST API data 
    public function clcf_submit_form(WP_REST_Request $request)
    {

        $params = $request->get_params();

        // Validate data 
        $validatedParams = (new CLCF_Validate)->clcf_validate_the_lead($params);

        // Store data 
        (new CLCF_Store)->clcf_store_the_lead($validatedParams);

        // Create email template and update data 
        (new CLCF_Create_Email_Template)->clcf_email_template($validatedParams);

        // Email the lead 
        (new CLCF_Email($validatedParams))->clcf_email_the_lead();

        // Show success message in the front-end 
        clcf_json_encode(true, esc_html(carbon_get_theme_option('clcf_success')));
    }
}
