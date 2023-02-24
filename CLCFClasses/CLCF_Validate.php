<?php

namespace CollectLeadContactForm;

if (!defined('ABSPATH')) {
    echo esc_html('Hi there!  I\'m just a plugin, not much I can do when called directly.');
    exit;
}

class CLCF_Validate
{
    // Validate the lead data that came with $params 
    public function clcf_validate_the_lead($params)
    {
        $this->clcf_verify_nonce($params);

        // define variables and set to empty values
        $name = $email = $message = "";

        // Validate inputs 
        $name = $this->clcf_validate_input($params['name']);
        $email = $this->clcf_validate_input($params['email']);
        $message = $this->clcf_validate_input($params['message']);

        $params = $this->clcf_form_field_empty_check($name, $email, $message);

        return $params;
    }

    private function clcf_form_field_empty_check($name, $email, $message)
    {
        if (!empty($name) || !empty($email) && is_email($email)) {

            $params = [
                'name' => esc_html($name),
                'email' => esc_html($email),
                'message' => esc_html($message),
            ];

            return $params;
        } else {

            clcf_json_encode(false, esc_html(carbon_get_theme_option('clcf_error')));
        }
    }

    private function clcf_verify_nonce($params)
    {
        if (!wp_verify_nonce($params['_wpnonce'], 'wp_rest')) {

            clcf_json_encode(false, esc_html(carbon_get_theme_option('clcf_error')));
        }

        unset($params['_wpnonce']);
        unset($params['_wp_http_referer']);
    }

    private function clcf_validate_input($data)
    {
        // Validation rules 
        $data = sanitize_text_field($data);
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
