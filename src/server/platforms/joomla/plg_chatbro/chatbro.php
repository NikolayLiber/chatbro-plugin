<?php

defined('_JEXEC') or die('Access Restricted');

require_once(JPATH_LIBRARIES . '/chatbro/init.php');
require_once(JPATH_LIBRARIES . '/chatbro/common/chat.php');

class PlgSystemChatBro extends JPlugin {
  function onAfterRender() {
    $app = JFactory::getApplication();

    if ($app->isSite())
      $app->appendBody(CBroChat::get_sitewide_popup_chat_code());
  }
}

?>
