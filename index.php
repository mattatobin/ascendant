<?php
// == | Setup | =======================================================================================================

// Define basic constants for the software
const kAppVendor          = 'Binary Outcast';
const kAppName            = 'Ascendant';
const kAppVersion         = '28.0.0pre';

const SOFTWARE_VENDOR     = kAppVendor;
const SOFTWARE_NAME       = kAppName;
const SOFTWARE_VERSION    = kAppVersion;

// Load fundamental utils
require_once('./base/src/utils.php');

// Load application entry point
require_once(ROOT_PATH . '/base/src/app.php');

// ====================================================================================================================

?>