<?php

namespace ChatBro\Common\Admin\Interfaces;

use ChatBro\Common\Core\Interfaces\ICBroBackend;

interface ICBroAdminBackend extends ICBroBackend {
  function has_permission_editor();
  function has_shortcodes();
  function get_login_url();
  function additional_fields();
  function render_permissions();
  function check_token();
  function get_help_text();
  function generated_scripts();
  function save_permissions();
}

?>
