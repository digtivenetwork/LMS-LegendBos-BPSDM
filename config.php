<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mariadb';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'lmsbpsdm_moodle5';
$CFG->dbuser    = 'legendbos';
$CFG->dbpass    = 'GcOwIKDc7IfqWm8oejbgrpV4U';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => '',
  'dbsocket' => '',
  'dbcollation' => 'utf8mb4_general_ci',
);

// Config for Webserver

$protocol='https://';
$hostname='legendbos.bpsdmjatim.web.id';

$CFG->sslproxy = true;

// if (isset($_SERVER['HTTPS'])) { $protocol='https://'; }
// if (isset($_SERVER['HTTP_HOST'])) { $hostname=$_SERVER['HTTP_HOST']; }
$CFG->wwwroot = $protocol.$hostname;

$CFG->dataroot  = '/home/legendbos/moodledata';
$CFG->admin     = 'admin';

$CFG->routerconfigured = true; // setelah FallbackResource aktif

// $CFG->xsendfile = 'X-Sendfile';
// $CFG->xsendfilealiases = ['/dataroot/' => $CFG->dataroot];

$CFG->preventexecpath = true;
$CFG->directorypermissions = 0750;



// $CFG->session_handler_class = '\core\session\redis';
// $CFG->session_redis_host = '127.0.0.1';
// $CFG->session_redis_port = 6379;
// $CFG->session_redis_database = 0;
// $CFG->session_redis_auth = 'bpsdm109';
// $CFG->session_redis_prefix = 'lmsbpsdm_sess_';
// $CFG->session_redis_acquire_lock_timeout = 120;
// $CFG->session_redis_lock_expire = 7200;
// $CFG->session_redis_serializer_use_igbinary = true;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
