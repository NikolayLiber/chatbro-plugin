<?php

defined('_JEXEC') or die('Access Restricted');

require_once(__DIR__ . '/../common/utils/exceptions.php');
require_once(__DIR__ . '/../common/utils/interfaces.php');
require_once(__DIR__ . '/../common/core/l10n/l10n.php');
require_once(__DIR__ . '/../common/core/version.php');
require_once('version.php');
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
    return 'joomla-plugin-' . chatbro_common_version . '.' . chatbro_joomla_minor_version;
  }

  public function is_front_page() {
    $app = JFactory::getApplication();
    $menu = $app->getMenu();
    $lang = JFactory::getLanguage();
    return $menu->getActive() == $menu->getDefault($lang->getTag());
  }

  public function enque_script($file) {
    $root = JURI::root();
    $root = substr($root, -1) == '/' ? $root : "{$root}/";
    JFactory::getDocument()->addScript($root . 'media/com_chatbro/js/' . $file);
  }

  public function enque_style($file) {
    $root = JURI::root();
    $root = substr($root, -1) == '/' ? $root : "{$root}/";
    JFactory::getDocument()->addStyleSheet($root . 'media/com_chatbro/css/' . $file);
  }

  public function get_locale() {
    return CBroL10N::get_locale();
  }

  public function get_request_var($var_name) {
    return JRequest::getVar($var_name);
  }

  public function get_home_url() {
    return JURI::root();
  }

  public function get_default_profile_url() {
    return "";
  }

  public function get_support_chat_data_offset_top() {
    return 105;
  }
}

?>
