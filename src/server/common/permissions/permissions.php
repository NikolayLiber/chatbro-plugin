<?php

class CBroPermissions extends CBroBackendable {
  const cap_delete = "chatbro_delete_message";
  const cap_ban = "chatbro_ban_user";
  const cap_view = "chatbro_view_chat";

  public static function can($capability) {
    return self::get_instance()->get_backend()->can($capability);
  }
}

?>
