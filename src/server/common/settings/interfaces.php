<?php

interface ICBroSetting {
  function id();
  function get();
  function set($value);
}

interface ICBroSettingsBackend {
  function get($id);
  function set($id, $value);
  function postponeWrite();
  function flush();
}

?>
