<?php
/*
Plugin Name: Collect Lead Form, Contact form
Description: This form is designed to collect lead easily, or use as contact form. if you want to modify or add new form, please contact the plugin owner faferdaus@gmail.com.
Author: Ferdaus Alom
Author URI: https://ferdausalom.site
Version: 1.0.0
Requires at least: 5.0
Requires PHP: 5.0
Text Domain: collect_lead_form
*/

// Make sure we don't expose any info if called directly
if (!defined('ABSPATH')) {
    echo esc_html('Hi there!  I\'m just a plugin, not much I can do when called directly.');
    exit;
}

// Load vendor autoload
require __DIR__ . '/vendor/autoload.php';

// Define plugin constants 
define('CLCF_VERSION', '1.0');
define('CLCF__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CLCF__PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required classes 
use CollectLeadContactForm\CLCF_Enqueue_Scripts;
use CollectLeadContactForm\CLCF_Short_Codes;
use CollectLeadContactForm\CLCF_Rest_Routes;
use CollectLeadContactForm\CLCF_Carbon_Fields;
use CollectLeadContactForm\CLCF_Meta_Boxes;
use CollectLeadContactForm\CLCF_Custom_Posts;

require_once ABSPATH . WPINC . '/class-phpmailer.php';
require_once ABSPATH . WPINC . '/class-smtp.php';


class Plugin_CLCF_Bootstrap
{
    // Init plugin 
    public function __construct()
    {
        add_action('plugins_loaded', array($this, 'clcf_run_classes'));
    }

    // Instantiate required classes 
    public function clcf_run_classes()
    {
        new CLCF_Enqueue_Scripts;
        new CLCF_Short_Codes;
        new CLCF_Rest_Routes;
        new CLCF_Carbon_Fields;
        new CLCF_Meta_Boxes;
        new CLCF_Custom_Posts;
    }
}

new Plugin_CLCF_Bootstrap;
