<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Split an OIDC name claim into firstname and lastname.
 *
 * @package    local_oidcname
 * @copyright  2026 BPSDM Jawa Timur
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_oidcname;

defined('MOODLE_INTERNAL') || die();

/**
 * Name synchronisation helper.
 */
class namesync {

    /** @var int Maximum length allowed by the user table for firstname/lastname. */
    const MAXLEN = 100;

    /**
     * Sync one user's firstname/lastname from the stored OIDC id_token.
     *
     * @param int $userid
     * @return bool True when the user record was changed.
     */
    public static function sync_user_name(int $userid): bool {
        global $DB;

        if ($userid <= 0) {
            return false;
        }

        $user = $DB->get_record('user', ['id' => $userid, 'deleted' => 0], 'id, auth, firstname, lastname', IGNORE_MISSING);
        if (!$user) {
            return false;
        }

        if (strpos((string)$user->auth, 'oidc') === false) {
            return false;
        }

        $claims = self::get_idtoken_claims($userid);
        if ($claims === null) {
            return false;
        }

        $claimname = trim((string)get_config('local_oidcname', 'claimname'));
        if ($claimname === '') {
            $claimname = 'name';
        }

        $prefergiven = (bool)get_config('local_oidcname', 'prefergivenfamily');
        $stripgelar = (bool)get_config('local_oidcname', 'stripgelar');
        $overwrite = get_config('local_oidcname', 'overwrite');
        $overwrite = ($overwrite === false) ? true : (bool)$overwrite;

        $striptitles = get_config('local_oidcname', 'striptitles');
        $striptitles = ($striptitles === false) ? true : (bool)$striptitles;

        $firstname = '';
        $lastname = '';

        if ($prefergiven && !empty($claims['given_name']) && !empty($claims['family_name'])) {
            $firstname = self::clean((string)$claims['given_name']);
            $lastname = self::clean((string)$claims['family_name']);
        }

        if ($firstname === '' || $lastname === '') {
            if (empty($claims[$claimname]) || !is_scalar($claims[$claimname])) {
                return false;
            }
            [$firstname, $lastname] = self::split_name((string)$claims[$claimname], $stripgelar, (string)$user->lastname, $striptitles);
        }

        if ($firstname === '' || $lastname === '') {
            return false;
        }

        // Respect the "do not overwrite" setting.
        if (!$overwrite && trim((string)$user->firstname) !== '' && trim((string)$user->lastname) !== '') {
            return false;
        }

        if ($firstname === (string)$user->firstname && $lastname === (string)$user->lastname) {
            return false;
        }

        $DB->set_field('user', 'firstname', $firstname, ['id' => $userid]);
        $DB->set_field('user', 'lastname', $lastname, ['id' => $userid]);

        if (class_exists('\cache_helper')) {
            \cache_helper::purge_by_event('changesinuserprofiles');
        }

        try {
            \core\event\user_updated::create_from_userid($userid)->trigger();
        } catch (\Throwable $e) {
            debugging('local_oidcname: event gagal: ' . $e->getMessage(), DEBUG_DEVELOPER);
        }

        return true;
    }

    /**
     * Decode the stored id_token payload for a user.
     *
     * @param int $userid
     * @return array|null
     */
    public static function get_idtoken_claims(int $userid): ?array {
        global $DB;

        $token = $DB->get_record_sql(
            "SELECT idtoken
               FROM {auth_oidc_token}
              WHERE userid = ?
           ORDER BY id DESC",
            [$userid],
            IGNORE_MULTIPLE
        );
        if (!$token || empty($token->idtoken)) {
            return null;
        }

        $parts = explode('.', (string)$token->idtoken);
        if (count($parts) < 2) {
            return null;
        }

        $payload = base64_decode(strtr($parts[1], '-_', '+/'), true);
        if ($payload === false) {
            return null;
        }

        $claims = json_decode($payload, true);

        return is_array($claims) ? $claims : null;
    }

    /**
     * Split a full name into firstname and lastname.
     *
     * @param string $name
     * @param bool $stripgelar Drop everything after the first comma (academic titles).
     * @param string $fallbacklast Used when the name only holds one word.
     * @return array [firstname, lastname]
     */
    public static function split_name(string $name, bool $stripgelar = true, string $fallbacklast = '', bool $striptitles = true): array {
        $value = self::clean($name);

        if ($stripgelar) {
            $comma = mb_strpos($value, ',');
            if ($comma !== false && $comma > 0) {
                $value = trim(mb_substr($value, 0, $comma));
            }
        }

        $value = self::clean($value);
        if ($value === '') {
            return ['', ''];
        }

        if ($striptitles) {
            $value = self::strip_front_titles($value);
        }

        $words = preg_split('/\s+/u', $value, -1, PREG_SPLIT_NO_EMPTY);
        if (empty($words)) {
            return ['', ''];
        }

        $firstname = self::truncate(array_shift($words));

        if (empty($words)) {
            $lastname = trim($fallbacklast);
            if ($lastname === '') {
                $lastname = '-';
            }
        } else {
            $lastname = self::truncate(implode(' ', $words));
        }

        return [$firstname, self::truncate($lastname)];
    }

    /**
     * Front titles removed from the start of a name (Indonesian academic/professional).
     *
     * @return array Lower-cased titles without the trailing dot.
     */
    public static function front_titles(): array {
        return [
            'prof', 'dr', 'drs', 'dra', 'ir', 'drg', 'drh', 'h', 'hj', 'kh', 'haji', 'hajjah',
            'ny', 'nyi', 'nyonya', 'rd', 'ra', 'r', 'tubagus', 'ust', 'ustadz', 'ustad', 'sdr', 'sdri',
        ];
    }

    /**
     * Remove leading title tokens, e.g. "Prof. Dr. Ir. Budi" becomes "Budi".
     *
     * @param string $value
     * @return string
     */
    public static function strip_front_titles(string $value): string {
        $titles = array_flip(self::front_titles());
        $words = preg_split('/\\s+/u', trim($value), -1, PREG_SPLIT_NO_EMPTY);
        if (empty($words)) {
            return '';
        }

        $removed = 0;
        $total = count($words);
        while ($removed < $total) {
            $candidate = mb_strtolower(rtrim($words[$removed], '.'));
            if (!isset($titles[$candidate])) {
                break;
            }
            $removed++;
        }

        if ($removed === 0) {
            return trim($value);
        }

        $rest = array_slice($words, $removed);

        return empty($rest) ? trim($value) : trim(implode(' ', $rest));
    }

    /**
     * Normalise whitespace and invisible characters.
     *
     * @param string $value
     * @return string
     */
    public static function clean(string $value): string {
        $value = str_replace(["\xC2\xA0", "\xE2\x80\x8B"], ' ', $value);
        $value = preg_replace('/\s+/u', ' ', $value);

        return trim((string)$value);
    }

    /**
     * Enforce the user table column limit.
     *
     * @param string $value
     * @return string
     */
    protected static function truncate(string $value): string {
        $value = trim($value);
        if (mb_strlen($value) > self::MAXLEN) {
            $value = rtrim(mb_substr($value, 0, self::MAXLEN));
        }

        return $value;
    }
}
