<?php

class CBroHttpError extends Exception {
  public function __construct($message) {
    parent::__construct($message);
  }
}

class CBroSanitizeError extends Exception {
  const Error = "error";
  const Fatal = "fatal";
  private $type;

  public function __construct($message, $type) {
    $this->type = $type;
    parent::__construct($message);
  }

  public function type() {
    return $this->type;
  }
}
?>
