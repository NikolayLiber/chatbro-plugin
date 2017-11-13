<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once(ABSPATH . '/wp-includes/class-wp-widget.php');
require_once(ABSPATH . '/wp-includes/formatting.php');

require_once('common/settings/settings.php');
require_once('common/user/user.php');
require_once('common/chat.php');


if (!class_exists('CBroWidget')) {
  class CBroWidget extends WP_Widget {
    const dtg = CBroWPSettingsBackend::display_to_guests;

    public function __construct() {
      parent::__construct(
            'chatbro',
            esc_html(__('ChatBro', 'chatbro')),
            array('description' => esc_html(__('ChatBro group chat', 'chatbro')))
      );
    }

    public static function register() {
      register_widget('CBroWidget');
    }

    private static function get_dtg($instance) {
      $display_to_guests = !!CBroSettings::get(self::dtg);

      if (isset($instance[self::dtg]))
        $display_to_guests = !!$instance[self::dtg];

      return $display_to_guests;
    }

    public function widget($args, $instance) {
      $display_to_guests = self::get_dtg($instance);

      if (!CBroUser::can_view() || ((!CBroUser::is_logged_in()) && (!$display_to_guests)))
        return;

      $container_id = 'chatbro-widget-' . rand(0, 99999);

      ?>
        <section id="<?php echo $container_id; ?>" class="widget">
          <?php echo CBroChat::get_static_chat_code(); ?>
        </section>
      <?php
    }

    public function form($instance) {
      $display_to_guests = self::get_dtg($instance);
      $dtg_id = $this->get_field_id(self::dtg);
      $dtg_name = $this->get_field_name(self::dtg);

      ?>
      <p>
        <label for="<?php echo $dtg_id; ?>">
          <input type="checkbox" id="<?php echo $dtg_id; ?>" name="<?php echo $dtg_name; ?>" class="checkbox" <?php echo $display_to_guests ? 'checked' : ''; ?>>
          <?php _e("Display chat to guests", "chatbro"); ?>
        </label>
      </p>
      <?php
    }

    public function update($new_instance, $old_instance) {
      $instance = array();
      $instance[self::dtg] = isset($new_instance[self::dtg]) ? !!$new_instance[self::dtg] : false;
      return $instance;
    }
  }
}

?>
