<?php

namespace ChatBro\Common\Permissions\Interfaces;

use ChatBro\Common\Core\Interfaces\ICBroBackend;

interface ICBroPermissionsBackend extends ICBroBackend {
  function can($capability);
  function can_manage_settings();
}

?>
