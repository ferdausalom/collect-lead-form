<?php

namespace CollectLeadContactForm;

if (!defined('ABSPATH')) {
    echo esc_html('Hi there!  I\'m just a plugin, not much I can do when called directly.');
    exit;
}

class CLCF_Meta_Boxes
{
    // Init custom metabox
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'clcf_meta_boxes'));
    }

    // Add custom metabox in the custom post 'cl_leads'
    public function clcf_meta_boxes()
    {
        add_meta_box('clcf_metabox', 'Lead', array($this, 'display_clcf'), 'clcf_leads');
    }

    // Display custom metabox and data
    public function display_clcf()
    {
        $metas = get_post_meta(get_the_ID());

        unset($metas['_edit_lock']);

        if (isset($metas['_edit_last'])) {
            unset($metas['_edit_last']);
        }

        echo '<ul>';

        foreach ($metas as $key => $value) {

            echo "<li>" . "<span class='cl-key-column'>" . ucfirst(esc_html_e($key)) . "</span>" . ' : ' . "<span class='cl-key-value'>" . esc_html_e($value[0]) . "</span>" . "</li>";
        }

        echo '</ul>';
    }
}
