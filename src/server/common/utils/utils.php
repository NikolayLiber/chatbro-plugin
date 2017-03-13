<?php

require_once(__DIR__ . '/../core/backendable.php');
require_once('exceptions.php');

class CBroUtils extends CBroBackendable {
  public static function gen_guid() {
    $instance = self::get_instance();
    $guid = $instance->_gen_uuid();
    $instance->call_constructor($guid);
    return $guid;
  }

  public static function get_site_url() {
    return self::get_backend()->get_site_url();
  }

  public static function get_site_domain() {
    return self::get_backend()->get_site_domain();
  }

  public static function get_platform() {
    return self::get_backend()->get_platform();
  }

  public static function is_front_page() {
    return self::get_backend()->is_front_page();
  }

  public static function check_path() {
    global $_SERVER;

    $page_match = false;
    $selected_pages = trim(CBroSettings::get(CBroSettings::selected_pages_setting));
    $display = CBroSettings::get(CBroSettings::display_setting);

    if ($selected_pages != '') {
      if (function_exists('mb_strtolower')) {
        $pages = mb_strtolower($selected_pages);
        $path = mb_strtolower($_SERVER['REQUEST_URI']);
      } else {
        $pages = strtolower($selected_pages);
        $path = strtolower($_SERVER['REQUEST_URI']);
      }

      $page_match = self::match_path($path, $pages);

      if($display == 'except_listed')
        $page_match = !$page_match;
    }

    return $page_match;
  }

  public function call_constructor($guid) {
    $url = "https://www.chatbro.com/constructor/{$guid}";

    try {
      self::get_backend()->http_get($url);
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

  public static function enque_script($file) {
    self::get_backend()->enque_script($file);
  }

  public static function enque_style($file) {
    self::get_backend()->enque_style($file);
  }
}

?>
