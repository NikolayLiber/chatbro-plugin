<?php

defined('_JEXEC') or die("Access Restricted");

require_once(__DIR__ . '/../common/admin/interfaces.php');
require_once(__DIR__ . '/../common/admin/admin.php');

class CBroJoomlaAdminBackend implements ICBroAdminBackend {
  function __construct() {
    $this->view_levels = [];

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select($db->quoteName(array('id', 'title')));
    $query->from($db->quoteName('#__viewlevels'));
    $query->order('ordering ASC');
    $db->setQuery($query);

    foreach($db->loadAssocList() as $r)
      $this->view_levels[$r['id']] = $r['title'];
  }

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

  function render_permissions() {}

  function get_help_text() {
    ob_start();
    ?>
      <ul>
        <li><?php _e('Enable chatbro plugin to add popup chat widget to your site.', 'chatbro'); ?></li>
        <li><?php _e('Use chatbro module to add chat to desired place on your page.', 'chatbro'); ?></li>
        <li><?php _e('Manage chat administrator permissions (ban user, delete messages) on Chatbro Component options page.', 'chatbro'); ?></li>
      </ul>
    <?php

    $text = ob_get_contents();
    ob_clean();

    return $text;
  }
}

?>
