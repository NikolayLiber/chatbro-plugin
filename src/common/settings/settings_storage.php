<?php

require_once('interfaces');

class CBroInputType {
  const checkbox = 'checkbox';
  const text = 'text';
  const select = 'select';
  const textarea = 'textarea';
};


class CBroSettingsStorage implements ICBroSettingsStorage {
  const guid = "chatbro_chat_guid";
  const display_to_guests = "chatbro_chat_display_to_guests";
  const display = "chatbro_chat_display";
  const selected_pages = 'chatbro_chat_selected_pages';
  const user_profile_path = 'chatbro_chat_user_profile_url';
  const enable_shortcodes = 'chatbro_enable_shortcodes';
  const plugin_version = 'chatbro_plugin_version';

  private $settings;

  public function __construct($factory) {
    $this->$settings = array();

    $this->addSetting($factory->create(array(
      'id' => self::guid,
      'type' => CBroInputType::text,
      'label' => 'Chat secret key',
      'sanitize_callback' => array('ChatBroUtils', 'sanitize_guid'),
      'default' => false,
      'required' => true,
      'pattern' => "[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}$",
      'pattern_error' => "Invalid chat key"
    )));

    $this->addSetting($factory->create(array(
      'id' => self::display,
      'type' => CBroInputType::select,
      'label' => 'Show popup chat',
      'options' => array(
        'everywhere' =>    'Everywhere',
        'frontpage_only' => 'Front page only',
        'except_listed' => 'Everywhere except those listed',
        'only_listed' =>   'Only the listed pages',
        'disable' =>       'Disable'
      ),
      'default' => 'everywhere',
      'required' => true
    )));
  }
}
?>
