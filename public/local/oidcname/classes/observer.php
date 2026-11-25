<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Login observer: split the OIDC name claim into firstname / lastname.
 *
 * @package    local_oidcname
 * @copyright  2026 BPSDM Jawa Timur
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_oidcname;

defined('MOODLE_INTERNAL') || die();

/**
 * Observer class.
 */
class observer {

    /**
     * Handle user_loggedin.
     *
     * @param \core\event\user_loggedin $event
     * @return void
     */
    public static function user_loggedin(\core\event\user_loggedin $event): void {
        global $CFG;

        if (!get_config('local_oidcname', 'enabled')) {
            return;
        }

        // A naming problem must never break the login flow.
        try {
            require_once($CFG->dirroot . '/local/oidcname/classes/namesync.php');
            namesync::sync_user_name((int)$event->objectid);
        } catch (\Throwable $e) {
            debugging('local_oidcname: ' . $e->getMessage(), DEBUG_DEVELOPER);
        }
    }
}
