<?php

namespace CollectLeadContactForm;

if (!defined('ABSPATH')) {
    echo esc_html('Hi there!  I\'m just a plugin, not much I can do when called directly.');
    exit;
}

class CLCF_Enqueue_Scripts
{
    // Init scripts 
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_clcf_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'crb_enqueue_custom_carbon_fields_styles'));
    }

    // Enqueue scripts
    public function enqueue_clcf_scripts()
    {
        wp_enqueue_style('clcf', CLCF__PLUGIN_URL  . 'assets/css/app.css', array(), '1.0.0', 'all');

        if (!wp_script_is('jquery', 'enqueued')) {
            wp_enqueue_script('jquery');
        }

        wp_enqueue_script('clcf-main', CLCF__PLUGIN_URL . 'assets/js/clcf-main.js', array('jquery'), CLCF_VERSION, false);

        wp_localize_script(

            'clcf-main', //Enqueued JS file handle
            'clcf_rest_url', //Localized ID that need to use in the JS file

            array(
                'url' => esc_url(get_rest_url(null, 'clcf/v1/collect-lead-form')),
            )
        );
    }

    // Enqueue carbon-fields css
    public function crb_enqueue_custom_carbon_fields_styles()
    {
        wp_enqueue_style('carbon-fields-custom-theme', CLCF__PLUGIN_URL  . 'assets/css/carbon-fields-theme.css', array(), '1.0.0', 'all');
    }
}
