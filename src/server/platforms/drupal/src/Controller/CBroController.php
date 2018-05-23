<?php

namespace Drupal\chatbro\Controller;

use Drupal\Core\Controller\ControllerBase;

class CBroController extends ControllerBase {
  public function content() {
    return [
      "type" => "markup",
      "#markup" => $this->t('ChatBro nah!!!')
    ];
  }
}

?>
