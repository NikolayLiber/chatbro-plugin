<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class CBroWPCommon {
  const display_to_guests = "chatbro_chat_display_to_guests";

  static function get_option($name, $default) {
    if (is_multisite() && is_plugin_active_for_network(plugin_basename(__FILE__))) {
        return get_site_option($name, $default);
    } else {
        return get_option($name, $default);
    }
  }
}

?>
