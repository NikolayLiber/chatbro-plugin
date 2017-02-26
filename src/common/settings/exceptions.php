<?php

class CBroInvalidSetting extends Exception {
  public function __construct() {
    parent::__construct('Invalid setting');
  }
}

class CBroSettingNotFound extends Exception {
  public function __construct($id = null) {
    $msg = 'Setting not found';

    if ($id)
      $msg .= ": {$id}";
    parent::__construct($msg);
  }
}

?>
