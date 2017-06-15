<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once(__DIR__ . '/../common/permissions/interfaces.php');
require_once(__DIR__ . '/../common/permissions/permissions.php');
require_once(__DIR__ . '/../wp_common.php');

class CBroWPPermissionsBackend implements ICBroPermissionsBackend {
  function can($capability) {
    switch($capability) {
      case CBroPermissions::cap_ban:
        return current_user_can(CBroPermissions::cap_ban);

      case CBroPermissions::cap_delete:
        return current_user_can(CBroPermissions::cap_delete);

      case CBroPermissions::cap_view:
        $display_to_guests = CBroSettings::get(CBroWPCommon::display_to_guests);
        $logged_in = is_user_logged_in();
        $can_view = $logged_in ? current_user_can(CBroPermissions::cap_view) : false;

        if ((!$display_to_guests && !$logged_in) || ($logged_in && !$can_view))
          return false;

        if (!$display_to_guests && !$logged_in)
          // Don't show the chat to unregistered users
          return false;

        return true;
    }
  }

  function can_manage_settings() {
    return current_user_can('manage_options');
  }
}

?>
