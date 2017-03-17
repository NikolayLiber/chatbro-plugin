<?php

interface ICBroPermissionsBackend {
  function can($capability);
  function can_manage_settings();
}

?>
