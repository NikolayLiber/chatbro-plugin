<?php

defined('_JEXEC') or die('Access Restricted');

require_once(JPATH_LIBRARIES . '/chatbro/init.php');
require_once(JPATH_LIBRARIES . '/chatbro/common/chat.php');

class PlgSystemChatBro extends JPlugin {
    function onAfterRender() {
      ob_start();
      ?>
        <script id="chatbro">
          console.log('Hello from chatbro!!!');
        </script>
      <?php

      $script = ob_get_contents();
      ob_end_clean();

      $app = JFactory::getApplication();
      $app->appendBody(CBroChat::get_popup_chat_code());
      // $app->appendBody($script);
    }
}

?>
