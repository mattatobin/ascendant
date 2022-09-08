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

// These components have pretty path slugs
const COMPONENT_SLUGS = ['special', 'panel'];

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

// --------------------------------------------------------------------------------------------------------------------



// ====================================================================================================================

// == | Global Functions | ============================================================================================

/**********************************************************************************************************************
* Basic Content Generation using the Special Component's Template
***********************************************************************************************************************/
function gfContent($aContent, array $aMetadata = EMPTY_ARRAY) {
  if (SAPI_IS_CLI) {
    gfOutput(['content' => $aContent, 'title' => $aMetadata['title'] ?? 'Output']);
  }

  $content = $aContent;

  $metadata = function($val) use(&$aMetadata) {
    return $aMetadata[$val] ?? null;
  };

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

  if ((is_string($content) || is_int($content)) && !$metadata('textbox')) {
    if (!str_starts_with($content, '<p') && !str_starts_with($content, '<ul') &&
        !str_starts_with($content, '<h1') && !str_starts_with($content, '<h2') &&
        !str_starts_with($content, '<table')) {
      $content = '<p>' . $content . '</p>';
    }
  }
  else {
    $aMetadata['textbox'] = true;
  }

  if ($metadata('textbox')) {
    $content = (is_string($content) || is_int($content)) ? $content : json_encode($content, JSON_FLAGS['display']);
    $content = '<form><textarea class="special-textbox" name="content" rows="30" readonly>' . $content . '</textarea></form>';
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
    '{$PAGE_STATUS}'      => $metadata('statustext') ?? gfGetProperty('server', 'REQUEST_URI', SLASH) ?? 'Done',
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
    gfSend404('Expected count was' . SPACE . $aExpectedCount . SPACE .
                 'but was' . SPACE . gfGetProperty('runtime', 'currentDepth'));
  }
}

/**********************************************************************************************************************
* The Special Component
***********************************************************************************************************************/
function gfSpecialComponent() {
  global $gaRuntime;

  gfSetProperty('runtime', 'qComponent', 'special');
  gfSetProperty('runtime', 'sectionName', 'Special Component');

  // The Special Component never has more than one level below it
  // We still have to determine the root of the component though...
  if (count(gfGetProperty('runtime', 'currentPath')) == 1) {
    // URL /special/
    $spSpecialFunction = 'root';
  }
  else {
    // URL /special/xxx/
    gfCheckDepth(2);
    $spSpecialFunction = gfGetProperty('runtime', 'currentPath')[1];
  }

  $spCommandBar = array(
    '/'                         => DEFAULT_HOME_TEXT,
    '/special/'                 => 'Special Component',
    '/special/test/'            => 'Test Cases',
    '/special/hex/'             => 'Hex String',
    '/special/guid/'            => 'GUID',
    '/special/runtime/'         => 'Runtime Status',
  );

  if (!array_key_exists('site', COMPONENTS)) {
    unset($spCommandBar['/']);
  }

  gfSetProperty('runtime', 'commandBar', $spCommandBar);

  switch ($spSpecialFunction) {
    case 'root':
      $spContent = '<h2>Welcome</h2>' .
                   '<p>Please select a special function from the command bar above.';
      gfContent($spContent, ['title' => 'Overview']);
      break;
    case 'test':
      gfSetProperty('runtime', 'qTestCase', gfGetProperty('get', 'case'));
      $spTestsPath = gfBuildPath(PATHS['base'], 'tests');
      $spGlobTests = glob($spTestsPath . WILDCARD . PHP_EXTENSION);
      $spTests = EMPTY_ARRAY;

      foreach ($spGlobTests as $_value) {
        $spTests[] = gfSubst($_value, [PHP_EXTENSION => EMPTY_STRING, $spTestsPath => EMPTY_STRING]);
      }

      if (gfGetProperty('runtime', 'qTestCase')) {
        if (!in_array(gfGetProperty('runtime', 'qTestCase'), $spTests)) {
          gfError('Unknown test case');
        }

        require_once($spTestsPath . gfGetProperty('runtime', 'qTestCase') . PHP_EXTENSION);
        headers_sent() ? exit() : gfError('The operation completed successfully.');
      }

      $spContent = EMPTY_STRING;

      foreach ($spTests as $_value) {
        $spContent .= '<li><a href="/special/test/?case=' . $_value . '">' . $_value . '</a></li>';
      }

      $spContent = ($spContent == EMPTY_STRING) ?
                   '<p>There are no test cases.</p>' :
                   '<h2>Please select a test case&hellip;</h2><ul>' . $spContent . '</ul>' . str_repeat('<br />', 3);

      gfContent($spContent, ['title' => 'Test Cases']);
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
gfSetProperty('runtime', 'currentDomain', binocConsoleUtils::getDomain(gfGetProperty('runtime', 'phpServerName')));
gfSetProperty('runtime', 'currentSubDomain', binocConsoleUtils::getDomain(gfGetProperty('runtime', 'phpServerName'), true));

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

// Handle pretty urls that override the site component
if (in_array(gfGetProperty('runtime', 'currentPath')[0], COMPONENT_SLUGS)) {
  gfSetProperty('runtime', 'qComponent', gfGetProperty('runtime', 'currentPath')[0]);
}

// In the event that the site component isn't defined then redirect to the special "component"
if (gfGetProperty('runtime', 'qComponent') == 'site' && !array_key_exists('site', COMPONENTS)) {
  gfRedirect(SLASH . 'special' . gfGetProperty('runtime', 'phpRequestURI'));
}

// Load component based on qComponent
if (array_key_exists(gfGetProperty('runtime', 'qComponent'), COMPONENTS)) {
  $gvComponentFile = COMPONENTS[gfGetProperty('runtime', 'qComponent')];
  $gvComponentFile = file_exists($gvComponentFile) ?
                     require_once($gvComponentFile) :
                     gfSend404('Cannot load the' . SPACE . gfGetProperty('runtime', 'qComponent') . SPACE . 'component.');
  
  headers_sent() ? exit() : gfError('The operation completed successfully.');
}

if (gfGetProperty('runtime', 'qComponent') == 'special') {
  gfSpecialComponent();
  
}

gfSend404('PC LOAD LETTER');

// ====================================================================================================================

?>