<?php

defined('_JEXEC') or die('Access Restricted');

require_once('common/settings/settings.php');
require_once('common/core/l10n/l10n.php');
require_once('common/core/l10n/functions.php');
require_once('common/permissions/permissions.php');
require_once('common/user/user.php');
require_once('common/utils/utils.php');
require_once('common/admin/admin.php');
require_once('backends/permissions.php');
require_once('backends/settings.php');
require_once('backends/user.php');
require_once('backends/utils.php');
require_once('backends/l10n.php');
require_once('backends/admin.php');

CBroUtils::init(new CBroJoomlaUtilsBackend());
CBroAdmin::init(new CBroJoomlaAdminBackend());
CBroSettings::init(new CBroJoomlaSettingsBackend());
CBroUser::init(new CBroJoomlaUserBackend());
CBroPermissions::init(new CBroJoomlaPermissionsBackend());
CBroL10N::init(new CBroJoomlaL10NBackend());

?>
