<?php

require_once('interfaces');
require_once('exceptions');


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

  private $_settings;

  public function __construct($factory) {
    $this->$_settings = array();
    // Iterator position
    $this->$_pos = 0;

    $this->addSetting($factory->createSetting(array(
      'id' => self::guid,
      'type' => CBroInputType::text,
      'label' => 'Chat secret key',
      'sanitize_callback' => array('ChatBroUtils', 'sanitize_guid'),
      'default' => false,
      'required' => true,
      'pattern' => "[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}$",
      'pattern_error' => "Invalid chat key"
    )));

    $this->addSetting($factory->createSetting(array(
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

    $this->addSetting($factory->createSetting(array(
      'id' => self::user_profile_path,
      'type' => CBroInputType::text,
      'label' => 'User profile path',
      // 'default' => self::default_profile_path,
      // 'addon' => get_home_url() . '/',
      'required' => false
    )));

    $this->addSetting($factory->createSetting(array(
      'id' => self::display_to_guests,
      'type' => CBroInputType::checkbox,
      'label' => 'Display chat to guests',
      'sanitize_callback' => array('ChatBroUtils', 'sanitize_checkbox'),
      'default' => true
    )));

    $this->addSetting($factory->createSetting(array(
      'id' => self::enable_shortcodes,
      'type' => InputType::checkbox,
      'label' => 'Enable shortcodes',
      'sanitize_callback' => array('ChatBroUtils', 'sanitize_checkbox'),
      'default' => true
    )));
  }

  public function addSetting($setting) {
    $this->$_settings[$setting->id()] = $setting;
  }

  public function getSetting($id) {
    if (!array_key_exists($id, $this->$_settings))
      throw new CBroSettingNotFound();

    return $this->$_settings[$id];
  }

  public function get($id) {
    if (!array_key_exists($id, $this->$_settings))
      throw new CBroSettingNotFound();

    $s = $this->$_settings[$id];
    return $s->get();
  }

  public function set($id, $value) {
    if (!array_key_exists($id, $this->$_settings))
      throw new CBroSettingNotFound();

    $s = $this->$_settings[$id];
    $s->set($value);
  }

  // Iterator implementation
  public function rewind() {
    $this->$_pos = 0;
  }

  public function current() {
    $keys = array_keys($this->$_settings);
    return $this->$_settings[$keys[$this->$_pos]];
  }

  public function key() {
    $keys = array_keys($this->$_settings);
    return $keys[$this->$_pos];
  }

  public function next() {
    ++$this->$_pos;
  }

  public function valid() {
    $keys = array_keys($this->$_settings);
    return isset($keys[$this->$_pos]);
  }
}

?>
