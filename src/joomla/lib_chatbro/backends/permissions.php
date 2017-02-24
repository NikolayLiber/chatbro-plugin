<?php

defined('_JEXEC') or die("Access Restricted");

require_once(__DIR__ . '/../common/permissions/interfaces.php');

class CBroJoomlaPermissionsBackend implements ICBroPermissionsBackend {
  public function user_can($cap) {
    // Temporary stub
    return true;
  }
}

?>
