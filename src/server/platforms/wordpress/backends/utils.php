<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once(__DIR__ . '/../common/utils/exceptions.php');
require_once(__DIR__ . '/../common/utils/interfaces.php');
require_once(__DIR__ . '/../common/core/version.php');
require_once(__DIR__ . '/../wp_common.php');
require_once('version.php');

class CBroWPUtilsBackend implements ICBroUtilsBackend {
  static private $scripts_count = 0;
  static private $styles_count = 0;

  function http_get($url) {
    $response = wp_safe_remote_get($url);
    if (is_wp_error($response)) {
      throw new CBroHttpError($response->get_error_message());
    }

    return $response['body'];
  }

  function get_site_url() {
    return CBroWPCommon::get_option('siteurl');
  }

  function get_site_domain() {
    $url = self::get_site_url();
    if (!preg_match('/^.+:\/\/([^\/\:]+)/', $url, $m))
        return '';

    return $m[1];
  }

  function get_platform() {
    return 'wordpress-plugin-' . chatbro_common_version . '.' . chatbro_wp_minor_version;
  }

  function is_front_page() {
    return is_front_page();
  }

  function enque_script($file) {
    wp_enqueue_script('chatbro' . ++self::$scripts_count, plugins_url('chatbro/js/' . $file));
  }

  function enque_style($file) {
    wp_enqueue_style('chatbro' . ++self::$styles_count, plugins_url('chatbro/css/' . $file));
  }

  function get_locale() {
    return get_locale();
  }

  function get_request_var($var_name) {
    global $_POST;

    if (in_array($var_name, array_keys($_POST)))
      return $_POST[$var_name];

    return null;
  }

  function get_home_url() {
    return get_home_url();
  }

  function get_default_profile_url() {
    return get_home_url() . '/';
  }

  /*
    Возвращает значение атрибута data-offset-top (кол-во пикселей отступа от верха
    экрана, доехав до которого чат перестает скроллироваться) для чата поддержки.
  */
  function get_support_chat_data_offset_top() {
    return 53;
  }
}

?>
