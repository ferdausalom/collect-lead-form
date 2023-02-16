<?php

namespace CollectLeadContactForm;

if (!defined('ABSPATH')) {
    echo esc_html('Hi there!  I\'m just a plugin, not much I can do when called directly.');
    exit;
}

use PHPMailer;
use Exception;

class CLCF_Email
{

    public function clcf_email_the_lead($params)
    {
        try {
            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = carbon_get_theme_option('clcf_email_host');
            $mail->SMTPAuth = true;

            $mail->SMTPSecure = 'ssl';
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = carbon_get_theme_option('clcf_email_port');
            $mail->Username = carbon_get_theme_option('clcf_email_username');
            $mail->Password = carbon_get_theme_option('clcf_email_password');
            //Recipients
            $mail->setFrom(esc_html(get_bloginfo('admin_email')), esc_html("Lead collected from: ") . esc_url(get_bloginfo('url')));
            $mail->addAddress(esc_html(get_bloginfo('admin_email')));
            $mail->addAddress(esc_html(carbon_get_theme_option('clcf_email_username')));
            $mail->addReplyTo(esc_html($params['email']));

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Lead name: <{$params['name']}>";
            $mail->Body    = file_get_contents(CLCF__PLUGIN_DIR . 'views/email-template.php');

            $mail->send();
        } catch (Exception $e) {

            clcf_json_encode(false, esc_html(carbon_get_theme_option('clcf_error')));
        }
    }
}
