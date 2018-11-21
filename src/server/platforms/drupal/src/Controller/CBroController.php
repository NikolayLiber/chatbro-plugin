<?php

namespace Drupal\chatbro_com\Controller;

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
