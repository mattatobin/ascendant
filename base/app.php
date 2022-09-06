<?php
// == | Setup | =======================================================================================================

// Define basic constants for the software
const SOFTWARE_REPO       = 'about:blank';
const DEVELOPER_DOMAIN    = 'preview.binaryoutcast.com';
const DEFAULT_SKIN        = 'default';
const DEFAULT_SITE_NAME   = 'Binary Outcast';

// --------------------------------------------------------------------------------------------------------------------

// Define paths
const PATHS = array(
  'base'            => ROOT_PATH . SLASH . 'base'       . SLASH,
  'components'      => ROOT_PATH . SLASH . 'components' . SLASH,
  'databases'       => ROOT_PATH . SLASH . 'db'         . SLASH,
  'datastore'       => ROOT_PATH . SLASH . 'datastore'  . SLASH,
  'modules'         => ROOT_PATH . SLASH . 'modules'    . SLASH,
  'libraries'       => ROOT_PATH . SLASH . 'libs'       . SLASH,
  'obj'             => ROOT_PATH . SLASH . '.obj'       . SLASH,
  'skin'            => ROOT_PATH . SLASH . 'skin'       . SLASH,
);

// Define components
const COMPONENTS = array(
  'file'            => PATHS['components'] . 'file.php',
  'panel'           => PATHS['components'] . 'panel' . SLASH . 'panel.php',
  'phoebus'         => PATHS['components'] . 'phoebus.php',
//'site'            => PATHS['components'] . 'site' . SLASH . 'site.php',
  'update'          => PATHS['components'] . 'update.php',
);

// Define databases
const DATABASES = array(
  'emailBlacklist'  => PATHS['databases'] . 'emailBlacklist.php',
);

// Define modules
const MODULES = array(
  'database'        => PATHS['modules'] . 'database.php',
  'vc'              => PATHS['modules'] . 'nsIVersionComparator.php',
);

// Define libraries
const LIBRARIES = array(
  'rdfParser'       => PATHS['libraries'] . 'rdf_parser.php',
  'safeMySQL'       => PATHS['libraries'] . 'safemysql.class.php',
  'smarty'          => PATHS['libraries'] . 'smarty' . SLASH . 'Smarty.class.php',
);

// ====================================================================================================================

// == | Global Functions | ============================================================================================

/**********************************************************************************************************************
* Basic Content Generation using the Special Component's Template
***********************************************************************************************************************/
function gfContent($aContent, array $aMetadata = EMPTY_ARRAY) {
  if (SAPI_IS_CLI) {
    gfOutput(['content' => $aContent, 'title' => $aMetadata['title'] ?? 'Output']);
  }

  $metadata = fn($aMetaItem) => $aMetadata[$aMetaItem] ?? null;
  $menuize = function($aMenu) {
    $rv = EMPTY_STRING;

    foreach ($aMenu as $_key => $_value) {
      if (gfContains($_key, 'onclick=', 1)) {
        $rv .= '<li><a href="#"' . SPACE . $_key . '>' . $_value . '</a></li>';
      }
      else {
        $rv .= '<li><a href="' . $_key . '">' . $_value . '</a></li>';
      }
    }

    return $rv;
  };

  if (!$metadata('textbox') && (is_string($aContent) || is_int($aContent))) {
    $content = $aContent;

    if (!str_starts_with($content, '<p') && !str_starts_with($content, '<ul') &&
        !str_starts_with($content, '<h1') && !str_starts_with($content, '<h2') &&
        !str_starts_with($content, '<table')) {
      $content = '<p>' . $content . '</p>';
    }
  }
  else {
    $content = '<form><textarea class="special-textbox" name="content" rows="30" readonly>' .
               ($metadata('textbox') ? $aContent : json_encode($aContent, JSON_FLAGS['display'])) . '</textarea></form>';
  }

  $template = gfReadFile(gfBuildPath(PATHS['skin'], DEFAULT_SKIN, 'template' . FILE_EXTS['xhtml'])); 

  if (!$template) {
    gfError('Could not read template.');
  }
 
  $siteName = gfGetProperty('runtime', 'siteName', SOFTWARE_NAME);
  $sectionName = gfGetProperty('runtime', 'sectionName');

  if ($sectionName) {
    $siteName = $sectionName . DASH_SEPARATOR . $siteName;
  }

  $commandBar = gfGetProperty('runtime', 'commandBar', ['/' => DEFAULT_HOME_TEXT]);
  $isTestCase = (!$metadata('title') && gfGetProperty('runtime', 'qTestCase') && gfGetProperty('runtime', 'qComponent') == 'special');

  $substs = array(
    '{$SKIN_PATH}'        => gfStripSubstr(gfBuildPath(PATHS['skin'], DEFAULT_SKIN)),
    '{$SITE_NAME}'        => $siteName,
    '{$SITE_MENU}'        => $menuize($commandBar),
    '{$SITE_SECTION}'     => $sectionName ?? EMPTY_STRING,
    '{$PAGE_TITLE}'       => $isTestCase ? '[Test]' . SPACE . gfGetProperty('runtime', 'qTestCase') : ($metadata('title') ?? 'Output'),
    '{$PAGE_CONTENT}'     => $content,
    '{$PAGE_STATUS}'      => $metadata('status') ?? gfGetProperty('server', 'REQUEST_URI', SLASH) ?? 'Done',
    '{$SOFTWARE_VENDOR}'  => SOFTWARE_VENDOR,
    '{$SOFTWARE_NAME}'    => SOFTWARE_NAME,
    '{$SOFTWARE_VERSION}' => SOFTWARE_VERSION,
  );

  $content = gfSubst($template, $substs);

  ob_end_clean();
  gfOutput($content, 'html');
}

/**********************************************************************************************************************
* Check the path count
***********************************************************************************************************************/
function gfCheckDepth($aExpectedCount) {
  if ((gfGetProperty('runtime', 'currentDepth', 0)) > $aExpectedCount) {
    gfErrorOr404('Expected count was' . SPACE . $aExpectedCount . SPACE .
                 'but was' . SPACE . gfGetProperty('runtime', 'currentDepth'));
  }
}

// ====================================================================================================================

// == | Main | ========================================================================================================

// Define an array that will hold the current application state
$gaRuntime = array(
  'currentPath'         => null,
  'currentDomain'       => null,
  'currentSubDomain'    => null,
  'currentSkin'         => DEFAULT_SKIN,
  'currentScheme'       => gfGetProperty('server', 'SCHEME') ??
                           (gfGetProperty('server', 'HTTPS') ? 'https' : 'http'),
  'debugMode'           => (gfGetProperty('server', 'SERVER_NAME') == DEVELOPER_DOMAIN) ?
                           !DEBUG_MODE :
                           gfGetProperty('get', 'debugOverride'),
  'offlineMode'         => file_exists(ROOT_PATH . '/.offline') && !gfGetProperty('get', 'overrideOffline'),
  'remoteAddr'          => gfGetProperty('server', 'HTTP_X_FORWARDED_FOR', gfGetProperty('server', 'REMOTE_ADDR', '127.0.0.1')),
  'userAgent'           => gfGetProperty('server', 'HTTP_USER_AGENT', PHP_SAPI . SLASH . PHP_VERSION),
  'phpRequestURI'       => gfGetProperty('server', 'REQUEST_URI', SLASH),
  'phpServerName'       => gfGetProperty('server', 'SERVER_NAME', 'localhost'),
  'qComponent'          => gfGetProperty('get', 'component', 'site'),
  'qPath'               => gfGetProperty('get', 'path', SLASH),
  'siteName'            => DEFAULT_SITE_NAME,
);

// Set the current domain and subdomain
gfSetProperty('runtime', 'currentDomain', gfGetDomain(gfGetProperty('runtime', 'phpServerName')));
gfSetProperty('runtime', 'currentSubDomain', gfGetDomain(gfGetProperty('runtime', 'phpServerName'), true));

// Explode the path if it exists
gfSetProperty('runtime', 'currentPath', gfSplitPath(gfGetProperty('runtime', 'qPath')));

// Get a count of the exploded path
gfSetProperty('runtime', 'currentDepth', count(gfGetProperty('runtime', 'currentPath')));

// ------------------------------------------------------------------------------------------------------------------

// Site Offline
if (!SAPI_IS_CLI && gfGetProperty('runtime', 'offlineMode')) {
  $gvOfflineMessage = 'This service is not currently available. Please try again later.';

  // Development offline message
  if (str_contains(SOFTWARE_VERSION, 'a') || str_contains(SOFTWARE_VERSION, 'b') ||
      str_contains(SOFTWARE_VERSION, 'pre') || gfGetProperty('runtime', 'offlineMode')) {
    $gvOfflineMessage = 'This in-development version of'. SPACE . SOFTWARE_NAME . SPACE . 'is not for public consumption.';
  }

  gfError($gvOfflineMessage);
}

// ------------------------------------------------------------------------------------------------------------------

// XXXTobin: Handle legacy phoebus component requests by sending them to a translation component
// This should be eventually removed as older versions age reasonably out
if (in_array(gfGetProperty('runtime', 'qComponent'), ['aus', 'discover', 'download', 'integration'])) {
  gfSetProperty('runtime', 'phoebusComponent', gfGetProperty('runtime', 'qComponent'));
  gfSetProperty('runtime', 'qComponent', 'phoebus');
}

// ------------------------------------------------------------------------------------------------------------------

// Handle the Special "component"
if (in_array('special', [gfGetProperty('runtime', 'currentPath')[0], gfGetProperty('runtime', 'qComponent')])) {
  gfSetProperty('runtime', 'qComponent', 'special');
  gfSetProperty('runtime', 'sectionName', 'Special Component');

  // The Special Component never has more than one level below it
  // We still have to determine the root of the component though...
  if (count(gfGetProperty('runtime', 'currentPath')) == 1) {
    // URL /special/
    $gvSpecialFunction = 'root';
  }
  else {
    // URL /special/xxx/
    gfCheckDepth(2);
    $gvSpecialFunction = gfGetProperty('runtime', 'currentPath')[1];
  }

  $gvCommandBar = array(
    '/'                         => DEFAULT_HOME_TEXT,
    '/special/'                 => 'Special Component',
    '/special/test/'            => 'Test Cases',
    '/special/hex/'             => 'Hex String',
    '/special/guid/'            => 'GUID',
    '/special/runtime/'         => 'Runtime Status',
  );

  if (!array_key_exists('site', COMPONENTS)) {
    unset($gvCommandBar['/']);
  }

  gfSetProperty('runtime', 'commandBar', $gvCommandBar);

  switch ($gvSpecialFunction) {
    case 'root':
      $gvContent = '<h2>Welcome</h2>' .
                   '<p>Please select a special function from the command bar above.';
      gfContent($gvContent, ['title' => 'Overview']);
      break;
    case 'test':
      gfSetProperty('runtime', 'qTestCase', gfGetProperty('get', 'case'));
      $gvTestsPath = gfBuildPath(PATHS['base'], 'tests');
      $gaGlobTests = glob($gvTestsPath . WILDCARD . PHP_EXTENSION);
      $gaTests = EMPTY_ARRAY;

      foreach ($gaGlobTests as $_value) {
        $gaTests[] = gfSubst($_value, [PHP_EXTENSION => EMPTY_STRING, $gvTestsPath => EMPTY_STRING]);
      }

      if (gfGetProperty('runtime', 'qTestCase')) {
        if (!in_array(gfGetProperty('runtime', 'qTestCase'), $gaTests)) {
          gfError('Unknown test case');
        }

        require_once($gvTestsPath . gfGetProperty('runtime', 'qTestCase') . PHP_EXTENSION);
        exit();
      }

      $gvContent = EMPTY_STRING;

      foreach ($gaTests as $_value) {
        $gvContent .= '<li><a href="/special/test/?case=' . $_value . '">' . $_value . '</a></li>';
      }

      $gvContent = ($gvContent == EMPTY_STRING) ?
                   '<p>There are no test cases.</p>' :
                   '<h2>Please select a test case&hellip;</h2><ul>' . $gvContent . '</ul>' . str_repeat('<br />', 3);

      gfContent($gvContent, ['title' => 'Test Cases']);
      break;
    case 'runtime':
      gfContent($gaRuntime, ['title' => 'Runtime Status']);
      break;
    case 'hex':
      gfContent(gfHexString(gfGetProperty('get', 'length', 40)), ['title' => 'Hex String', 'textbox' => true]);
      break;
    case 'guid':
      gfContent(gfGUID(gfGetProperty('get', 'vendor'), gfGetProperty('get', 'xpcom')), ['title' => 'GUID', 'textbox' => true]);
      break;
    case 'system':
      ini_set('default_mimetype', 'text/html');
      phpinfo(/* INFO_GENERAL | INFO_CONFIGURATION | INFO_ENVIRONMENT | INFO_VARIABLES */);
      break;
    default:
      gfHeader(404);
  }

  // We're done here
  exit();
}

// ------------------------------------------------------------------------------------------------------------------

// Handle pretty urls that override the site component
if (in_array(gfGetProperty('runtime', 'currentPath')[0], ['panel'])) {
  gfSetProperty('runtime', 'qComponent', gfGetProperty('runtime', 'currentPath')[0]);
}

// In the event that the site component isn't defined then redirect to the special "component"
// The handling for the special "component" is handled above
if (gfGetProperty('runtime', 'qComponent') == 'site' && !array_key_exists('site', COMPONENTS)) {
  gfRedirect(SLASH . 'special' . str_replace('/special', EMPTY_STRING, gfGetProperty('runtime', 'phpRequestURI')));
}

// Load component based on qComponent
if (array_key_exists(gfGetProperty('runtime', 'qComponent'), COMPONENTS)) {
  $gvComponentFile = COMPONENTS[gfGetProperty('runtime', 'qComponent')];

  $gvFinalResult = file_exists($gvComponentFile) ?
                   require_once($gvComponentFile) :
                   gfErrorOr404('Cannot load the' . SPACE . gfGetProperty('runtime', 'qComponent') . SPACE . 'component.');
  
  if (headers_sent()) {
    // We're done here.
    exit();
  }

  gfError('The operation completed successfully.');
}

gfErrorOr404('PC LOAD LETTER');

// ====================================================================================================================

?>