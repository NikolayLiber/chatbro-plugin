<?php

defined('_JEXEC') or die;

require_once(JPATH_LIBRARIES . '/chatbro/common/admin/admin.php');

$document = JFactory::getDocument();
$document->setTitle(JText::_('COM_CHATBRO'));

CBroAdmin::display();

?>
