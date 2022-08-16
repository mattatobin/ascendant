<?php
// == | Setup | =======================================================================================================

// Define basic constants for the software
const SOFTWARE_REPO       = 'about:blank';
const DEVELOPER_DOMAIN    = 'preview.binaryoutcast.com';
const DEFAULT_SKIN        = 'default';

// Define basic relpaths
const BASE_RELPATH        = '/base/';
const COMPONENTS_RELPATH  = '/components/';
const DATABASES_RELPATH   = '/db/';
const DATASTORE_RELPATH   = '/datastore/';
const MODULES_RELPATH     = '/modules/';
const LIB_RELPATH         = '/libs/';
const OBJ_RELPATH         = '/.obj/';
const SKIN_RELPATH        = '/skin/';

// --------------------------------------------------------------------------------------------------------------------

// Define components
const COMPONENTS = array(
  'file'            => ROOT_PATH . COMPONENTS_RELPATH . 'file.php',
  'panel'           => ROOT_PATH . COMPONENTS_RELPATH . 'panel/panel.php',
  'phoebus'         => ROOT_PATH . COMPONENTS_RELPATH . 'phoebus.php',
//'site'            => ROOT_PATH . COMPONENTS_RELPATH . 'site/site.php',
  'update'          => ROOT_PATH . COMPONENTS_RELPATH . 'update.php',
);

const PRETTY_PATH_COMPONENTS = ['panel'];

// Define databases
const DATABASES = array(
  'emailBlacklist'  => ROOT_PATH . DATABASES_RELPATH . 'emailBlacklist.php',
);

// Define modules
const MODULES = array(
  'account'         => ROOT_PATH . MODULES_RELPATH . 'classAccount.php',
  'aviary'          => ROOT_PATH . MODULES_RELPATH . 'classAviary.php',
  'database'        => ROOT_PATH . MODULES_RELPATH . 'classDatabase.php',
  'addonManifest'   => ROOT_PATH . MODULES_RELPATH . 'classAddonManifest.php',
  'content'         => ROOT_PATH . MODULES_RELPATH . 'classContent.php',
  'vc'              => ROOT_PATH . MODULES_RELPATH . 'nsIVersionComparator.php',
);

// Define libraries
const LIBRARIES = array(
  'rdfParser'       => ROOT_PATH . LIB_RELPATH . 'rdf_parser.php',
  'safeMySQL'       => ROOT_PATH . LIB_RELPATH . 'safemysql.class.php',
  'smarty'          => ROOT_PATH . LIB_RELPATH . 'smarty/Smarty.class.php',
);

// ====================================================================================================================

// == | Global Functions | ============================================================================================

/**********************************************************************************************************************
* Basic Content Generation using the Special Component's Template
*
* @dep SOFTWARE_NAME
* @dep SOFTWARE_VERSION
* @dep gfError()
* @param $aTtitle     Title of the page
* @param $aContent    Content of the page
* @param $aTextBox    Use textbox for content
* @param $aList       Use list for content
* @param $aError      Is an Error Page
***********************************************************************************************************************/
function gfContent($aMetadata, $aLegacyContent = null, $aTextBox = null, $aList = null, $aError = null) {
  global $gaRuntime;
  $ePrefix = __FUNCTION__ . DASH_SEPARATOR;
  $skinPath = SKIN_RELPATH . DEFAULT_SKIN;

  if (php_sapi_name() == "cli") {
    gfOutput(['metadata' => $aMetadata, 'legacyContent' => $aLegacyContent], false, true);
  }

  // Anonymous functions
  $contentIsStringish = function($aContent) {
    return (is_string($aContent) || is_int($aContent)); 
  };

  $textboxContent = function($aContent) {
    return '<textarea class="special-textbox aligncenter" name="content" rows="36" readonly>' .
           $aContent . '</textarea>';
  };

  $maybePTagContent = function($aContent) {
    if (!str_starts_with($aContent, '<p') && !str_starts_with($aContent, '<ul') &&
        !str_starts_with($aContent, '<h1') && !str_starts_with($aContent, '<h2') &&
        !str_starts_with($aContent, '<table')) {
      $aContent = '<p>' . $aContent . '</p>';
    }

    return $aContent;
  };

  $template = gfReadFile(DOT . $skinPath . SLASH . 'template.xhtml');

  if (!$template) {
    gfError($ePrefix . 'Special Template is busted...', null, true);
  }

  $pageSubsts = array(
    '{$SKIN_PATH}'        => $skinPath,
    '{$SITE_NAME}'        => defined('SITE_NAME') ? SITE_NAME : SOFTWARE_NAME . SPACE . SOFTWARE_VERSION,
    '{$SITE_MENU}'        => EMPTY_STRING,
    '{$PAGE_TITLE}'       => null,
    '{$PAGE_CONTENT}'     => null,
    '{$SOFTWARE_NAME}'    => SOFTWARE_NAME,
    '{$SOFTWARE_VERSION}' => SOFTWARE_VERSION,
  );

  if (is_string($aMetadata) || $aMetadata == null) {
    if (is_array($aMetadata)) {
      gfError($ePrefix . 'aMetadata may not be an array in legacy mode.');
    }

    if ($aTextBox && $aList) {
      gfError($ePrefix . 'You cannot use both textbox and list');
    }

    if (!$contentIsStringish($aLegacyContent) || in_array($aMetadata, ['jsonEncode', 'phpEncode'])) {
      if ($aMetadata == 'phpEncode') {
        $aLegacyContent = var_export($aLegacyContent, true);
      }
      else {
        $aLegacyContent = json_encode($aLegacyContent, JSON_FLAGS['display']);
      }

      $aTextBox = true;
      $aList = false;
    }

    if ($aTextBox) {
      $aLegacyContent = $textboxContent($aLegacyContent);
    }
    elseif ($aList) {
      // We are using an unordered list so put aLegacyContent in there
      $aLegacyContent = '<ul><li>' . $aLegacyContent . '</li><ul>';
    }
    else {
      $aLegacyContent = $maybePTagContent($aLegacyContent);
    }
    

    if (!$aError && ($gaRuntime['qTestCase'] ?? null)) {
      $pageSubsts['{$PAGE_TITLE}'] = 'Test Case' . DASH_SEPARATOR . $gaRuntime['qTestCase'];

      foreach ($gaRuntime['siteMenu'] ?? EMPTY_ARRAY as $_key => $_value) {
        $pageSubsts['{$SITE_MENU}'] .= '<li><a href="' . $_key . '">' . $_value . '</a></li>';
      }
    }
    else {
      $pageSubsts['{$PAGE_TITLE}'] = $aMetadata;
    }

    $pageSubsts['{$PAGE_CONTENT}'] = $aLegacyContent;
  }
  else {
    if ($aTextBox || $aList) {
      gfError($ePrefix . 'Mode attributes are deprecated.');
    }

    if (!array_key_exists('title', $aMetadata) && !array_key_exists('content', $aMetadata)) {
      gfError($ePrefix . 'You must specify a title and content');
    }

    $pageSubsts['{$PAGE_TITLE}'] = $aMetadata['title'];

    if (!$contentIsStringish($aMetadata['content']) || in_array($aMetadata, ['jsonEncode', 'phpEncode'])) {
      if ($aMetadata['phpEncode'] ?? null) {
        $pageSubsts['{$PAGE_CONTENT}'] = $textboxContent(var_export($aMetadata['content'], true));
      }
      else {
        $pageSubsts['{$PAGE_CONTENT}'] = $textboxContent(json_encode($aMetadata['content'], JSON_FLAGS['display']));
      }
    }
    else {
      $pageSubsts['{$PAGE_CONTENT}'] = $maybePTagContent($aMetadata['content']);
    }

    foreach ($aMetadata['menu'] ?? EMPTY_ARRAY as $_key => $_value) {
      $pageSubsts['{$SITE_MENU}'] .= '<li><a href="' . $_key . '">' . $_value . '</a></li>';
    }
  }

  if ($pageSubsts['{$SITE_MENU}'] == EMPTY_STRING) {
    $pageSubsts['{$SITE_MENU}'] = '<li><a href="/">Root</a></li>';
  }

  $template = gfSubst('string', $pageSubsts, $template);

  // If we are generating an error from gfError we want to clean the output buffer
  if ($aError) {
    ob_get_clean();
  }

  // Output the content
  gfOutput($template, 'html');
}

/**********************************************************************************************************************
* Check the path count
***********************************************************************************************************************/
function gfCheckPathCount($aExpectedCount) {
  global $gaRuntime;

  if (($gaRuntime['pathCount'] ?? 0) > $aExpectedCount) {
    gfErrorOr404('Expected count was' . SPACE . $aExpectedCount . SPACE .
                 'but was' . SPACE . $gaRuntime['pathCount']);
  }
}

// ====================================================================================================================

// == | Main | ========================================================================================================

// Define an array that will hold the current application state
$gaRuntime = array(
  'currentPath'         => null,
  'currentDomain'       => 'localhost',
  'currentSubDomain'    => null,
  'currentSkin'         => DEFAULT_SKIN,
  'currentScheme'       => gfSuperVar('server', 'SCHEME') ?? (gfSuperVar('server', 'HTTPS') ? 'https' : 'http'),
  'debugMode'           => (gfSuperVar('server', 'SERVER_NAME') == DEVELOPER_DOMAIN) ? !DEBUG_MODE :
                            gfSuperVar('get', 'debugOverride'),
  'offlineMode'         => file_exists(ROOT_PATH . '/.offline') && !gfSuperVar('get', 'overrideOffline'),
  'remoteAddr'          => gfSuperVar('server', 'HTTP_X_FORWARDED_FOR') ?? gfSuperVar('server', 'REMOTE_ADDR'),
  'userAgent'           => gfSuperVar('server', 'HTTP_USER_AGENT'),
  'phpRequestURI'       => gfSuperVar('server', 'REQUEST_URI') ?? SLASH,
  'phpServerName'       => gfSuperVar('server', 'SERVER_NAME') ?? 'localhost',
  'qComponent'          => gfSuperVar('get', 'component') ?? 'site',
  'qPath'               => gfSuperVar('get', 'path') ?? SLASH,
);

// Set the current domain and subdomain
$gaRuntime['currentDomain'] = gfSuperVar('check', gfGetDomain($gaRuntime['phpServerName']));
$gaRuntime['currentSubDomain'] = gfSuperVar('check', gfGetDomain($gaRuntime['phpServerName'], true));

// Explode the path if it exists
$gaRuntime['currentPath'] = gfExplodePath($gaRuntime['qPath']);

// Get a count of the exploded path
$gaRuntime['pathCount'] = count($gaRuntime['currentPath']);

// ------------------------------------------------------------------------------------------------------------------

// Site Offline
if (!SAPI_IS_CLI && $gaRuntime['offlineMode']) {
  $gvOfflineMessage = 'This service is not currently available. Please try again later.';

  // Development offline message
  if (str_contains(SOFTWARE_VERSION, 'a') || str_contains(SOFTWARE_VERSION, 'b') ||
      str_contains(SOFTWARE_VERSION, 'pre') || $gaRuntime['debugMode']) {
    $gvOfflineMessage = 'This in-development version of'. SPACE . SOFTWARE_NAME . SPACE . 'is not for public consumption.';
  }

  gfError($gvOfflineMessage);
}

// ------------------------------------------------------------------------------------------------------------------

// XXXTobin: Handle legacy phoebus component requests by sending them to a translation component
// This should be eventually removed as older versions age reasonably out
if (in_array($gaRuntime['qComponent'], ['aus', 'discover', 'download', 'integration'])) {
  $gaRuntime['phoebusComponent'] = $gaRuntime['qComponent'];
  $gaRuntime['qComponent'] = 'phoebus';
}

// ------------------------------------------------------------------------------------------------------------------

// Handle the Special "component"
if (in_array('special', [$gaRuntime['currentPath'][0], $gaRuntime['qComponent']])) {
  $gaRuntime['qComponent'] = 'special';
  
  // The Special Component never has more than one level below it
  // We still have to determine the root of the component though...
  if (count($gaRuntime['currentPath']) == 1) {
    // URL /special/
    $gvSpecialFunction = 'root';
  }
  else {
    // URL /special/xxx/
    gfCheckPathCount(2);
    $gvSpecialFunction = $gaRuntime['currentPath'][1];
  }

  $gaRuntime['siteMenu'] = [
    '/'                         => 'Root',
    '/special/'                 => 'Special',
    '/special/test/'            => 'Test Cases',
    '/special/software-state/'  => 'Software State',
    '/special/phpinfo/'         => 'PHP Info',
  ];

  switch ($gvSpecialFunction) {
    case 'root':
      gfContent(['title'   => 'Special Component',
                  'content' => '<h2>Welcome to the Special Component!</h2>' .
                               '<p>Please select a function from the command bar above.</p>',
                  'menu'    => $gaRuntime['siteMenu']]);
      break;
    case 'test':
      $gaRuntime['qTestCase'] = gfSuperVar('get', 'case');
      $gvTestsPath = gfBuildPath(ROOT_PATH, 'base', 'tests');
      $gaGlobTests = glob($gvTestsPath . WILDCARD . PHP_EXTENSION);
      $gaTests = EMPTY_ARRAY;

      foreach ($gaGlobTests as $_value) {
        $gaTests[] = gfSubst('str', [PHP_EXTENSION => EMPTY_STRING, $gvTestsPath => EMPTY_STRING], $_value);
      }

      if ($gaRuntime['qTestCase']) {
        if (!in_array($gaRuntime['qTestCase'], $gaTests)) {
          gfError('Unknown test case');
        }

        require_once($gvTestsPath . $gaRuntime['qTestCase'] . PHP_EXTENSION);
        exit();
      }

      $gvContent = EMPTY_STRING;

      foreach ($gaTests as $_value) {
        $gvContent .= '<li><a href="/special/test/?case=' . $_value . '">' . $_value . '</a></li>';
      }

      $gvContent = ($gvContent == EMPTY_STRING) ?
                   '<p>There are no test cases.</p>' :
                   '<h2>Please select a test case&hellip;</h2><ul>' . $gvContent . '</ul>';

      gfContent(['title' => 'Test Cases', 'content' => $gvContent, 'menu' => $gaRuntime['siteMenu']]);
      break;
    case 'software-state':
      gfContent(['title' => 'Software State', 'content' => $gaRuntime, 'menu' => $gaRuntime['siteMenu']]);
      break;
    case 'phpinfo':
      ini_set('default_mimetype', 'text/html');
      phpinfo(INFO_GENERAL | INFO_CONFIGURATION | INFO_ENVIRONMENT | INFO_VARIABLES);
      break;
    default:
      gfHeader(404);
  }

  // We're done here
  exit();
}

// ------------------------------------------------------------------------------------------------------------------

// Handle pretty urls that override the site component
if (in_array($gaRuntime['currentPath'][0], PRETTY_PATH_COMPONENTS)) {
  $gaRuntime['qComponent'] = $gaRuntime['currentPath'][0];
}

// In the event that the site component isn't defined then redirect to the special "component"
// The handling for the special "component" is handled above
if ($gaRuntime['qComponent'] == 'site' && !array_key_exists('site', COMPONENTS)) {
  gfRedirect(SLASH . 'special' . str_replace('/special', EMPTY_STRING, $gaRuntime['phpRequestURI']));
}

// Load component based on qComponent
if (array_key_exists($gaRuntime['qComponent'], COMPONENTS)) {
  $gvComponentFile = COMPONENTS[$gaRuntime['qComponent']];

  file_exists($gvComponentFile) ? require_once($gvComponentFile) :
  gfErrorOr404('Cannot load the' . SPACE . $gaRuntime['qComponent'] . SPACE . 'component.');
  
  if (headers_sent()) {
    // We're done here.
    exit();
  }

  gfError('The operation completed successfully.');
}

gfErrorOr404('PC LOAD LETTER');

// ====================================================================================================================

?>