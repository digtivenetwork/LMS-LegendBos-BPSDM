<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Indonesian strings.
 *
 * @package    local_oidcname
 * @copyright  2026 BPSDM Jawa Timur
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Pemisah nama depan/belakang OIDC';
$string['privacy:metadata'] = 'Plugin pemisah nama OIDC tidak menyimpan data pribadi; ia hanya menyalin nilai dari token identity provider ke record pengguna.';
$string['enabled'] = 'Aktifkan sinkronisasi nama';
$string['enabled_desc'] = 'Jika aktif, nama depan dan nama belakang diambil dari claim identity provider setiap login.';
$string['claimname'] = 'Nama claim sumber';
$string['claimname_desc'] = 'Claim pada ID token yang berisi nama lengkap (default: name).';
$string['stripgelar'] = 'Buang gelar akademik';
$string['stripgelar_desc'] = 'Buang semua setelah koma pertama, mis. "Budi Santoso, S.Kom" menjadi "Budi Santoso".';
$string['striptitles'] = 'Buang gelar depan';
$string['striptitles_desc'] = 'Hapus gelar di awal nama seperti Prof., Dr., Drs., Ir., H. sebelum nama dipecah.';
$string['prefergivenfamily'] = 'Utamakan given_name/family_name';
$string['prefergivenfamily_desc'] = 'Jika aktif dan token memuat given_name serta family_name, pakai keduanya daripada memecah nama lengkap.';
$string['overwrite'] = 'Timpa nama yang sudah ada';
$string['overwrite_desc'] = 'Jika dimatikan, pengguna yang nama depan dan belakangnya sudah terisi tidak diubah.';
