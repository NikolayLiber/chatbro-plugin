<?php

require_once(__DIR__ . '/../core/backendable.php');
require_once('exceptions.php');

class CBroUtils extends CBroBackendable {
  public static function gen_guid() {
    $instance = self::get_instance();
    $guid = $instance->_gen_uuid();
    self::call_constructor($guid);
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
    $selected_pages = trim(CBroSettings::get(CBroSettings::selected_pages));
    $display = CBroSettings::get(CBroSettings::display);

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

  static function match_path($path, $patterns)
  {
      $to_replace = array(
          '/(\r\n?|\n)/',
          '/\\\\\*/',
      );
      $replacements = array(
          '|',
          '.*',
      );
      $patterns_quoted = preg_quote($patterns, '/');
      $regexps = '/^(' . preg_replace($to_replace, $replacements, $patterns_quoted) . ')$/';
      return (bool)preg_match($regexps, $path);
  }

  public static function http_get($url) {
    return self::get_backend()->http_get($url);
  }

  public static function call_constructor($guid) {
    $url = "https://www.chatbro.com/constructor/{$guid}";

    try {
      self::http_get($url);
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

  public static function get_locale() {
    return self::get_backend()->get_locale();
  }

  public static function get_request_var($var_name) {
    return self::get_backend()->get_request_var($var_name);
  }

  public static function sanitize_guid($guid) {
    $guid = trim(strtolower($guid));

    if (!preg_match('/^[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}$/', $guid))
      throw new CBroSanitizeError(__("Invalid chat secret key", 'chatbro'), CBroSanitizeError::Error);

    try {
      self::call_constructor($guid);
    }
    catch(Exception $e) {
      throw new CBroSanitizeError($e->getMessage(), CBroSanitizeError::Fatal);
    }

    return $guid;
  }

  public static function sanitize_display($val) {
    $p = CBroSettings::get_setting(CBroSettings::display)->get_params();
      $options = $p['options'];

      if (!in_array($val, array_keys($options)))
          throw new CBroSanitizeError(__("Invalid show popup chat option value", 'chatbro'), CBroSanitizeError::Error);

      return $val;
  }

  public static function sanitize_checkbox($val) {
      return ($val == "on");
  }

  public static function get_home_url() {
    return self::get_backend()->get_home_url();
  }

  public static function get_default_profile_url() {
    return self::get_backend()->get_default_profile_url();
  }

  public static function get_support_chat_data_offset_top() {
    return self::get_backend()->get_support_chat_data_offset_top();
  }
}

?>
