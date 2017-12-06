<?php

interface ICBroSetting {
  function id();
  function get();
  function set($value);
  function set_sanitized($value);
  function get_params();
  function sanitize($value);
  function del();
}

interface ICBroSettingsBackend {
  // Прочитать сохраненное значение параметра
  function get($id);
  // Сохранить значение параметра
  function set($id, $value);
  // Удаление параметра из базы
  function del($id);
  // Отложить запись в хранилище до вызова flush (можно использовать когда параметры
  // хранятся не в виде отдельных записей в базе, а одним куском, чтобы не пере
  // писывать их по 10 раз)
  function postpone_write();
  function flush();
  // Добавить в CBroSettings дополнительные параметры
  function add_extra_settings($settings);
}

?>
