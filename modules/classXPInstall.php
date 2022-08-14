<?php
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this
// file, You can obtain one at http://mozilla.org/MPL/2.0/.

class classXPInstall {
  /********************************************************************************************************************
   * Known Application IDs
   * Application IDs are normally in the form of a {GUID} or user@host ID.
   *
   * Mozilla Suite:             {86c18b42-e466-45a9-ae7a-9b95ba6f5640}
   * Firefox:                   {ec8030f7-c20a-464f-9b0e-13a3a9e97384}
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
   * Pale Moon 25+:             {8de7fcbb-c55c-4fbe-bfc5-fc555c87dbc4}
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
  ********************************************************************************************************************/

  /********************************************************************************************************************
  * Class constants
  ********************************************************************************************************************/
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
    'borealis' => array(
      'id'            => '{86c18b42-e466-4580-8b97-957ad5f8ea47}',
      'bit'           => 2,
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
      'bit'           => 4,
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

  // ------------------------------------------------------------------------------------------------------------------

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
  const VALID_XPI_TYPES   = self::XPINSTALL_TYPES['extension'] | self::XPINSTALL_TYPES['theme'] |
                            self::XPINSTALL_TYPES['locale'] | self::XPINSTALL_TYPES['dictionary'];

  // These are add-on types only Phobos understands. They are NOT installable in the application directly
  // We will treat them as any other xpi but deliver them to the client in different ways
  const EXTRA_XPI_TYPES   = self::XPINSTALL_TYPES['persona'] | self::XPINSTALL_TYPES['search-plugin'] |
                            self::XPINSTALL_TYPES['user-script'] | self::XPINSTALL_TYPES['user-style'];

  // These are unsupported "real" XPInstall types (plus external because it is completely virtual)
  const INVALID_XPI_TYPES = self::XPINSTALL_TYPES['app'] | self::XPINSTALL_TYPES['plugin'] | self::XPINSTALL_TYPES['multipackage'] |
                            self::XPINSTALL_TYPES['experiment'] | self::XPINSTALL_TYPES['apiextension'] | self::XPINSTALL_TYPES['external'];

  // Originally XPInstall only needed to a handful of types since it was killed much refactoring and Olympia reused
  // older types. We are gonna match that for now even if they aren't actually implemented. 
  const AUS_XPI_TYPES = array(
    self::XPINSTALL_TYPES['extension']      => 'extension',
    self::XPINSTALL_TYPES['theme']          => 'theme',
    self::XPINSTALL_TYPES['dictionary']     => 'extension',
    self::XPINSTALL_TYPES['search-plugin']  => 'search',
    self::XPINSTALL_TYPES['locale']         => 'item',
    self::XPINSTALL_TYPES['persona']        => 'background-theme',
  );

  // Add-ons Manager Search uses the Olympia types so map the XPInstall Types to Olympia which match the Add-ons Manager
  const SEARCH_XPI_TYPES = array(
    self::XPINSTALL_TYPES['extension']      => 1,
    self::XPINSTALL_TYPES['theme']          => 2,
    self::XPINSTALL_TYPES['dictionary']     => 3,
    self::XPINSTALL_TYPES['search-plugin']  => 4,
    self::XPINSTALL_TYPES['locale']         => 5,
    self::XPINSTALL_TYPES['persona']        => 9,
  );

  // ------------------------------------------------------------------------------------------------------------------

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

  // ------------------------------------------------------------------------------------------------------------------

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

  // ------------------------------------------------------------------------------------------------------------------

  const SECTIONS = array(
    'extensions'      => array('type'        => self::XPINSTALL_TYPES['extension'],
                               'name'        => 'Extensions',
                               'description' =>
                                 'Extensions are small add-ons that add new functionality to {%APPLICATION_SHORTNAME},' . SPACE .
                                 'from a simple toolbar button to a completely new feature.' . SPACE .
                                 'They allow you to customize the {%APPLICATION_COMMONTYPE} to fit your own needs' . SPACE .
                                 'and preferences, while keeping the core itself light and lean.'
                              ),
    'themes'          => array('type'        => self::XPINSTALL_TYPES['theme'],
                               'name'        => 'Themes',
                               'description' =>
                                 'Themes allow you to change the look and feel of the user interface' . SPACE .
                                 'and personalize it to your tastes.' . SPACE .
                                 'A theme can simply change the colors of the UI or it can change every aspect of its appearance.'
                              ),
    'language-packs'  => array('type'        => self::XPINSTALL_TYPES['locale'],
                               'name'        => 'Language Packs',
                               'description' => 'These add-ons provide strings for the user interface in your local language.'
                              ),
    'dictionaries'    => array('type'        => self::XPINSTALL_TYPES['dictionary'],
                               'name'        => 'Dictionaries',
                               'description' =>
                                 '{%APPLICATION_SHORTNAME} has spell checking features, with this type of add-on' . SPACE .
                                 'you can add check the spelling in additional languages.'
                              ),
    'personas'        => array('type'        => self::XPINSTALL_TYPES['persona'],
                               'name'        => 'Personas',
                               'description' => 'Lightweight themes which allow you personalize {%APPLICATION_SHORTNAME} further.'
                              ),
    'search-plugins'  => array('type'        => self::XPINSTALL_TYPES['search-plugin'],
                               'name'        => 'Search Plugins',
                               'description' =>
                                 'A search plugin provides the ability to access a search engine from a web browser,' . SPACE .
                                 'without having to go to the engine\'s website first.<br />' .
                                 'Technically, a search plugin is a small Extensible Markup Language file that tells' . SPACE .
                                 'the browser what information to send to a search engine and how the results are to be retrieved. '
                              ),
    'user-scripts'    => ['type' => self::XPINSTALL_TYPES['user-script'], 'name' => 'User Scripts', 'description' => null],
    'user-styles'     => ['type' => self::XPINSTALL_TYPES['user-style'], 'name' => 'User Styles', 'description' => null],
  );

  // ------------------------------------------------------------------------------------------------------------------

  const CATEGORIES = array(
    'unlisted'                  => ['bit' => 0,         'name' => 'Unlisted', 'type' => 0],
    'alerts-and-updates'        => ['bit' => 1,         'name' => 'Alerts &amp; Updates',
                                    'type' => self::XPINSTALL_TYPES['extension']],
    'appearance'                => ['bit' => 2,         'name' => 'Appearance',
                                    'type' => self::XPINSTALL_TYPES['extension']],
    'bookmarks-and-tabs'        => ['bit' => 4,         'name' => 'Bookmarks &amp; Tabs',
                                    'type' => self::XPINSTALL_TYPES['extension']],
    'download-management'       => ['bit' => 8,         'name' => 'Download Management',
                                    'type' => self::XPINSTALL_TYPES['extension'],],
    'feeds-news-and-blogging'   => ['bit' => 16,        'name' => 'Feeds, News, &amp; Blogging',
                                    'type' => self::XPINSTALL_TYPES['extension'],],
    'privacy-and-security'      => ['bit' => 32,        'name' => 'Privacy &amp; Security',
                                    'type' => self::XPINSTALL_TYPES['extension']],
    'search-tools'              => ['bit' => 64,        'name' => 'Search Tools',
                                    'type' => self::XPINSTALL_TYPES['extension']],
    'social-and-communication'  => ['bit' => 128,       'name' => 'Social &amp; Communication',
                                    'type' => self::XPINSTALL_TYPES['extension']],
    'tools-and-utilities'       => ['bit' => 256,       'name' => 'Tools &amp; Utilities',
                                    'type' => self::XPINSTALL_TYPES['extension']],
    'web-development'           => ['bit' => 512,       'name' => 'Web Development', 
                                    'type' => self::XPINSTALL_TYPES['extension']],
    'abstract'                  => ['bit' => 1024,      'name' => 'Abstract',
                                    'type' => self::XPINSTALL_TYPES['persona']],
    'brands'                    => ['bit' => 4096,      'name' => 'Brands',
                                    'type' => self::XPINSTALL_TYPES['persona']],
    'compact'                   => ['bit' => 8192,      'name' => 'Compact',
                                    'type' => self::XPINSTALL_TYPES['theme']],
    'dark'                      => ['bit' => 16384,     'name' => 'Dark',
                                    'type' => self::XPINSTALL_TYPES['theme'] | self::XPINSTALL_TYPES['persona']],
    'large'                     => ['bit' => 32768,     'name' => 'Large',
                                    'type' => self::XPINSTALL_TYPES['theme']],
    'modern'                    => ['bit' => 65536,     'name' => 'Modern',
                                    'type' => self::XPINSTALL_TYPES['theme']],
    'music'                     => ['bit' => 131072,    'name' => 'Music',
                                    'type' => self::XPINSTALL_TYPES['persona']],
    'nature'                    => ['bit' => 262144,    'name' => 'nature',
                                    'type' => self::XPINSTALL_TYPES['persona']],
    'other-web-clients'         => ['bit' => 524288,    'name' => 'Browsers, Explorers, &amp; Navigators',
                                    'type' => self::XPINSTALL_TYPES['theme']],
    'retro'                     => ['bit' => 1048576,   'name' => 'Retro &amp; Classic',
                                    'type' => self::XPINSTALL_TYPES['theme'] | self::XPINSTALL_TYPES['persona']],
    'os-integration'            => ['bit' => 2097152,   'name' => 'OS Integration',
                                    'type' => self::XPINSTALL_TYPES['theme']],
    'scenery'                   => ['bit' => 4194304,   'name' => 'Scenery',
                                    'type' => self::XPINSTALL_TYPES['persona']],
    'seasonal'                  => ['bit' => 8388608,   'name' => 'Seasonal',
                                    'type' => self::XPINSTALL_TYPES['persona']],
    'other'                     => ['bit' => 16777216,  'name' => 'Other',
                                    'type' => self::XPINSTALL_TYPES['extension'] | self::XPINSTALL_TYPES['theme'] | self::XPINSTALL_TYPES['persona']],
  );

  // ------------------------------------------------------------------------------------------------------------------

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

  /********************************************************************************************************************
  * Class constructor that sets initial state of things
  ********************************************************************************************************************/
  function __construct() {
    return true;
  }

  // XML Stuff and Things
  const RDF_NS        = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#';
  const EM_NS         = 'http://www.mozilla.org/2004/em-rdf#';
  const MF_RES        = 'urn:mozilla:install-manifest';
  const ANON_PREFIX   = '#genid';

  // ------------------------------------------------------------------------------------------------------------------

  // Single properties
  // em:multiprocessCompatible' em:hasEmbeddedWebExtension are considered invalid for gregoriantojd
  // The following props only currently matter to Phobos. We /may/ add these to the Add-ons Manager at some point.
  // em:slug, em:category, em:license, em:repositoryURL, em:supportURL, and em:supportEmail
  const SINGLE_PROPS    = ['id', 'type', 'version', 'creator', 'homepageURL', 'updateURL', 'updateKey', 'bootstrap',
                           'skinnable', 'strictCompatibility', 'iconURL', 'icon64URL', 'optionsURL', 'optionsType',
                           'aboutURL', 'iconURL', 'unpack', 'multiprocessCompatible', 'hasEmbeddedWebExtension',
                           'slug', 'category', 'license', 'repositoryURL', 'supportURL', 'supportEmail'];

  // Multiple properties (because this is shared with other methods we use a class constant)
  // According to documentation, em:file is supposed to be used as a fallback when no chrome.manifest exists.
  // It would then use em:file and old style contents.rdf to generate a chrome manifest but I cannot find
  // any existing code to facilitate this at our level.
  // em:additionalLicenses is a Phobos-only multi-prop
  const MULTI_PROPS     = ['contributor', 'developer', 'translator', 'otherLicenses',
                           'targetPlatform', 'localized', 'targetApplication'];

  /********************************************************************************************************************
  * Parses install.rdf using Rdf_parser class
  *
  * @param string     $aManifestData
  * @return array     $data["manifest"]
  ********************************************************************************************************************/
  public function parseInstallManifest($aManifestData, $aEmDevloperMerge = null) {
    $data = EMPTY_ARRAY;

    // ----------------------------------------------------------------------------------------------------------------

    // Setup the repat rdf parser
    require_once(LIBRARIES['rdfParser']);
    $rdf = new Rdf_parser();
    $rdf->rdf_parser_create(null);
    $rdf->rdf_set_user_data($data);
    $rdf->rdf_set_statement_handler(['classAviary', 'mfStatementHandler']);
    $rdf->rdf_set_base(EMPTY_STRING);

    // If the install manifest can't be parsed return why as a string.
    if (!$rdf->rdf_parse($aManifestData, strlen($aManifestData), true)) {
      $parseError = 'RDF Parsing Error' . COLON . SPACE .
                    xml_error_string(xml_get_error_code($rdf->rdf_parser['xml_parser'])) . NEW_LINE .
                    'Line Number' . SPACE . 
                    xml_get_current_line_number($rdf->rdf_parser['xml_parser']) . SPACE .
                    ', Column' . SPACE . xml_get_current_column_number($rdf->rdf_parser['xml_parser']) . DOT;
      return $parseError;
    }

    // ----------------------------------------------------------------------------------------------------------------

    // We need to resolve em:localized by attaching the associated genid data into the manifest data
    if (array_key_exists('localized', $data['manifest']) &&
        is_array($data['manifest']['localized'])) {
      $localized = ['name' => EMPTY_ARRAY, 'description' => EMPTY_ARRAY, 'contributor' => EMPTY_ARRAY,
                    'developer' => EMPTY_ARRAY, 'translator'  => EMPTY_ARRAY];

      foreach ($data['manifest']['localized'] as $_value) {
        if (!array_key_exists(self::EM_NS . 'locale', $data[$_value])) {
          continue;
        }

        if ($data[$_value][self::EM_NS . 'locale'] == 'en-US') {
          continue;
        }

        foreach ($data[$_value] as $_key2 => $_value2) {
          switch ($_key2) {
            case self::EM_NS . 'name':
            case self::EM_NS . 'description':
              if ($_value2 != $data['manifest'][str_replace(self::EM_NS, EMPTY_STRING, $_key2)]['en-US']) {
                $localized[str_replace(self::EM_NS, EMPTY_STRING, $_key2)]
                          [$data[$_value][self::EM_NS . 'locale']] = $_value2;
              }
              break;
            case self::EM_NS . 'contributor':
            case self::EM_NS . 'developer':
            case self::EM_NS . 'translator':
              $localized[str_replace(self::EM_NS, EMPTY_STRING, $_key2)] =
                array_merge($localized[str_replace(self::EM_NS, EMPTY_STRING, $_key2)], $_value2);
              break;
          }
        }
      }

      unset($data['manifest']['localized']);

      foreach($localized as $_key => $_value) {
        if ($_value == EMPTY_ARRAY) {
          continue;
        }

        $data['manifest'][$_key] = array_key_exists($_key, $data['manifest']) ? 
                                                    array_merge($data['manifest'][$_key], $_value) :
                                                    $_value;

        if (!in_array($_key, ['name', 'description'])) {
          $data['manifest'][$_key] = array_values(array_unique($data['manifest'][$_key]));
        }
      }
    }

    // ----------------------------------------------------------------------------------------------------------------

    // em:developer is no longer supported. Merge it with em:contributors
    if ($aEmDevloperMerge && array_key_exists('developer', $data['manifest'])) {
      if (array_key_exists('contributor', $data['manifest'])) {
       $data['manifest']['contributor'] = array_values(array_unique(array_merge($data['manifest']['contributor'],
                                                                                $data['manifest']['developer'])));
      }
      else {
        $data['manifest']['contributor'] = $data['manifest']['developer'];
      }

      unset($data['manifest']['developer']);
    }

    // ----------------------------------------------------------------------------------------------------------------

    // Set the targetApplication data
    if (array_key_exists('targetApplication', $data['manifest']) &&
        is_array($data['manifest']['targetApplication'])) {
      $targetApplication = EMPTY_ARRAY;

      foreach ($data['manifest']['targetApplication'] as $_value) {
        $id = $data[$_value][self::EM_NS . "id"];
        $targetApplication[$id]['minVersion'] = $data[$_value][self::EM_NS . 'minVersion'];
        $targetApplication[$id]['maxVersion'] = $data[$_value][self::EM_NS . 'maxVersion'];
        unset($data[$_value]);
      }

      unset($data['manifest']['targetApplication']);
      $data['manifest']['targetApplication'] = $targetApplication;
    }

    // ----------------------------------------------------------------------------------------------------------------

    // Tell the repat rdf parser to fuck off
    $rdf->rdf_parser_free();

    // Return the manifest
    return $data['manifest'];
  }

  /********************************************************************************************************************
  * Parses install.rdf for our desired properties
  *
  * @param array      &$aData
  * @param string     $aSubjectType
  * @param string     $aSubject
  * @param string     $aPredicate
  * @param int        $aOrdinal
  * @param string     $aObjectType
  * @param string     $aObject
  * @param string     $aXmlLang
  ********************************************************************************************************************/
  static function mfStatementHandler(&$aData, $aSubjectType, $aSubject, $aPredicate,
                                     $aOrdinal, $aObjectType, $aObject, $aXmlLang) {
    // Look for properties on the install manifest itself
    if ($aSubject == self::MF_RES && $aObject != 'false') {
      // we're only really interested in EM properties
      if (str_starts_with($aPredicate, self::EM_NS)) {
        $emProp = str_replace(self::EM_NS, EMPTY_STRING, $aPredicate);

        if (in_array($emProp, self::SINGLE_PROPS)) {
          $aData['manifest'][$emProp] = $aObject;
        }
        elseif (in_array($emProp, self::MULTI_PROPS)) {
          $aData['manifest'][$emProp][] = $aObject;
        }
        elseif (in_array($emProp, ['name', 'description'])) {
          $aData['manifest'][$emProp][($aXmlLang ? $aXmlLang  : 'en-US')] = $aObject;
        }
      }
    }
    else {
      // Previously, Mozilla did not BOTHER to even ATTEMPT to handle em:localized props
      // Here we will attempt it. Though it does mean any multi-prop with localized-props
      // COULD have these set but it /GENERALLY/ is not the job of the install manifest
      // parser or the statement handler to say if that is right or wrong..
      // Just make it possble.
      if (in_array(str_replace(self::EM_NS, EMPTY_STRING, $aPredicate),
                   ['contributor', 'developer', 'translator'])) {
        $aData[$aSubject][$aPredicate][] = $aObject;
      }
      else {
        // We don't know what it is so save it anyway as Mozilla always did.
        $aData[$aSubject][$aPredicate] = $aObject;
      }
    }

    // And return
    return $aData;
  }

  /********************************************************************************************************************
  * Parses manifest array into install.rdf
  *
  * @dep gfCreateXML()
  * @param $aManifest        Parsed installManifest
  * @param $aDirectOutput    If we should directly output the XML to the client
  * @returns                 String with XML markup if not aDirectOutput
  ********************************************************************************************************************/
  public function createInstallManifest($aManifest, $aDirectOutput = null) {
    // The Root Element of an install manifest
    $installManifest = array(
      '@element' => 'RDF',
      '@attributes' => array(
        'xmlns' => self::RDF_NS,
        'xmlns:em' => self::EM_NS,
      )
    );

    // The main description of an install manifest
    $mainDescription = array(
      '@element' => 'Description',
      '@attributes' => array(
        'about' => self::MF_RES,
      )
    );

    // ----------------------------------------------------------------------------------------------------------------

    // XXXTobin: Bump version if not bumpped
    if (!str_ends_with($aManifest['version'], '.1-fxguid')) {
      $aManifest['version'] .= '.1-fxguid';
    }

    // XXXTobin: Remove email addresses from creator..
    $aManifest['creator'] = preg_replace('<[\w.]+@[\w.]+>', EMPTY_STRING, $aManifest['creator']);
    $aManifest['creator'] = trim($aManifest['creator']);

    // XXXTobin: aboutURL is the add-on's about box NOT website
    if (array_key_exists('aboutURL', $aManifest)) {
      if (!str_starts_with($aManifest['aboutURL'], 'chrome://')) {
        unset($aManifest['aboutURL']);
      }
    }

    // XXXTobin: OptionsURL data:text
    if (array_key_exists('optionsURL', $aManifest)) {
      if (str_starts_with($aManifest['optionsURL'], 'data:text')) {
        unset($aManifest['optionsURL']);
        unset($aManifest['optionsType']);
      }
    }

    // XXXTobin: multiprocessCompatible means nothing to us
    if (array_key_exists('multiprocessCompatible', $aManifest)) {
      unset($aManifest['multiprocessCompatible']);
    }

    // XXXTobin: We tend to mangle homepageURL to repositoryURL when it is a known forge
    // However, we should mangle back unless both are used.
    // This should be removed after the launch of Phobos since we are introducing an em:repositoryURL
    if (!array_key_exists('homepageURL', $aManifest)) {
      if (array_key_exists('repositoryURL', $aManifest)) {
        $aManifest['homepageURL'] = $aManifest['repositoryURL'];
        unset($aManifest['repositoryURL']);
      }
    }
    // ----------------------------------------------------------------------------------------------------------------

    // Add single props as attributes to the main description
    foreach ($aManifest as $_key => $_value) {
      if (in_array($_key, self::MULTI_PROPS)) {
        continue;
      }

      if (in_array($_key, ['name', 'description'])) {
        $mainDescription['@attributes']['em:' . $_key] = $_value['en-US'];
        continue;
      }

      $mainDescription['@attributes']['em:' . $_key] = $_value;
    }

    // ----------------------------------------------------------------------------------------------------------------

    // Add multiprops as elements
    foreach (['em:contributor'      => $aManifest['contributor'] ?? null,
              'em:developer'        => $aManifest['developer'] ?? null,
              'em:translator'       => $aManifest['translator'] ?? null,
              'em:otherLicenses'    => $aManifest['otherLicenses'] ?? null,
              'em:targetPlatform'   => $aManifest['targetPlatform'] ?? null]
             as $_key => $_value) {
      if (!$_value) {
        continue;
      }

      foreach ($_value as $_value2) {
        $mainDescription[] = ['@element' => $_key, '@content' => trim($_value2)];
      }
    }

    // ----------------------------------------------------------------------------------------------------------------

    $locales = array_unique(array_merge(array_keys($aManifest['name']), array_keys($aManifest['description'])));
    sort($locales);

    foreach ($locales as $_value) {
      if ($_value == 'en-US') {
        continue;
      }

      $_name = $aManifest['name'][$_value] ?? null;
      $_desc = $aManifest['description'][$_value] ?? null;
      $_attrs = ['em:locale' => $_value];

      if ($_name) {
        $_attrs['em:name'] = $_name;
      }

      if ($_desc) {
        $_attrs['em:description'] = $_desc;
      }

      if (count($_attrs) < 2) {
        continue;
      }

      $mainDescription[] = ['@element' => 'em:localized', ['@element' => 'Description', '@attributes' => $_attrs]];
    }

    // ----------------------------------------------------------------------------------------------------------------

    // Add targetApplications as elements with attrs of the targetApplication description
    foreach ($aManifest['targetApplication'] as $_key => $_value) {
      $mainDescription[] = array(
        '@element' => 'em:targetApplication',
        array(
          '@element' => 'Description',
          '@attributes' => array(
            'em:id' => $_key,
            'em:minVersion' => $_value['minVersion'],
            'em:maxVersion' => $_value['maxVersion'],
          )
        )
      );
    }

    // ----------------------------------------------------------------------------------------------------------------

    // Attach the main description to the root element
    $installManifest[] = $mainDescription;

    // Generate XML (or RDF in this case)
    $installManifest = gfCreateXML($installManifest, $aDirectOutput);

    // ----------------------------------------------------------------------------------------------------------------

    return $installManifest;
  }

  /********************************************************************************************************************
  * Parses manifest array into update.rdf
  *
  * @dep AUS_XPI_TYPES
  * @dep gfCreateXML()
  * @param $aManifest        Parsed installManifest
  * @param $aDirectOutput    If we should directly output the XML to the client
  * @returns                 String with XML markup if not aDirectOutput
  ********************************************************************************************************************/
  public function createUpdateManifest($aManifest, $aDirectOutput = null) {
    global $gaRuntime;

    if ($aManifest == null) {
      gfOutput(XML_TAG . RDF_AUS_BLANK, 'xml');
    }

    $aManifest['type'] = AUS_XPI_TYPES[$aManifest['type']] ?? 'item';

    // ----------------------------------------------------------------------------------------------------------------

    // Construct the Update Manifest
    $updateManifest = array(
      '@element' => 'RDF:RDF',
      '@attributes' => array(
        'xmlns:RDF' => self::RDF_NS,
        'xmlns:em' => self::EM_NS,
      ),
      array(
        '@element' => 'Description',
        '@attributes' => array(
          'about' => 'urn:mozilla:' . $aManifest['type'] . COLON . $aManifest['id']
        ),
        array(
          '@element' => 'em:updates',
          array(
            '@element' => 'RDF:Seq',
            array(
              '@element' => 'RDF:li',
              array(
                '@element' => 'Description',
                '@attributes' => array(
                  'em:version' => $aManifest['version']
                ),
              )
            )
          )
        )
      )
    );

    // ----------------------------------------------------------------------------------------------------------------

    // Add targetApplications as elements with attrs of the targetApplication description
    foreach ($aManifest['targetApplication'] as $_key => $_value) {
      $_updateLink = $gaRuntime['currentScheme'] . SCHEME_SUFFIX . gfGetAppDomainByID($_key) . $aManifest['updateLink'];

      if ($gaRuntime['debugMode']) {
        $_updateLink = $gaRuntime['currentScheme'] . SCHEME_SUFFIX . DEVELOPER_DOMAIN . $aManifest['updateLink'];

        if (($_key != TARGET_APPLICATION[$gaRuntime['currentApplication']]['id']) &&
            ($_key != TARGET_APPLICATION['palemoon']['id'])) {
          $_updateLink .= '&appOverride=' . gfGetAppNameByID($_key);
        }
      }

      // RDF:RDF -> Description -> em:updates -> RDF:Seq -> RDF:li -> Description
      $updateManifest[0][0][0][0][0][] = array(
      '@element' => 'em:targetApplication',
      array(
        '@element' => 'Description',
        '@attributes' => array(
          'em:id' => $_key,
          'em:minVersion' => $_value['minVersion'],
          'em:maxVersion' => $_value['maxVersion'],
          'em:updateHash' => $aManifest['updateHash']
        ),
        array(
          '@element' => 'em:updateLink',
          '@content' =>  $_updateLink,
        ),
      )
      );
    }    

    // ----------------------------------------------------------------------------------------------------------------

    return gfCreateXML($updateManifest, $aDirectOutput);
  }

  /********************************************************************************************************************
  * Creates a search result that is consumed by the Add-ons Manager
  *
  * @dep EMPTY_ARRAY
  * @dep SEARCH_XPI_TYPES (which requires XPINSTALL_TYPES)
  * @dep gfCreateXML()
  * @dep $gaRuntime
  * @param $aManifests       List of parsed installManifests with additional stored and calculated data
  * @param $aDirectOutput    If we should directly output the XML to the client
  * @returns                 String with XML markup if not aDirectOutput
  *
  * Each installManifest in the list needs the following stored or calculated data:
  * @dbAddon - slug
  * @dbAddon - hasIcon
  * @dbXPInstall - epoch
  * @dbXPInstall - size
  * @dbXPInstall - hash
  * @classAddon - addonURL
  * @classAddon - creatorURL
  * @classAddon - iconURL
  * @classAddon - downloadURL
  ********************************************************************************************************************/
  public function createSearchResults($aManifests, $aDirectOutput = null) {
    global $gaRuntime;
    $count = 0;
    $warnings = EMPTY_ARRAY;

    // Create the root searchresults element
    $searchResults = ['@element' => 'searchresults', '@attributes' => EMPTY_ARRAY];

    // Make sure aManifests is actually and array and an indexed list of manifests
    if (!is_array($aManifests) || !array_is_list($aManifests)) {
      // Log a warning if it is not
      $warnings[] = 'Not a list of search results.';

      // Make aManifests an empty array so that the subsequent foreach won't bitch.
      $aManifests = EMPTY_ARRAY;
    }

    // Loop through manifests to create the structure for a search result add-on
    // If it is null then assume empty array and pass through
    foreach ($aManifests as $_key => $_value) {
      $_addon = ['@element' => 'addon'];

      $_addon[] = ['@element' => 'type', '@attributes' => ['id' => SEARCH_XPI_TYPES[$_value['type']]]];
      $_addon[] = ['@element' => 'guid', '@content' => $_value['id']];
      $_addon[] = ['@element' => 'name', '@content' => $_value['name']['en-US']];
      $_addon[] = ['@element' => 'version', '@content' => $_value['version']];
      $_addon[] = ['@element' => 'icon', '@attributes' => ['size' => '48'], '@content' => $_value['iconURL']];
      $_addon[] = ['@element' => 'learnmore', '@content' =>  $_value['addonURL']];

      if (array_key_exists('homepageURL', $_value)) {
        $_addon[] = ['@element' => 'homepage', '@content' => $_value['homepageURL']];
      }

      // Deal with Authors
      $_authors = ['@element' => 'authors'];

      // The creator MUST first author element
      $_authors[] = ['@element' => 'author', ['@element' => 'name', '@content' => $_value['creator']],
                                             ['@element' => 'link', '@content' => $_value['creatorURL']]];

      // Assign authors to the addon element
      $_addon[] = $_authors;

      // Deal with targetApplications
      $targetApps = ['@element' => 'compatible_applications'];

      foreach ($_value['targetApplication'] as $_key2 => $_value2) {
        if (TARGET_APPLICATION[$gaRuntime['currentApplication']]['id'] != $_key) {
          continue;
        }

        $targetApps[] = ['@element' => 'application', ['@element' => 'appID', '@content' => $_key2],
                                                      ['@element' => 'min_version', '@content' => $_value2['minVersion']],
                                                      ['@element' => 'max_version', '@content' => $_value2['maxVersion']]];
      }

      // Assign the targetApplications as application elements 
      $_addon[] = $targetApps;

      $_addon[] = ['@element' => 'last_updated', '@attributes' => ['epoch' => $_value['epoch']]];
      $_addon[] = ['@element' => 'install',
                   '@attributes' => ['size' => $_value['size'], 'hash' => $_value['hash']],
                   '@content' => $_value['downloadURL']];

      $searchResults[] = $_addon;
      $count++;
    }

    // If the count has not be increased then there are no results so log a warning.
    if ($count == 0) {
      $warnings[] = 'No results.';
    }

    // Attach the total number of results to the searchresults element
    $searchResults['@attributes']['total_results'] = $count;

    // If we are in debug mode and we have warnings then create a phobos element
    // and emit the warnings as warning elements.
    // We do this so that this method has a safe failure that won't piss off either the
    // xml parser or the code that consumes the search results in the Add-ons Manager code.
    if ($gaRuntime['debugMode'] && $warnings != EMPTY_ARRAY) {
      // Create phobos element
      $warningResults = ['@element' => 'phobos'];

      // Loop through warnings and create warning elements and attach them to the phobos element.
      foreach ($warnings as $_value) {
        $warningResults[] = ['@element' => 'warning', '@content' => $_value];
      }

      // Attach the phobos element with the warnings to the search results element.
      $searchResults[] = $warningResults;
    }

    // Create the XML and return if not direct output.
    return gfCreateXML($searchResults, $aDirectOutput);
  }
}

?>
