<?php

if (!defined('ABSPATH')) {
    echo esc_html('Hi there!  I\'m just a plugin, not much I can do when called directly.');
    exit;
}

// Die and dump 
if (!function_exists('clcf_dd')) {
    function clcf_dd($data)
    {
        echo '<pre>';
        die(highlight_string("<?php\n\$data =\n" . var_export($data, true) . ";\n?>"));
        echo '</pre>';
    }
}

// Message function to show in the front-end 
if (!function_exists('clcf_json_encode')) {
    function clcf_json_encode($success, $message)
    {
        echo wp_json_encode(array(
            'success' => $success,
            'message' => $message
        ));
        exit();
    }
}
