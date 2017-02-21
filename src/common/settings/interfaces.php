<?php

interface ICBroSetting {
  function id();
  function get();
  function set($value);
}

interface ICBroSettingsStorage {
  function get($id);
  function set($id, $value);
  function postponeWrite();
  function flush();
}

?>
