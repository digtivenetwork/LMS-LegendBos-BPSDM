<?php
// Admin settings for customcertelement_bpsdmno.

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings->add(new admin_setting_configtext(
        'customcertelement_bpsdmno/startingnumber',
        get_string('startingnumber', 'customcertelement_bpsdmno'),
        get_string('startingnumber_desc', 'customcertelement_bpsdmno'),
        '71076',
        PARAM_INT
    ));
}
