<?php

require_once(__DIR__ . '/../core/backendable.php');
require_once(__DIR__ . '/../permissions/permissions.php');
require_once(__DIR__ . '/../utils/utils.php');
require_once('exceptions.php');

class CBroAdmin extends CBroBackendable {
  public static function display() {
    self::get_instance()->display_admin();
  }

  private function display_admin() {
    CBroUtils::enque_style('chatbro.css');
    CBroUtils::enque_script('chatbro.js');

    $guid = CBroSettings::get(CBroSettings::guid);

    ?>
    <div id="chatbro-admin">
      <?php
        self::get_backend()->generated_scripts();
        $this->render_tabs();
      ?>
        <div class="tab-content">
          <?php
            $this->render_constructor_tab($guid);
            $this->render_settings_tab($guid);
            $this->render_contact_us_tab();
          ?>
        </div>
      </div>
    <?php
  }

  private function render_tabs() {
    ?>
    <ul id="settings-tabs" class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#constructor" aria-controls="constructor" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-wrench"></span><span class="tab-title hidden-xs"><?php _e("Chat Constructor", 'chatbro'); ?></span></a>
        </li>
        <li role="presentation">
            <a href="#plugin-settings" aria-controls="plugin-settings" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-cog"></span><span class="tab-title hidden-xs"><?php _e("Plugin Settings", 'chatbro'); ?></span></a>
        </li>
        <li role="presentation">
            <a href="#contact-us" aria-controls="contact-us" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-question-sign"></span><span class="tab-title hidden-xs"><?php _e("Help", "chatbro"); ?></span></a>
        </li>
    </ul>
    <?php
  }

  private function render_constructor_tab($guid) {
    ?>
    <div role="tabpanel" class="tab-pane fade in active" id="constructor">
        <iframe id="chatbro-constructor" name="chatbro-constructor"></iframe>
        <form id="load-constructor" target="chatbro-constructor" action="https://www.chatbro.com/constructor/<?php echo $guid; ?>/" method="GET">
            <input type="hidden" name="guid" value="<?php echo $guid; ?>">
            <input type="hidden" name="avatarUrl" value="<?php echo CBroUser::avatar_url(); ?>">
            <input type="hidden" name="userFullName" value="<?php echo CBroUser::display_name(); ?>">
            <input type="hidden" name="userProfileUrl" value="<?php echo CBroUser::profile_url(); ?>">
        </form>
        <script>
            jQuery("#load-constructor").submit();
        </script>
    </div>
    <?php
  }

  private function render_settings_tab($guid) {
    ?>
    <div role="tabpanel" class="tab-pane fade in container-fluid" id="plugin-settings">
        <?php $this->render_guid_confirmation_modal(); ?>

        <div class="row">
            <div class="col-lg-8">
                <div id="chatbro-message" role="alert"></div>
                <?php
                    $this->render_settings_form($guid);
                ?>
            </div>
            <?php $this->render_help_block(); ?>
        </div>
    </div>
    <?php
  }

  static private function get_support_chat_id() {
    $chats = array (
      'en' => '083y',
      'ru' => '47cs'
    );

    $locale = CBroUtils::get_locale();

    if (isset($chats[$locale]))
      return $chats[$locale];

    $t = explode('_', $locale);
    $lang = $t[0];

    if (isset($chats[$lang]))
      return $chats[$lang];

    return $chats['en'];
  }

  private function render_contact_us_tab() {
    ?>
    <div id="contact-us" role="tabpanel" class="tab-pane fade in container-fluid" >
      <div class="row">
        <div id="chatbro-chat-panel" class="col-lg-6 col-lg-push-6">
          <div id="support-chat" data-spy="affix" data-offset-top="<?php echo CBroUtils::get_support_chat_data_offset_top(); ?>"></div>
        </div>
        <div id="chatbro-faq-panel" class="col-lg-6 col-lg-pull-6">
          <h2><?php _e("Frequently Asked Questions", "chatbro"); ?></h2>
          <p id="chatbro-faq"></p>
        </div>
      </div>
      <script id="chatBroEmbedCode">
        /* Chatbro Widget Embed Code Start */function ChatbroLoader(chats,async) {async=async!==false;var params={embedChatsParameters:chats instanceof Array?chats:[chats],needLoadCode:typeof Chatbro==='undefined'};var xhr=new XMLHttpRequest();xhr.withCredentials = true;xhr.onload=function(){eval(xhr.responseText)};xhr.onerror=function(){console.error('Chatbro loading error')};xhr.open('POST','//www.chatbro.com/embed_chats/',async);xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');xhr.send('parameters='+encodeURIComponent(JSON.stringify(params)))}/* Chatbro Widget Embed Code End */
        ChatbroLoader({encodedChatId: '<?php echo self::get_support_chat_id(); ?>'});
      </script>
    </div>
    <?php
  }

  private function render_guid_confirmation_modal() {
    ?>
    <div id="chb-confirm-guid-modal-wrapper">
      <div class="modal fade" id="chb-confirm-guid-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"><?php _e("You are about to change the secret key", "chatbro"); ?></h4>
            </div>
            <p class="modal-body">
              <?php
              _e('Please be noticed that your current chat configuration and content are identified by your secret key and if you lose it there
              will be no way to restore access to you current chat unless you have registered an account at
              <a href="https://chatbro.com">Chatbro.com</a>. Please make sure that you have saved your old secret key and fully understand
              what are you going to do.', 'chatbro');
              ?>
              <p id="chb-old-key">
                  <?php _e("Your old secret key: <span></span>", "chatbro"); ?>
              </p>
            </p>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("Cancel", "chatbro"); ?></button>
              <button type="button" class="btn btn-primary"><?php _e("Change Secret Key", "chatbro"); ?></button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
  }

  private function render_settings_form($guid) {
    ?>
    <form id="chatbro-settings-form" class="form-horizontal" data-toggle="validator" role="form">
      <?php self::get_backend()->additional_fields(); ?>
      <input id="chb-login-url" name="chb-login-url" type="hidden" value="<?php echo self::get_backend()->get_login_url(); ?>">
      <input id="chb-sec-key" name="chb-sec-key" type="hidden" value = "<?php echo $guid ?>">
      <?php
          foreach(CBroSettings::iterator() as $name => $setting) {
            $this->render_field($setting->get_params());
          }

          self::get_backend()->render_permissions();
      ?>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button id="chatbro-save" type="button" class="btn btn-primary" data-saving-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving Changes"><?php _e('Save Changes', 'chatbro'); ?></button>
       </div>
      </div>
    </form>
    <?php
  }

  private function render_help_block() {
    $help_text = self::get_backend()->get_help_text();

    if (!$help_text)
      return;

    ?>
      <div id="chatbro-shortcode-tip" class="col-lg-4">
        <div class="bs-callout bs-callout-info">
          <h3><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span><span id="cbro-useful-tip"><?php _e("Useful Tips", "chatbro"); ?></span></h3>
          <?php echo $help_text; ?>
        </div>
      </div>
    <?php
  }

  private function render_field($args) {
    if (array_key_exists('hidden', $args) && $args['hidden'] == true)
      return;

    $id = $args['id'];
    $type = $args['type'];
    $label = $args['label'];

    ?>
    <div id="<?php echo $id; ?>-group" class="form-group">
      <?php
      if($type == CBroInputType::checkbox)
        $this->render_checkbox($id, $label);
      else
        $this->render_other($id, $label, $args);
      ?>
    </div>
    <?php
  }

  private function render_checkbox($id, $label) {
    $checked = CBroSettings::get($id) ? 'checked="checked"' : '';
    ?>

    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input id="<?php echo $id; ?>" type="checkbox" name="<?php echo $id; ?>" <?php echo $checked; ?> >
          <?php _e($label, 'chatbro'); ?>
        </label>
      </div>
    </div>
    <?php
  }

  private function render_other($id, $label, $args) {
    ?>
    <label for="<?php echo $id; ?>" class="col-sm-2 control-label"><?php _e($label, 'chatbro'); ?></label>
    <div class="col-sm-10">
      <?php
        if (array_key_exists('addon', $args))
          $this->render_addon($id, $args);
        else
          $this->render_control($id, $args);

        ?>
        <div class="help-block with-errors"></div>
        <?php

        if (array_key_exists('help_block', $args)) {
          $help_block = $args['help_block'];
          ?>
          <div class="input-group">
            <span class="help-block"><?php _e($help_block, 'chatbro'); ?></span>
          </div>
          <?php
        }
      ?>
    </div>
    <?php
  }

  private function render_addon($id, $args) {
    $addon = $args['addon'];
    ?>
    <div class="input-group">
      <span class="input-group-addon"><?php echo $addon; ?></span>
      <?php $this->render_control($id, $args); ?>
    </div>
    <?php
  }

  private function render_control($id, $args) {
    $value = CBroSettings::get($id);
    $required = (array_key_exists('required', $args) && $args['required']) ? "required " : "";

    switch($args['type']) {
      case CBroInputType::text:
        $pattern = array_key_exists('pattern', $args) ? "pattern=\"{$args['pattern']}\" " : "";
        $pattern_error = (array_key_exists('pattern_error', $args) ? ('data-pattern-error="' . __($args['pattern_error'], 'chatbro') . '" ') : "");
        ?>
        <input id="<?php echo $id; ?>" name="<?php echo $id; ?>" type="text" class="form-control" value="<?php echo $value; ?>" <?php echo "{$required}{$pattern}{$pattern_error}"; ?>>
        <span class="field-icon form-control-feedback glyphicon" aria-hidden="true"></span>
        <?php
        break;

      case CBroInputType::textarea:
        ?>
        <textarea id="<?php echo $id; ?>" name="<?php echo $id; ?>" class="form-control" cols="80" rows="6" <?php echo $required; ?>><?php echo $value; ?></textarea>
        <?php
        break;

      case CBroInputType::select:
        ?>
        <select id="<?php echo $id; ?>" name="<?php echo $id; ?>" class="form-control" <?php echo $required; ?>>
          <?php
          foreach($args['options'] as $val => $desc) {
            $desc = __($desc, 'chatbro');
            $selected = $val == $value ? 'selected="selected"' : '';
            echo "<option {$selected} name=\"$id\" value=\"{$val}\">{$desc}</option>";
          }
          ?>
        </select>
        <?php
        break;
    }
  }

  public static function save_settings() {
    if (!self::get_backend()->check_token())
      return '{"success":false,"message":"' . __("Invalid token","chatbro") . '","msg_type":"error"}';

    if (!CBroPermissions::can_manage_settings())
      return '{"success":false,"message":"' . __("You are not allowed to modify settings","chatbro") . '","msg_type":"error"}';

    $messages = array('fields' => array());
    $new_vals = array();

    foreach(CBroSettings::iterator() as $id => $setting) {
      $value = CBroUtils::get_request_var($id);
      $value = $value === null ? false : $value;

      try {
        $value = $setting->sanitize($value);
      }
      catch(CBroSanitizeError $e) {
        if ($e->type() == CBroSanitizeError::Error)
          $messages['fields'][$id] = array('message' => $e->getMessage(), 'type' => $e->type());

        $messages['fatal'] = $e->getMessage();
        $value = $setting->get();
      }

      $new_vals[$id] = $value;
    }

    $reply = array('success' => true);

    if (array_key_exists('fatal', $messages)) {
      $reply['success'] = false;
      $reply['message'] = $messages['fatal'];
      $reply['msg_type'] = 'error';
    }
    else {
      foreach($messages['fields'] as $m) {
        if ($m['type'] == 'error') {
          $reply['success'] = false;
          break;
        }
      }
    }

    if ($reply['success']) {
      foreach($new_vals as $option => $value)
        CBroSettings::set_sanitized($option, $value);

        try {
          self::get_backend()->save_permissions();
        }
        catch(CBroPermissionsSaveError $e) {
          $reply['success'] = false;
          $reply['message'] = $e->getMessage();
          $reply['msg_type'] = 'error';

          return json_encode($reply);
        }

      $reply['message'] = "<strong>" . __("Settings was successfuly saved", "chatbro") . "</strong>";
      $reply['msg_type'] = "info";
    }

    if (count($messages['fields']))
      $reply['field_messages'] = $messages['fields'];

    return json_encode($reply);
  }

  public static function has_shortcodes() {
    return self::get_backend()->has_shortcodes();
  }

  public static function get_faq() {
    $url = 'https://www.chatbro.com/faq.html';

    try {
      return CBroUtils::http_get($url);
    }
    catch(CBroHttpError $e) {
      return '<h1>' . __("Failed to load FAQ: ") . $e->getMessage() . '</h1>';
    }
  }
}

?>
