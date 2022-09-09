<?php
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this
// file, You can obtain one at http://mozilla.org/MPL/2.0/.

class moduleDatabase {
  public $connection;
  private $safeMySQL;
  
  /********************************************************************************************************************
  * Class constructor that sets initial state of things
  ********************************************************************************************************************/
  function __construct($aDatabase, $aUsername, $aPassword) {
    $this->connection = mysqli_connect('localhost', $aUsername, $aPassword, $aDatabase);

    if (mysqli_connect_errno()) {
      gError('SQL Connection Error: ' . mysqli_connect_errno($this->connection));
    }

    gSetProperty('runtime', 'currentDatabase', $aDatabase);
    mysqli_set_charset($this->connection, 'utf8');
    require_once(LIBRARIES['safeMySQL']);
    $this->safeMySQL = new SafeMysql(['mysqli' => $this->connection]);
  }

  /********************************************************************************************************************
  * Class de-constructor that cleans up items
  ********************************************************************************************************************/
  function __destruct() {
    if ($this->connection) {
      $this->safeMySQL = null;
      mysqli_close($this->connection);
      gSetProperty('runtime', 'currentDatabase', false);
    }
  }

  /********************************************************************************************************************
  * Force a specific database
  ********************************************************************************************************************/
  public function changeDB($aDatabase) {
    $dbChange = mysqli_select_db($this->connection, $aDatabase);

    if ($dbChange) {
      gSetProperty('runtime', 'currentDatabase', $this->safeMySQL->getCol("SELECT DATABASE()")[0]);
      return $dbChange;
    }

    gError('Failed to change database to' . SPACE . $aDatabase);
  }

  /********************************************************************************************************************
  * SafeMySQL Method Wrappers
  ********************************************************************************************************************/
  public function parse(...$aArgs) { return gGetProperty('value', $this->safeMySQL->parse(...$aArgs)); }
  public function query(...$aArgs) { return gGetProperty('value', $this->safeMySQL->query(...$aArgs)); }
  public function col(...$aArgs) { return gGetProperty('value', $this->safeMySQL->getCol(...$aArgs)); }
  public function row(...$aArgs) { return gGetProperty('value', $this->safeMySQL->getRow(...$aArgs)); }
  public function all(...$aArgs) { return gGetProperty('value', $this->safeMySQL->getAll(...$aArgs)); }

  /********************************************************************************************************************
  * MySQLi Raw Query Wrappers
  ********************************************************************************************************************/
  public function raw($aQuery) { return gGetProperty('value', mysqli_query($this->connection, $aQuery)); }
  public function multi($aQuery) { return gGetProperty('value', mysqli_multi_query($this->connection, $aQuery)); }
}

?>
