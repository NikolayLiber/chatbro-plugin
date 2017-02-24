<?php

defined('_JEXEC') or die('Access Restricted');

require_once(__DIR__ . '/../common/user/interfaces.php');

class CBroJoomlaUserBackend implements ICBroUserBackend {
  private $user;

  public function __construct() {
    $this->user = JFactory::getUser();
  }

  public function is_guest() {
    return $this->user->guest;
  }
}

?>
