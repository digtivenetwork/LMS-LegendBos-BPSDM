<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Admin settings.
 *
 * @package    local_oidcname
 * @copyright  2026 BPSDM Jawa Timur
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_oidcname', get_string('pluginname', 'local_oidcname'));

    $settings->add(new admin_setting_configcheckbox(
        'local_oidcname/enabled',
        get_string('enabled', 'local_oidcname'),
        get_string('enabled_desc', 'local_oidcname'),
        1
    ));

    $settings->add(new admin_setting_configtext(
        'local_oidcname/claimname',
        get_string('claimname', 'local_oidcname'),
        get_string('claimname_desc', 'local_oidcname'),
        'name',
        PARAM_ALPHANUMEXT
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_oidcname/stripgelar',
        get_string('stripgelar', 'local_oidcname'),
        get_string('stripgelar_desc', 'local_oidcname'),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_oidcname/striptitles',
        get_string('striptitles', 'local_oidcname'),
        get_string('striptitles_desc', 'local_oidcname'),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_oidcname/prefergivenfamily',
        get_string('prefergivenfamily', 'local_oidcname'),
        get_string('prefergivenfamily_desc', 'local_oidcname'),
        0
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_oidcname/overwrite',
        get_string('overwrite', 'local_oidcname'),
        get_string('overwrite_desc', 'local_oidcname'),
        1
    ));

    $ADMIN->add('localplugins', $settings);
}
