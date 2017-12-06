<?php

if (!defined('WP_UNINSTALL_PLUGIN'))
  exit;

require_once(ABSPATH . '/wp-admin/includes/user.php');

require_once('backends/permissions.php');
require_once('backends/settings.php');
require_once('backends/utils.php');
require_once('backends/admin.php');
require_once('init.php');
require_once('wp_common.php');

CBroUtils::init(new CBroWPUtilsBackend());
CBroAdmin::init(new CBroWPAdminBackend());
CBroSettings::init(new CBroWPSettingsBackend());

foreach(CBroSettings::iterator() as $s) {
  $s->del();
}

foreach(get_editable_roles() as $name => $info) {
  $role = get_role($name);
  $role->remove_cap(CBroPermissions::cap_view);
  $role->remove_cap(CBroPermissions::cap_ban);
  $role->remove_cap(CBroPermissions::cap_delete);
}

CBroWPCommon::delete_option(CBroInit::caps_initialized);

?>
