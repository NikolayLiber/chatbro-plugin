<?php

require_once('exceptions.php');

class CBroUtils {
  private $_http;
  private static $_instance;

  protected function __construct($http) {
    $this->_http = $http;
  }

  public static function init($http) {
    if (!self::$_instance)
      self::$_instance = new CBroUtils($http);

    return self::$_instance;
  }

  public static function get_instance() {
    if (!self::$_instance)
      throw new Exception("CBroUtils is not initialized");

    return self::$_instance;
  }

  public function gen_guid() {
    $instance = self::get_instance();
    $guid = $instance->_gen_uuid();
    $instance->call_constructor($guid);
    return $guid;
  }

  public function call_contructor($guid) {
    $url = "https://www.chatbro.com/constructor/{$guid}";

    try {
      $this->_http->get($url);
    }
    catch(CBroHttpError $e) {
      throw new Exception('Failed to call chat constructor: ' . $e->getMessage());
    }
  }

  private function _gen_uuid() {
    return strtolower(sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      // 32 bits for "time_low"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

      // 16 bits for "time_mid"
      mt_rand( 0, 0xffff ),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand( 0, 0x0fff ) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand( 0, 0x3fff ) | 0x8000,

      // 48 bits for "node"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    ));
  }
}

?>
