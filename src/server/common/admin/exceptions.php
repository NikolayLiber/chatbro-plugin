<?php

namespace ChatBro\Common\Admin\Exceptions;

class CBroPermissionsSaveError extends Exception {
  public function __construct($msg) {
    parent::__construct($msg);
  }
}

?>
