<?php

class CBroPermissions extends CBroBackendable {
  const cap_delete = "chatbro_delete_message";
  const cap_ban = "chatbro_ban_user";
  const cap_view = "chatbro_view_chat";

  // private static $instance;
  // private $backend;
  //
  // private function __construct($backend) {
  //   $this->backend = $backend;
  // }
  //
  // private static function get_instance() {
  //   if (!self::$instance)
  //     throw new Exception('CBroPermissions is not initialized');
  //
  //   return self::$instance;
  // }
  //
  // public static function init($backend) {
  //   if (self::$instance)
  //     return;
  //
  //   self::$instance = new CBroPermissions($backend);
  // }

  public static function user_can($cap) {
    return self::get_instance()->get_backend()->user_can($cap);
  }
}

?>
