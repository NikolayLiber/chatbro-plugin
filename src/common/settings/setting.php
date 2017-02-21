<?php

require_once('exceptions.php');
require_once('interfaces.php');
// require_once('../utils/utils.php');

class CBroSetting implements ICBroSetting {
  private $storage;
  private $params;
  private $id;

  public function __construct($storage, $params) {
    $this->params = $params;
    $this->storage = $storage;

    if (!array_key_exists('id', $this->params))
      throw new Exception("Invalid setting params (no id)");

    $this->id = $params['id'];

    $value = null;
    try {
      $value = $this->storage->get($this->id);
    }
    catch(CBroSettingNotFound $e) {
      if (array_key_exists('generator', $this->params))
        $value = call_user_func_array($this->params['generator'], array());
      elseif (array_key_exists('default', $this->params))
        $value = $this->params['default'];
      else
        throw $e;

      $this->storage->set($this->id, $value);
    }
  }

  public function get() {
    return $this->storage->get($this->id);
  }

  public function set($value) {
    if (array_key_exists('sanitizer', $this->params))
      $value = call_user_func_array($this->params['sanitizer'], array($value));

    $this->storage->set($this->id, $value);
  }

  public function id() {
    return $this->id;
  }
}

?>
