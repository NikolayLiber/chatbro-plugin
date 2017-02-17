<?php

class CBroInvalidSetting extends Exception {
  public function __construct() {
    parent::__construct('Invalid setting');
  }
}

class CBroSettingNotFound extends Exception {
  public function __construct() {
    parent::__construct('Setting not found');
  }
}

?>
