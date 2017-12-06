<?php

require_once(__DIR__ . '/../core/backendable.php');
require_once(__DIR__ . '/../admin/admin.php');
require_once('interfaces.php');
require_once('exceptions.php');
require_once('setting.php');


class CBroInputType {
  const checkbox = 'checkbox';
  const text = 'text';
  const select = 'select';
  const textarea = 'textarea';
};

class CBroSettingsIterator implements Iterator {
  private $keys;
  private $pos;

  public function __construct($keys) {
    $this->keys = $keys;
    $this->pos = 0;
  }

  public function rewind() {
    $this->pos = 0;
  }

  public function current() {
    return CBroSettings::get_setting($this->keys[$this->pos]);
  }

  public function key() {
    return $this->keys[$this->pos];
  }

  public function next() {
    ++$this->pos;
  }

  public function valid() {
    return isset($this->keys[$this->pos]);
  }
}

class CBroSettings extends CBroBackendable {
  const guid = "chatbro_chat_guid";
  const display = "chatbro_chat_display";
  const selected_pages = 'chatbro_chat_selected_pages';
  const user_profile_path = 'chatbro_chat_user_profile_url';
  const enable_shortcodes = 'chatbro_enable_shortcodes';
  const plugin_version = 'chatbro_plugin_version';

  private $settings;

  protected function __construct($backend) {
    parent::__construct($backend);

    $this->settings = array();

    $this->add_setting(new CBroSetting($backend, array(
      'id' => self::guid,
      'type' => CBroInputType::text,
      'label' => 'Chat secret key',
      'sanitizer' => array('CBroUtils', 'sanitize_guid'),
      'generator' => array('CBroUtils', 'gen_guid'),
      'required' => true,
      'pattern' => "[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}$",
      'pattern_error' => "Invalid chat key"
    )));

    $this->add_setting(new CBroSetting($backend, array(
      'id' => self::display,
      'type' => CBroInputType::select,
      'label' => 'Show popup chat',
      'sanitizer' => array('CBroUtils', 'sanitize_display'),
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

    $this->add_setting(new CBroSetting($backend, array(
      'id' => self::selected_pages,
      'type' => CBroInputType::textarea,
      'label' => "Pages",
      'help_block' => "Specify pages by using their paths. Enter one path per line. The '*' character is a wildcard. Example paths are /2012/10/my-post for a single post and /2012/* for a group of posts. The path should always start with a forward slash(/).",
      'default' => false,
      'required' => false
    )));

    $this->add_setting(new CBroSetting($backend, array(
      'id' => self::user_profile_path,
      'type' => CBroInputType::text,
      'label' => 'User profile path',
      'default' => CBroUtils::get_default_profile_url(),
      'addon' => CBroUtils::get_home_url(),
      'required' => false
    )));

    if (CBroAdmin::has_shortcodes()) {
      $this->add_setting(new CBroSetting($backend, array(
        'id' => self::enable_shortcodes,
        'type' => CBroInputType::checkbox,
        'label' => 'Enable shortcodes',
        'sanitizer' => array('CBroUtils', 'sanitize_checkbox'),
        'default' => true
      )));
    }

    // Добавляем дополнительные настройки, специфичные для данной платформы
    $backend->add_extra_settings($this);
  }

  public function add_setting($setting) {
    $this->settings[$setting->id()] = $setting;
  }

  public static function get_setting($id) {
    if (!array_key_exists($id, self::get_instance()->settings))
      throw new CBroSettingNotFound($id);

    return self::get_instance()->settings[$id];
  }

  public static function get($id) {
    return self::get_setting($id)->get();
  }

  public static function set($id, $value) {
    self::get_setting($id)->set($value);
  }

  public static function set_sanitized($id, $value) {
    self::get_setting($id)->set_sanitized($value);
  }

  public static function iterator() {
    return new CBroSettingsIterator(array_keys(self::get_instance()->settings));
  }

  public static function del($id) {
    self::get_setting($id)->del();
  }
}

?>
