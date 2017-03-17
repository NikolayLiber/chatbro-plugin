<?php

require_once(__DIR__ . '/../core/backendable.php');

class CBroPermissions extends CBroBackendable {
  const cap_delete = "chatbro_delete_message";
  const cap_ban = "chatbro_ban_user";
  const cap_view = "chatbro_view_chat";

  public static function can($capability) {
    return self::get_backend()->can($capability);
  }

  public static function can_manage_settings() {
      return self::get_backend()->can_manage_settings();
  }
}

?>
