<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Indonesian strings.
 *
 * @package    local_oidcpicture
 * @copyright  2026 BPSDM Jawa Timur
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Sinkronisasi foto profil OIDC';
$string['privacy:metadata'] = 'Plugin sinkronisasi foto profil OIDC menyimpan URL foto terakhir sebagai preferensi pengguna.';
$string['privacy:preference:local_oidcpicture_lasturl'] = 'URL foto OIDC terakhir yang diterapkan ke pengguna ini.';
$string['enabled'] = 'Aktifkan sinkronisasi foto';
$string['enabled_desc'] = 'Jika aktif, foto pengguna diambil dari claim identity provider setiap kali login.';
$string['claimname'] = 'Nama claim foto';
$string['claimname_desc'] = 'Nama claim pada ID token yang berisi URL foto (default: picture).';
$string['maxbytes'] = 'Ukuran gambar maksimum (byte)';
$string['maxbytes_desc'] = 'Unduhan yang lebih besar dari nilai ini ditolak. Default 2097152 (2 MB).';
$string['timeout'] = 'Batas waktu unduh (detik)';
$string['timeout_desc'] = 'Batas waktu koneksi dan total saat mengunduh foto. Default 15.';
