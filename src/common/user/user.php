<?php

require_once(__DIR__ . '/../core/backendable.php');
require_once(__DIR__ . '/../settings/settings.php');
require_once(__DIR__ . '/../permissions/permissions.php');

class CBroUser extends CBroBackendable {
  public static function is_guest() {
    return self::get_backend()->is_guest();
  }

  public static function can_view($display_to_guests = null) {
    if ($display_to_guests === null)
      $display_to_guests = CBroSettings::get(CBroSettings::display_to_guests);

    $guest = self::is_guest();
    $can_view = !$guest ? CBroPermissions::can(CBroPermissions::cap_view) : false;

    if ((!$display_to_guests && $guest) || (!$guest && !$can_view))
        return false;

    if (!$display_to_guests && $guest)
        // Don't show the chat to unregistered users
        return false;

    return true;

  }
  public static function can_ban() {
    return CBroPermissions::can(CBroPermissions::cap_ban);
  }

  public static function can_delete() {
    return CBroPermissions::can(CBroPermissions::cap_delete);
  }
}

?>
