<?php

require_once('exceptions.php');
require_once('interfaces.php');

class CBroSetting implements ICBroSetting {
  private $backend;
  private $params;
  private $id;

  public function __construct($backend, $params) {
    $this->params = $params;
    $this->backend = $backend;

    if (!array_key_exists('id', $this->params))
      throw new Exception("Invalid setting params (no id)");

    $this->id = $params['id'];

    $value = null;
    try {
      $value = $this->backend->get($this->id);
    }
    catch(CBroSettingNotFound $e) {
      if (array_key_exists('generator', $this->params))
        $value = call_user_func_array($this->params['generator'], array());
      elseif (array_key_exists('default', $this->params))
        $value = $this->params['default'];
      elseif (!$this->params['required'])
        return;
      else
        throw $e;

      $this->backend->set($this->id, $value);
    }
  }

  public function get() {
    $value = null;
    try {
      $value = $this->backend->get($this->id);
    }
    catch(CBroSettingNotFound $e) {
      if ($this->is_required())
        throw $e;
    }

    return $value;
  }

  public function set_sanitized($value) {
    $this->backend->set($this->id, $value);
  }
  public function set($value) {
    $this->set_sanitized($this->id, $this->sanitize($value));
  }

  public function id() {
    return $this->id;
  }

  public function get_params() {
    return $this->params;
  }

  public function sanitize($value) {
    if (array_key_exists('sanitizer', $this->params))
      $value = call_user_func_array($this->params['sanitizer'], array($value));

    return $value;
  }

  public function is_required() {
    return $this->params['required'] === true;
  }

  public function del() {
    $this->backend->del($this->id);
  }
}

?>
