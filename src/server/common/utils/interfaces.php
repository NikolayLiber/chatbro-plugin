<?php

interface ICBroUtilsBackend {
  function http_get($url);
  function get_site_url();
  function get_site_domain();
  function get_platform();
  function is_front_page();
  function enque_script($file);
  function enque_style($file);
  function get_locale();
  function get_request_var($var_name);
  function get_home_url();
  function get_default_profile_url();
  /*
    Возвращает значение атрибута data-offset-top (кол-во пикселей отступа от верха
    экрана, доехав до которого чат перестает скроллироваться) для чата поддержки.
  */
  function get_support_chat_data_offset_top();
}
?>
