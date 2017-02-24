<?php

defined('_JEXEC') or die('Access Restricted');

require_once(__DIR__  . '/../common/utils/exceptions.php');
require_once(__DIR__  . '/../common/utils/interfaces.php');
jimport('joomla.http');

class CBroJoomlaUtilsBackend implements ICBroUtilsBackend {
  private $_http;

  public function __construct() {
      $this->_http = JHttpFactory::getHttp();
  }

  public function http_get($url) {
    $response = $this->_http->get($url);

    if (!$response || $response->code != 200)
      throw new CBroHttpError("HTTP GET Failed");

    return $response->body;
  }
}

?>
