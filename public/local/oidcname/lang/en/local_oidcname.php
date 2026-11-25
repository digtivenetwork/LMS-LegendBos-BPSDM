<?php
// This file is part of Moodle - http://moodle.org/

/**
 * English strings.
 *
 * @package    local_oidcname
 * @copyright  2026 BPSDM Jawa Timur
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'OIDC first/last name split';
$string['privacy:metadata'] = 'The OIDC name split plugin does not store any personal data; it only copies values from the identity provider token into the user record.';
$string['enabled'] = 'Enable name sync';
$string['enabled_desc'] = 'When enabled, firstname and lastname are derived from the identity provider claim on every login.';
$string['claimname'] = 'Source claim name';
$string['claimname_desc'] = 'ID token claim holding the full name (default: name).';
$string['stripgelar'] = 'Strip academic titles';
$string['stripgelar_desc'] = 'Drop everything after the first comma, e.g. "Budi Santoso, S.Kom" becomes "Budi Santoso".';
$string['striptitles'] = 'Strip front titles';
$string['striptitles_desc'] = 'Remove leading titles such as Prof., Dr., Drs., Ir., H. before splitting the name.';
$string['prefergivenfamily'] = 'Prefer given_name/family_name';
$string['prefergivenfamily_desc'] = 'If enabled and the token carries given_name and family_name, use them instead of splitting the full name.';
$string['overwrite'] = 'Overwrite existing names';
$string['overwrite_desc'] = 'If disabled, users with both firstname and lastname already filled in are left untouched.';
