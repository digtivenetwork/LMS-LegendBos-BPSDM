<?php
// BPSDM certificate number element.

declare(strict_types=1);

namespace customcertelement_bpsdmno;

use mod_customcert\element as base_element;
use mod_customcert\element\form_element_interface;
use mod_customcert\element\persistable_element_interface;
use mod_customcert\element\preparable_form_interface;
use mod_customcert\element\renderable_element_interface;
use mod_customcert\element\validatable_element_interface;
use mod_customcert\element_helper;
use mod_customcert\service\certificate_repository;
use mod_customcert\service\element_renderer;
use MoodleQuickForm;
use pdf;
use stdClass;

/**
 * Certificate number with auto increment and editable suffix.
 */
class element extends base_element implements
    form_element_interface,
    persistable_element_interface,
    preparable_form_interface,
    renderable_element_interface,
    validatable_element_interface
{
    /**
     * Build the element settings form.
     *
     * @param MoodleQuickForm $mform
     * @return void
     */
    public function build_form(MoodleQuickForm $mform): void {
        $mform->addElement('text', 'suffix', get_string('suffix', 'customcertelement_bpsdmno'));
        $mform->setType('suffix', PARAM_RAW);
        $mform->addHelpButton('suffix', 'suffix', 'customcertelement_bpsdmno');
        $mform->setDefault('suffix', '/ BPSDM - ASNB / 205.5 / II / 2026');

        element_helper::render_common_form_elements($mform, $this->showposxy);
    }

    /**
     * Populate the suffix when editing an existing element.
     *
     * @param MoodleQuickForm $mform
     * @return void
     */
    public function prepare_form(MoodleQuickForm $mform): void {
        $value = $this->get_suffix();
        if ($value !== null) {
            $mform->getElement('suffix')->setValue($value);
        }
    }

    /**
     * Normalise submitted element data.
     *
     * @param stdClass $formdata
     * @return array
     */
    public function normalise_data(stdClass $formdata): array {
        return [
            'suffix' => (string)($formdata->suffix ?? ''),
            'font' => (string)($formdata->font ?? ''),
            'fontsize' => (int)($formdata->fontsize ?? 0),
            'colour' => (string)($formdata->colour ?? ''),
            'width' => (int)($formdata->width ?? 0),
        ];
    }

    /**
     * Validate element data.
     *
     * @param array $data
     * @return array<string,string>
     */
    public function validate(array $data): array {
        return [];
    }

    /**
     * Render to PDF.
     *
     * @param pdf $pdf
     * @param bool $preview
     * @param stdClass $user
     * @param element_renderer|null $renderer
     * @return void
     */
    public function render(pdf $pdf, bool $preview, stdClass $user, ?element_renderer $renderer = null): void {
        $content = $this->get_number_text($preview, $user);
        if ($renderer) {
            $renderer->render_content($this, $content);
        } else {
            element_helper::render_content($pdf, $this, $content);
        }
    }

    /**
     * Render in the template editor.
     *
     * @param element_renderer|null $renderer
     * @return string
     */
    public function render_html(?element_renderer $renderer = null): string {
        $user = new stdClass();
        $user->id = 0;
        $content = $this->get_number_text(true, $user);
        if ($renderer) {
            return (string) $renderer->render_content($this, $content);
        }
        return element_helper::render_html_content($this, $content);
    }

    /**
     * Get the stored suffix.
     *
     * @return string|null
     */
    private function get_suffix(): ?string {
        $payload = $this->get_payload();
        if (array_key_exists('suffix', $payload)) {
            return is_scalar($payload['suffix']) ? (string)$payload['suffix'] : '';
        }
        return null;
    }

    /**
     * Build the stable number for an issued certificate, or the next number for previews.
     *
     * @param bool $preview
     * @param stdClass $user
     * @return string
     */
    private function get_number_text(bool $preview, stdClass $user): string {
        global $DB;

        $configured = get_config('customcertelement_bpsdmno', 'startingnumber');
        $start = max(1, (int)($configured ?: 71076));

        $base = get_config('customcertelement_bpsdmno', 'baseissueid');
        if ($base === false) {
            $base = (int)$DB->get_field_sql('SELECT MAX(id) FROM {customcert_issues}');
            set_config('baseissueid', $base, 'customcertelement_bpsdmno');
        }
        $base = max(0, (int)$base);

        $issueid = 0;
        if (!$preview && !empty($user->id)) {
            $page = $DB->get_record('customcert_pages', ['id' => $this->get_pageid()], '*', MUST_EXIST);
            $customcert = (new certificate_repository())->get_by_template_id_or_fail((int)$page->templateid);
            $issue = $DB->get_record(
                'customcert_issues',
                ['userid' => $user->id, 'customcertid' => $customcert->id],
                'id',
                IGNORE_MULTIPLE
            );
            $issueid = $issue ? (int)$issue->id : 0;
        }

        if ($issueid) {
            $number = $start + max(0, ($issueid - $base) - 1);
        } else {
            $maxid = (int)$DB->get_field_sql('SELECT MAX(id) FROM {customcert_issues}');
            $number = $start + max(0, $maxid - $base);
        }

        return str_pad((string)$number, 6, '0', STR_PAD_LEFT) . ($this->get_suffix() ?? '');
    }
}
