<?php
// == | Setup | =======================================================================================================

// Enable Error Reporting
error_reporting(E_ALL);
ini_set("display_errors", "on");

// This is the absolute webroot path
// It does NOT have a trailing slash
define('ROOT_PATH', empty($_SERVER['DOCUMENT_ROOT']) ? __DIR__ : $_SERVER['DOCUMENT_ROOT']);

// Debug flag
define('DEBUG_MODE', $_GET['debug'] ?? null);

// Define basic constants for the software
const SOFTWARE_NAME       = 'Ascendant';
const SOFTWARE_VERSION    = '28.0.0pre';

// Load fundamental utils
require_once(ROOT_PATH . '/base/utils.php');

// Load application entry point
require_once(ROOT_PATH . '/base/app.php');

// ====================================================================================================================

?>