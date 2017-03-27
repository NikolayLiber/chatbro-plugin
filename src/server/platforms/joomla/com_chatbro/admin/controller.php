<?php

defined('_JEXEC') or die('Access Restricted');

require_once(JPATH_LIBRARIES . '/chatbro/common/settings/settings.php');
require_once(JPATH_LIBRARIES . '/chatbro/common/admin/admin.php');

class ChatBroController extends JControllerLegacy {
  protected $default_view = "chatbro";

  public function save_settings() {
    echo CBroAdmin::save_settings();
    JFactory::getApplication()->close();
  }

  public function get_faq() {
    echo CBroAdmin::get_faq();
    JFactory::getApplication()->close();
  }
}

?>
