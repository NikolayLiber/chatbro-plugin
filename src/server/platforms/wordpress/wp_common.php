<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once('common/settings/settings.php');
require_once('common/admin/admin.php');

class CBroWPCommon {
  const display_to_guests = "chatbro_chat_display_to_guests";

  static function get_option($name, $default = NULL) {
    if (is_multisite() && is_plugin_active_for_network(plugin_basename(__FILE__))) {
        return get_site_option($name, $default);
    } else {
        return get_option($name, $default);
    }
  }

  static function add_option($name, $value = '', $v2 = '', $v3 = 'yes') {
    if (is_multisite() && is_plugin_active_for_network(plugin_basename(__FILE__))) {
      return add_site_option($name, $value, $v2, $v3);
    } else {
      return add_option($name, $value, $v2, $v3);
    }
  }

  public static function delete_option($name) {
    if (is_multisite() && is_plugin_active_for_network(plugin_basename(__FILE__))) {
        return delete_site_option($name);
    } else {
        return delete_option($name);
    }
  }

  static function ajax_save_settings() {
    die(CBroAdmin::save_settings());
  }

  static function get_faq() {
    die(CBroAdmin::get_faq());
  }
}

?>
