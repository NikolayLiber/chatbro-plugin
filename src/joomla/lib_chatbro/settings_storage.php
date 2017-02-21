<?php

defined('_JEXEC') or die('Access Restricted');

require_once('common/settings/interfaces.php');
require_once('common/settings/exceptions.php');

class CBroJoomlaSettingsStorage implements ICBroSettingsStorage {
  private $postponed;
  private $has_changes;
  private $settings;

  public function __construct() {
    $this->postponed = false;
    $this->has_changes = false;
    $this->settings = JComponentHelper::getParams('com_chatbro', true);

    if ($this->settings === false)
      throw new Exception("Component com_chatbro not found");
  }

  public function get($id) {
    $res = $this->settings->get($id);

    if ($res === null)
      throw new CBroSettingNotFound();

    return $res;
  }

  public function set($id, $value) {
    $this->settings->set($id, $value);
    $this->has_changes = true;

    if (!$this->postponed)
      $this->flush();
  }

  public function postponeWrite() {
    $this->postponed = true;
  }

  public function flush() {
    $this->postponed = false;

    if (!$this->has_changes)
      return;

    $component_id = JComponentHelper::getComponent('com_chatbro')->id;
    $table = JTable::getInstance('extension');
    $table->load($component_id);
    $table->bind(array('params' => $this->settings->toString()));

    // check for error
    if (!$table->check())
      throw new Exception('Failed to save settings; ' . $table->getError());

    // Save to database
    if (!$table->store())
      throw new Exception('Failed to save settings; ' . $table->getError());
  }
}

?>