<?php

interface ICBroSetting {
  function id();
  function get();
  function set($value);
  function set_sanitized($value);
  function get_params();
  function sanitize($value);
}

interface ICBroSettingsBackend {
  function get($id);
  function set($id, $value);
  function postponeWrite();
  function flush();
}

?>
