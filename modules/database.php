<?php
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this
// file, You can obtain one at http://mozilla.org/MPL/2.0/.

class moduleDatabase {
  private $init;
  private $connection;
  private $safeMySQL;
  
  /********************************************************************************************************************
  * Class constructor that sets initial state of things
  ********************************************************************************************************************/
  function __construct($aDatabase, $aUsername, $aPassword) {
    $this->connection = mysqli_connect('localhost', $aUsername, $aPassword, $aDatabase);

    if (mysqli_connect_errno()) {
      gError('SQL Connection Error: ' . mysqli_connect_errno($this->connection));
    }

    mysqli_set_charset($this->connection, 'utf8');
    require_once(LIBRARIES['safeMySQL']);
    $this->safeMySQL = new SafeMysql(['mysqli' => $this->connection]);

    gSetProperty('runtime', 'currentDatabase', $aDatabase);
    gSetRegKey('database.current', $this->safeMySQL->getCol("SELECT DATABASE()")[0]);
  }

  /********************************************************************************************************************
  * Class de-constructor that cleans up items
  ********************************************************************************************************************/
  function __destruct() {
    if ($this->connection) {
      $this->safeMySQL = null;
      mysqli_close($this->connection);
      gSetProperty('runtime', 'currentDatabase', false);
      gSetRegKey('database.currentDB', false);
    }
  }

  /********************************************************************************************************************
  * Force a specific database
  ********************************************************************************************************************/
  public function changeDB($aDatabase) {
    $dbChange = mysqli_select_db($this->connection, $aDatabase);

    if ($dbChange) {
      gSetProperty('runtime', 'currentDatabase', $this->safeMySQL->getCol("SELECT DATABASE()")[0]);
      gSetRegKey('database.current', $this->safeMySQL->getCol("SELECT DATABASE()")[0]);
      return $dbChange;
    }

    gError('Failed to change database to' . SPACE . $aDatabase);
  }

  /********************************************************************************************************************
  * Query the database
  ********************************************************************************************************************/
  public function query(string $aType, ...$aArgs) {
    $errorMsg = 'The query type is not currently available.';
    switch (strtolower($aType)) {
      case 'parse':
        $rv = ($this->safeMySQL) ? $this->safeMySQL->parse(...$aArgs) : gError($errorMsg);
        break;
      case 'exec':
        $rv = ($this->safeMySQL) ? $this->safeMySQL->query(...$aArgs) : gError($errorMsg);
        break;
      case 'col':
        $rv = ($this->safeMySQL) ? $this->safeMySQL->getCol(...$aArgs) : gError($errorMsg);
        break;
      case 'row':
        $rv = ($this->safeMySQL) ? $this->safeMySQL->getRow(...$aArgs) : gError($errorMsg);
        break;
      case 'all':
        $rv = ($this->safeMySQL) ? $this->safeMySQL->getAll(...$aArgs) : gError($errorMsg);
        break;
      case 'execRaw':
        $rv = mysqli_query($this->connection, $aQuery);
        break;
      case 'execMulti':
        $rv = mysqli_multi_query($this->connection, $aQuery);
        break;
      default:
        gError('Unknown query type.');
    }

    return gMaybeNull($rv);
  }
}

?>
