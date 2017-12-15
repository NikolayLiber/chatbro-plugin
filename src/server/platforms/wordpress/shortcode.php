<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once('common/settings/settings.php');
require_once('common/user/user.php');
require_once('common/chat.php');

if (!class_exists("CBroShortCode")) {
  class CBroShortCode {
    private static $instance = null;

    private function __construct() {
        add_shortcode('chatbro', array(&$this, 'render'));
    }

    public static function get_instance() {
      if (!self::$instance)
        self::$instance = new CBroShortCode();

      return self::$instance;
    }

    public static function render($atts, $content = null) {
      $a = shortcode_atts(array(
          'static' => true,
          'registered_only' => false
      ), $atts);

      if (!CBroSettings::get(CBroSettings::enable_shortcodes))
          return "";

      // If "registered_only" attribute is explicitly set in shortcode then it will be used or global display_to_guests_setting will be used
      $registered_only = $atts && array_key_exists('registered_only', $atts) ? (strtolower($a['registered_only']) == 'true' || $a['registered_only'] == '1') : !CBroSettings::get(CBroWPSettingsBackend::display_to_guests);
      $static = strtolower($a['static']) == 'true' || $a['static'] == '1';


      if (!CBroUser::can_view() || ($registered_only && !CBroUser::is_logged_in()))
        return "";

      $code = $static ? CBroChat::get_static_chat_code() : CBroChat::get_chat_code();
      return $code;
    }
  }
}

?>
