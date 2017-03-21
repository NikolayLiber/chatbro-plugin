<?php

defined('_JEXEC') or die("Access Restricted");

require_once(__DIR__ . '/../common/admin/interfaces.php');
require_once(__DIR__ . '/../common/admin/admin.php');

class CBroJoomlaAdminBackend implements ICBroAdminBackend {
  function has_permission_editor() {
    return false;
  }

  function has_shortcodes() {
    return false;
  }

  function get_login_url() {
    return "/login.php";
  }

  function additional_fields() {
    echo JHtml::_('form.token');
  }

  function check_token() {
    return JSession::checkToken();
  }
}

?>
