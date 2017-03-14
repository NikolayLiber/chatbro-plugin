<?php

interface ICBroSetting {
  function id();
  function get();
  function set($value);
  function get_params();
}

interface ICBroSettingsBackend {
  function get($id);
  function set($id, $value);
  function postponeWrite();
  function flush();
}

?>
