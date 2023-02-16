<?php

namespace CollectLeadContactForm;

if (!defined('ABSPATH')) {

    echo esc_html('Hi there!  I\'m just a plugin, not much I can do when called directly.');
    exit;
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Carbon_Fields;

class CLCF_Carbon_Fields
{

    // Boot carbon fields plugin 
    public function crb_load()
    {
        Carbon_Fields::boot();
    }

    // Register carbon fields and init submenu page 
    public function __construct()
    {
        add_action('carbon_fields_register_fields', array($this, 'crb_attach_theme_options'));
        add_action('after_setup_theme', array($this, 'crb_load'));
        add_action('admin_menu', array($this, 'register_clcf_sub_menu'));
    }

    // Register submenu page 
    public function register_clcf_sub_menu()
    {
        add_submenu_page(
            'edit.php?post_type=clcf_leads',
            __('Lead Forms', 'collect_lead_form'),
            __('Lead Forms', 'collect_lead_form'),
            'manage_options',
            'collect-lead-forms',
            array($this, 'clcf_forms')
        );
    }

    // Show forms into submenu page  
    public function clcf_forms()
    {
        include CLCF__PLUGIN_DIR . 'views/admin/cl-forms.php';
    }

    // Declare carbon fields options
    public function crb_attach_theme_options()
    {
        !current_user_can('manage_options');

        Container::make('theme_options', __('Form Messages', 'collect_lead_form'))
            ->set_page_parent('edit.php?post_type=clcf_leads')
            ->add_fields(array(
                Field::make('textarea', 'clcf_success', __('Success Message', 'collect_lead_form'))
                    ->set_attribute('placeholder', __('Enter success message', 'collect_lead_form'))
                    ->set_help_text(__('Type the message you want the show after form has been successfully submitted.', 'collect_lead_form'))
                    ->set_default_value(__('Sent successfully!', 'collect_lead_form'))
                    ->set_required(true),
                Field::make('textarea', 'clcf_error', __('Error Message', 'collect_lead_form'))
                    ->set_attribute('placeholder', __('Enter error message', 'collect_lead_form'))
                    ->set_help_text(__('Type the message you want the show after form has been unsuccessfully submitted.', 'collect_lead_form'))
                    ->set_default_value(__('Something went wrong!', 'collect_lead_form'))
                    ->set_required(true)
            ));

        Container::make('theme_options', __('Configure Server', 'collect_lead_form'))
            ->set_page_parent('edit.php?post_type=clcf_leads')
            ->add_fields(array(
                Field::make('html', 'clcf_config_help_text')
                    ->set_html('
                    <h2 class="note">Note:</h2>
                    <span>First register an email in your web server and configure it here. If you want to
                    receive the lead rather than web server inbox then redirect the email from web
                    server to gmail or yahoo or other account.
                    If you get any problem to configure, or want to configure with other email client like
                    <strong>Mailchimp, SendGrid</strong>, contact the plugin owner <strong>faferdaus@gmail.com</strong></span>
                '),
                Field::make('text', 'clcf_email_host', __('Host', 'collect_lead_form'))
                    ->set_attribute('placeholder', __('e.g. smtp.email.com', 'collect_lead_form'))
                    ->set_help_text(__('Write SMTP server address.', 'collect_lead_form'))
                    ->set_required(true),
                Field::make('text', 'clcf_email_port', __('SMTP port', 'collect_lead_form'))
                    ->set_attribute('placeholder', __('e.g. 465', 'collect_lead_form'))
                    ->set_help_text(__('Write SMTP port.', 'collect_lead_form'))
                    ->set_required(true),
                Field::make('text', 'clcf_email_username', __('SMTP username', 'collect_lead_form'))
                    ->set_attribute('placeholder', __('e.g. your@email.com', 'collect_lead_form'))
                    ->set_help_text(__('Write SMTP username.', 'collect_lead_form'))
                    ->set_required(true),
                Field::make('wolfie_password', 'clcf_email_password', __('SMTP password', 'collect_lead_form'))
                    ->set_required(true)
                    ->set_help_text(__('Write your email password.', 'collect_lead_form')),
            ));
    }
}
