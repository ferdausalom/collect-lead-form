<?php

namespace CollectLeadContactForm;

if (!defined('ABSPATH')) {
    echo esc_html('Hi there!  I\'m just a plugin, not much I can do when called directly.');
    exit;
}

class CLCF_Email
{

    private $clcf_add_reply_to;
    private $clcf_lead_name;

    public function __construct($params)
    {
        $this->clcf_add_reply_to = esc_html($params['email']);
        $this->clcf_lead_name = esc_html($params['name']);
    }

    // Setup email options 
    public function clcf_send_smtp_email($phpmailer)
    {
        $phpmailer->isSMTP();
        $phpmailer->Host = carbon_get_theme_option('clcf_email_host');
        $phpmailer->SMTPAuth = true;
        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->Port = carbon_get_theme_option('clcf_email_port');
        $phpmailer->Username = carbon_get_theme_option('clcf_email_username');
        $phpmailer->Password = carbon_get_theme_option('clcf_email_password');

        //Recipients
        $phpmailer->From     = esc_html(get_bloginfo('admin_email'));
        $phpmailer->FromName = esc_html("Lead collected from: ") . esc_url(get_bloginfo('url'));
        $phpmailer->addAddress(esc_html(get_bloginfo('admin_email')));
        $phpmailer->addAddress(esc_html(carbon_get_theme_option('clcf_email_username')));
        $phpmailer->addReplyTo($this->clcf_add_reply_to);
    }

    public function clcf_email_the_lead()
    {

        $to = esc_html(get_bloginfo('admin_email'));
        $subject = "Lead name: <{$this->clcf_lead_name}>";
        $message = file_get_contents(CLCF__PLUGIN_DIR . 'views/email-template.php');
        $headers = array('Content-Type: text/html; charset=UTF-8');

        // Instantiate PHPMAILER 
        add_filter('phpmailer_init', array($this, 'clcf_send_smtp_email'));

        try {

            wp_mail($to, $subject, $message, $headers);

            remove_action('phpmailer_init', 'clcf_send_smtp_email');
        } catch (\Throwable $th) {
            clcf_json_encode(false, esc_html(carbon_get_theme_option('clcf_error')));
        }
    }
}
