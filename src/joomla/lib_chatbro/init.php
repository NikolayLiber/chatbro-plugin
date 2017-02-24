<?php

defined('_JEXEC') or die('Access Restricted');

require_once('common/settings/settings.php');
require_once('common/permissions/permissions.php');
require_once('common/utils/utils.php');
require_once('backends/permissions.php');
require_once('backends/settings.php');
require_once('backends/utils.php');

CBroUtils::init(new CBroJoomlaUtilsBackend());
CBroSettings::init(new CBroJoomlaSettingsBackend());
CBroPermissions::init(new CBroJoomlaPermissionsBackend());

?>
