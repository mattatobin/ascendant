<?php
// == | Setup | =======================================================================================================

// Enable Error Reporting
error_reporting(E_ALL);
ini_set("display_errors", "on");

// This is the absolute webroot path
// It does NOT have a trailing slash
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);

// Debug flag
define('DEBUG_MODE', $_GET['debug'] ?? null);

// Define basic constants for the software
const SOFTWARE_NAME       = 'Ascendant';
const SOFTWARE_VERSION    = '28.0.0pre';
const BASE_RELPATH        = '/base/';
const SKIN_RELPATH        = '/skin/';

// Include fundamental constants and global functions
const PHP_ERROR_CODES       = array(
  E_ERROR                   => 'Fatal Error',
  E_WARNING                 => 'Warning',
  E_PARSE                   => 'Parse',
  E_NOTICE                  => 'Notice',
  E_CORE_ERROR              => 'Fatal Error (Core)',
  E_CORE_WARNING            => 'Warning (Core)',
  E_COMPILE_ERROR           => 'Fatal Error (Compile)',
  E_COMPILE_WARNING         => 'Warning (Compile)',
  E_USER_ERROR              => 'Fatal Error (User Generated)',
  E_USER_WARNING            => 'Warning (User Generated)',
  E_USER_NOTICE             => 'Notice (User Generated)',
  E_STRICT                  => 'Strict',
  E_RECOVERABLE_ERROR       => 'Fatal Error (Recoverable)',
  E_DEPRECATED              => 'Deprecated',
  E_USER_DEPRECATED         => 'Deprecated (User Generated)',
  E_ALL                     => 'All'
);

const HTTP_HEADERS          = array(
  404                       => 'HTTP/1.1 404 Not Found',
  501                       => 'HTTP/1.1 501 Not Implemented',
  'text'                    => 'Content-Type: text/plain',
  'html'                    => 'Content-Type: text/html',
  'xhtml'                   => 'Content-Type: application/xhtml+xml',
  'css'                     => 'Content-Type: text/css',
  'xml'                     => 'Content-Type: text/xml',
  'json'                    => 'Content-Type: application/json',
  'bin'                     => 'Content-Type: application/octet-stream',
  'xpi'                     => 'Content-Type: application/x-xpinstall',
  '7z'                      => 'Content-Type: application/x-7z-compressed',
  'xz'                      => 'Content-Type: application/x-xz',
);

// --------------------------------------------------------------------------------------------------------------------

const NEW_LINE              = "\n";
const EMPTY_STRING          = "";
const EMPTY_ARRAY           = [];
const SPACE                 = " ";
const WILDCARD              = "*";
const SLASH                 = "/";
const DOT                   = ".";
const DASH                  = "-";
const UNDERSCORE            = "_";
const PIPE                  = "|";
const AMP                   = "&";
const DOLLAR                = "\$";
const COLON                 = ":";
const DBLCOLON              = COLON . COLON;
const DOTDOT                = DOT . DOT;

// --------------------------------------------------------------------------------------------------------------------

const DASH_SEPARATOR        = SPACE . DASH . SPACE;
const SCHEME_SUFFIX         = "://";

const PHP_EXTENSION         = DOT . 'php';
const INI_EXTENSION         = DOT . 'ini';
const HTML_EXTENSION        = DOT . 'html';
const XHTML_EXTENSION       = DOT . 'xhtml';
const XML_EXTENSION         = DOT . 'xml';
const RDF_EXTENSION         = DOT . 'rdf';
const JSON_EXTENSION        = DOT . 'json';
const CONTENT_EXTENSION     = DOT . 'content';
const TEMPLATE_EXTENSION    = DOT . 'tpl';
const XPINSTALL_EXTENSION   = DOT . 'xpi';
const WINSTALLER_EXTENSION  = DOT . 'installer' . DOT .'exe';
const WINPORTABLE_EXTENSION = DOT . 'portable' . DOT .'exe';
const SEVENZIP_EXTENSION    = DOT . '7z';
const TARGZ_EXTENSION       = DOT . 'tar' . DOT . 'gz';
const TGZ_EXTENSION         = DOT . 'tgz';
const TARBZ2_EXTENSION      = DOT . 'tar' . DOT . 'bz2';
const TBZ_EXTENSION         = DOT . 'tbz';
const TARXZ_EXTENSION       = DOT . 'tar' . DOT . 'xz';
const TXZ_EXTENSION         = DOT . 'txz';
const MAR_EXTENSION         = DOT . 'mar';
const TEMP_EXTENSION        = DOT . 'temp';

// --------------------------------------------------------------------------------------------------------------------

const XML_TAG               = '<?xml version="1.0" encoding="utf-8" ?>';

// --------------------------------------------------------------------------------------------------------------------

const RDF_INSTALL_MANIFEST  = 'install' . RDF_EXTENSION;
const JSON_INSTALL_MANIFEST = 'install' . JSON_EXTENSION;

// --------------------------------------------------------------------------------------------------------------------

const JSON_DISPLAY_FLAGS    = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
const JSON_STORAGE_FLAGS    = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
const JSON_ENCODE_FLAGS     = JSON_DISPLAY_FLAGS;

const FILE_WRITE_FLAGS      = "w+";

// --------------------------------------------------------------------------------------------------------------------

const REGEX_GET_FILTER      = "/[^-a-zA-Z0-9_\-\/\{\}\@\.\%\s\,]/";
const REGEX_YAML_FILTER     = "/\A---(.|\n)*?---/";
const REGEX_GUID            = "/^\{[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\}$/i";
const REGEX_HOST            = "/[a-z0-9-\._]+\@[a-z0-9-\._]+/i";

// --------------------------------------------------------------------------------------------------------------------

const PASSWORD_CLEARTEXT    = "clrtxt";
const PASSWORD_HTACCESS     = "apr1";

const BASE64_ALPHABET       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
const APRMD5_ALPHABET       = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

// --------------------------------------------------------------------------------------------------------------------

/* Known Application IDs
 * Application IDs are normally in the form of a {GUID} or user@host ID.
 *
 * Mozilla Suite:             {86c18b42-e466-45a9-ae7a-9b95ba6f5640}
 * Firefox:                   {ec8030f7-c20a-464f-9b0e-13a3a9e97384}    (Also, Pale Moon 30+)
 * Thunderbird:               {3550f703-e582-4d05-9a08-453d09bdfdc6}    (Also, Interlink Mail & News)
 * SeaMonkey:                 {92650c4d-4b8e-4d2a-b7eb-24ecf4f6b63a}
 * Fennec (Android):          {aa3c5121-dab2-40e2-81ca-7ea25febc110}
 * Fennec (XUL):              {a23983c0-fd0e-11dc-95ff-0800200c9a66}
 * Sunbird:                   {718e30fb-e89b-41dd-9da7-e25a45638b28}
 * Instantbird:               {33cb9019-c295-46dd-be21-8c4936574bee}
 * Netscape Browser:          {3db10fab-e461-4c80-8b97-957ad5f8ea47}
 *
 * Nvu:                       {136c295a-4a5a-41cf-bf24-5cee526720d5}
 * Flock:                     {a463f10c-3994-11da-9945-000d60ca027b}
 * Kompozer:                  {20aa4150-b5f4-11de-8a39-0800200c9a66}
 * BlueGriffon:               bluegriffon@bluegriffon.com
 * Adblock Browser:           {55aba3ac-94d3-41a8-9e25-5c21fe874539}
 * Postbox:                   postbox@postbox-inc.com
 *
 * Pale Moon 25-29:           {8de7fcbb-c55c-4fbe-bfc5-fc555c87dbc4}
 * Borealis 0.9:              {a3210b97-8e8a-4737-9aa0-aa0e607640b9}
 * Ambassador (Standalone):   {4523665a-317f-4a66-9376-3763d1ad1978}    (Soft-abandoned, also, same as extension)
 * XUL Example:               example@uxp.app
 *
 * IceDove-UXP:               {3aa07e56-beb0-47a0-b0cb-c735edd25419}
 * IceApe-UXP:                {9184b6fe-4a5c-484d-8b4b-efbfccbfb514}
 */

/* ----------------------------------------------------------------------------------------------------------------- */

/* Olympia Add-on Types
 * ADDON_ANY        = 0
 * ADDON_EXTENSION  = 1
 * ADDON_THEME      = 2
 * ADDON_DICT       = 3
 * ADDON_SEARCH     = 4
 * ADDON_LPAPP      = 5   XXXTobin: This seems to be the PROPER locale type originally defined in XPInstall
 * ADDON_LPADDON    = 6   XXXTobin: What the hell is the difference between LPAPP and LPADDON?!
 * ADDON_PLUGIN     = 7
 * ADDON_API        = 8   XXXOlympia: not actually a type but used to identify extensions + themes
 *                        XXXTobin: Are these actual multipackage or on-the-fly multipackage via AMO Collections?
 * ADDON_PERSONA    = 9
 * ADDON_WEBAPP     = 11  XXXOlympia: Calling this ADDON_* is gross but we've gotta ship code.
 *                        XXXTobin: no1curr
 */

/* ----------------------------------------------------------------------------------------------------------------- */

/* Olympia Update Types
 * ADDON_EXTENSION  : 'extension',
 * ADDON_THEME      : 'theme',
 * ADDON_DICT       : 'extension',        XXXTobin: extensions.. Really?
 * ADDON_SEARCH     : 'search',           XXXTobin: We may never find out how this was intended to be handled.
 * ADDON_LPAPP      : 'item',
 * ADDON_LPADDON    : 'extension',        XXXTobin: See Olympia Add-on Types
 * ADDON_PERSONA    : 'background-theme', XXXTobin: Ditto re: search
 * ADDON_PLUGIN     : 'plugin',
 */

// --------------------------------------------------------------------------------------------------------------------

// Do not allow this to be included more than once...
if (defined('APP_UTILS')) {
  die('Application Specific Utilities: You may not include this more than once.');
}

// Define that this is a thing.
define('APP_UTILS', 1);

// --------------------------------------------------------------------------------------------------------------------

const SOFTWARE_REPO       = 'about:blank';
const DATASTORE_RELPATH   = '/datastore/';
const OBJ_RELPATH         = '/.obj/';
const COMPONENTS_RELPATH  = '/components/';
const MODULES_RELPATH     = '/modules/';
const DATABASES_RELPATH   = '/db/';
const LIB_RELPATH         = '/libs/';

// Define components
const COMPONENTS = array(
  'special'         => ROOT_PATH . BASE_RELPATH       . 'special.php',
  'site'            => ROOT_PATH . BASE_RELPATH       . 'addonsSite.php',
  'download'        => ROOT_PATH . BASE_RELPATH       . 'addonsDownload.php',
  'aus'             => ROOT_PATH . COMPONENTS_RELPATH . 'manager/amUpdate.php',
  'discover'        => ROOT_PATH . COMPONENTS_RELPATH . 'manager/amDiscoverPane.php',
  'integration'     => ROOT_PATH . COMPONENTS_RELPATH . 'manager/amIntegration.php',
  'panel'           => ROOT_PATH . COMPONENTS_RELPATH . 'panel/addonsPanel.php',
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

// Define databases
const DATABASES = array(
  'emailBlacklist'  => ROOT_PATH . DATABASES_RELPATH . 'emailBlacklist.php',
);

// Define libraries
const LIBRARIES = array(
  'rdfParser'       => ROOT_PATH . LIB_RELPATH . 'rdf_parser.php',
  'safeMySQL'       => ROOT_PATH . LIB_RELPATH . 'safemysql.class.php',
  'smarty'          => ROOT_PATH . LIB_RELPATH . 'smarty/Smarty.class.php',
);

// --------------------------------------------------------------------------------------------------------------------

const XML_API_SEARCH_BLANK  = '<searchresults total_results="0" />';
const XML_API_LIST_BLANK    = '<addons />';
const XML_API_ADDON_ERROR   = '<error>Add-on not found!</error>';
const RDF_AUS_BLANK         = '<RDF:RDF xmlns:RDF="http://www.w3.org/1999/02/22-rdf-syntax-ns#"' . SPACE .
                              'xmlns:em="http://www.mozilla.org/2004/em-rdf#" />';

// --------------------------------------------------------------------------------------------------------------------

// Define Domains for Applications
const APPLICATION_DOMAINS = ['palemoon.org' => 'palemoon', 'binaryoutcast.com' => ['borealis', 'interlink']];
const DEVELOPER_DOMAIN = 'addons-dev.palemoon.org';

// --------------------------------------------------------------------------------------------------------------------

// Define application metadata
/* Features are as follows:
 * 'e-cat', 't-cat', 'p-cat', 'unified', 'disable-xpinstall',
 * 'extensions', 'themes', 'language-packs', 'dictionaries',
 * 'search-plugins', 'personas', 'user-scripts', 'user-styles'
*/
const TARGET_APPLICATION = array(
  'toolkit' => array(
    'id'            => 'toolkit@mozilla.org',
    'bit'           => 1,
    'minVersion'    => '5.0.0a1',
    'maxVersion'    => '5.*',
    'maxOldVersion' => '4.*',
    'domain'        => 'addons.thereisonlyxul.org',
    'unified'       => false,
    'name'          => 'Goanna Runtime Environment',
    'shortName'     => 'GRE',
    'commonType'    => 'platform',
    'vendor'        => 'GRE Alliance',
    'siteTitle'     => EMPTY_STRING,
    'features'      => EMPTY_ARRAY
  ),
  'palemoon' => array(
    'id'            => '{ec8030f7-c20a-464f-9b0e-13a3a9e97384}',
    'bit'           => 2,
    'minVersion'    => '30.0.0a1',
    'maxVersion'    => '30.*',
    'maxOldVersion' => '29.*',
    'domain'        => 'addons.palemoon.org',
    'unified'       => false,
    'name'          => 'Pale Moon',
    'shortName'     => 'Pale Moon',
    'commonType'    => 'browser',
    'vendor'        => 'Moonchild Productions',
    'siteTitle'     => 'Pale Moon - Add-ons',
    'features'      => ['extensions', 'themes', 'language-packs', 'dictionaries']
  ),
  'borealis' => array(
    'id'            => '{86c18b42-e466-4580-8b97-957ad5f8ea47}',
    'bit'           => 4,
    'minVersion'    => '8.5.7900a1',
    'maxVersion'    => '8.5.8400',
    'maxOldVersion' => '8.4.*',
    'domain'        => 'addons.binaryoutcast.com',
    'unified'       => true,
    'name'          => 'Borealis Navigator',
    'shortName'     => 'Borealis',
    'commonType'    => 'navigator',
    'vendor'        => 'Binary Outcast',
    'siteTitle'     => 'Add-ons - Binary Outcast',
    'features'      => ['extensions', 'themes', 'dictionaries', 'search-plugins']
  ),
  'interlink' => array(
    'id'            => '{3550f703-e582-4d05-9a08-453d09bdfdc6}',
    'bit'           => 8,
    'minVersion'    => '52.9.7900a1',
    'maxVersion'    => '52.9.8400',
    'maxOldVersion' => '52.9.7899', /* Basically irrelevant for non-web clients */
    'domain'        => 'addons.binaryoutcast.com',
    'unified'       => true,
    'name'          => 'Interlink Mail &amp; News',
    'shortName'     => 'Interlink',
    'commonType'    => 'client',
    'vendor'        => 'Binary Outcast',
    'siteTitle'     => 'Add-ons - Binary Outcast',
    'features'      => ['disable-xpinstall', 'extensions', 'themes', 'dictionaries', 'search-plugins']
  ),
);

const PALEMOON_GUID = '{8de7fcbb-c55c-4fbe-bfc5-fc555c87dbc4}';

// --------------------------------------------------------------------------------------------------------------------

// User Levels are not bit-wise so they correspond with the following indexed array order
const USER_LEVELS         = ['unregistered', 'banned', 'user', 'developer',
                             'moderator', 'administrator'];
const USER_LEVELS_DISPLAY = ['Unknown', 'Non-entity', 'Regular User', 'Add-on Developer',
                             'Add-ons Team', 'Phobos Overlord'];

// --------------------------------------------------------------------------------------------------------------------

const XPINSTALL_TYPES = array(
  'app'               => 1,     // No longer applicable
  'extension'         => 2,
  'theme'             => 4,
  'locale'            => 8,
  'plugin'            => 16,    // No longer applicable
  'multipackage'      => 32,    // Forbidden on Phobos
  'dictionary'        => 64,
  'experiment'        => 128,   // No longer applicable
  'apiextension'      => 256,   // No longer applicable
  'external'          => 512,   // Phobos only
  'persona'           => 1024,  // Phobos only
  'search-plugin'     => 2048,  // Phobos only
  'user-script'       => 4096,  // Phobos only
  'user-style'        => 8192,  // Phobos only
);

// These are the supported "real" XPInstall types
const VALID_XPI_TYPES   = XPINSTALL_TYPES['extension'] | XPINSTALL_TYPES['theme'] |
                          XPINSTALL_TYPES['locale'] | XPINSTALL_TYPES['dictionary'];

// These are add-on types only Phobos understands. They are NOT installable in the application directly
// We will treat them as any other xpi but deliver them to the client in different ways
const EXTRA_XPI_TYPES   = XPINSTALL_TYPES['persona'] | XPINSTALL_TYPES['search-plugin'] |
                          XPINSTALL_TYPES['user-script'] | XPINSTALL_TYPES['user-style'];

// These are unsupported "real" XPInstall types (plus external because it is completely virtual)
const INVALID_XPI_TYPES = XPINSTALL_TYPES['app'] | XPINSTALL_TYPES['plugin'] | XPINSTALL_TYPES['multipackage'] |
                          XPINSTALL_TYPES['experiment'] | XPINSTALL_TYPES['apiextension'] | XPINSTALL_TYPES['external'];

// Originally XPInstall only needed to a handful of types since it was killed much refactoring and Olympia reused
// older types. We are gonna match that for now even if they aren't actually implemented. 
const AUS_XPI_TYPES = array(
  XPINSTALL_TYPES['extension']      => 'extension',
  XPINSTALL_TYPES['theme']          => 'theme',
  XPINSTALL_TYPES['dictionary']     => 'extension',
  XPINSTALL_TYPES['search-plugin']  => 'search',
  XPINSTALL_TYPES['locale']         => 'item',
  XPINSTALL_TYPES['persona']        => 'background-theme',
);

// Add-ons Manager Search uses the Olympia types so map the XPInstall Types to Olympia which match the Add-ons Manager
const SEARCH_XPI_TYPES = array(
  XPINSTALL_TYPES['extension']      => 1,
  XPINSTALL_TYPES['theme']          => 2,
  XPINSTALL_TYPES['dictionary']     => 3,
  XPINSTALL_TYPES['search-plugin']  => 4,
  XPINSTALL_TYPES['locale']         => 5,
  XPINSTALL_TYPES['persona']        => 9,
);

// --------------------------------------------------------------------------------------------------------------------

const MANIFEST_FILES = array(
  'xpinstall'         => 'install.js',
  'rdfinstall'        => RDF_INSTALL_MANIFEST,
  'jsoninstall'       => JSON_INSTALL_MANIFEST,
  'chrome'            => 'chrome.manifest',
  'bootstrap'         => 'bootstrap.js',
  'cfxJetpack'        => 'harness-options.json',
  'npmJetpack'        => 'package.json',
  'webex'             => 'manifest.json',
);

// --------------------------------------------------------------------------------------------------------------------

// Define the specific technology that Add-ons can have
const ADDON_TECHNOLOGY = ['overlay' => 1, 'xpcom' => 2, 'bootstrap' => 4, 'jetpack' => 8];

// These ID fragments are NOT allowed anywhere in an Add-on ID unless you are a member of the Add-ons Team or higher
const RESTRICTED_IDS  = array(
  'bfc5-fc555c87dbc4',  // Moonchild Productions
  '9376-3763d1ad1978',  // Pseudo-Static
  '9aa0-aa0e607640b9',  // Binary Outcast
  'moonchild',          // Moonchild Productions
  'palemoon',           // Moonchild Productions
  'basilisk',           // Moonchild Productions
  'binaryoutcast',      // Binary Outcast
  'mattatobin',         // Binary Outcast
  'thereisonlyxul',
  'mozilla.org',
  'lootyhoof',          // Ryan
  'srazzano',           // BANNED FOR LIFE
  'justoff',            // BANNED FOR LIFE
);

// --------------------------------------------------------------------------------------------------------------------

const SECTIONS = array(
  'extensions'      => array('type'        => XPINSTALL_TYPES['extension'],
                             'name'        => 'Extensions',
                             'description' =>
                               'Extensions are small add-ons that add new functionality to {%APPLICATION_SHORTNAME},' . SPACE .
                               'from a simple toolbar button to a completely new feature.' . SPACE .
                               'They allow you to customize the {%APPLICATION_COMMONTYPE} to fit your own needs' . SPACE .
                               'and preferences, while keeping the core itself light and lean.'
                            ),
  'themes'          => array('type'        => XPINSTALL_TYPES['theme'],
                             'name'        => 'Themes',
                             'description' =>
                               'Themes allow you to change the look and feel of the user interface' . SPACE .
                               'and personalize it to your tastes.' . SPACE .
                               'A theme can simply change the colors of the UI or it can change every aspect of its appearance.'
                            ),
  'language-packs'  => array('type'        => XPINSTALL_TYPES['locale'],
                             'name'        => 'Language Packs',
                             'description' => 'These add-ons provide strings for the user interface in your local language.'
                            ),
  'dictionaries'    => array('type'        => XPINSTALL_TYPES['dictionary'],
                             'name'        => 'Dictionaries',
                             'description' =>
                               '{%APPLICATION_SHORTNAME} has spell checking features, with this type of add-on' . SPACE .
                               'you can add check the spelling in additional languages.'
                            ),
  'personas'        => array('type'        => XPINSTALL_TYPES['persona'],
                             'name'        => 'Personas',
                             'description' => 'Lightweight themes which allow you personalize {%APPLICATION_SHORTNAME} further.'
                            ),
  'search-plugins'  => array('type'        => XPINSTALL_TYPES['search-plugin'],
                             'name'        => 'Search Plugins',
                             'description' =>
                               'A search plugin provides the ability to access a search engine from a web browser,' . SPACE .
                               'without having to go to the engine\'s website first.<br />' .
                               'Technically, a search plugin is a small Extensible Markup Language file that tells' . SPACE .
                               'the browser what information to send to a search engine and how the results are to be retrieved. '
                            ),
  'user-scripts'    => ['type' => XPINSTALL_TYPES['user-script'], 'name' => 'User Scripts', 'description' => null],
  'user-styles'     => ['type' => XPINSTALL_TYPES['user-style'], 'name' => 'User Styles', 'description' => null],
);

// --------------------------------------------------------------------------------------------------------------------

const CATEGORIES = array(
  'unlisted'                  => ['bit' => 0,         'name' => 'Unlisted', 'type' => 0],
  'alerts-and-updates'        => ['bit' => 1,         'name' => 'Alerts &amp; Updates',
                                  'type' => XPINSTALL_TYPES['extension']],
  'appearance'                => ['bit' => 2,         'name' => 'Appearance',
                                  'type' => XPINSTALL_TYPES['extension']],
  'bookmarks-and-tabs'        => ['bit' => 4,         'name' => 'Bookmarks &amp; Tabs',
                                  'type' => XPINSTALL_TYPES['extension']],
  'download-management'       => ['bit' => 8,         'name' => 'Download Management',
                                  'type' => XPINSTALL_TYPES['extension'],],
  'feeds-news-and-blogging'   => ['bit' => 16,        'name' => 'Feeds, News, &amp; Blogging',
                                  'type' => XPINSTALL_TYPES['extension'],],
  'privacy-and-security'      => ['bit' => 32,        'name' => 'Privacy &amp; Security',
                                  'type' => XPINSTALL_TYPES['extension']],
  'search-tools'              => ['bit' => 64,        'name' => 'Search Tools',
                                  'type' => XPINSTALL_TYPES['extension']],
  'social-and-communication'  => ['bit' => 128,       'name' => 'Social &amp; Communication',
                                  'type' => XPINSTALL_TYPES['extension']],
  'tools-and-utilities'       => ['bit' => 256,       'name' => 'Tools &amp; Utilities',
                                  'type' => XPINSTALL_TYPES['extension']],
  'web-development'           => ['bit' => 512,       'name' => 'Web Development', 
                                  'type' => XPINSTALL_TYPES['extension']],
  'abstract'                  => ['bit' => 1024,      'name' => 'Abstract',
                                  'type' => XPINSTALL_TYPES['persona']],
  'brands'                    => ['bit' => 4096,      'name' => 'Brands',
                                  'type' => XPINSTALL_TYPES['persona']],
  'compact'                   => ['bit' => 8192,      'name' => 'Compact',
                                  'type' => XPINSTALL_TYPES['theme']],
  'dark'                      => ['bit' => 16384,     'name' => 'Dark',
                                  'type' => XPINSTALL_TYPES['theme'] | XPINSTALL_TYPES['persona']],
  'large'                     => ['bit' => 32768,     'name' => 'Large',
                                  'type' => XPINSTALL_TYPES['theme']],
  'modern'                    => ['bit' => 65536,     'name' => 'Modern',
                                  'type' => XPINSTALL_TYPES['theme']],
  'music'                     => ['bit' => 131072,    'name' => 'Music',
                                  'type' => XPINSTALL_TYPES['persona']],
  'nature'                    => ['bit' => 262144,    'name' => 'nature',
                                  'type' => XPINSTALL_TYPES['persona']],
  'other-web-clients'         => ['bit' => 524288,    'name' => 'Browsers, Explorers, &amp; Navigators',
                                  'type' => XPINSTALL_TYPES['theme']],
  'retro'                     => ['bit' => 1048576,   'name' => 'Retro &amp; Classic',
                                  'type' => XPINSTALL_TYPES['theme'] | XPINSTALL_TYPES['persona']],
  'os-integration'            => ['bit' => 2097152,   'name' => 'OS Integration',
                                  'type' => XPINSTALL_TYPES['theme']],
  'scenery'                   => ['bit' => 4194304,   'name' => 'Scenery',
                                  'type' => XPINSTALL_TYPES['persona']],
  'seasonal'                  => ['bit' => 8388608,   'name' => 'Seasonal',
                                  'type' => XPINSTALL_TYPES['persona']],
  'other'                     => ['bit' => 16777216,  'name' => 'Other',
                                  'type' => XPINSTALL_TYPES['extension'] | XPINSTALL_TYPES['theme'] | XPINSTALL_TYPES['persona']],
);

// --------------------------------------------------------------------------------------------------------------------

// Open Source Licenses users can set for their Add-ons
const LICENSES = array(
  'Apache-2.0'                => 'Apache License 2.0',
  'Apache-1.1'                => 'Apache License 1.1',
  'BSD-3-Clause'              => 'BSD 3-Clause',
  'BSD-2-Clause'              => 'BSD 2-Clause',
  'GPL-3.0'                   => 'GNU General Public License 3.0',
  'GPL-2.0'                   => 'GNU General Public License 2.0',
  'LGPL-3.0'                  => 'GNU Lesser General Public License 3.0',
  'LGPL-2.1'                  => 'GNU Lesser General Public License 2.1',
  'AGPL-3.0'                  => 'GNU Affero General Public License v3',
  'MIT'                       => 'MIT License',
  'MPL-2.0'                   => 'Mozilla Public License 2.0',
  'MPL-1.1'                   => 'Mozilla Public License 1.1',
  'PD'                        => 'Public Domain',
  'COPYRIGHT'                 => '&copy;',
  'Custom'                    => 'Custom License',
);

// ====================================================================================================================

// == | Global Functions | ============================================================================================

/**********************************************************************************************************************
* Error function that will display data (Error Message)
*
* This version of the function can emit the error as xml or text depending on the environment.
* It also can use gfContent() if defined and has the same signature.
* It also has its legacy ability for generic output if the error message is not a string as formatted json
* regardless of the environment.
*
* @dep gfContent() - conditional
* @dep NEW_LINE
* @dep XML_TAG
* @dep JSON_ENCODE_FLAGS
**********************************************************************************************************************/
function gfError($aValue, $aPHPError = false, $aExternalOutput = true) { 
  $pageHeader = ['default' => 'Unable to Comply', 'php' => 'PHP Error', 'output' => 'Output'];
  $externalOutput = ($aExternalOutput === null) ? function_exists('gfContent') : $aExternalOutput;
  $isCLI = (php_sapi_name() == "cli");
  $isOutput = false;

  if (is_string($aValue) || is_int($aValue)) {
    $eContentType = 'text/xml';
    $ePrefix = $aPHPError ? $pageHeader['php'] : $pageHeader['default'];

    if ($externalOutput || $isCLI) {
      $eMessage = $aValue;
    }
    else {
      $eMessage = XML_TAG . NEW_LINE . '<error title="' . $ePrefix . '">' . $aValue . '</error>';
    }
  }
  else {
    $isOutput = true;
    $eContentType = 'application/json';
    $ePrefix = $pageHeader['output'];
    $eMessage = json_encode($aValue, JSON_ENCODE_FLAGS);
  }

  if ($externalOutput) {
    if ($aPHPError) {
      gfContent($ePrefix, $eMessage, null, true, true);
    }

    if ($isOutput) {
      gfContent($ePrefix, $eMessage, true, false, true);
    }
    
    gfContent($ePrefix, $eMessage, null, null, true);
  }
  elseif ($isCLI) {
    print('========================================' . NEW_LINE .
          $ePrefix . NEW_LINE .
          '========================================' . NEW_LINE .
          $eMessage . NEW_LINE);
  }
  else {
    header('Content-Type: ' . $eContentType, false);
    print($eMessage);
  }

  // We're done here.
  exit();
}

/**********************************************************************************************************************
* PHP Error Handler
*
* @dep SPACE
* @dep PHP_ERROR_CODES
* @dep gfError()
**********************************************************************************************************************/
function gfErrorHandler($eCode, $eString, $eFile, $eLine) {
  $eType = PHP_ERROR_CODES[$eCode] ?? $eCode;
  $eMessage = $eType . ': ' . $eString . SPACE . 'in' . SPACE .
                  str_replace(ROOT_PATH, '', $eFile) . SPACE . 'on line' . SPACE . $eLine;

  if (!(error_reporting() & $eCode)) {
    // Don't do jack shit because the developers of PHP think users shouldn't be trusted.
    return;
  }

  gfError($eMessage, true);
}

// Set error handler fairly early...
set_error_handler("gfErrorHandler");

/**********************************************************************************************************************
* Unified Var Checking
*
* @dep DASH_SEPARATOR
* @dep UNDERSCORE
* @dep EMPTY_STRING
* @dep REGEX_GET_FILTER
* @dep gfError()
* @param $aVarType        Type of var to check
* @param $aVarValue       GET/SERVER/EXISTING Normal Var
* @param $aFalsy          Optional - Allow falsey returns on var/direct
* @returns                Value or null
**********************************************************************************************************************/
function gfSuperVar($aVarType, $aVarValue) {
  // Set up the Error Message Prefix
  $ePrefix = __FUNCTION__ . DASH_SEPARATOR;
  $rv = null;

  // Turn the variable type into all caps prefixed with an underscore
  $varType = UNDERSCORE . strtoupper($aVarType);

  // General variable absolute null check unless falsy is allowed
  if ($varType == "_CHECK" || $varType == "_VAR"){
    $rv = $aVarValue;

    if (empty($rv) || $rv === 'none' || $rv === 0) {
      return null;
    }

    return $rv;
  }

  // This handles the superglobals
  switch($varType) {
    case '_SERVER':
    case '_GET':
    case '_FILES':
    case '_POST':
    case '_COOKIE':
    case '_SESSION':
      $rv = $GLOBALS[$varType][$aVarValue] ?? null;
      break;
    default:
      // We don't know WHAT was requested but it is obviously wrong...
      gfError($ePrefix . 'Incorrect Var Check');
  }
  
  // We always pass $_GET values through a general regular expression
  // This allows only a-z A-Z 0-9 - / { } @ % whitespace and ,
  if ($rv && $varType == "_GET") {
    $rv = preg_replace(REGEX_GET_FILTER, EMPTY_STRING, $rv);
  }

  // Files need special handling.. In principle we hard fail if it is anything other than
  // OK or NO FILE
  if ($rv && $varType == "_FILES") {
    if (!in_array($rv['error'], [UPLOAD_ERR_OK, UPLOAD_ERR_NO_FILE])) {
      gfError($ePrefix . 'Upload of ' . $aVarValue . ' failed with error code: ' . $rv['error']);
    }

    // No file is handled as merely being null
    if ($rv['error'] == UPLOAD_ERR_NO_FILE) {
      return null;
    }

    // Cursory check the actual mime-type and replace whatever the web client sent
    $rv['type'] = mime_content_type($rv['tmp_name']);
  }
  
  return $rv;
}

/**********************************************************************************************************************
* Sends HTTP Headers to client using a short name
*
* @dep HTTP_HEADERS
* @dep DEBUG_MODE
* @dep gfError()
* @param $aHeader    Short name of header
**********************************************************************************************************************/
function gfHeader($aHeader, $aReplace = true) { 
  $ePrefix = __FUNCTION__ . DASH_SEPARATOR;
  $debugMode = DEBUG_MODE;
  $isErrorPage = in_array($aHeader, [404, 501]);

  global $gaRuntime;

  if ($gaRuntime['debugMode'] ?? null || DEBUG_MODE) {
    $debugMode = $gaRuntime['debugMode'];
  }

  if (!array_key_exists($aHeader, HTTP_HEADERS)) {
    gfError($ePrefix . 'Unknown' . SPACE . $aHeader . SPACE . 'header');
  }

  if ($debugMode && $isErrorPage) {
    gfError($ePrefix . HTTP_HEADERS[$aHeader]);
  }

  if (!headers_sent()) { 
    header(HTTP_HEADERS[$aHeader], $aReplace);

    if ($isErrorPage) {
      exit();
    }
  }
}

/**********************************************************************************************************************
* 404 or Error
*
* @param $aErrorMessage   Error message if debug
***********************************************************************************************************************/
function gfErrorOr404($aErrorMessage) {
  global $gaRuntime;

  if ($gaRuntime['debugMode'] ?? null || DEBUG_MODE) {
    gfError($aErrorMessage);
  }

  gfHeader(404);
}

/**********************************************************************************************************************
* Sends HTTP Header to redirect the client to another URL
*
* @param $aURL   URL to redirect to
**********************************************************************************************************************/
// This function sends a redirect header
function gfRedirect($aURL) {
  header('Location: ' . $aURL, true, 302);
  
  // We are done here
  exit();
}

/**********************************************************************************************************************
* Simply prints output and sends header if not cli and exits
**********************************************************************************************************************/
function gfOutput($aContent, $aHeader = 'text') {
  if (php_sapi_name() != "cli") {
    gfHeader($aHeader);
  }

  print($aContent);
  exit();
}

/**********************************************************************************************************************
* Basic Filter Substitution of a string
*
* @dep EMPTY_STRING
* @dep SLASH
* @dep SPACE
* @dep gfError()
* @param $aSubsts               multi-dimensional array of keys and values to be replaced
* @param $aString               string to operate on
* @param $aRegEx                set to true if pcre
* @returns                      bitwise int value representing applications
***********************************************************************************************************************/
function gfSubst($aMode, $aSubsts, $aString) {
  $ePrefix = __FUNCTION__ . DASH_SEPARATOR;
  if (!is_array($aSubsts)) {
    gfError($ePrefix . '$aSubsts must be an array');
  }

  if (!is_string($aString)) {
    gfError($ePrefix . '$aString must be a string');
  }

  $rv = $aString;

  switch ($aMode) {
    case 'simple':
    case 'string':
    case 'str':
      foreach ($aSubsts as $_key => $_value) { $rv = str_replace($_key, $_value, $rv); }
      break;
    case 'regex':
      foreach ($aSubsts as $_key => $_value) { $rv = preg_replace(SLASH . $_key . SLASH . 'iU', $_value, $rv); }
      break;
    default:
      gfError($ePrefix . 'Unknown mode');
  }

  if (!$rv) {
    gfError($ePrefix . 'Something has gone wrong...');
  }

  return $rv;
}

/**********************************************************************************************************************
* Explodes a string to an array without empty elements if it starts or ends with the separator
*
* @dep DASH_SEPARATOR
* @dep gfError()
* @param $aSeparator   Separator used to split the string
* @param $aString      String to be exploded
* @returns             Array of string parts
***********************************************************************************************************************/
function gfExplodeString($aSeparator, $aString) {
  $ePrefix = __FUNCTION__ . DASH_SEPARATOR;

  if (!is_string($aString)) {
    gfError($ePrefix . 'Specified string is not a string type');
  }

  if (!str_contains($aString, $aSeparator)) {
    gfError($ePrefix . 'String does not contain the separator');
  }

  $explodedString = array_values(array_filter(explode($aSeparator, $aString), 'strlen'));

  return $explodedString;
}

/**********************************************************************************************************************
* Splits a path into an indexed array of parts
*
* @dep SLASH
* @dep gfExplodeString()
* @param $aPath   URI Path
* @returns        array of uri parts in order
***********************************************************************************************************************/
function gfExplodePath($aPath) {
  if ($aPath == SLASH) { return ['root']; }
  return gfExplodeString(SLASH, $aPath);
}

/**********************************************************************************************************************
* Builds a path from a list of arguments
*
* @dep ROOT_PATH
* @dep SLASH
* @dep DOT
* @param        ...$aPathParts  Path Parts
* @returns                      Path string
***********************************************************************************************************************/
function gfBuildPath(...$aPathParts) {
  $path = implode(SLASH, $aPathParts);

  $filesystem = str_starts_with($path, ROOT_PATH);
  
  // Add a pre-pending slash if this is not a file system path
  if (!$filesystem) {
    $path = SLASH . $path;
  }

  // Add a trailing slash if the last part does not contain a dot
  // If it is a file system path then we will also add a trailing slash if the last part starts with a dot
  if (!str_contains(basename($path), DOT) || ($filesystem && str_starts_with(basename($path), DOT))) {
    $path .= SLASH;
  }

  // Remove any cases of multiple slashes
  $path = preg_replace('#/+#', '/', $path);

  return $path;
}

/**********************************************************************************************************************
* Strips the constant ROOT_PATH from a string
*
* @dep ROOT_PATH
* @dep EMPTY_STRING
* @param $aPath   Path to be stripped
* @returns        Stripped path
***********************************************************************************************************************/
function gfStripRootPath($aPath) {
  return str_replace(ROOT_PATH, EMPTY_STRING, $aPath);
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

/**********************************************************************************************************************
* Build a URL
***********************************************************************************************************************/
function gfBuildURL($aDomain, $aQueryArguments, ...$aPath) {
  global $gaRuntime;

  $rv = gfBuildPath(...$aPath);

  if (!$rv) {
    return null;
  }

  if ($aDomain === 'link') {
    $rv = $gaRuntime['currentScheme'] . SCHEME_SUFFIX .
          $gaRuntime['currentSubDomain'] . DOT . $gaRuntime['currentDomain'] . $rv;
  }
  else {
    $rv = $aDomain . $rv;
  }

  if (is_array($aQueryArguments)) {
    $query = http_build_query($aQueryArguments, EMPTY_STRING, null, PHP_QUERY_RFC3986);

    if ($query && $query != EMPTY_STRING) {
      $rv .= '?' . gfSubst('str', ['%40' => "@", '%7B' => "{", '%7D' => "}"], $query);
    }
  }

  return $rv;
}

/**********************************************************************************************************************
* Get a subdomain or base domain from a host
*
* @dep DOT
* @dep gfExplodeString()
* @param $aHost       Hostname
* @param $aReturnSub  Should return subdmain
* @returns            domain or subdomain
***********************************************************************************************************************/
function gfGetDomain($aHost, $aReturnSub = null) {
  $host = gfExplodeString(DOT, $aHost);
  $domainSlice = $aReturnSub ? array_slice($host, 0, -2) : array_slice($host, -2, 2);
  $rv = implode(DOT, $domainSlice);
  return $rv;
}

/**********************************************************************************************************************
* Includes a module
*
* @dep MODULES - Phoebus-Style Array Constant
* @dep gfError()
* @param $aModules    List of modules
**********************************************************************************************************************/
function gfImportModules(...$aModules) {
  if (!defined('MODULES')) {
    gfError('MODULES is not defined');
  }

  foreach ($aModules as $_value) {
    if (is_array($_value)) {
      if (str_starts_with($_value[0], 'static:')) {
        gfError('Cannot initialize a static class with arguments.');
      }

      $include = str_replace('static:' , EMPTY_STRING, $_value[0]);
      $className = 'class' . ucfirst($_value[0]);
      $moduleName = 'gm' . ucfirst($_value[0]);
      unset($_value[0]);
      $args = array_values($_value);
    }
    else {
      $include = str_replace('static:' , EMPTY_STRING, $_value);
      $className = str_starts_with($_value, 'static:') ? false : 'class' . ucfirst($include);
      $moduleName = 'gm' . ucfirst($include);
      $args = null;
    }
   
    if (array_key_exists($moduleName, $GLOBALS)) {
      gfError('Module ' . $include . ' has already been imported.');
    }

    if (!array_key_exists($include, MODULES)) {
      gfError('Unable to import unknown module ' . $include . DOT);
    }

    require(MODULES[$include]);

    if ($args) {
      $GLOBALS[$moduleName] = new $className(...$args);
    }
    else {
      $GLOBALS[$moduleName] = ($className === false) ? true : new $className();
    }
  }
}

/**********************************************************************************************************************
* Check if a module has been included
*
* @dep EMPTY_ARRAY
* @dep gfError()
* @param $aClass      Class name
* @param $aIncludes   List of includes
**********************************************************************************************************************/
function gfEnsureModules($aClass, ...$aIncludes) { 
  if (!$aClass) {
    $aClass = "Global";
  }

  if (empty($aIncludes)) {
    gfError('You did not specify any modules');
  }
  
  $unloadedModules = EMPTY_ARRAY;
  $indicative = ' is ';
  foreach ($aIncludes as $_value) {
    $moduleName = 'gm' . ucfirst($_value);

    if ($_value == 'vc') {
      $moduleName = 'gm' . strtoupper($_value);
    }

    if (!array_key_exists($moduleName, $GLOBALS)) {
      $unloadedModules[] = $_value;
    }
  }

  if (count($unloadedModules) > 0) {
    if (count($unloadedModules) > 1) {
      $indicative = ' are ';
    }

    gfError(implode(', ', $unloadedModules) . $indicative . 'required for ' . $aClass);
  }
}


/**********************************************************************************************************************
* Read file (decode json if the file has that extension or parse install.rdf if that is the target file)
*
* @dep JSON_EXTENSION
* @dep gfError()
* @dep gfSuperVar()
* @dep $gmAviary - Conditional
* @param $aFile     File to read
* @returns          file contents or array if json
                    null if error, empty string, or empty array
**********************************************************************************************************************/
function gfReadFile($aFile) {
  $file = @file_get_contents($aFile);

  // Automagically decode json
  if (str_ends_with($aFile, JSON_EXTENSION)) {
    $file = json_decode($file, true);
  }

  // If it is a mozilla install manifest and the module has been included then parse it
  if (str_ends_with($aFile, RDF_INSTALL_MANIFEST) && array_key_exists('gmAviary', $GLOBALS)) {
    global $gmAviary;
    $file = $gmAviary->parseInstallManifest($file);

    if (is_string($file)) {
      gfError('RDF Parsing Error: ' . $file);
    }
  }

  return gfSuperVar('var', $file);
}

/**********************************************************************************************************************
* Read file from zip-type archive
*
* @dep gfReadFile()
* @param $aArchive  Archive to read
* @param $aFile     File in archive
* @returns          file contents or array if json
                    null if error, empty string, or empty array
**********************************************************************************************************************/
function gfReadFileFromArchive($aArchive, $aFile) {
  return gfReadFile('zip://' . $aArchive . "#" . $aFile);
}

/**********************************************************************************************************************
* Write file (encodes json if the file has that extension)
*
* @dep JSON_EXTENSION
* @dep JSON_ENCODE_FLAGS
* @dep FILE_WRITE_FLAGS
* @dep gfSuperVar()
* @param $aData     Data to be written
* @param $aFile     File to write
* @returns          true else return error string
**********************************************************************************************************************/
function gfWriteFile($aData, $aFile, $aRenameFile = null, $aOverwrite = null) {
  if (!gfSuperVar('var', $aData)) {
    return 'No useful data to write';
  }

  if ($aOverwrite && $file_exists($aFile)) {
    return 'File already exists';
  }

  if (str_ends_with($aFile, JSON_EXTENSION)) {
    $aData = json_encode($aData, JSON_ENCODE_FLAGS);
  }

  $file = @file_put_contents($aFile, $aData);

  if ($file === false) {
    return 'Could not write file';
  }

  if ($aRenameFile) {
    rename($aFile, $aRenameFile);
  }

  return true;
}

/**********************************************************************************************************************
* Generate a random hexadecimal string
*
* @param $aLength   Desired number of final chars
* @returns          Random hexadecimal string of desired length
**********************************************************************************************************************/
function gfHexString($aLength = 40) {
  return bin2hex(random_bytes(($aLength <= 1) ? 1 : (int)($aLength / 2)));
}

/**********************************************************************************************************************
* Request HTTP Basic Authentication
*
* @dep SOFTWARE_NAME
* @dep gfError()
***********************************************************************************************************************/
function gfBasicAuthPrompt() {
  header('WWW-Authenticate: Basic realm="' . SOFTWARE_NAME . '"');
  header('HTTP/1.0 401 Unauthorized');   
  gfError('You need to enter a valid username and password.');
}

/**********************************************************************************************************************
* Hash a password
***********************************************************************************************************************/
function gfPasswordHash($aPassword, $aCrypt = PASSWORD_BCRYPT, $aSalt = null) {
  $ePrefix = __FUNCTION__ . DASH_SEPARATOR;

  // We can "hash" a cleartext password by prefixing it with the fake algo prefix $clear$
  if ($aCrypt == PASSWORD_CLEARTEXT) {
    if (str_contains($aPassword, DOLLAR)) {
      // Since the dollar sign is used as an identifier and/or separator for hashes we can't use passwords
      // that contain said dollar sign.
      gfError($ePrefix . 'Cannot "hash" this Clear Text password because it contains a dollar sign.');
    }

    return DOLLAR . PASSWORD_CLEARTEXT . DOLLAR . time() . DOLLAR . $aPassword;
  }

  // We want to be able to generate Apache APR1-MD5 hashes for use in .htpasswd situations.
  if ($aCrypt == PASSWORD_HTACCESS) {
    $salt = $aSalt;

    if (!$salt) {
      $salt = EMPTY_STRING;

      for ($i=0; $i<8; $i++) {
        $offset = hexdec(bin2hex(openssl_random_pseudo_bytes(1))) % 64;
        $salt .= APRMD5_ALPHABET[$offset];
      }
    }

    $salt = substr($salt, 0, 8);
    $max = strlen($aPassword);
    $context = $aPassword . DOLLAR . PASSWORD_HTACCESS . DOLLAR .$salt;
    $binary = pack('H32', md5($aPassword . $salt . $aPassword));

    for ($i=$max; $i>0; $i-=16) {
      $context .= substr($binary, 0, min(16, $i));
    }

    for ($i=$max; $i>0; $i>>=1) {
      $context .= ($i & 1) ? chr(0) : $aPassword[0];
    }

    $binary = pack('H32', md5($context));

    for ($i=0; $i<1000; $i++) {
      $new = ($i & 1) ? $aPassword : $binary;

      if ($i % 3) {
        $new .= $salt;
      }
      if ($i % 7) {
        $new .= $aPassword;
      }

      $new .= ($i & 1) ? $binary : $aPassword;
      $binary = pack('H32', md5($new));
    }

    $hash = EMPTY_STRING;

    for ($i = 0; $i < 5; $i++) {
      $k = $i+6;
      $j = $i+12;
      if($j == 16) $j = 5;
      $hash = $binary[$i] . $binary[$k] . $binary[$j] . $hash;
    }

    $hash = chr(0) . chr(0) . $binary[11] . $hash;
    $hash = strtr(strrev(substr(base64_encode($hash), 2)), BASE64_ALPHABET, APRMD5_ALPHABET);

    return DOLLAR . PASSWORD_HTACCESS . DOLLAR . $salt . DOLLAR . $hash;
  }

  // Else, our standard (and secure) default is PASSWORD_BCRYPT hashing.
  // We do not allow custom salts for anything using password_hash as PHP generates secure salts.
  // PHP Generated passwords are also self-verifiable via password_verify.
  return password_hash($aPassword, $aCrypt);
}

/**********************************************************************************************************************
* Check a password
***********************************************************************************************************************/
function gfPasswordVerify($aPassword, $aHash) {
  $ePrefix = __FUNCTION__ . DASH_SEPARATOR;

  // We can accept a pseudo-hash for clear text passwords in the format of $clrtxt$unix-epoch$clear-text-password
  if (str_starts_with($aHash, DOLLAR . PASSWORD_CLEARTEXT)) {
    $password = gfExplodeString(DOLLAR, $aHash) ?? null;

    if ($password == null || count($password) > 3) {
      gfError($ePrefix . 'Unable to "verify" this Clear Text "hashed" password.');
    }

    return $aPassword === $password[2];
  }

  // We can also accept an Apache APR1-MD5 password that is commonly used in .htpasswd
  if (str_starts_with($aHash, DOLLAR . PASSWORD_HTACCESS)) {
    $salt = gfExplodeString(DOLLAR, $aHash)[1] ?? null;

    if(!$salt) {
      gfError($ePrefix . 'Unable to verify this Apache APR1-MD5 hashed password.');
    }

    return gfPasswordHash($aPassword, PASSWORD_HTACCESS, $salt) === $aHash;
  }

  // For everything else send to the native password_verify function.
  // It is almost certain to be a BCRYPT2 hash but hashed passwords generated BY PHP are self-verifiable.
  return password_verify($aPassword, $aHash);
}

/**********************************************************************************************************************
* Create an XML Document 
***********************************************************************************************************************/
function gfCreateXML($aData, $aDirectOutput = null) {
  $dom = new DOMDocument('1.0');
  $dom->encoding = "UTF-8";
  $dom->formatOutput = true;

  $processChildren = function($aData) use (&$dom, &$processChildren) {
    if (!($aData['@element'] ?? null)) {
      return false;
    }

    // Create the element
    $element = $dom->createElement($aData['@element']);

    // Properly handle content using XML and not try and be lazy.. It almost never works!
    if (array_key_exists('@content', $aData) && is_string($aData['@content'])) {
      if (str_contains($aData['@content'], "<") || str_contains($aData['@content'], ">") || str_contains($aData['@content'], "?") ||
          str_contains($aData['@content'], "&") || str_contains($aData['@content'], "'") || str_contains($aData['@content'], '"')) {
        $content = $dom->createCDATASection($aData['@content'] ?? EMPTY_STRING);
      }
      else {
        $content = $dom->createTextNode($aData['@content'] ?? EMPTY_STRING);
      }

      $element->appendChild($content);
    }
   
    // Add any attributes
    if (!empty($aData['@attributes']) && is_array($aData['@attributes'])) {
      foreach ($aData['@attributes'] as $_key => $_value) {
        $element->setAttribute($_key, $_value);
      }
    }
   
    // Any other items in the data array should be child elements
    foreach ($aData as $_key => $_value) {
      if (!is_numeric($_key)) {
        continue;
      }
   
      $child = $processChildren($_value);
      if ($child) {
        $element->appendChild($child);
      }
    }
   
    return $element;
  };

  $child = $processChildren($aData);
  $xml = null;

  if ($child) {
    $dom->appendChild($child);
  }

  $xml = $dom->saveXML();

  if (!$xml) {
    gfError('Could not generate xml/rdf.');
  }

  if ($aDirectOutput) {
    gfOutput($xml, 'xml');
  }

  return $xml;
}

/**********************************************************************************************************************
* Show dates in different forms from epoch (or any value that date() accepts.. 
***********************************************************************************************************************/
function gfDate($aTypeOrFormat, $aDateStamp, $aReturnTime = null) {
  if ($aTypeOrFormat == 'buildNumber') {
    return date_diff(date_create(date('Y-m-D', $aDateStamp)), date_create('2000-01-01'))->format('%a');
  }

  $format = EMPTY_STRING;

  switch ($aTypeOrFormat) {
    case 'standard':
      $format = $aReturnTime ? 'Y-m-D, H:i' : 'Y-m-D';
      break;
    case 'longUS':
      $format = $aReturnTime ? 'F j, Y, H:i' : 'F j, Y';
      break;
    case 'shortUS':
      $format = $aReturnTime ? 'm-d-Y, H:i' : 'm-d-Y';
      break;
    case 'eDate':
      $format = 'Ymd.Hi';
      break;
    case 'buildDate':
      $format = 'YmdHi';
      break;
    default:
      $format = $aTypeOrFormat;
  }

  $rv = date($format, $aDateStamp);

  if (!$rv) {
    return $aDateStamp;
  }

  return $rv;
}

/**********************************************************************************************************************
* Simple and almost certainly painless hack to convert an object into an array
***********************************************************************************************************************/
function gfObjectToArray($aObject) {
  return json_decode(json_encode($aObject), true);
}

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
  $ePrefix = __FUNCTION__ . DASH_SEPARATOR;
  $skinPath = '/skin/default';

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
        $aLegacyContent = json_encode($aLegacyContent, JSON_ENCODE_FLAGS);
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
    

    if (!$aError && ($GLOBALS['gaRuntime']['qTestCase'] ?? null)) {
      $pageSubsts['{$PAGE_TITLE}'] = 'Test Case' . DASH_SEPARATOR . $GLOBALS['gaRuntime']['qTestCase'];

      foreach ($GLOBALS['gaRuntime']['siteMenu'] ?? EMPTY_ARRAY as $_key => $_value) {
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
        $pageSubsts['{$PAGE_CONTENT}'] = $textboxContent(json_encode($aMetadata['content'], JSON_ENCODE_FLAGS));
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
    $pageSubsts['{$SITE_MENU}'] = '<li><a href="/">Home</a></li>';
  }

  $template = gfSubst('string', $pageSubsts, $template);

  // If we are generating an error from gfError we want to clean the output buffer
  if ($aError) {
    ob_get_clean();
  }

  // Send an html header
  gfHeader('html');

  // write out the everything
  print($template);

  // We're done here
  exit();
}

/**********************************************************************************************************************
* Checks for old versions
*
* @param $aFeature    feature
* @param $aReturn     if true we will return a value else 404
***********************************************************************************************************************/
function gfValidClientVersion($aCheckVersion = null, $aVersion = null) {
  global $gaRuntime;

  $currentApplication = $gaRuntime['currentApplication'];

  // No user agent is a blatantly bullshit state
  if (!$gaRuntime['userAgent']) {
    gfError('Reference Code - ID-10-T');
  }

  // Knock the UA to lowercase so it is easier to deal with
  $userAgent = strtolower($gaRuntime['userAgent']);

  // Check for invalid clients
  foreach (['curl/', 'wget/', 'git/'] as $_value) {
    if (str_contains($userAgent, $_value)) {
      gfError('Reference Code - ID-10-T');
    }
  }

  // This function doesn't work in unifiedMode when the application hasn't been determined yet.
  if ($gaRuntime['unifiedMode'] && is_bool($currentApplication)) {
    return true;
  }

  // ------------------------------------------------------------------------------------------------------------------

  // This is our basic client ua check.
  if (!$aCheckVersion) {
    $oldAndInsecureHackJobs = ['nt 5', 'nt 6.0', 'bsd', 'intel', 'ppc', 'mac', 'iphone', 'ipad', 'ipod', 'android',
                               'goanna/3.5', 'goanna/4.0', 'rv:3.5', 'rv:52.9', 'basilisk/', '55.0', 'mypal/',
                               'centaury/', 'bnavigator/'];

    // Check for old and insecure Windows versions and enemy hackjobs
    foreach ($oldAndInsecureHackJobs as $_value) {
      if (str_contains($userAgent, $_value)) {
        return false;
      }
    }

    // Check if the application slice matches the current site.
    if (!str_contains($userAgent, $currentApplication)) {
      return false;
    }

    return true;
  }

  // ------------------------------------------------------------------------------------------------------------------

  // This is the main meat of this function. To detect old and insecure application versions
  // Try to find the position of the application slice in the UA
  $uaVersion = strpos($userAgent, $currentApplication . SLASH);

  // Make sure we have a position for the application slice
  // If we don't then it ain't gonna match the current add-ons site
  if ($uaVersion === false) {
    return false;
  }

  // Extract the application slice by slicing off everything before it
  // UXP Applications ALWAYS have the application slice at the end of the UA
  $uaVersion = substr($userAgent, $uaVersion, $uaVersion);

  // Extract the application version
  $uaVersion = str_replace($currentApplication . SLASH, EMPTY_STRING, $uaVersion);

  // Make sure we actually have a string
  if (!gfSuperVar('var', $uaVersion)) {
    return false;
  }

  // Set currentVersion to the supplied version else the extracted version from the ua
  $currentVersion = $aVersion ?? $uaVersion;

  // ------------------------------------------------------------------------------------------------------------------

  // Set the old version to compare against 
  $maxOldVersion = TARGET_APPLICATION[$currentApplication]['maxOldVersion'];

  // If we are supplying the version number to check make sure it actually matches the UA.
  if ($aVersion && ($currentVersion != $uaVersion)) {
    return false;
  }

  // NOW we can compare it against the old version.. Finally.
  if (ToolkitVersionComparator::compare($currentVersion, $maxOldVersion) <= 0) {
    return false;
  }

  // Welp, seems it is newer than the currently stated old version so pass
  return true;
}

/**********************************************************************************************************************
* TBD
***********************************************************************************************************************/
function gfGetAppDomainByID($aAppID) {
  global $gaRuntime;
  $targetApplication = array_combine(array_column(TARGET_APPLICATION, 'id'),
                                     array_column(TARGET_APPLICATION, 'domain'));

  return $targetApplication[$aAppID] ?? $gaRuntime['currentSubdomain'] . DOT . $gaRuntime['currentDomain'];
}

/**********************************************************************************************************************
* TBD
***********************************************************************************************************************/
function gfGetAppDomainByName($aAppName) {
  global $gaRuntime;
  $targetApplication = array_combine(array_keys(TARGET_APPLICATION),
                                     array_column(TARGET_APPLICATION, 'domain'));

  return $targetApplication[$aAppName] ?? $gaRuntime['currentSubdomain'] . DOT . $gaRuntime['currentDomain'];
}

/**********************************************************************************************************************
* TBD
***********************************************************************************************************************/
function gfGetAppNameByID($aAppID) {
  global $gaRuntime;
  $targetApplication = array_combine(array_column(TARGET_APPLICATION, 'id'),
                                     array_keys(TARGET_APPLICATION));

  return $targetApplication[$aAppID] ?? $gaRuntime['currentApplication'];
}

/**********************************************************************************************************************
* Get the bitwise value of valid applications from a list of application ids
*
* @param $aTargetApplications   list of targetApplication ids
* @returns                      bitwise int value representing applications
***********************************************************************************************************************/
function gfGetClientBits($aTargetApplications) {
  if (!is_array($aTargetApplications)) {
    gfError(__FUNCTION__ . ': You must supply an array of ids');
  }

  if (!array_is_list($aTargetApplications)) {
    $aTargetApplications = array_keys($aTargetApplications);
  }

  $applications = array_combine(array_column(TARGET_APPLICATION, 'id'), array_column(TARGET_APPLICATION, 'bit'));
  $applicationBits = 0;

  foreach ($applications as $_key => $_value) {
    if (in_array($_key, $aTargetApplications)) {
      $applicationBits |= $_value;
    }
  }

  return $applicationBits;
}

/**********************************************************************************************************************
* Check if the application has the supplied feature
***********************************************************************************************************************/
function gfCheckFeature($aFeature, $aReturn = null) {
  global $gaRuntime;

  if (is_bool($gaRuntime['currentApplication'])) {
    gfError(__FUNCTION__ . ': Unable to determine the application features.');
  }
  
  if (!in_array($aFeature, TARGET_APPLICATION[$gaRuntime['currentApplication']]['features'])) {
    if (!$aReturn) {
      gfErrorOr404('Feature' . SPACE . $aFeature . SPACE . 'is not enabled for' . SPACE .
                   $gaRuntime['currentApplication']);
    }
    return false;
  }

  return true;
}

/**********************************************************************************************************************
* Get categories for a specific XPINSTALL type
***********************************************************************************************************************/
function gfGetCategoriesByType($aType) {
  return gfSuperVar('check', array_filter(CATEGORIES, function($aCat) use($aType) { return $aCat['type'] &= $aType; }));
}

// ====================================================================================================================

// == | Main | ========================================================================================================

// Define an array that will hold the current application state
$gaRuntime = array(
  'currentPath'         => null,
  'currentDomain'       => null,
  'currentSubDomain'    => null,
  'currentScheme'       => gfSuperVar('server', 'SCHEME') ?? (gfSuperVar('server', 'HTTPS') ? 'https' : 'http'),
  'currentSkin'         => 'default',
  'debugMode'           => DEBUG_MODE,
  'offlineMode'         => file_exists(ROOT_PATH . '/.offline') && !gfSuperVar('get', 'overrideOffline'),
  'remoteAddr'          => gfSuperVar('server', 'HTTP_X_FORWARDED_FOR') ?? gfSuperVar('server', 'REMOTE_ADDR'),
  'userAgent'           => gfSuperVar('server', 'HTTP_USER_AGENT'),
  'phpServerName'       => gfSuperVar('server', 'SERVER_NAME'),
  'phpRequestURI'       => gfSuperVar('server', 'REQUEST_URI'),
  'qComponent'          => gfSuperVar('get', 'component'),
  'qPath'               => gfSuperVar('get', 'path'),
  'qApplication'        => gfSuperVar('get', 'appOverride'),
  'currentApplication'  => null,
  'orginalApplication'  => null,
  'unifiedMode'         => null,
  'unifiedApps'         => null,
  'validClient'         => null,
  'validVersion'        => null,
  'debugMode'           => (gfSuperVar('server', 'SERVER_NAME') == DEVELOPER_DOMAIN) ?
                           !DEBUG_MODE : gfSuperVar('get', 'debugOverride'),
);

// --------------------------------------------------------------------------------------------------------------------

// Root (/) won't set a component or path
if (!$gaRuntime['qComponent'] && !$gaRuntime['qPath']) {
  $gaRuntime['qComponent'] = 'site';
  $gaRuntime['qPath'] = SLASH;
}

// --------------------------------------------------------------------------------------------------------------------

// Set the current domain and subdomain
$gaRuntime['currentDomain'] = gfSuperVar('check', gfGetDomain($gaRuntime['phpServerName']));
$gaRuntime['currentSubDomain'] = gfSuperVar('check', gfGetDomain($gaRuntime['phpServerName'], true));

// --------------------------------------------------------------------------------------------------------------------

// If we have a path we want to explode it into an array and count it
if ($gaRuntime['qPath']) {
  // Explode the path if it exists
  $gaRuntime['currentPath'] = gfExplodePath($gaRuntime['qPath']);

  // Get a count of the exploded path
  $gaRuntime['pathCount'] = count($gaRuntime['currentPath']);
}

// --------------------------------------------------------------------------------------------------------------------

// Decide which application by domain that the software will be serving
$gaRuntime['currentApplication'] = APPLICATION_DOMAINS[$gaRuntime['currentDomain']] ?? null;

if (!$gaRuntime['currentApplication']) {
  if ($gaRuntime['debugMode']) {
    gfError('Invalid domain/application');
  }

  // We want to be able to give blank responses to any invalid domain/application
  // when not in debug mode
  $gaRuntime['offlineMode'] = true;
}

// See if this is a unified add-ons site
if (is_array($gaRuntime['currentApplication'])) {
  $gaRuntime['unifiedMode'] = true;
  $gaRuntime['unifiedApps'] = $gaRuntime['currentApplication'];
  $gaRuntime['currentApplication'] = true;
}

// ------------------------------------------------------------------------------------------------------------------

// Site Offline
if ($gaRuntime['offlineMode']) {
  $gvOfflineMessage = 'This site is currently unavailable. Please try again later.';

  // Development offline message
  if (str_contains(SOFTWARE_VERSION, 'a') || str_contains(SOFTWARE_VERSION, 'b') ||
      str_contains(SOFTWARE_VERSION, 'pre') || $gaRuntime['debugMode']) {
    $gvOfflineMessage = 'This in-development version of'. SPACE . SOFTWARE_NAME . SPACE . 'is not for public consumption.';
  }

  switch ($gaRuntime['qComponent']) {
    case 'aus':
      gfOutput(XML_TAG . RDF_AUS_BLANK, 'xml');
      break;
    case 'integration':
      $gaRuntime['qAPIScope'] = gfSuperVar('get', 'type');
      $gaRuntime['qAPIFunction'] = gfSuperVar('get', 'request');
      if ($gaRuntime['qAPIScope'] != 'internal') {
        gfHeader(404);
      }
      switch ($gaRuntime['qAPIFunction']) {
        case 'search':
          gfOutput(XML_TAG . XML_API_SEARCH_BLANK, 'xml');
          break;      
        case 'get':
        case 'recommended':
          gfOutput(XML_TAG . XML_API_LIST_BLANK, 'xml');
          break;
        default:
          gfHeader(404);
      }
      break;
    case 'discover':
      gfHeader(404);
    default:
      gfError($gvOfflineMessage);
  }
}

// ------------------------------------------------------------------------------------------------------------------

// Items that get changed depending on debug mode
if ($gaRuntime['debugMode']) {
  // In debug mode we need to test other applications
  if ($gaRuntime['qApplication']) {
    // We can't test an application that doesn't exist
    if (!array_key_exists($gaRuntime['qApplication'], TARGET_APPLICATION)) {
      gfError('Invalid override application');
    }

    // Stupidity check
    if ($gaRuntime['qApplication'] == $gaRuntime['currentApplication']) {
      gfError('It makes no sense to override to the same application');
    }

    // Set the application
    $gaRuntime['orginalApplication'] = $gaRuntime['currentApplication'];
    $gaRuntime['currentApplication'] = $gaRuntime['qApplication'];

    // If this is a unified add-ons site then we need to try and figure out the domain
    if (in_array('unified', TARGET_APPLICATION[$gaRuntime['currentApplication']]['features'])) {
      // Switch unified mode on
      $gaRuntime['unifiedMode'] = true;

      // Loop through the domains
      foreach (APPLICATION_DOMAINS as $_key => $_value) {
        // Skip any value that isn't an array
        if (!is_array($_value)) {
          continue;
        }

        // If we hit a domain with the requested application then set unifiedApps
        if (in_array($gaRuntime['currentApplication'], $_value)) {
          $gaRuntime['unifiedApps'] = $_value;
          $gaRuntime['currentApplication'] = true;
          break;
        }
      }

      // Final check to make sure we have a unified domain figured out
      if (!$gaRuntime['unifiedApps']) {
        gfError('Unable to switch to unified mode');
      }
    }
  }
}

// ------------------------------------------------------------------------------------------------------------------

// We need nsIVersionComparator from this point on
gfImportModules('static:vc');

// Set valid client
$gaRuntime['validClient'] = gfValidClientVersion();
$gaRuntime['validVersion'] = gfValidClientVersion(true);

// Determine if we should redirect Pale Moon clients back to addons-legacy
$gaRuntime['phoebusRedirect'] = ($gaRuntime['currentApplication'] == 'palemoon' &&
                                 $gaRuntime['validClient'] && !$gaRuntime['validVersion']);

if ($gaRuntime['phoebusRedirect']) {
  switch ($gaRuntime['qComponent']) {
    case 'aus':
    case 'integration':
    case 'discover':
      gfRedirect('https://addons-legacy.palemoon.org/?' . gfSuperVar('server', 'QUERY_STRING'));
      break;
    case 'site':
    case 'panel':
      gfRedirect('https://addons-legacy.palemoon.org' . $gaRuntime['qPath']);
      break;
    default:
      gfErrorOr404('Invalid legacy request.');
  }
}

// ------------------------------------------------------------------------------------------------------------------

// If we have a path then explode it and check for component pretty-paths
if ($gaRuntime['currentPath']) {
  // These paths override the site component
  switch ($gaRuntime['currentPath'][0]) {
    case 'special':
    case 'panel':
      $gaRuntime['qComponent'] = $gaRuntime['currentPath'][0];
      break;
  }
}


// --------------------------------------------------------------------------------------------------------------------

if (!defined("COMPONENTS")) {
  define("COMPONENTS", ['site' => ROOT_PATH . BASE_RELPATH . 'site.php',
                        'special' => ROOT_PATH . BASE_RELPATH . 'special.php']);
  if (($gaRuntime['currentPath'][0] ?? null) == 'special') {
    $gaRuntime['qComponent'] = 'special';
  }
}

// Load component based on qComponent
if ($gaRuntime['qComponent'] && array_key_exists($gaRuntime['qComponent'], COMPONENTS)) {
  $gvComponentFile = COMPONENTS[$gaRuntime['qComponent']];

  if (!file_exists($gvComponentFile)) {
    if ($gaRuntime['qComponent'] == 'site') {
      gfError('Could not load site component.');
    }
    else {
      gfErrorOr404('Cannot load the' . SPACE . $gaRuntime['qComponent'] . SPACE . 'component.');
    }
  }

  require_once($gvComponentFile);
}
else {
  gfErrorOr404('Invalid component.');
}


// ====================================================================================================================

?>