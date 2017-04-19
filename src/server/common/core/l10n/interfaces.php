<?php

interface ICBroL10NBackend {
  /**
   * Retrieves the current locale.
   */
  function get_locale();

  /**
   * Retrieves the locale of a user.
   *
   * If the user has a locale set to a non-empty string then it will be
   * returned. Otherwise it returns the locale of get_locale().
   */
   function get_user_locale($user_id = 0);

   function get_path_to_translations();
}

?>
