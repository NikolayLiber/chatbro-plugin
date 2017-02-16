<?php

interface ICBroSettingsStorage {
  // Shortcuts for get/set setting value
  public function get($id);
  public function set($id, $value);

  // Add settings object to storage
  public function addSetting($id);
  // Get setting object
  public function getSetting($id);
}

interface ICBroSetting {
  public function id();
  public function get();
  public function set($value);
}

interface ICBroSettingsFactory {
  public function create($params);
}

?>
