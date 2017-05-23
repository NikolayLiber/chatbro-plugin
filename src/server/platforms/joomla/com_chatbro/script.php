<?php

defined('_JEXEC') or die;

class com_chatbroInstallerScript {
  public function install($parent) {}
  public function uninstall($parent) {}
  public function preflight ($type, $parent) {}

  public function postflight ($type, $parent) {
    $this->run("update #__extensions set enabled=1 where type = 'plugin' and element = 'chatbro'");
  }

  private function run ($query)
  {
    $db = JFactory::getDBO();
    $db->setQuery($query);
    $db->query();
  }
}

?>
