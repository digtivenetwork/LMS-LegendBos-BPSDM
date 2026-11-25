<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Privacy provider.
 *
 * @package    local_oidcname
 * @copyright  2026 BPSDM Jawa Timur
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_oidcname\privacy;

defined('MOODLE_INTERNAL') || die();

use core_privacy\local\metadata\null_provider;

/**
 * Privacy provider: this plugin stores no personal data of its own.
 */
class provider implements null_provider {

    /**
     * Reason for the null provider.
     *
     * @return string
     */
    public static function get_reason(): string {
        return 'privacy:metadata';
    }
}
