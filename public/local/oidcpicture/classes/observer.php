<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Login observer: sync user picture from OIDC "picture" claim.
 *
 * @package    local_oidcpicture
 * @copyright  2026 BPSDM Jawa Timur
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_oidcpicture;

defined('MOODLE_INTERNAL') || die();

/**
 * Observer class.
 */
class observer {

    /**
     * Handle user_loggedin: pull the picture claim from the stored OIDC id_token and apply it.
     *
     * @param \core\event\user_loggedin $event
     * @return void
     */
    public static function user_loggedin(\core\event\user_loggedin $event): void {
        global $CFG;

        if (!get_config('local_oidcpicture', 'enabled')) {
            return;
        }

        // Never let a picture problem break the login flow.
        try {
            require_once($CFG->dirroot . '/local/oidcpicture/classes/sync.php');
            sync::sync_user_picture((int)$event->objectid);
        } catch (\Throwable $e) {
            debugging('local_oidcpicture: ' . $e->getMessage(), DEBUG_DEVELOPER);
        }
    }
}
