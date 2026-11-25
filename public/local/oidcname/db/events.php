<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Event observers.
 *
 * @package    local_oidcname
 * @copyright  2026 BPSDM Jawa Timur
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$observers = [
    [
        'eventname' => '\core\event\user_loggedin',
        'callback'  => '\local_oidcname\observer::user_loggedin',
        'internal'  => false,
        'priority'  => 9990,
    ],
];
