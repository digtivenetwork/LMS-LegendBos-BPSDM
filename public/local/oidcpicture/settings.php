<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Admin settings.
 *
 * @package    local_oidcpicture
 * @copyright  2026 BPSDM Jawa Timur
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_oidcpicture', get_string('pluginname', 'local_oidcpicture'));

    $settings->add(new admin_setting_configcheckbox(
        'local_oidcpicture/enabled',
        get_string('enabled', 'local_oidcpicture'),
        get_string('enabled_desc', 'local_oidcpicture'),
        1
    ));

    $settings->add(new admin_setting_configtext(
        'local_oidcpicture/claimname',
        get_string('claimname', 'local_oidcpicture'),
        get_string('claimname_desc', 'local_oidcpicture'),
        'picture',
        PARAM_ALPHANUMEXT
    ));

    $settings->add(new admin_setting_configtext(
        'local_oidcpicture/maxbytes',
        get_string('maxbytes', 'local_oidcpicture'),
        get_string('maxbytes_desc', 'local_oidcpicture'),
        2097152,
        PARAM_INT
    ));

    $settings->add(new admin_setting_configtext(
        'local_oidcpicture/timeout',
        get_string('timeout', 'local_oidcpicture'),
        get_string('timeout_desc', 'local_oidcpicture'),
        15,
        PARAM_INT
    ));

    $ADMIN->add('localplugins', $settings);
}
