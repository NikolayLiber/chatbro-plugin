<?php

namespace ChatBro\Common\User\Interfaces;

use ChatBro\Common\Core\Interfaces\ICBroBackend;

interface ICBroUserBackend extends ICBroBackend {
  function is_logged_in();
  function is_admin();
  function avatar_url();
  function profile_url();
  function id();
  function display_name();
  function full_name();
}

?>
