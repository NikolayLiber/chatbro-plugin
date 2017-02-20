<?php

defined('_JEXEC') or die;

require_once(JPATH_LIBRARIES . '/chatbro/init.php');

$controller = JControllerLegacy::getInstance('ChatBro');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

?>
