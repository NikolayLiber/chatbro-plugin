<?php

defined('_JEXEC') or die;

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
      $app->appendBody($script);
    }
}

?>
