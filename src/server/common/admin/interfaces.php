<?php

interface ICBroAdminBackend {
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
