<?php

defined('_JEXEC') or die('Access Restricted');

require_once('common/interfaces.php');
require_once('common/settings_manager.php');
require_once('setting.php');

class CBroJoomlaSettingsStorage extends JModel implements ICBroSettingsManager, ICBroSettingFactory {
  private $_manager;
  private $_instance;
  private $_settings;

  private function __construct() {
    $_settings = JComponentHelper::getParams('com_chatbro');
    $this->_manager = new CBroSettingsManager($this);
  }

  public function get_instance() {
    if (!$this->_instance)
      $this->_instance = new CBroJoomlaSettingsStorage();

    return $this->_instance;
  }

  public static function get($id) {
    return self::get_instance()->_manager->get($id);
  }

  public static function set($id, $value) {
    self::get_instance()->_manager->set($id, $value);
  }

  public function add_setting($setting) {
    $this->_manager->add_setting($setting);
  }

  public static function get_setting($id) {
    return self::get_instance()->_manager->get_setting($id);
  }

  public function create_setting($params) {
    return new CBroJoomlaSetting($this, $params);
  }


}
?>
