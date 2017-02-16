<?php

defined('_JEXEC') or die;

$controller = JControllerLegacy::getInstance('ChatBro');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

?>
