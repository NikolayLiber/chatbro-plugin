<?php

interface ICBroUtilsBackend {
  function http_get($url);
  function get_site_url();
  function get_site_domain();
  function get_platform();
  function is_front_page();
  function enque_script($file);
  function enque_style($file);
}
?>
