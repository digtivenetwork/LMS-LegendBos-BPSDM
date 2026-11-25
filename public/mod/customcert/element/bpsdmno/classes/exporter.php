<?php
// Template export support for customcertelement_bpsdmno.

declare(strict_types=1);

namespace customcertelement_bpsdmno;

use mod_customcert\export\datatypes\string_field;
use mod_customcert\export\subplugin_text_exportable;

/**
 * Export/import the certificate number element.
 */
class exporter extends subplugin_text_exportable {
    /**
     * Define portable fields.
     *
     * @return array
     */
    protected function get_fields(): array {
        return parent::get_fields() + [
            'suffix' => new string_field(true),
        ];
    }
}
