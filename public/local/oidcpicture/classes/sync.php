<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Picture synchronisation from the OIDC id_token "picture" claim.
 *
 * @package    local_oidcpicture
 * @copyright  2026 BPSDM Jawa Timur
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_oidcpicture;

defined('MOODLE_INTERNAL') || die();

/**
 * Syncs the Moodle user picture from a URL claim of the stored OIDC id_token.
 */
class sync {

    /** @var string User preference holding the last applied picture URL. */
    const PREF_LASTURL = 'local_oidcpicture_lasturl';

    /**
     * Sync one user's picture.
     *
     * @param int $userid
     * @return bool True when a new picture was applied.
     */
    public static function sync_user_picture(int $userid): bool {
        global $CFG, $DB;

        if ($userid <= 0) {
            return false;
        }

        $user = $DB->get_record('user', ['id' => $userid, 'deleted' => 0], 'id, auth, picture', IGNORE_MISSING);
        if (!$user) {
            return false;
        }

        // Only users that authenticated through auth_oidc have a stored id_token.
        if (strpos((string)$user->auth, 'oidc') === false) {
            return false;
        }

        $token = $DB->get_record_sql(
            "SELECT id, idtoken
               FROM {auth_oidc_token}
              WHERE userid = ?
           ORDER BY id DESC",
            [$userid],
            IGNORE_MULTIPLE
        );
        if (!$token || empty($token->idtoken)) {
            return false;
        }

        $claimname = trim((string)get_config('local_oidcpicture', 'claimname'));
        if ($claimname === '') {
            $claimname = 'picture';
        }

        $url = self::extract_claim((string)$token->idtoken, $claimname);
        if ($url === null) {
            return false;
        }

        // Skip when nothing changed and a picture is already applied.
        $lasturl = get_user_preferences(self::PREF_LASTURL, null, $userid);
        if ($lasturl === $url && (int)$user->picture === 1) {
            return false;
        }

        $tmpfile = self::download_image($url);
        if ($tmpfile === false) {
            return false;
        }

        require_once($CFG->libdir . '/gdlib.php');

        $context = \context_user::instance($userid);
        $applied = process_new_icon($context, 'user', 'icon', 0, $tmpfile);
        @unlink($tmpfile);

        if (!$applied) {
            return false;
        }

        $DB->set_field('user', 'picture', 1, ['id' => $userid]);
        set_user_preference(self::PREF_LASTURL, $url, $userid);

        if (class_exists('\cache_helper')) {
            \cache_helper::purge_by_event('changesinuserprofiles');
        }

        return true;
    }

    /**
     * Decode a JWT payload and return a claim value as a string, or null when absent.
     *
     * @param string $jwt
     * @param string $claim
     * @return string|null
     */
    public static function extract_claim(string $jwt, string $claim): ?string {
        $parts = explode('.', $jwt);
        if (count($parts) < 2) {
            return null;
        }

        $payload = base64_decode(strtr($parts[1], '-_', '+/'), true);
        if ($payload === false) {
            return null;
        }

        $claims = json_decode($payload, true);
        if (!is_array($claims) || !isset($claims[$claim]) || !is_scalar($claims[$claim])) {
            return null;
        }

        $value = trim((string)$claims[$claim]);

        return $value === '' ? null : $value;
    }

    /**
     * Download a remote image into a temporary file, applying size/type/SSRF guards.
     *
     * @param string $url
     * @return string|false Path to the temporary file, false on failure.
     */
    protected static function download_image(string $url) {
        global $CFG;

        if (!self::is_safe_url($url)) {
            debugging('local_oidcpicture: URL ditolak oleh pemeriksaan keamanan', DEBUG_DEVELOPER);
            return false;
        }

        $maxbytes = (int)get_config('local_oidcpicture', 'maxbytes');
        if ($maxbytes <= 0) {
            $maxbytes = 2097152;
        }
        $timeout = (int)get_config('local_oidcpicture', 'timeout');
        if ($timeout <= 0) {
            $timeout = 15;
        }

        $tempdir = make_temp_directory('local_oidcpicture');
        $tmpfile = $tempdir . '/' . md5($url . microtime(true)) . '.img';

        $fp = fopen($tmpfile, 'wb');
        if (!$fp) {
            return false;
        }

        $contenttype = '';
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_FILE            => $fp,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_MAXREDIRS       => 3,
            CURLOPT_CONNECTTIMEOUT  => $timeout,
            CURLOPT_TIMEOUT         => $timeout,
            CURLOPT_SSL_VERIFYPEER  => true,
            CURLOPT_SSL_VERIFYHOST  => 2,
            CURLOPT_USERAGENT       => 'Moodle-local_oidcpicture/1.0',
            CURLOPT_MAXFILESIZE     => $maxbytes,
            CURLOPT_HEADERFUNCTION  => function($ch, $header) use (&$contenttype) {
                if (stripos($header, 'content-type:') === 0) {
                    $contenttype = trim(substr($header, 13));
                }
                return strlen($header);
            },
        ]);
        $ok = curl_exec($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        fclose($fp);

        if (!$ok || $status < 200 || $status >= 300) {
            @unlink($tmpfile);
            debugging('local_oidcpicture: unduhan gagal (HTTP ' . $status . ')', DEBUG_DEVELOPER);
            return false;
        }

        if (filesize($tmpfile) > $maxbytes) {
            @unlink($tmpfile);
            debugging('local_oidcpicture: berkas melebihi batas ukuran', DEBUG_DEVELOPER);
            return false;
        }

        if ($contenttype !== '' && stripos($contenttype, 'image/') !== 0) {
            @unlink($tmpfile);
            debugging('local_oidcpicture: content-type bukan gambar (' . $contenttype . ')', DEBUG_DEVELOPER);
            return false;
        }

        $info = @getimagesize($tmpfile);
        if (empty($info) || empty($info[0]) || empty($info[1])) {
            @unlink($tmpfile);
            debugging('local_oidcpicture: berkas bukan gambar yang valid', DEBUG_DEVELOPER);
            return false;
        }

        return $tmpfile;
    }

    /**
     * Reject non-https URLs and hosts resolving to private/reserved addresses (SSRF guard).
     *
     * @param string $url
     * @return bool
     */
    protected static function is_safe_url(string $url): bool {
        $parts = parse_url($url);
        if (empty($parts['scheme']) || empty($parts['host'])) {
            return false;
        }
        if (strtolower($parts['scheme']) !== 'https') {
            return false;
        }

        $host = $parts['host'];
        $ips = [];

        if (filter_var($host, FILTER_VALIDATE_IP)) {
            $ips[] = $host;
        } else {
            $resolved = gethostbynamel($host);
            if ($resolved === false) {
                return false;
            }
            $ips = $resolved;
        }

        foreach ($ips as $ip) {
            if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                return false;
            }
        }

        return true;
    }
}
