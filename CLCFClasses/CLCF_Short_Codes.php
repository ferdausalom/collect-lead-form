<?php

namespace CollectLeadContactForm;

if (!defined('ABSPATH')) {
    echo esc_html('Hi there!  I\'m just a plugin, not much I can do when called directly.');
    exit;
}

class CLCF_Short_Codes
{
    // Init shortcode 
    public function __construct()
    {
        add_shortcode('collect-lead-form', array($this, 'clcf_form'));
    }

    // Include front-end form
    public function clcf_form()
    {
        ob_start();
        include CLCF__PLUGIN_DIR . 'views/cl-form.php';
        $output = ob_get_clean();
        return $output;
    }
}
