<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Privacy provider.
 *
 * @package    local_oidcpicture
 * @copyright  2026 BPSDM Jawa Timur
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_oidcpicture\privacy;

defined('MOODLE_INTERNAL') || die();

use core_privacy\local\metadata\collection;
use core_privacy\local\request\user_preference_provider;

/**
 * Privacy provider for local_oidcpicture.
 */
class provider implements
    \core_privacy\local\metadata\provider,
    user_preference_provider {

    /**
     * Describe the personal data stored.
     *
     * @param collection $collection
     * @return collection
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_user_preference(
            'local_oidcpicture_lasturl',
            'privacy:preference:local_oidcpicture_lasturl'
        );

        return $collection;
    }

    /**
     * Export user preferences.
     *
     * @param int $userid
     * @return void
     */
    public static function export_user_preferences(int $userid): void {
        $value = get_user_preferences('local_oidcpicture_lasturl', null, $userid);
        if ($value !== null) {
            \core_privacy\local\request\writer::export_user_preference(
                'local_oidcpicture',
                'local_oidcpicture_lasturl',
                $value,
                get_string('privacy:preference:local_oidcpicture_lasturl', 'local_oidcpicture')
            );
        }
    }
}
