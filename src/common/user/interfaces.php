<?php

interface ICBroUserBackend {
  function is_logged_in();
  function avatar_url();
  function profile_url();
  function id();
  function display_name();
  function full_name();
}

?>
