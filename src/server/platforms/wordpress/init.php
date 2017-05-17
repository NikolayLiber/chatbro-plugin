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

class CBroInit {
  public static function load_textdomain() {
    load_plugin_textdomain('chatbro', false, dirname(plugin_basename(__FILE__)) . '/common/languages');
  }
}

CBroUtils::init(new CBroJoomlaUtilsBackend());
CBroAdmin::init(new CBroJoomlaAdminBackend());
CBroSettings::init(new CBroWPSettingsBackend());
CBroUser::init(new CBroJoomlaUserBackend());
CBroPermissions::init(new CBroJoomlaPermissionsBackend());

add_action('plugins_loaded', array('CBroInit', 'load_textdomain'));

?>
