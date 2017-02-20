<?php

defined('_JEXEC') or die('Access Restricted');

require_once('common/utils/exceptions.php');
require_once('common/utils/interfaces.php');
jimport('joomla.http');


class CBroJoomlaHttp implements ICBroHttp {
  private $_http;

  public function __construct() {
      $this->_http = JHttpFactory::getHttp();
  }

  public function get($url) {
    $response = $this->_http->get($url);

    if (!$response || $response->code = 200)
      throw new CBroHttpError("HTTP GET Failed");

    return $response->body;
  }
}

?>
