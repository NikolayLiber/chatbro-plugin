<?php

class CBroBackendable {
  private $backend;
  private static $instance;

  protected function __construct($backend) {
    $this->backend = $backend;
  }

  public static function init($backend) {
    if (self::$instance)
      return;

    $class = get_called_class();
    self::$instance = new $class($backend);
  }

  protected static function get_instance() {
    if (!self::$instance)
      throw new Exception(get_called_class() . " is not initialized");

    return self::$instance;
  }

  protected static function get_backend() {
    return self::get_instance()->backend;
  }
}

?>
