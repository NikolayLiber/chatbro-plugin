<?php

defined('_JEXEC') or die('Access Restricted');

require_once('common/settings/base_setting.php');

class CBroJoomlaSetting extends CBroBaseSetting {
  private $_storage;

  public function __construct($storage, $params) {
      $this->_storage = $storage;
      parent::__construct($params);
  }

  public function get() {
    return $this->_saver->get($this->id());
  }

  protected function save() {
    $this->_storage->save($this->id(), $this->_value);
  }
}

?>
