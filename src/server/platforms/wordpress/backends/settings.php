<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once(__DIR__ . '/../common/settings/interfaces.php');
require_once(__DIR__ . '/../common/settings/exceptions.php');
require_once(__DIR__ . '/../wp_common.php');

class CBroNonExistentOption {}

class CBroWPSettingsBackend implements ICBroSettingsBackend {
  const display_to_guests = "chatbro_chat_display_to_guests";

  function __construct() {
      $this->non_existent_option = new CBroNonExistentOption();
  }

  private static function update_option($name, $value) {
    if (is_multisite() && is_plugin_active_for_network(plugin_basename(__FILE__))) {
      return update_site_option($name, $value);
    } else {
      return update_option($name, $value);
    }
  }

  function get($id) {
    $val = CBroWPCommon::get_option($id, $this->non_existent_option);

    if ($val === $this->non_existent_option)
      throw new CBroSettingNotFound($id);

    return $val;
  }

  function set($id, $value) {
    if (!CBroWPCommon::add_option($id, $value))
      self::update_option($id, $value);
  }

  function postpone_write() {}

  function flush() {}

  function add_extra_settings($settings) {
    $settings->add_setting(new CBroSetting($this, array(
      'id' => self::display_to_guests,
      'type' => CBroInputType::checkbox,
      'label' => 'Display chat to guests',
      'sanitizer' => array('CBroUtils', 'sanitize_checkbox'),
      'default' => true
    )));
  }

  function del($id) {
    delete_option($id);
  }
}

?>
