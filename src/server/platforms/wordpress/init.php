<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once('common/settings/settings.php');
require_once('common/permissions/permissions.php');
require_once('common/user/user.php');
require_once('common/utils/utils.php');
require_once('common/admin/admin.php');
require_once('backends/permissions.php');
require_once('backends/settings.php');
require_once('backends/user.php');
require_once('backends/utils.php');
require_once('backends/admin.php');
require_once('wp_common.php');
require_once('common/chat.php');
require_once('shortcode.php');
require_once('widget.php');


class CBroInit {
  public static function load_textdomain() {
    load_plugin_textdomain('chatbro', false, dirname(plugin_basename(__FILE__)) . '/common/languages');
  }

  public static function init_backends() {
    CBroUtils::init(new CBroWPUtilsBackend());
    CBroAdmin::init(new CBroWPAdminBackend());
    CBroSettings::init(new CBroWPSettingsBackend());
    CBroUser::init(new CBroWPUserBackend());
    CBroPermissions::init(new CBroWPPermissionsBackend());

    // Инициализируем шорткоды
    CBroShortCode::get_instance();
  }

  public static function add_menu_option() {
    add_menu_page("ChatBro", "ChatBro", "manage_options", "chatbro_settings", array('CBroAdmin', 'display'), plugins_url()."/chatbro/favicon_small.png");
  }

  public static function chat() {
    echo CBroChat::get_popup_chat_code();
  }

  public static function init() {
    add_action('plugins_loaded', array('CBroInit', 'load_textdomain'));
    add_action('init', array('CBroInit', 'init_backends'));
    add_action('admin_menu', array('CBroInit', 'add_menu_option'));
    add_action('wp_footer', array('CBroInit', 'chat'));
    add_action('wp_ajax_chatbro_save_settings', array('CBroWPCommon', 'ajax_save_settings'));
    add_action('wp_ajax_chatbro_get_faq', array('CBroAdmin', 'get_faq'));
    add_action('widgets_init', array('CBroWidget', 'register'));
  }
}

?>
