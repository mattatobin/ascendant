<?php
// == | Setup | =======================================================================================================

// Define basic constants for the software
const SOFTWARE_VENDOR     = 'Binary Outcast';
const SOFTWARE_NAME       = 'Ascendant';
const SOFTWARE_VERSION    = '28.0.0pre';

// ROOT_PATH is defined as the absolute path (without a trailing slash) of the document root or the scriptdir if cli.
// It does NOT have a trailing slash
define('ROOT_PATH', empty($_SERVER['DOCUMENT_ROOT']) ? __DIR__ : $_SERVER['DOCUMENT_ROOT']);

// Load fundamental utils
require_once(ROOT_PATH . '/base/utils.php');

// Load application entry point
require_once(ROOT_PATH . '/base/app.php');

// ====================================================================================================================

?>