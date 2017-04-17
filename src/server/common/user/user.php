<?php

require_once(__DIR__ . '/../core/backendable.php');
require_once(__DIR__ . '/../settings/settings.php');
require_once(__DIR__ . '/../permissions/permissions.php');

class CBroUser extends CBroBackendable {
  public static function is_logged_in() {
    return self::get_backend()->is_logged_in();
  }

  public static function is_admin() {
    return self::get_backend()->is_admin();
  }

  public static function can_view() {
    return CBroPermissions::can(CBroPermissions::cap_view);
  }

  public static function can_ban() {
    return CBroPermissions::can(CBroPermissions::cap_ban);
  }

  public static function can_delete() {
    return CBroPermissions::can(CBroPermissions::cap_delete);
  }

  public static function avatar_url() {
    return self::get_backend()->avatar_url();
  }

  public static function profile_url() {
    return self::get_backend()->profile_url();
  }

  public static function id() {
    return self::get_backend()->id();
  }

  public static function display_name() {
    return self::get_backend()->display_name();
  }

  public static function full_name() {
    return self::get_backend()->full_name();
  }
}

?>
