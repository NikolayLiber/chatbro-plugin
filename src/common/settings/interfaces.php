<?php

interface ICBroSettingsManager extends Iterator {
  // Shortcuts for get/set setting value
  function get($id);
  function set($id, $value);

  // Add settings object to storage
  function add_setting($setting);
  // Get setting object
  function get_setting($id);
}

interface ICBroSetting {
  function id();
  function get();
  function set($value);
}

interface ICBroSettingsFactory {
  function create_setting($params);
}

?>
