<?php

defined('_JEXEC') or die('Access Restricted');

require_once(__DIR__ . '/../common/user/interfaces.php');

class CBroJoomlaUserBackend implements ICBroUserBackend {
  private $user;

  public function __construct() {
    $this->user = JFactory::getUser();
  }

  public function is_logged_in() {
    return !$this->user->guest;
  }

  public function avatar_url() {
    return "";
  }

  public function profile_url() {
    return "";
  }

  public function id() {
    return $this->user->id;
  }

  public function display_name() {
    return $this->user->username;
  }

  public function full_name() {
    return $this->user->name;
  }
}

?>
