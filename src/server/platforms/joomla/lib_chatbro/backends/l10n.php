<?php

defined('_JEXEC') or die('Access Restricted');

require_once(__DIR__ . '/../common/core/l10n/interfaces.php');

class CBroJoomlaL10NBackend implements ICBroL10NBackend {
  public function get_locale() {
    return JFactory::getLanguage()->getTag();
  }

  public function get_user_locale($user_id = 0) {
    return $this->get_locale();
  }

  public function get_path_to_translations() {
    return JPATH_LIBRARIES . '/chatbro/languages';
  }
}

?>
