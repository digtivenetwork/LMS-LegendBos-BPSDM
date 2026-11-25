<?php
// Privacy provider for customcertelement_bpsdmno.

namespace customcertelement_bpsdmno\privacy;

use core_privacy\local\metadata\null_provider;

/**
 * This element does not store personal data.
 */
class provider implements null_provider {
    /**
     * Get the reason.
     *
     * @return string
     */
    public static function get_reason(): string {
        return 'privacy:metadata';
    }
}
