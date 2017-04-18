<?php

defined('_JEXEC') or die;

class ChatBroViewChatBro extends JViewLegacy {
  function display($tpl = null) {
    JToolBarHelper::title(JText::_('COM_CHATBRO'));
    JToolBarHelper::preferences("com_chatbro");
    parent::display($tpl);
  }
}

?>
