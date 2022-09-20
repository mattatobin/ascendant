<?php
// == | Setup | =======================================================================================================

// Define basic constants for the software
const kDebugDomain = 'preview.binaryoutcast.com';
const kAppRepo = '#';
const kAppComps = ['panel', 'phoebus', 'update', 'storage'];
const kPrettyComps = ['special', 'panel'];
const kAppModules = ['database'];
const kAppLibs = array(
  'rdf'             => 'rdf_parser.php',
  'safeMySQL'       => 'safemysql.class.php',
  'smarty'          => 'smarty/Smarty.class.php',
);

// --------------------------------------------------------------------------------------------------------------------

const SOFTWARE_REPO       = kAppRepo;
const DEVELOPER_DOMAIN    = kDebugDomain;

const DEFAULT_SKIN        = 'default';
const DEFAULT_SITE_NAME   = 'Binary Outcast';

// Define paths
const PATHS = array(
  'base'            => ROOT_PATH . SLASH . 'base'         . SLASH,
  'components'      => ROOT_PATH . SLASH . 'components'   . SLASH,
  'datastore'       => ROOT_PATH . SLASH . 'datastore'    . SLASH,
  'modules'         => ROOT_PATH . SLASH . 'modules'      . SLASH,
  'libraries'       => ROOT_PATH . SLASH . 'third_party'  . SLASH,
  'objdir'          => ROOT_PATH . SLASH . '.obj'         . SLASH,
  'skin'            => ROOT_PATH . SLASH . 'skin'         . SLASH,
);

// --------------------------------------------------------------------------------------------------------------------

gRegisterFiles('COMPONENTS', kAppComps);
gRegisterFiles('MODULES', kAppModules);
gRegisterFiles('LIBRARIES', kAppLibs);

// ====================================================================================================================

// == | Global Functions | ============================================================================================

/**********************************************************************************************************************
* Basic Content Generation using the Special Component's Template
***********************************************************************************************************************/
function gContent($aContent, array $aMetadata = EMPTY_ARRAY) {
  if (SAPI_IS_CLI) {
    gOutput(['content' => $aContent, 'title' => $aMetadata['title'] ?? 'Output']);
  }

  $content = $aContent;

  $metadata = function($val) use(&$aMetadata) {
    return $aMetadata[$val] ?? null;
  };

  $menuize = function($aMenu) {
    $rv = EMPTY_STRING;

    foreach ($aMenu as $_key => $_value) {
      if (gContains($_key, 'onclick=', 1)) {
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

  $template = gReadFile(gBuildPath(PATHS['base'], 'skin', 'template' . FILE_EXTS['xhtml'])); 

  if (!$template) {
    gError('Could not read template.');
  }
 
  $siteName = gGetProperty('runtime', 'siteName', SOFTWARE_NAME);
  $sectionName = gGetProperty('runtime', 'sectionName');

  if ($sectionName) {
    $siteName = $sectionName . DASH_SEPARATOR . $siteName;
  }

  $commandBar = gGetProperty('runtime', 'commandBar', ['/' => DEFAULT_HOME_TEXT]);
  $isTestCase = (!$metadata('title') && gGetProperty('runtime', 'qTestCase') && gGetProperty('runtime', 'qComponent') == 'special');

  $substs = array(
    '{$SKIN_PATH}'        => gStripSubstr(gBuildPath(PATHS['base'], 'skin')),
    '{$SITE_NAME}'        => $siteName,
    '{$SITE_MENU}'        => $menuize($commandBar),
    '{$SITE_SECTION}'     => $wellsectionName ?? EMPTY_STRING,
    '{$PAGE_TITLE}'       => $isTestCase ? '[Test]' . SPACE . gGetProperty('runtime', 'qTestCase') : ($metadata('title') ?? 'Output'),
    '{$PAGE_CONTENT}'     => $content,
    '{$PAGE_STATUS}'      => $metadata('statustext') ?? gGetProperty('server', 'REQUEST_URI', SLASH) ?? 'Done',
    '{$SOFTWARE_VENDOR}'  => SOFTWARE_VENDOR,
    '{$SOFTWARE_NAME}'    => SOFTWARE_NAME,
    '{$SOFTWARE_VERSION}' => SOFTWARE_VERSION,
  );

  $content = gSubst($template, $substs);

  ob_end_clean();
  gOutput($content, 'html');
}

/**********************************************************************************************************************
* Check the path count
***********************************************************************************************************************/
function gCheckDepth($aExpectedCount) {
  if ((gGetProperty('runtime', 'currentDepth', 0)) > $aExpectedCount) {
    gSend404('Expected count was' . SPACE . $aExpectedCount . SPACE .
                 'but was' . SPACE . gGetProperty('runtime', 'currentDepth'));
  }
}

/**********************************************************************************************************************
* The Special Component
***********************************************************************************************************************/
function gSpecialComponent() {
  global $gaRuntime;

  gSetProperty('runtime', 'qComponent', 'special');
  gSetProperty('runtime', 'sectionName', 'Special Component');

  // The Special Component never has more than one level below it
  // We still have to determine the root of the component though...
  if (count(gGetProperty('runtime', 'currentPath')) == 1) {
    // URL /special/
    $spSpecialFunction = 'root';
  }
  else {
    // URL /special/xxx/
    gCheckDepth(2);
    $spSpecialFunction = gGetProperty('runtime', 'currentPath')[1];
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

  gSetProperty('runtime', 'commandBar', $spCommandBar);

  switch ($spSpecialFunction) {
    case 'root':
      $spContent = '<h2>Welcome</h2>' .
                   '<p>Please select a special function from the command bar above.';
      gContent($spContent, ['title' => 'Overview']);
      break;
    case 'test':
      gSetProperty('runtime', 'qTestCase', gGetProperty('get', 'case'));
      $spTestsPath = gBuildPath(PATHS['base'], 'tests');
      $spGlobTests = glob($spTestsPath . WILDCARD . PHP_EXTENSION);
      $spTests = EMPTY_ARRAY;

      foreach ($spGlobTests as $_value) {
        $spTests[] = gSubst($_value, [PHP_EXTENSION => EMPTY_STRING, $spTestsPath => EMPTY_STRING]);
      }

      if (gGetProperty('runtime', 'qTestCase')) {
        if (!in_array(gGetProperty('runtime', 'qTestCase'), $spTests)) {
          gError('Unknown test case');
        }

        require_once($spTestsPath . gGetProperty('runtime', 'qTestCase') . PHP_EXTENSION);
        headers_sent() ? exit() : gError('The operation completed successfully.');
      }

      $spContent = EMPTY_STRING;

      foreach ($spTests as $_value) {
        $spContent .= '<li><a href="/special/test/?case=' . $_value . '">' . $_value . '</a></li>';
      }

      $spContent = ($spContent == EMPTY_STRING) ?
                   '<p>There are no test cases.</p>' :
                   '<h2>Please select a test case&hellip;</h2><ul>' . $spContent . '</ul>' . str_repeat('<br />', 3);

      gContent($spContent, ['title' => 'Test Cases']);
      break;
    case 'runtime':
      gContent(['gaRuntime' => $gaRuntime, 'registry' => binoc\utils\registry::getStore()],
               ['title' => 'Runtime Status']);
      break;
    case 'hex':
      gContent(gHexString(gGetProperty('get', 'length', 40)), ['title' => 'Hex String', 'textbox' => true]);
      break;
    case 'guid':
      gContent(gGUID(gGetProperty('get', 'vendor'), gGetProperty('get', 'xpcom')), ['title' => 'GUID', 'textbox' => true]);
      break;
    case 'system':
      ini_set('default_mimetype', 'text/html');
      phpinfo(INFO_GENERAL | INFO_CONFIGURATION | INFO_ENVIRONMENT | INFO_VARIABLES);
      break;
    default:
      gHeader(404);
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
  'currentScheme'       => gGetProperty('server', 'SCHEME') ??
                           (gGetProperty('server', 'HTTPS') ? 'https' : 'http'),
  'debugMode'           => (gGetProperty('server', 'SERVER_NAME') == DEVELOPER_DOMAIN) ?
                           !DEBUG_MODE :
                           gGetProperty('get', 'debugOverride'),
  'offlineMode'         => file_exists(ROOT_PATH . '/.offline') && !gGetProperty('get', 'overrideOffline'),
  'remoteAddr'          => gGetProperty('server', 'HTTP_X_FORWARDED_FOR', gGetProperty('server', 'REMOTE_ADDR', '127.0.0.1')),
  'userAgent'           => gGetProperty('server', 'HTTP_USER_AGENT', PHP_SAPI . SLASH . PHP_VERSION),
  'phpRequestURI'       => gGetProperty('server', 'REQUEST_URI', SLASH),
  'phpServerName'       => gGetProperty('server', 'SERVER_NAME', 'localhost'),
  'qComponent'          => gGetProperty('get', 'component', 'site'),
  'qPath'               => gGetProperty('get', 'path', SLASH),
  'siteName'            => DEFAULT_SITE_NAME,
);

// Set the current domain and subdomain
gSetProperty('runtime', 'currentDomain', binoc\utils\output::getDomain(gGetProperty('runtime', 'phpServerName')));
gSetProperty('runtime', 'currentSubDomain', binoc\utils\output::getDomain(gGetProperty('runtime', 'phpServerName'), true));

// Explode the path if it exists
gSetProperty('runtime', 'currentPath', gSplitPath(gGetProperty('runtime', 'qPath')));

// Get a count of the exploded path
gSetProperty('runtime', 'currentDepth', count(gGetProperty('runtime', 'currentPath')));

gSetRegKey('app.offline', (file_exists(ROOT_PATH . '/.offline') && !gSuperGlobal('get', 'overrideOffline')));
gSetRegKey('app.debug', (gSuperGlobal('server', 'SERVER_NAME') == DEVELOPER_DOMAIN) ? !DEBUG_MODE : !gSuperGlobal('get', 'overrideOffline'));
gSetRegKey('output.siteName', 'Binary Outcast');
gSetRegKey('output.commandBar', [SLASH => 'Site Root (Home)']);
gSetRegKey('output.contentType', 'text/html');

// ------------------------------------------------------------------------------------------------------------------

// Site Offline
if (!SAPI_IS_CLI && gGetProperty('runtime', 'offlineMode')) {
  $gvOfflineMessage = 'This service is not currently available. Please try again later.';

  // Development offline message
  if (str_contains(SOFTWARE_VERSION, 'a') || str_contains(SOFTWARE_VERSION, 'b') ||
      str_contains(SOFTWARE_VERSION, 'pre') || gGetProperty('runtime', 'offlineMode')) {
    $gvOfflineMessage = 'This in-development version of'. SPACE . SOFTWARE_NAME . SPACE . 'is not for public consumption.';
  }

  gError($gvOfflineMessage);
}

// ------------------------------------------------------------------------------------------------------------------

// XXXTobin: Handle legacy phoebus component requests by sending them to a translation component
// This should be eventually removed as older versions age reasonably out
if (in_array(gGetProperty('runtime', 'qComponent'), ['aus', 'discover', 'download', 'integration'])) {
  gSetProperty('runtime', 'phoebusComponent', gGetProperty('runtime', 'qComponent'));
  gSetProperty('runtime', 'qComponent', 'phoebus');
}

// ------------------------------------------------------------------------------------------------------------------

// Handle pretty urls that override the site component
if (in_array(gGetProperty('runtime', 'currentPath')[0], kPrettyComps)) {
  gSetProperty('runtime', 'qComponent', gGetProperty('runtime', 'currentPath')[0]);
}

// In the event that the site component isn't defined then redirect to the special "component"
if (gGetProperty('runtime', 'qComponent') == 'site' && !array_key_exists('site', COMPONENTS)) {
  gRedirect(SLASH . 'special' . gGetProperty('runtime', 'phpRequestURI'));
}

// Load component based on qComponent
if (array_key_exists(gGetProperty('runtime', 'qComponent'), COMPONENTS)) {
  $gvComponentFile = COMPONENTS[gGetProperty('runtime', 'qComponent')];
  $gvComponentFile = file_exists($gvComponentFile) ?
                     require_once($gvComponentFile) :
                     gSend404('Cannot load the' . SPACE . gGetProperty('runtime', 'qComponent') . SPACE . 'component.');
  
  headers_sent() ? exit() : gError('The operation completed successfully.');
}

if (gGetProperty('runtime', 'qComponent') == 'special') {
  gSpecialComponent();
}

gSend404('PC LOAD LETTER');

// ====================================================================================================================

?>