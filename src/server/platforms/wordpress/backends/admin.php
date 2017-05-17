<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once(__DIR__ . '/../common/admin/interfaces.php');

class CBroWPAdminBackend implements ICBroAdminBackend {
  function has_permission_editor() {
    return true;
  }

  function has_shortcodes() {
    return true;
  }

  function get_login_url() {
    return wp_login_url(get_permalink());
  }

  function additional_fields() {
    wp_create_nonce("chatbro_save_settings", "chb-sec");
  }

  function render_permissions() {

  }

  function check_token() {

  }

  function get_help_text() {

  }

  function generated_scripts() {

  }
}

?>
