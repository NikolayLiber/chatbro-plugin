<?php

require_once('exceptions');

class CBroUtils {
  private $_http;

  public function __construct($http) {
    $this->$_http = $http;
  }

  public function gen_guid() {
    $guid = $this->_gen_uuid();
    $this->call_constructor($guid);
    return $guid;
  }

  public function call_contructor($guid) {
    $url = "https://www.chatbro.com/constructor/{$guid}";

    try {
      $this->$_http->get($url);
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
