<?php
// This file is part of Moodle - http://moodle.org/

/**
 * English strings.
 *
 * @package    local_oidcpicture
 * @copyright  2026 BPSDM Jawa Timur
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'OIDC profile picture sync';
$string['privacy:metadata'] = 'The OIDC profile picture sync plugin stores the last applied picture URL as a user preference.';
$string['privacy:preference:local_oidcpicture_lasturl'] = 'The last OIDC picture URL applied to this user.';
$string['enabled'] = 'Enable picture sync';
$string['enabled_desc'] = 'When enabled, the user picture is fetched from the identity provider claim on every login.';
$string['claimname'] = 'Picture claim name';
$string['claimname_desc'] = 'Name of the ID token claim that holds the picture URL (default: picture).';
$string['maxbytes'] = 'Maximum image size (bytes)';
$string['maxbytes_desc'] = 'Downloads larger than this are rejected. Default 2097152 (2 MB).';
$string['timeout'] = 'Download timeout (seconds)';
$string['timeout_desc'] = 'Connection and total timeout when downloading the picture. Default 15.';
