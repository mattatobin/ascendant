<?php
// == | Setup | =======================================================================================================

// Enable Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

// This is the absolute webroot path
// It does NOT have a trailing slash
define('ROOT_PATH', empty($_SERVER['DOCUMENT_ROOT']) ? __DIR__ : $_SERVER['DOCUMENT_ROOT']);

// We like CLI
define('SAPI_IS_CLI', php_sapi_name() == "cli");
define('CLI_NO_LOGO', in_array('--nologo', $GLOBALS['argv'] ?? []));

// Debug flag (CLI always triggers debug mode)
define('DEBUG_MODE', $_GET['debug'] ?? SAPI_IS_CLI);

// Define basic constants for the software
const SOFTWARE_VENDOR     = 'Binary Outcast';
const SOFTWARE_NAME       = 'Ascendant';
const SOFTWARE_VERSION    = '28.0.0pre';

// Load fundamental utils
require_once(ROOT_PATH . '/base/utils.php');

// Load application entry point
require_once(ROOT_PATH . '/base/app.php');

// ====================================================================================================================

?>