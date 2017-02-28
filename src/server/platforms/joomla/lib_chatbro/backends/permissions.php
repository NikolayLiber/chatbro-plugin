<?php

defined('_JEXEC') or die("Access Restricted");

require_once(__DIR__ . '/../common/permissions/interfaces.php');
require_once(__DIR__ . '/../common/permissions/permissions.php');

class CBroJoomlaPermissionsBackend implements ICBroPermissionsBackend {
  public function can($capability) {
    // Temporary stub
    switch($capability) {
      case CBroPermissions::cap_ban:
      case CBroPermissions::cap_delete:
        return JFactory::getUser()->authorise('core.admin');

      case CBroPermissions::cap_view:
        return true;

      default:
        return false;
    }
  }
}

?>
