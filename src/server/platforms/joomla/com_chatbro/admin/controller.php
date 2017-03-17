<?php

defined('_JEXEC') or die('Access Restricted');

require_once(JPATH_LIBRARIES . '/chatbro/common/settings/settings.php');
require_once(JPATH_LIBRARIES . '/chatbro/common/save_settings.php');

class ChatBroController extends JControllerLegacy {
  protected $default_view = "chatbro";

  public function save_settings() {
    $ss = new CBroSaveSettings();
    echo $ss->save();
    JFactory::getApplication()->close();
  }
}

?>
