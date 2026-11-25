<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * OAuth2 client that adds PKCE (S256) support.
 *
 * @package    local_bpsdmpkce
 * @copyright  2026 BPSDM Jatim
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\oauth2\client;

defined('MOODLE_INTERNAL') || die();

/**
 * Core OAuth2 client with PKCE parameters.
 */
class bpsdmpkce extends \core\oauth2\client {

    /**
     * Add code_challenge + method to the authorization request.
     *
     * @return array
     */
    public function get_additional_login_parameters() {
        $params = parent::get_additional_login_parameters();

        $issuerid = $this->get_issuer()->get('id');
        $key = 'local_bpsdmpkce_verifier_' . $issuerid;

        if (empty($_SESSION[$key])) {
            $_SESSION[$key] = self::generate_verifier();
        }

        $params['code_challenge'] = self::create_challenge($_SESSION[$key]);
        $params['code_challenge_method'] = 'S256';

        return $params;
    }

    /**
     * Add code_verifier to the token exchange request.
     *
     * @return array
     */
    public function get_additional_upgrade_token_parameters(): array {
        $issuerid = $this->get_issuer()->get('id');
        $key = 'local_bpsdmpkce_verifier_' . $issuerid;

        if (empty($_SESSION[$key])) {
            return [];
        }

        $verifier = $_SESSION[$key];
        unset($_SESSION[$key]);
        return ['code_verifier' => $verifier];
    }

    /**
     * Generate a PKCE code verifier (43 chars, URL-safe).
     *
     * @return string
     */
    private static function generate_verifier(): string {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    /**
     * Derive the S256 code challenge from a verifier.
     *
     * @param string $verifier
     * @return string
     */
    private static function create_challenge(string $verifier): string {
        return rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');
    }
}
