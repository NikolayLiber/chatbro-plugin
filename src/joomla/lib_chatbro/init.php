<?php

defined('_JEXEC') or die('Access Restricted');

require_once('common/settings/settings.php');
require_once('common/utils/utils.php');
require_once('http.php');
require_once('settings_storage.php');

CBroUtils::init(new CBroJoomlaHttp());
CBroSettings::init(new CBroJoomlaSettingsStorage());

?>
