<?php

namespace ChatBro\Common\Core\Backendable;

use ChatBro\Common\Core\Interfaces\ICBroBackend;
use Exception;

class CBroBackendable {
  private $backend;
  private static $instances = array();

  protected function __construct(ICBroBackend $backend) {
    $this->backend = $backend;
  }

  public static function init(ICBroBackend $backend) {
    $class = get_called_class();

    if (array_key_exists($class, self::$instances))
      return;

    self::$instances[$class] = new $class($backend);
  }

  protected static function get_instance() {
    $class = get_called_class();

    if (!array_key_exists($class, self::$instances))
      throw new Exception("{$class} is not initialized");

    return self::$instances[$class];
  }

  protected static function get_backend() {
    return self::get_instance()->backend;
  }
}

?>
