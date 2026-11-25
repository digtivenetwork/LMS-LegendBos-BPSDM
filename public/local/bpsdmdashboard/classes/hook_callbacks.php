<?php
// This file is part of Moodle - https://moodle.org/

namespace local_bpsdmdashboard;

/**
 * Hook callbacks for the BPSDM dashboard plugin.
 *
 * Kept as a no-op so an older cached hook registration cannot redirect users.
 */
class hook_callbacks {
    /**
     * No-op.
     *
     * @param \core\hook\output\before_http_headers $hook
     */
    public static function before_http_headers(\core\hook\output\before_http_headers $hook): void {
        // Dashboard access is no longer redirected.
    }
}
