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

  public function get_site_url() {
    return JURI::root();
  }

  public function get_site_domain() {
    $uri = new JURI(JURI::current());
    return $uri->getHost();
  }

  public function get_platform() {
    return 'joomla-plugin-0.0.1';
  }

  public function is_front_page() {
    $app = JFactory::getApplication();
    $menu = $app->getMenu();
    $lang = JFactory::getLanguage();
    return $menu->getActive() == $menu->getDefault($lang->getTag());
  }
}

?>
