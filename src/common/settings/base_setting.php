<?php

require_once('exceptions.php');
require_once('interfaces.php');
require_once('../utils/utils.php');

abstract class CBroBaseSetting implements ICBroSetting {
  private $_params;
  private $_id;
  protected $_value;

  protected function __construct($params) {
    $this->_params = $params;

    if (!array_key_exists('id', $this->_params))
      throw new Exception("Invalid setting params (no id)");

    $this->_id = $_params['id'];

    try {
      $this->_value = $this->get();
    }
    catch(CBroSettingNotFound $e) {
      if (array_key_exists('generator', $this->_params))
        $this->_value = call_user_func_array($this->_params['generator']);
      elseif (array_key_exists('default', $this->_params))
        $this->_value = $this->_params['default'];
      else
        throw $e;

      $this->save();
    }
  }

  public function set($value) {
    if (array_key_exists('sanitizer', $this->_params))
      $this->_value = call_user_func_array($this->_params['sanitizer'], array($value));
    else
      $this->_value = $value;

    $this->save();
  }

  public function id() {
    return $this->_id;
  }

  protected abstract function save();
}

?>
