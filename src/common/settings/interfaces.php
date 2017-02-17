<?php

interface ICBroSettingsStorage extends Iterator {
  // Shortcuts for get/set setting value
  function get($id);
  function set($id, $value);

  // Add settings object to storage
  function addSetting($setting);
  // Get setting object
  function getSetting($id);
}

interface ICBroSetting {
  function id();
  function get();
  function set($value);
}

interface ICBroSettingsFactory {
  function createSetting($params);
}

?>
