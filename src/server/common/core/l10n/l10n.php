<?php

require_once('pomo/mo.php');
require_once(__DIR__ . '/../backendable.php');
require_once(__DIR__ . '/../../user/user.php');

class CBroL10N extends CBroBackendable {
  private static $l10n = array();
  private static $noop_translations = null;

  /**
   * Return the Translations instance for a text domain.
   *
   * If there isn't one, returns empty Translations instance.
   *
   * @param string $domain Text domain. Unique identifier for retrieving translated strings.
   * @return Translations|NOOP_Translations A Translations instance.
   */
  static function get_translations_for_domain( $domain ) {
    if ( isset( self::$l10n[ $domain ] ) || ( self::_load_textdomain_just_in_time( $domain ) && isset( self::$l10n[ $domain ] ) ) ) {
      return self::$l10n[ $domain ];
    }

    if ( null === self::$noop_translations ) {
      self::$noop_translations = new NOOP_Translations;
    }

    return self::$noop_translations;
  }

  private static function _load_textdomain_just_in_time( $domain ) {
    // Short-circuit if domain is 'default' which is reserved for core.
    if ( 'default' === $domain ) {
      return false;
    }

    $translation_path = self::get_backend()->get_path_to_translations();
    if ( false === $translation_path ) {
      return false;
    }

    return self::load_textdomain( $domain, $translation_path );
  }

  private static function load_textdomain( $domain, $mofile ) {
    if ( !is_readable( $mofile ) )
      return false;

    $mo = new MO();
    if ( !$mo->import_from_file( $mofile ) )
      return false;

    if ( isset( self::$l10n[$domain] ) )
      $mo->merge_with( self::$l10n[$domain] );

    self::$l10n[$domain] = &$mo;

    return true;
  }

  public static function load_plugin_textdomain() {
    $locale = CBroUser::is_admin() ? self::get_backend()->get_user_locale() : self::get_backend()->get_locale();
    $mofile = self::get_backend()->get_path_to_translations() . '/chatbro-' . $locale . '.mo';
    return self::load_textdomain('chatbro', $mofile);
  }

  /**
   * Retrieve the translation of $text.
   *
   * If there is no translation, or the text domain isn't loaded, the original text is returned.
   **/
  static function translate($text, $domain = 'default') {
    $translations = self::get_translations_for_domain( $domain );
    return $translations->translate( $text );
  }

  /**
   * Retrieve the translation of $text in the context defined in $context.
   *
   * If there is no translation, or the text domain isn't loaded the original
   * text is returned.
   */
  public static function translate_with_gettext_context( $text, $context, $domain = 'default' ) {
    $translations = self::get_translations_for_domain( $domain );
    return $translations->translate( $text, $context );
  }

  public static function translate_plural( $single, $plural, $number, $context, $domain = 'default' ) {
    $translations = self::get_translations_for_domain( $domain );
    return $translations->translate_plural( $single, $plural, $number, $context );
  }

  public static function get_locale() {
    return self::get_backend()->get_locale();
  }
}

?>
