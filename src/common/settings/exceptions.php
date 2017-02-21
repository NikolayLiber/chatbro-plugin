<?php

class CBroInvalidSetting extends Exception {
  public function __construct() {
    parent::__construct('Invalid setting');
  }
}

class CBroSettingNotFound extends Exception {
  public function __construct($reason = null) {
    $msg = 'Setting not found';

    if ($reason)
      $msg .= ": {$reason}";
    parent::__construct($msg);
  }
}

?>
