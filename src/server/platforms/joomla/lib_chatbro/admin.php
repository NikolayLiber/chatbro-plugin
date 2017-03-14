<?php

defined('_JEXEC') or die('Access Restricted');

require_once('common/admin.php');

class CBroJoomlaAdmin extends CBroAbstractAdmin {
  protected function additional_fields() {}

  protected function get_login_url() {
    return "/login.php";
  }
}

?>
