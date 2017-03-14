<?php

defined('_JEXEC') or die;

require_once(JPATH_LIBRARIES . '/chatbro/admin.php');

$document = JFactory::getDocument();
$document->setTitle('Chatbro');
JToolBarHelper::title("Chatbro");

$admin = new CBroJoomlaAdmin(false);
$admin->display();
// throw new Exception("AAA!!");

?>
